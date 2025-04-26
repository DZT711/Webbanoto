<?php
include 'header.php';

// Get order details
$order_id = $_SESSION['current_order_id'];
$user_id = $_SESSION['user_id'];

// Get order information
$order_query = "SELECT o.*, u.full_name, u.phone_num, u.address, pm.description 
                FROM orders o
                JOIN users_acc u ON o.user_id = u.id
                LEFT JOIN payment_methods pm ON o.payment_method_id = pm.payment_method_id
                WHERE o.order_id = ? AND o.user_id = ?";

$stmt = mysqli_prepare($connect, $order_query);
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// Get order details (products)
$products_query = "SELECT od.*, p.car_name, p.price, p.year_manufacture, p.max_speed, ct.type_name 
                  FROM order_details od
                  JOIN products p ON od.product_id = p.product_id
                  LEFT JOIN car_types ct ON p.brand_id = ct.type_id
                  WHERE od.order_id = ?";

$stmt = mysqli_prepare($connect, $products_query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$products = mysqli_stmt_get_result($stmt);

$total = 0;
// Update the products query to specify the table for image_link
$products_query = "SELECT od.*, p.car_name, p.price, p.year_manufacture, p.max_speed, ct.type_name, 
p.image_link
                  FROM order_details od
                  JOIN products p ON od.product_id = p.product_id
                  LEFT JOIN car_types ct ON p.brand_id = ct.type_id
                  WHERE od.order_id = ?";

$stmt = mysqli_prepare($connect, $products_query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$products = mysqli_stmt_get_result($stmt);

// Calculate totals
while ($product = mysqli_fetch_assoc($products)) {
    $subtotal = $product['quantity'] * $product['price'];
    $total += $subtotal;
}

// Calculate VAT and total amount
$vat = $total * 0.1;
$total_with_shipping = $total + $order['shipping_fee'] + $vat;

// Update the order with calculated values
$update_totals = "UPDATE orders SET 
    expected_total_amount = ?,
    VAT = ?,
    total_amount = ?
    WHERE order_id = ?";

$stmt = mysqli_prepare($connect, $update_totals);
mysqli_stmt_bind_param(
    $stmt,
    "dddi",
    $total,
    $vat,
    $total_with_shipping,
    $order_id
);
mysqli_stmt_execute($stmt);

// Refresh order data after update
$stmt = mysqli_prepare($connect, $order_query);
mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// Reset products result for display
mysqli_data_seek($products, 0);
// Handle form submission for final confirmation
// Update the order submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        mysqli_begin_transaction($connect);

        // Calculate final amounts
        $total_amount = $order['expected_total_amount'] + $order['shipping_fee'] + $order['VAT'];

        // Update order with final amounts and status
        $update_order = "UPDATE orders SET 
            shipping_fee = ?,
            total_amount = ?,
            order_status = 'is pending',
            order_date = NOW()
            WHERE order_id = ?";

        $stmt = mysqli_prepare($connect, $update_order);
        mysqli_stmt_bind_param($stmt, "ddi", 
            $order['shipping_fee'],
            $total_amount,
            $order_id
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Không thể hoàn tất đơn hàng");
        }

        mysqli_commit($connect);

        // Clear session cart data
        $_SESSION['cart'] = array();
        
        echo "<script>
            showNotification('Đặt hàng thành công! Vui lòng chờ xác nhận.', 'success');
            setTimeout(() => { window.location.href = 'billhistory.php'; }, 2000);
        </script>";
        exit();

    } catch (Exception $e) {
        mysqli_rollback($connect);
        echo "<script>
            showNotification('Có lỗi xảy ra: " . addslashes($e->getMessage()) . "','error');
        </script>";
    }
}
?>
<!DOCTYPE html>

<head>
    <title>Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="review.css">
</head>
<style>
    /* Order Review Page Styling */
    .review-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .review-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .review-header {
        background: #007bff;
        color: white;
        padding: 20px;
        text-align: center;
    }

    .review-header h1 {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
    }

    .review-content {
        padding: 30px;
    }

    .section {
        margin-bottom: 30px;
    }

    .section-title {
        color: #2c3e50;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    /* Product Items */
    .product-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .product-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .product-price {
        color: #007bff;
        font-weight: 600;
    }

    .product-details {
        color: #6c757d;
        font-size: 14px;
    }

    /* Order Summary */
    .order-summary {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 5px 0;
    }

    .total-row {
        border-top: 2px solid #dee2e6;
        margin-top: 10px;
        padding-top: 10px;
        font-weight: 600;
        font-size: 18px;
    }

    .total-amount {
        color: #dc3545;
    }

    /* Delivery Info */
    .delivery-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .info-block {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }

    .info-title {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .info-content strong {
        color: #2c3e50;
    }

    /* Payment Method */
    .payment-method {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-back {
        background: #6c757d;
        color: white;
    }

    .btn-back:hover {
        background: #5a6268;
    }

    .btn-confirm {
        background: #007bff;
        color: white;
    }

    .btn-confirm:hover {
        background: #0056b3;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .delivery-info {
            grid-template-columns: 1fr;
        }

        .review-content {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
        /* Add to your existing styles */
    .product-item {
        display: flex;
        gap: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .product-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .product-image {
        width: 120px;
        height: 80px;
        border-radius: 6px;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-item:hover .product-image img {
        transform: scale(1.1);
    }
    
    .product-content {
        flex: 1;
    }
    
    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }
</style>
<style>
/* Enhanced Review Page Styles */
.review-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    animation: fadeIn 0.5s ease-out;
}

.review-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transform: translateY(20px);
    opacity: 0;
    animation: slideUp 0.5s ease-out forwards;
}

.review-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    padding: 25px;
    text-align: center;
    position: relative;
    overflow: hidden;
    
}

.review-header::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    animation: shimmer 2s infinite;
}

.section {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.5s ease-out forwards;
}

.section:nth-child(1) { animation-delay: 0.2s; }
.section:nth-child(2) { animation-delay: 0.4s; }
.section:nth-child(3) { animation-delay: 0.6s; }

.section-title {
    position: relative;
    padding-left: 15px;
    transition: all 0.3s ease;
}

.section-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 0;
    background: #007bff;
    transition: height 0.3s ease;
}

.section:hover .section-title::before {
    height: 100%;
}

.product-item {
    transform: translateX(-20px);
    opacity: 0;
    animation: slideInLeft 0.5s ease-out forwards;
}

.product-item:hover {
    transform: translateX(5px) translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.1);
}

.order-summary {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 1px solid rgba(0,123,255,0.1);
    transform: scale(0.95);
    opacity: 0;
    animation: scaleIn 0.5s ease-out 0.8s forwards;
}

.btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: 0.5s;
}

.btn:hover::after {
    left: 100%;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes shimmer {
    100% { left: 100%; }
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes scaleIn {
    to {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
</style>
<style>
        /* Enhanced Title Styles */
    .review-header {
        background: linear-gradient(135deg, #007bff, #0056b3, #003780);
        background-size: 200% 100%;
        color: white;
        padding: 35px 25px;
        text-align: center;
        position: relative;
        overflow: hidden;
        animation: gradientBG 5s ease infinite;
    }
    
    .review-header h1 {
        font-size: 28px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s ease forwards;
    }
    
    .review-header h1::before {
        content: '\f058'; /* FontAwesome check icon */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 24px;
        color: #4CAF50;
        animation: bounce 2s ease infinite;
        padding-right: 10px;
    }
    
    .review-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        );
        animation: shimmer 3s ease-in-out infinite;
    }
    
    /* New animations */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .review-header h1{
        display: inline-block;
    }
</style>
<body>

    <div class="review-container">
        <div class="review-card">
            <div class="review-header">
                <h1>XÁC NHẬN THÔNG TIN ĐƠN HÀNG</h1>
            </div>

            <div class="review-content">
                <!-- Products Section -->
                <!-- Products Section -->
                <div class="section">
                    <h2 class="section-title">1. CHI TIẾT SẢN PHẨM</h2>
                    <?php while ($product = mysqli_fetch_assoc($products)): ?>
                        <div class="product-item">
                            <div class="product-image">
                                <img src="<?= htmlspecialchars($product['image_link']  ) ?>" 
                                     alt="<?= htmlspecialchars($product['car_name']) ?>"
                                     onerror="this.src='../images/no-image.png';">
                            </div>
                            <div class="product-content">
                                <div class="product-header">
                                    <span class="product-name">
                                        <?= htmlspecialchars($product['car_name']) ?>
                                        (<?= $product['year_manufacture'] ?>)
                                    </span>
                                    <span class="product-price">
                                        <?= number_format($product['price']) ?> VND
                                    </span>
                                </div>
                                <div class="product-details">
                                    <p>Số lượng: <?= $product['quantity'] ?></p>
                                    <p>Vận tốc: <?= $product['max_speed'] ?> km/h</p>
                                    <p>Thương hiệu: <?= $product['type_name'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <div class="order-summary">
                        <div class="summary-row">
                            <span>Tổng tiền hàng:</span>
                            <span><?= number_format($order['expected_total_amount']) ?> VND</span>
                        </div>
                        <div class="summary-row">
                            <span>Phí vận chuyển:</span>
                            <span><?= number_format($order['shipping_fee']) ?> VND</span>
                        </div>
                        <div class="summary-row">
                            <span>VAT (10%):</span>
                            <span><?= number_format($order['VAT']) ?> VND</span>
                        </div>
                        <div class="summary-row total-row">
                            <span>Tổng cộng:</span>
                            <span class="total-amount"><?= number_format($order['total_amount']) ?> VND</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="section">
                    <h2 class="section-title">2. THÔNG TIN GIAO HÀNG</h2>
                    <div class="info-block">
                        <div class="delivery-info">
                            <div>
                                <p class="info-title">Thông Tin Người Nhận</p>
                                <p><strong>Họ và Tên:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                                <p><strong>Số Điện Thoại:</strong> <?= htmlspecialchars($order['phone_num']) ?></p>
                            </div>
                            <div>
                                <p class="info-title">Địa Chỉ Giao Hàng</p>
                                <p><?= htmlspecialchars($order['address']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="section">
                    <h2 class="section-title">3. PHƯƠNG THỨC THANH TOÁN</h2>
                    <div class="payment-method">
                        <p class="font-medium"><?= htmlspecialchars($order['description']) ?></p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <form method="POST" class="action-buttons">
                    <a href="payment.php" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Quay Lại
                    </a>
                    <button type="submit" class="btn btn-confirm">
                        Xác Nhận Đặt Hàng
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>
                // Add to your existing script
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effect to products
            const products = document.querySelectorAll('.product-item');
            products.forEach((product, index) => {
                product.style.animationDelay = `${0.2 * index}s`;
                
                product.addEventListener('mouseenter', () => {
                    product.querySelector('.product-image img').style.transform = 'scale(1.1)';
                });
                
                product.addEventListener('mouseleave', () => {
                    product.querySelector('.product-image img').style.transform = 'scale(1)';
                });
            });
        
            // Add animation to total amount
            // const totalAmount = document.querySelector('.total-amount');
            // if (totalAmount) {
            //     totalAmount.style.animation = 'bounce 2s infinite';
            // }
        
            // Smooth scroll to sections
            document.querySelectorAll('.section-title').forEach(title => {
                title.addEventListener('click', () => {
                    title.parentElement.scrollIntoView({ behavior: 'smooth' });
                });
            });
        
            // Add loading animation when submitting
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const confirmBtn = this.querySelector('.btn-confirm');
                confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
                confirmBtn.disabled = true;
            });
        });
    </script>
    <script>
                document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('.review-header');
            const title = header.querySelector('h1');
        
            // Add hover effect
            header.addEventListener('mouseenter', () => {
                title.style.transform = 'scale(1.05)';
                title.style.textShadow = '0 0 15px rgba(255,255,255,0.5)';
            });
        
            header.addEventListener('mouseleave', () => {
                title.style.transform = 'scale(1)';
                title.style.textShadow = 'none';
            });
        
            // Add text reveal animation
            const text = title.textContent;
            title.textContent = '';
            text.split('').forEach((char, i) => {
                const span = document.createElement('span');
                span.textContent = char;
                span.style.opacity = '0';
                span.style.transform = 'translateY(20px)';
                span.style.transition = `all 0.3s ease ${i * 0.05}s`;
                title.appendChild(span);
        
                setTimeout(() => {
                    span.style.opacity = '1';
                    span.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>

</html>
<?php include 'footer.php'; ?>
<?php
include 'header.php';
function canOrderBeCancelled($status)
{
    return in_array($status, ['initiated', 'is pending']);
}
if (!isset($_SESSION['user_id'])) {
    echo "<script>
        showNotification('Vui lòng đăng nhập để xem lịch sử mua hàng','warning');
        window.location.href='login.php';
    </script>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all orders for this user
$orders_query = "SELECT o.*, 
                        pm.method_name as payment_method,
                        COUNT(od.product_id) as total_items 
                 FROM orders o
                 LEFT JOIN payment_methods pm ON o.payment_method_id = pm.payment_method_id
                 LEFT JOIN order_details od ON o.order_id = od.order_id
                 WHERE o.user_id = ?
                 GROUP BY o.order_id
                 ORDER BY o.order_date DESC";

$stmt = mysqli_prepare($connect, $orders_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$orders = mysqli_stmt_get_result($stmt);
?>
<head>
    <title>Lịch sử đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<div class="billHistory-container">
    <div class="page-header">
        <h1 class="page-title">Lịch sử đơn hàng</h1>
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Quay lại trang chủ
        </a>
    </div>

    <?php if (mysqli_num_rows($orders) > 0): ?>
        <?php while ($order = mysqli_fetch_assoc($orders)): ?>
            <?php
            // Get order details for this order
            $details_query = "SELECT od.*, p.car_name, p.price, p.year_manufacture, ct.type_name 
                            FROM order_details od
                            JOIN products p ON od.product_id = p.product_id
                            LEFT JOIN car_types ct ON p.brand_id = ct.type_id
                            WHERE od.order_id = ?";

            $stmt = mysqli_prepare($connect, $details_query);
            mysqli_stmt_bind_param($stmt, "i", $order['order_id']);
            mysqli_stmt_execute($stmt);
            $products = mysqli_stmt_get_result($stmt);
            ?>

            <div class="bill-container">
                <div class="bill-header">
                    <span class="order-id">
                        <i class="fas fa-receipt"></i>
                        Đơn hàng #<?= $order['order_id'] ?>
                    </span>
                    <span class="order-date">
                        <i class="far fa-calendar-alt"></i>
                        <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?>
                    </span>
                </div>

                
<div class="order-status status-<?= strtolower(str_replace(' ', '-', $order['order_status'])) ?>">
                    <i class="fas fa-info-circle"></i>
                    Trạng thái:
                    <?php
                    switch ($order['order_status']) {
                        case 'initiated':
                            echo 'Đã khởi tạo';
                            break;
                        case 'is pending':
                            echo 'Đang chờ xác nhận';
                            break;
                        case 'is confirmed':
                            echo 'Đã xác nhận';
                            break;
                        case 'is delivering':
                            echo 'Đang giao hàng';
                            break;
                        case 'completed':
                            echo 'Đã hoàn thành';
                            break;
                        case 'cancelled':
                            echo 'Đã hủy';
                            break;
                        default:
                            echo $order['order_status'];
                    }
                    ?>
                    <?php if (canOrderBeCancelled($order['order_status'])): ?>
                        <button onclick="cancelOrder(<?= $order['order_id'] ?>)" class="cancel-order-btn">
                            <i class="fas fa-times"></i>
                            Hủy đơn hàng
                        </button>
                    <?php endif; ?>
                </div>

                <div class="bill-content">
                    <?php while ($product = mysqli_fetch_assoc($products)): ?>
                        <div class="bill-item">
                            <div class="bill-details">
                                <div class="product-info">
                                    <i class="fas fa-car"></i>
                                    <div>
                                        <div><?= htmlspecialchars($product['car_name']) ?></div>
                                        <div class="text-sm text-gray-500">
                                            <?= $product['year_manufacture'] ?> - <?= htmlspecialchars($product['type_name']) ?>
                                            (x<?= $product['quantity'] ?>)
                                        </div>
                                    </div>
                                </div>
                                <div class="price-info">
                                    <?= number_format($product['price']) ?> VND
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="order-summary">
                    <div class="summary-item">
                        <i class="fas fa-shipping-fast"></i>
                        Phí vận chuyển: <?= number_format($order['shipping_fee']) ?> VND
                    </div>
                    <div class="summary-item">
                        <i class="fas fa-percentage"></i>
                        VAT (10%): <?= number_format($order['VAT']) ?> VND
                    </div>
                    <div class="bill-total">
                        <i class="fas fa-money-bill-wave"></i>
                        Tổng cộng: <?= number_format($order['total_amount']) ?> VND
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-orders">
            <i class="fas fa-shopping-cart"></i>
            <p>Bạn chưa có đơn hàng nào.</p>
            <a href="index.php" class="browse-btn">Mua sắm ngay</a>
        </div>
    <?php endif; ?>
</div>
<!-- // Add this HTML right before the footer include -->
<div id="cancel-popup" class="popup-overlay">
    <div class="popup-content">
        <h3>Xác nhận hủy đơn hàng</h3>
        <p>Bạn có chắc chắn muốn hủy đơn hàng này không?</p>
        <div class="popup-buttons">
            <button class="btn-secondary" onclick="closePopup()">
                <i class="fas fa-times"></i>
                Không
            </button>
            <button class="btn-danger" onclick="confirmCancel()">
                <i class="fas fa-check"></i>
                Có, hủy đơn hàng
            </button>
        </div>
    </div>
</div>
<style>
        /* Add these styles to your existing CSS */
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    
    .popup-content {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        max-width: 400px;
        width: 90%;
        text-align: center;
        animation: popup-show 0.3s ease;
    }
    
    @keyframes popup-show {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    .popup-content h3 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 20px;
    }
    
    .popup-content p {
        color: #666;
        margin-bottom: 25px;
    }
    
    .popup-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }
    
    .btn-secondary, .btn-danger {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ff4747, #cc0000);
        color: white;
    }
    
    .btn-secondary:hover, .btn-danger:hover {
        transform: translateY(-2px);
    }
    
    .btn-secondary:hover {
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .btn-danger:hover {
        box-shadow: 0 4px 15px rgba(204, 0, 0, 0.3);
    }
    .billHistory-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 24px;
        color: #2c3e50;
        font-weight: 600;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f8f9fa;
        color: #2c3e50;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        background: #e9ecef;
        transform: translateX(-5px);
    }

    .bill-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        overflow: hidden;
    }

    .bill-header {
        background: #f8f9fa;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }

    .order-id {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
    }

    .order-date {
        color: #6c757d;
        font-size: 14px;
    }

    .bill-content {
        padding: 20px;
    }

    .bill-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .bill-item:last-child {
        border-bottom: none;
    }

    .bill-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-info i {
        color: #007bff;
    }

    .price-info {
        color: #2c3e50;
        font-weight: 600;
    }

    .order-summary {
        background: #f8f9fa;
        padding: 20px;
        border-top: 1px solid #eee;
    }

    .summary-item {
        margin-bottom: 10px;
    }

    .bill-total {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #dee2e6;
        font-size: 18px;
        font-weight: 600;
        color: #008000;
    }

    .order-status {
        margin: 15px 20px;
        padding: 12px;
        border-radius: 8px;
        font-weight: 500;
    }

    /* Status colors */
    .status-initiated {
        background: #e3f2fd;
        color: #1976d2;
    }

    .status-pending {
        background:rgb(255, 207, 129);
        color: #f57c00;
    }

    .status-confirmed {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-delivering {
        background: #ede7f6;
        color: #5e35b1;
    }

    .status-completed {
        background: #e0f2f1;
        color: #00897b;
    }

    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }

    .order-status {
        margin: 15px 0;
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .order-status.initiated {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .order-status.is.pending {
        background-color: #fff3e0;
        color: #f57c00;
    }

    .order-status.confirmed {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .order-status.delivering {
        background-color: #ede7f6;
        color: #5e35b1;
    }

    .order-status.completed {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .order-status.cancelled {
        background-color: #ffebee;
        color: #c62828;
    }

    .order-summary {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px dashed #ddd;
    }

    .summary-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 8px 0;
        color: #666;
    }

    .no-orders {
        text-align: center;
        padding: 40px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .no-orders i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .no-orders p {
        color: #666;
        margin-bottom: 20px;
    }

    .browse-btn {
        display: inline-block;
        padding: 10px 20px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .browse-btn:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }
        /* Order Status Styles */
    .order-status {
        margin: 15px 20px;
        padding: 12px 15px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        border-left: 4px solid;
    }
    
    /* Initiated Status */
    .status-initiated {
        background-color: #E3F2FD;
        border-left-color: #2196F3;
        color: #1976D2;
    }
    .status-initiated i {
        color: #2196F3;
    }
    
    /* Pending Status */
    .status-is-pending {
        background-color: #FFF3E0;
        border-left-color: #FF9800;
        color: #F57C00;
    }
    .status-is-pending i {
        color: #FF9800;
        animation: pulse 2s infinite;
    }
    
    /* Confirmed Status */
    .status-is-confirmed {
        background-color: #E8F5E9;
        border-left-color: #4CAF50;
        color: #2E7D32;
    }
    .status-is-confirmed i {
        color: #4CAF50;
    }
    
    /* Delivering Status */
    .status-is-delivering {
        background-color: #EDE7F6;
        border-left-color: #673AB7;
        color: #5E35B1;
    }
    .status-is-delivering i {
        color: #673AB7;
        animation: truck-move 2s infinite;
    }
    
    /* Completed Status */
    .status-completed {
        background-color: #E0F7FA;
        border-left-color: #009688;
        color: #00796B;
    }
    .status-completed i {
        color: #009688;
    }
    
    /* Cancelled Status */
    .status-cancelled {
        background-color: #FFEBEE;
        border-left-color: #F44336;
        color: #C62828;
    }
    .status-cancelled i {
        color: #F44336;
    }
    
    /* Animations */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    @keyframes truck-move {
        0% { transform: translateX(-3px); }
        50% { transform: translateX(3px); }
        100% { transform: translateX(-3px); }
    }
    
    /* Status Icons */
    .order-status i {
        font-size: 1.2rem;
    }
    
    .status-initiated i::before { content: '\f044'; }        /* Edit icon */
    .status-is-pending i::before { content: '\f017'; }       /* Clock icon */
    .status-is-confirmed i::before { content: '\f00c'; }     /* Check icon */
    .status-is-delivering i::before { content: '\f48b'; }    /* Truck icon */
    .status-completed i::before { content: '\f058'; }        /* Check-circle icon */
    .status-cancelled i::before { content: '\f057'; }        /* Times-circle icon */
    
    /* Status Badge */
    .order-status::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin: 12px;
    }
    
    .status-initiated::after { background-color: #2196F3; }
    .status-is-pending::after { background-color: #FF9800; }
    .status-is-confirmed::after { background-color: #4CAF50; }
    .status-is-delivering::after { background-color: #673AB7; }
    .status-completed::after { background-color: #009688; }
    .status-cancelled::after { background-color: #F44336; }
        /* Add these styles to your existing CSS */
    .cancel-order-btn {
        margin-left: auto;
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        background: linear-gradient(135deg, #ff4747, #cc0000);
        color: white;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    
    .cancel-order-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(204, 0, 0, 0.3);
    }
    
    .cancel-order-btn i {
        font-size: 14px;
    }
    
    /* Responsive design */
    @media (max-width: 768px) {
        .order-status {
            flex-wrap: wrap;
        }
        
        .cancel-order-btn {
            margin-top: 10px;
            width: 100%;
            justify-content: center;
        }
    }
</style>
<script>
    // Replace your existing cancelOrder function with this
let currentOrderId = null;

function cancelOrder(orderId) {
    currentOrderId = orderId;
    document.getElementById('cancel-popup').style.display = 'flex';
}

function closePopup() {
    document.getElementById('cancel-popup').style.display = 'none';
}

function confirmCancel() {
    if (!currentOrderId) return;
    
    fetch('cancel_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'order_id=' + currentOrderId
    })
    .then(response => response.json())
    .then(data => {
        closePopup();
        if (data.success) {
            showNotification('Đã hủy đơn hàng thành công', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Không thể hủy đơn hàng', 'error');
        }
    })
    .catch(error => {
        closePopup();
        window.location.href = 'billhistory.php';
    });
}

// Close popup when clicking outside
document.addEventListener('click', function(event) {
    const popup = document.getElementById('cancel-popup');
    if (event.target === popup) {
        closePopup();
    }
});
</script>
<?php
include 'footer.php';
?>
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
<style>
    /* Product Image Styles */
    .product-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .product-image {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        border: 1px solid #eee;
        background: #f8f9fa;
        transition: all 0.3s ease;
    }

    .product-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-text {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
    }

    .product-meta {
        font-size: 0.9em;
        color: #6c757d;
    }

    .quantity {
        background: #e9ecef;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.85em;
        margin-left: 5px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .bill-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .product-info {
            width: 100%;
        }

        .product-image {
            width: 100px;
            height: 75px;
        }

        .price-info {
            align-self: flex-end;
        }
    }

    /* Loading state */
    .product-image.loading {
        animation: shimmer 1.5s infinite linear;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
    }

    @keyframes shimmer {
        to {
            background-position: -200% 0;
        }
    }
</style>
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
        from {
            transform: scale(0.8);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
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

    .btn-secondary,
    .btn-danger {
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

    .btn-secondary:hover,
    .btn-danger:hover {
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
        background: rgb(255, 207, 129);
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
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes truck-move {
        0% {
            transform: translateX(-3px);
        }

        50% {
            transform: translateX(3px);
        }

        100% {
            transform: translateX(-3px);
        }
    }

    /* Status Icons */
    .order-status i {
        font-size: 1.2rem;
    }

    .status-initiated i::before {
        content: '\f044';
    }

    /* Edit icon */
    .status-is-pending i::before {
        content: '\f017';
    }

    /* Clock icon */
    .status-is-confirmed i::before {
        content: '\f00c';
    }

    /* Check icon */
    .status-is-delivering i::before {
        content: '\f48b';
    }

    /* Truck icon */
    .status-completed i::before {
        content: '\f058';
    }

    /* Check-circle icon */
    .status-cancelled i::before {
        content: '\f057';
    }

    /* Times-circle icon */

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

    .status-initiated::after {
        background-color: #2196F3;
    }

    .status-is-pending::after {
        background-color: #FF9800;
    }

    .status-is-confirmed::after {
        background-color: #4CAF50;
    }

    .status-is-delivering::after {
        background-color: #673AB7;
    }

    .status-completed::after {
        background-color: #009688;
    }

    .status-cancelled::after {
        background-color: #F44336;
    }

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
<style>
    /* Enhanced Bill Container Animations */
    .bill-container {
        animation: slideIn 0.5s ease-out;
        transform-origin: top;
        transition: all 0.3s ease;
    }

    .bill-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Enhanced Bill Header */
    .bill-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .bill-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent);
        animation: shimmer 3s infinite;
    }

    /* Staggered Animation for Bill Items */
    .bill-item {
        opacity: 0;
        transform: translateX(-20px);
        animation: slideInRight 0.5s ease-out forwards;
    }

    .bill-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .bill-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .bill-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    /* Enhanced Product Image Hover */
    .product-image {
        perspective: 1000px;
    }

    .product-image img {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        backface-visibility: hidden;
    }

    .product-image:hover img {
        transform: rotateY(10deg) scale(1.1);
    }

    /* Enhanced Status Badges */
    .order-status {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(0);
    }

    .order-status:hover {
        transform: translateY(-2px);
    }

    .order-status i {
        transition: transform 0.3s ease;
    }

    .order-status:hover i {
        transform: scale(1.2);
    }

    /* Enhanced Price Animation */
    .price-info {
        position: relative;
        padding: 5px 10px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .price-info:hover {
        background: rgba(0, 128, 0, 0.1);
        transform: scale(1.05);
    }

    /* New Animations */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes shimmer {
        100% {
            left: 100%;
        }
    }
</style>
<style>
    /* Enhanced Page Header Styles */
    .page-header {
        position: relative;
        margin-bottom: 40px;
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .page-title {
        font-size: 2rem;
        color: #2c3e50;
        font-weight: 700;
        text-transform: uppercase;
        margin: 0;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60%;
        height: 3px;
        background: linear-gradient(90deg, #1abc9c, transparent);
        animation: titleLine 2s infinite;
    }

    .page-title::before {
        content: '📋';
        margin-right: 10px;
        font-size: 2.2rem;
        animation: bounce 2s infinite;
    }

    .page-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent);
        animation: shimmer 3s infinite;
    }

    @keyframes titleLine {
        0% {
            width: 0;
            opacity: 0;
        }

        50% {
            width: 60%;
            opacity: 1;
        }

        100% {
            width: 0;
            opacity: 0;
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    /* Enhanced Back Button */
    .back-btn {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        padding: 12px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(26, 188, 156, 0.2);
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #1abc9c, #16a085) !important;
        transform: translateX(-5px);
        box-shadow: 0 6px 20px rgba(26, 188, 156, 0.3);
    }

    .back-btn i {
        transition: transform 0.3s ease;
    }

    .back-btn:hover i {
        transform: translateX(-5px);
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .page-title::after {
            left: 20%;
            width: 60%;
        }

        .back-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<div class="billHistory-container">
    <div class="page-header">
        <h1 class="page-title">Lịch sử đơn hàng</h1>
        <a href="index.php" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Quay lại trang chủ</span>
        </a>
    </div>

    <?php if (mysqli_num_rows($orders) > 0): ?>
        <?php while ($order = mysqli_fetch_assoc($orders)): ?>
            <?php
            // Get order details for this order
            // Update the details query to include image_link
            $details_query = "SELECT od.*, p.car_name, p.price, p.year_manufacture, p.image_link, ct.type_name 
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
                                    <div class="product-image">
                                        <img src="<?= htmlspecialchars($product['image_link']) ?>"
                                            alt="<?= htmlspecialchars($product['car_name']) ?>"
                                            onerror="this.src='../placeholder-car.jpg'">
                                    </div>
                                    <div class="product-text">
                                        <div class="product-name"><?= htmlspecialchars($product['car_name']) ?></div>
                                        <div class="product-meta">
                                            <?= $product['year_manufacture'] ?> - <?= htmlspecialchars($product['type_name']) ?>
                                            <span class="quantity">(x<?= $product['quantity'] ?>)</span>
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
    document.addEventListener('click', function (event) {
        const popup = document.getElementById('cancel-popup');
        if (event.target === popup) {
            closePopup();
        }
    });
</script>
<script>
    // Add lazy loading for images
    document.addEventListener('DOMContentLoaded', function () {
        const images = document.querySelectorAll('.product-image img');

        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.parentElement.classList.remove('loading');
                    }
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            img.parentElement.classList.add('loading');
            const src = img.src;
            img.src = '';
            img.dataset.src = src;
            imageObserver.observe(img);
        });
    });
</script>
<script>
    // Add this JavaScript after your existing scripts
    document.addEventListener('DOMContentLoaded', function () {
        // Animate numbers in price display
        const priceElements = document.querySelectorAll('.price-info');
        priceElements.forEach(element => {
            const price = parseInt(element.textContent.replace(/[^\d]/g, ''));

            element.addEventListener('mouseenter', () => {
                animateValue(element, 0, price, 1000);
            });
        });

        function animateValue(element, start, end, duration) {
            const originalText = element.textContent;
            let startTimestamp = null;

            function step(timestamp) {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const current = Math.floor(progress * (end - start) + start);
                element.textContent = current.toLocaleString('vi-VN') + ' VND';

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    element.textContent = originalText;
                }
            }

            window.requestAnimationFrame(step);
        }

        // Enhance status icon animations
        const statusIcons = document.querySelectorAll('.order-status i');
        statusIcons.forEach(icon => {
            if (icon.parentElement.classList.contains('status-is-delivering')) {
                icon.style.animation = 'truckMove 2s infinite';
            }
            if (icon.parentElement.classList.contains('status-is-pending')) {
                icon.style.animation = 'pulse 1.5s infinite';
            }
        });

        // Add hover effect to order summary items
        const summaryItems = document.querySelectorAll('.summary-item');
        summaryItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'translateX(10px)';
            });

            item.addEventListener('mouseleave', () => {
                item.style.transform = 'translateX(0)';
            });
        });
    });

    // Add smooth scroll for "Back to top" functionality
    window.onscroll = function () {
        if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
            document.querySelector('.back-btn').style.display = 'flex';
        } else {
            document.querySelector('.back-btn').style.display = 'none';
        }
    };
</script>
<?php
include 'footer.php';
?>
<?php
include 'header.php';

// Add this after your session_start()
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update the date initialization
    // Replace the date initialization code at the top
    $end_date = isset($_POST['end_date']) && !empty($_POST['end_date']) ?
        date('Y-m-d', strtotime($_POST['end_date'])) :
        date('Y-m-d');

    $start_date = isset($_POST['start_date']) && !empty($_POST['start_date']) ?
        date('Y-m-d', strtotime($_POST['start_date'])) :
        date('Y-m-d', strtotime('-30 days'));
    // Validate dates
    if (strtotime($start_date) > strtotime($end_date)) {
        echo "<script>
                    showNotification('The end date cannot smaller than the start date!','warning');
            window.location.href = 'statics.php';
        </script>";
        exit;
    }
}

// Modify the getTopCustomers function
// Update the getTopCustomers function to include product counts
function getTopCustomers($connect, $start_date = null, $end_date = null)
{
    $query = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.full_name,
            COUNT(DISTINCT o.order_id) as order_count,
            SUM(o.expected_total_amount) as total_spent,
            SUM(oi.quantity) as total_products
        FROM users_acc u
        LEFT JOIN orders o ON u.id = o.user_id
        LEFT JOIN order_details oi ON o.order_id = oi.order_id
    ";

    if ($start_date && $end_date) {
        $query .= " WHERE DATE(o.order_date) BETWEEN ? AND ?";
    } else {
        $query .= " WHERE o.order_id IS NOT NULL";
    }

    $query .= "
        GROUP BY 
            u.id,
            u.username,
            u.email,
            u.full_name
        HAVING total_spent > 0
        ORDER BY total_spent DESC
        LIMIT 5
    ";

    $stmt = mysqli_prepare($connect, $query);

    if ($start_date && $end_date) {
        mysqli_stmt_bind_param($stmt, "ss", $start_date, $end_date);
    }

    mysqli_stmt_execute($stmt);
    return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
}

// Update the date initialization
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    $start_date = date('Y-m-d', strtotime($_POST['start_date']));
    $end_date = date('Y-m-d', strtotime($_POST['end_date']));
} else {
    $start_date = null;
    $end_date = null;
}

// Get top customers with or without date filter
$top_customers = getTopCustomers($connect, $start_date, $end_date);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="statics.css"> -->
    <!-- <script src="statics.js"></script> -->
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<style>
    #staticsforproducts p {
        font-size: 16px;
        line-height: 1.5;
        padding: 10px;
        margin: 10px 0;
        background-color: #f4f4f4;
        border-radius: 5px;
        margin: 20px;
    }

    #staticsforproducts p.best-seller {
        background-color: #d4edda;
        /* Màu xanh nhạt cho sản phẩm bán chạy nhất */
        color: #155724;
        /* Màu chữ xanh đậm */
        border: 1px solid #c3e6cb;
        /* Đường viền xanh nhạt */
    }

    #staticsforproducts p.worst-seller {
        background-color: #f8d7da;
        /* Màu đỏ nhạt cho sản phẩm ế nhất */
        color: #721c24;
        /* Màu chữ đỏ đậm */
        border: 1px solid #f5c6cb;
        /* Đường viền đỏ nhạt */
    }

    /* Admin Header */
    .admin-header {
        background-color: #f3f3f3;
        color: white;
        padding: 20px;
        text-align: center;
    }

    /* Admin Main Sections */
    .admin-section {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        border-radius: 8px;

    }

    /* Quick Stats Boxes */
    .stats-container {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .stat-box {
        background-color: #007BFF;
        color: white;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        width: 30%;
    }

    /* Admin Tables */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table th,
    .admin-table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .admin-table th {
        background-color: #f3f3f3;
        font-weight: bold;
    }


    /* Admin Buttons */
    .admin-table button {
        padding: 5px 10px;
        margin-right: 5px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .admin-table button:hover {
        background-color: #0056b3;
    }


    /* Navbar Styling */
    .navbar {
        background-color: #2c3e50;
        /* Darker color for admin navbar */
        overflow: hidden;
        font-weight: bold;
        padding: 10px 0;
        padding-left: 100px;
    }

    .navbar a {
        color: #ecf0f1;
        /* Light text color */
        float: left;
        display: block;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
        /* Smooth transition */
    }

    /* Hover Effects for Links */
    .navbar a:hover {
        background-color: #34495e;
        /* Slightly lighter background on hover */
        color: #1abc9c;
        /* Accent color for text on hover */
    }

    /* Active Link */
    .navbar a.active {
        background-color: #1abc9c;
        /* Highlight color for active page */
        color: #ffffff;
    }

    /* Dropdown Menu for Navbar (optional for sub-navigation) */
    .navbar .dropdown {
        float: left;
        overflow: hidden;
    }

    .navbar .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: #ecf0f1;
        padding: 14px 20px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }

    /* Dropdown Content (Hidden by Default) */
    .navbar .dropdown-content {
        display: none;
        position: absolute;
        background-color: #34495e;
        min-width: 160px;
        z-index: 1;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Links inside Dropdown */
    .navbar .dropdown-content a {
        float: none;
        color: #ecf0f1;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .navbar .dropdown-content a:hover {
        background-color: #1abc9c;
        /* Highlight for dropdown items on hover */
    }

    /* Show Dropdown on Hover */
    .navbar .dropdown:hover .dropdown-content {
        display: block;
    }

    #logoheader {
        max-width: 10%;
    }


    /* Styling for Admin Info in Header */
    .admin-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-right: 20px;
        font-size: 16px;
        color: #000000;
        font-size: 1.5em;
        font-weight: bold;
    }

    #logout-btn {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    #logout-btn:hover {
        background-color: #c0392b;
    }

    Specific hover effect for Ban button .admin-table button[style*="background-color: red;"] {
        background-color: #e74c3c;
        color: white;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .admin-table button[style*="background-color: red;"]:hover {
        background-color: #c0392b;
        /* Darker red on hover  */
        transform: scale(1.1);
        /* Slight zoom effect  */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        /* Add shadow  */
    }

    /* More Button Styling */
    button.link {
        margin-top: 20px;
        display: inline-block;
        background-color: #1abc9c;
        /* Màu nền xanh ngọc */
        color: white;
        /* Màu chữ trắng */
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        /* Kích thước nút */
        font-size: 16px;
        /* Kích thước chữ */
        font-weight: bold;
        /* Đậm chữ */
        cursor: pointer;
        /* Hiển thị icon tay khi hover */
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        /* Hiệu ứng mượt */
        text-align: center;
        /* Canh giữa văn bản */
    }

    /* Hover Effect for More Button */
    button.link:hover {
        background-color: #16a085;
        /* Màu nền đậm hơn khi hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Đổ bóng khi hover */
    }

    /* Active State for More Button */
    button.link:active {
        background-color: #0e7766;
        /* Màu tối hơn khi bấm */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        /* Giảm độ cao bóng */
    }

    /* Add this to style.css */
    #logout-btn {
        text-decoration: none;
        color: #fff;
        background-color: #dc3545;
        padding: 8px 16px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }

    #logout-btn:hover {
        background-color: #c82333;
    }

    /* Add these styles to your existing CSS */
    .filter-container {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        max-width: 400px;
    }

    .filter-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .filter-grid {
        display: grid;
        /* grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); */
        gap: 20px;
    }

    .filter-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        color: #2c3e50;
    }

    .filter-group input[type="date"] {
        width: 90%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .nested-table {
        width: 100%;
        margin: 10px 0;
        background: #f8f9fa;
        border-radius: 4px;
    }

    .nested-table th {
        background: #e9ecef;
        padding: 8px;
        font-size: 0.9em;
    }

    .nested-table td {
        padding: 8px;
        font-size: 0.9em;
    }

    .view-invoice-btn {
        padding: 4px 8px;
        background: #007bff;
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.8em;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .view-invoice-btn:hover {
        background: #0056b3;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8em;
        font-weight: 500;
    }

    /* Add more status styles as needed */
    .status-completed {
        background: #28a745;
        color: white;
    }

    .status-pending {
        background: #ffc107;
        color: black;
    }

    .status-cancelled {
        background: #dc3545;
        color: white;
    }

    /* These styles should already be in your CSS */
    .filter-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        padding: 20px;
    }

    .filter-grid {
        display: grid;
        /* grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); */
        gap: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        /* gap: 8px; */
    }

    .filter-group label {
        color: #34495e;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-group label i {
        color: #1abc9c;
        width: 16px;
    }

    .filter-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .filter-btn,
    .reset-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .filter-btn {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
    }

    .reset-btn {
        background: #f8f9fa;
        color: #666;
        border: 1px solid #ddd;
        text-decoration: none;
    }

    /* Add to your existing styles */
    .rank-cell {
        font-size: 1.2em;
        text-align: center;
    }

    .rank {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 8px;
        border-radius: 20px;
        font-weight: bold;
        background: #f8f9fa;
    }

    .rank-1 {
        background: linear-gradient(135deg, #ffd700, #ffa500);
        color: #fff;
    }

    .rank-2 {
        background: linear-gradient(135deg, #c0c0c0, #a9a9a9);
        color: #fff;
    }

    .rank-3 {
        background: linear-gradient(135deg, #cd7f32, #8b4513);
        color: #fff;
    }

    .rank i {
        font-size: 0.9em;
    }

    .rank-1 i {
        color: #ffd700;
    }

    .rank-2 i {
        color: #c0c0c0;
    }

    .rank-3 i {
        color: #cd7f32;
    }

    .order-count,
    .product-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e9ecef;
        padding: 4px 8px;
        border-radius: 15px;
        font-size: 0.9em;
    }

    .total-spent {
        font-weight: bold;
        color: #28a745;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-initiated {
        background: #e3f2fd;
        color: #1976d2;
    }

    .status-is-pending {
        background: #fff3e0;
        color: #f57c00;
    }

    .status-is-confirmed {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-is-delivering {
        background: #ede7f6;
        color: #5e35b1;
    }

    .status-completed {
        background: #e0f7fa;
        color: #00796b;
    }

    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }

    .edit-status-btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .edit-status-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(26, 188, 156, 0.3);
    }

    /* Status Modal Styles */
    .status-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }
</style>

<body>

    <main>

        <!-- Add this to your HTML section -->
        <section class="admin-section">
            <h2><i class="fas fa-chart-line"></i> Sales Statistics</h2>

            <div class="admin-section filter-container">
                <h2><i class="fas fa-filter"></i> Filter Statistics</h2>
                <form method="POST" class="filters" onsubmit="return validateDates()">
                    <div class="filter-grid">
                        <!-- Date Range Filter -->
                        <div class="filter-group">
                            <label for="start-date">
                                <i class="far fa-calendar-alt"></i> Start Date:
                            </label>
                            <input type="date" id="start-date" name="start_date" value="" placeholder="dd/mm/yyyy">
                        </div>
<br>
                        <div class="filter-group">
                            <label for="end-date">
                                <i class="far fa-calendar-alt"></i> End Date:
                            </label>
                            <input type="date" id="end-date" name="end_date" value="" placeholder="dd/mm/yyyy">
                        </div>
                    </div>

                    <div class="filter-buttons">
                        <button type="submit" class="filter-btn">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="statics.php" class="reset-btn">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Top Customers Table -->
            <div class="top-customers">
                <h3><i class="fas fa-crown"></i> Top 5 Customers by Purchase Amount</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-ranking-star"></i> Rank</th>
                            <th><i class="fas fa-user"></i> Customer</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-shopping-cart"></i> Orders</th>
                            <th><i class="fas fa-box"></i> Total Products</th>
                            <th><i class="fas fa-money-bill-wave"></i> Total Spent</th>
                            <th><i class="fas fa-list"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rank = 1;
                        foreach ($top_customers as $customer): ?>
                            <tr>
                                <td class="rank-cell">
                                    <?php if ($rank <= 3): ?>
                                        <span class="rank rank-<?php echo $rank; ?>">
                                            <i class="fas fa-crown"></i>
                                            #<?php echo $rank++; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="rank">
                                            #<?php echo $rank++; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($customer['full_name']); ?></strong>
                                    <br>
                                    <small><?php echo htmlspecialchars($customer['username']); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td>
                                    <span class="order-count">
                                        <i class="fas fa-shopping-bag"></i>
                                        <?php echo $customer['order_count']; ?> orders
                                    </span>
                                </td>
                                <td>
                                    <span class="product-count">
                                        <i class="fas fa-box"></i>
                                        <?php echo number_format($customer['total_products']); ?> items
                                    </span>
                                </td>
                                <td>
                                    <span class="total-spent">
                                        <?php echo number_format($customer['total_spent'], 0, ',', '.'); ?> VND
                                    </span>
                                </td>
                                <td>
                                    <button onclick="showCustomerOrders(<?php echo $customer['id']; ?>)"
                                        class="view-orders-btn">
                                        <i class="fas fa-receipt"></i> View Orders
                                    </button>
                                </td>
                            </tr>

                            <!-- Orders Detail Row (Initially Hidden) -->
                            <tr class="order-details" id="orders-<?php echo $customer['id']; ?>" style="display: none;">
                                <td colspan="5">
                                    <div class="orders-list">
                                        <table class="nested-table">
                                            <thead>
                                                <tr>
                                                    <th><i class="fas fa-hashtag"></i>Order ID</th>
                                                    <th><i class="far fa-calendar-alt"></i> Order Date</th>
                                                    <th><i class="fas fa-money-bill-wave"></i>Amount</th>
                                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                                    <th><i class="fas fa-cogs"></i> Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Replace the existing orders query in the foreach loop
                                                // Replace the existing orders query in the foreach loop
                                                $orders_query = "SELECT * FROM orders WHERE user_id = ? ";

                                                if ($start_date && $end_date) {
                                                    $orders_query .= "AND DATE(order_date) BETWEEN ? AND ? ";
                                                }
                                                $orders_query .= "ORDER BY expected_total_amount DESC";

                                                $stmt = mysqli_prepare($connect, $orders_query);

                                                if ($start_date && $end_date) {
                                                    mysqli_stmt_bind_param($stmt, "iss", $customer['id'], $start_date, $end_date);
                                                } else {
                                                    mysqli_stmt_bind_param($stmt, "i", $customer['id']);
                                                }
                                                mysqli_stmt_execute($stmt);
                                                $orders = mysqli_stmt_get_result($stmt);

                                                while ($order = mysqli_fetch_assoc($orders)): ?>
                                                    <tr>
                                                        <td>#<?php echo $order['order_id']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></td>
                                                        <td><?php echo number_format($order['expected_total_amount'], 0, ',', '.'); ?>
                                                            VND</td>
                                                        <td>
                                                            <span
                                                                class="status-badge status-<?= str_replace(' ', '-', strtolower($order['order_status'])) ?>">
                                                                <?php
                                                                switch ($order['order_status']) {
                                                                    case 'initiated':
                                                                        echo 'Initiated';
                                                                        break;
                                                                    case 'is pending':
                                                                        echo 'Is pending';
                                                                        break;
                                                                    case 'is confirmed':
                                                                        echo 'Is confirmed';
                                                                        break;
                                                                    case 'is delivering':
                                                                        echo 'Is delivering';
                                                                        break;
                                                                    case 'completed':
                                                                        echo 'Completed';
                                                                        break;
                                                                    case 'cancelled':
                                                                        echo 'Cancelled';
                                                                        break;
                                                                    default:
                                                                        echo $order['order_status'];
                                                                }
                                                                ?>
                                                        </td>
                                                        <td>
                                                            <a href="view-invoice.php?id=<?php echo $order['order_id']; ?>"
                                                                class="view-invoice-btn">
                                                                <i class="fas fa-eye"></i> View Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        function showCustomerOrders(customerId) {
            const orderDetails = document.getElementById(`orders-${customerId}`);
            const allOrderDetails = document.querySelectorAll('.order-details');

            // Hide all other order details
            allOrderDetails.forEach(detail => {
                if (detail.id !== `orders-${customerId}`) {
                    detail.style.display = 'none';
                }
            });

            // Toggle current order details
            orderDetails.style.display = orderDetails.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>

    <script>
        function validateDates() {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                showNotification('Ngày bắt đầu không thể lớn hơn ngày kết thúc', 'warning');
                return false;
            }
            return true;
        }

        // Format date as dd/mm/yyyy
        function formatDate(date) {
            return date.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        // Initialize dates on page load
        document.addEventListener('DOMContentLoaded', function () {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            if (!startDate.value) {
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
                startDate.value = thirtyDaysAgo.toISOString().split('T')[0];
                startDate.setAttribute('placeholder', formatDate(thirtyDaysAgo));
            }

            if (!endDate.value) {
                const today = new Date();
                endDate.value = today.toISOString().split('T')[0];
                endDate.setAttribute('placeholder', formatDate(today));
            }
        });
    </script>
</body>

</html>
<?php
include 'footer.php';
?>
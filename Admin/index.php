<?php
include 'header.php';

// Get 5 most recent users
$users_query = "SELECT id, username, full_name, email, phone_num, role, status, register_date 
                FROM users_acc 
                ORDER BY register_date DESC 
                LIMIT 5";
$users_result = mysqli_query($connect, $users_query);

// Get 5 most recent products
$products_query = "SELECT p.*, c.type_name 
                  FROM products p 
                  LEFT JOIN car_types c ON p.brand_id = c.type_id 
                  ORDER BY p.product_id DESC 
                  LIMIT 5";
$products_result = mysqli_query($connect, $products_query);

// Get 5 most recent orders
$orders_query = "SELECT o.*, u.username, u.full_name, u.phone_num, u.email 
                FROM orders o 
                JOIN users_acc u ON o.user_id = u.id 
                ORDER BY o.order_date DESC 
                LIMIT 5";
$orders_result = mysqli_query($connect, $orders_query);

// Calculate statistics
$stats_query = "SELECT 
    (SELECT COUNT(*) FROM users_acc) as total_users,
    (SELECT COUNT(*) FROM orders WHERE DATE(order_date) = CURDATE()) as orders_today,
    (SELECT SUM(total_amount) FROM orders) as total_revenue";
$stats_result = mysqli_query($connect, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- <script src="index.js"></script> -->
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">

    <!-- <link rel="stylesheet" href="style.css"> -->
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
</head>
<style>
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
        /* padding-left: 40px; */
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
</style>
<style>
    /* Enhanced Admin Section */
    .admin-section {
        margin: 20px;
        padding: 20px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        transform: translateY(20px);
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* Enhanced Stats Container */
    .stats-container {
        /* display: grid; */
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
        margin-top: 20px;
    }

    .stat-box {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        padding: 20px;
        border-radius: 15px;
        color: white;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .stat-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent);
        animation: shimmer 2s infinite;
    }

    /* Enhanced Tables */
    .admin-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 20px 0;
    }

    .admin-table th {
        background: linear-gradient(45deg, #1abc9c, #16a085);
        color: white;
        padding: 15px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9em;
        letter-spacing: 0.5px;
    }

    .admin-table tr {
        transition: all 0.3s ease;
    }

    .admin-table tr:hover {
        background-color: rgba(26, 188, 156, 0.1);
        transform: scale(1.01);
    }

    .admin-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
    }

    /* Enhanced Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
        text-transform: capitalize;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .status-active {
        background-color: #2ecc71;
        color: white;
    }

    .status-banned {
        background-color: #e74c3c;
        color: white;
    }

    .status-pending {
        background-color: #f1c40f;
        color: white;
    }

    .status-completed {
        background-color: #3498db;
        color: white;
    }

    /* Animations */
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

    @keyframes shimmer {
        100% {
            left: 100%;
        }
    }

    /* Enhanced Button Styles */
    .link {
        background: linear-gradient(45deg, #1abc9c, #16a085);
        color: white;
        padding: 12px 24px;
        border-radius: 25px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .link:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(26, 188, 156, 0.3);
    }

    .link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent);
        animation: shimmer 2s infinite;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .admin-table {
            font-size: 0.9em;
        }
    }
</style>
<style>

    /* Enhanced Section Titles and Admin Greeting */
    
    /* .s2 h2 {
        position: relative;
        font-size: 1.8rem;
        color: #2c3e50;
        padding-bottom: 15px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
     */
    /* .s2 h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #1abc9c, transparent);
        transition: width 0.3s ease;
    }
    
    .s2 h2:hover::after {
        width: 120px;
    }
      .s2 h2 i {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-size: 1.6em;
        transition: transform 0.3s ease;
    }
    .s2:hover h2 {
        transform: scale(1.1) ;
    }  */
          /* Enhanced Section Titles */
    .s2 h2 {
        position: relative;
        font-size: 1.4rem;
        color: #2c3e50;
        padding-bottom: 15px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        transform-origin: left center; /* Anchor the transform to the left */
        transition: transform 0.3s ease;
    }
    
    .s2 h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #1abc9c, transparent);
        transition: width 0.3s ease;
    }
    
    .s2 h2 i {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-size: 1.3em;
        transition: transform 0.3s ease;
    }
    
    /* Change the hover effect to only scale the icon instead of the entire heading */
    .s2 h2:hover i {
        transform: scale(1.2) ;
    }
    
    .s2 h2:hover::after {
        width: 120px;
    }
     .admin-info {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(26, 188, 156, 0.1);
        transition: all 0.3s ease;
    }
    
    #admin-greeting {
        font-size: 1.8rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    #admin-greeting::before {
        content: '👋';
        font-size: 2rem;
        animation: wave 2s infinite;
    }
    
    #admin-name {
        background: linear-gradient(45deg, #1abc9c, #16a085);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: bold;
        padding: 0 5px;
        position: relative;
    }
    
    #admin-name::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #1abc9c, #16a085);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }
    
    #admin-name:hover::after {
        transform: scaleX(1);
    }
    
    /* Animations */
    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-20deg); }
        75% { transform: rotate(15deg); }
    }
    
    /* Enhanced Table Headers */
    .admin-table thead th {
        background: linear-gradient(135deg, #1abc9c, #16a085);
        color: white;
        padding: 15px 20px;
        /* font-size: 1rem; */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
    }
    
    .admin-table thead th i {
        margin-right: 8px;
        font-size: 1.1em;
        opacity: 0.9;
        transition: transform 0.3s ease;
    }
    

    .admin-table thead th::after {
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
        animation: shimmer 2s infinite;
    }  
    
</style>
<body>

    <!-- <header class="admin-header">
        <div class="logo">
            <a href="index.php">
                <img id="logoheader" src="../User/dp56vcf7.png" alt="Image Description">
            </a>
        </div>
    </header>
    
    <div class="navbar">
        <a href="index.php" class="homelink"><i class="fa-solid fa-house-chimney"></i>&nbsp;&nbsp;</i>Home</a>
        <a href="statics.php" ><i class="fa-regular fa-clipboard">&nbsp;&nbsp;</i>Statics</a>
        <a href="manage-users.php"><i class="fa-solid fa-users-rectangle">&nbsp;&nbsp;</i>Manage Users</a>
        <a href="manage-orders.php"><i class="fa-solid fa-clipboard-list">&nbsp;&nbsp;</i>Manage Orders</a>
         <a href="reports.php"><i class="fa-solid fa-clipboard-check">&nbsp;&nbsp;</i>Reports</a> 
         <a href="settings.php"><i class="fa-solid fa-gear">&nbsp;&nbsp;</i>Settings</a> 
        <a href="manage-products.php" ><i class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;</i>Manage Products</a>

    </div>  -->

    <!-- Main Content -->

    <!-- User Management -->

    <main>
        <!-- Statistics Section -->
        <section class="admin-section">
            <div class="admin-info">
                <span id="admin-greeting">Welcome, <span
                        id="admin-name"><?php echo htmlspecialchars($_SESSION['username']) ?></span></span>
                <!-- <button id="logout-btn" onclick=""><a href="login.php"></a><i class="fa-solid fa-right-from-bracket">&nbsp;&nbsp;</i>Logout</button> -->
            </div>

            <p>Overview of recent activities and system status.</p>
            <div class="stats-container">
                <div class="stat-box">
                    <h2><i class="fa-solid fa-user-group"></i> Total Users</h2>
                    <p><?php echo number_format($stats['total_users']); ?></p>
                </div>
                <div class="stat-box">
                    <h2><i class="fa-solid fa-list-check"></i> Orders Today</h2>
                    <p><?php echo number_format($stats['orders_today']); ?></p>
                </div>
                <div class="stat-box">
                    <h2><i class="fa-solid fa-wallet"></i> Total Revenue</h2>
                    <p><?php echo number_format($stats['total_revenue']) . ' VND'; ?></p>
                </div>
            </div>
        </section>

        <!-- Users Section -->
        <section class="admin-section s2">
            <h2><i class="fa-solid fa-users"></i> Recent Registered Users</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-id-badge"></i> ID</th>
                        <th><i class="fa-solid fa-user"></i> Username</th>
                        <th><i class="fa-solid fa-user"></i> Full Name</th>
                        <th><i class="fa-solid fa-envelope"></i> Email</th>
                        <th><i class="fa-solid fa-phone"></i> Phone</th>
                        <th><i class="fa-solid fa-user-tag"></i> Role</th>
                        <th><i class="fa-solid fa-toggle-on"></i> Status</th>
                        <th><i class="fa-solid fa-calendar-alt"></i> Register Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone_num']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($user['status']); ?>">
                                    <?php echo htmlspecialchars($user['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($user['register_date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button class="link" onclick="window.location.href='manage-users.php'">View All Users</button>
        </section>

        <!-- Products Section -->
        <section class="admin-section s2">
            <h2><i class="fa-solid fa-car"></i> Recent Updated Products</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-hashtag"></i> ID</th>
                        <th><i class="fa-solid fa-image"></i> Image</th>
                        <th><i class="fa-solid fa-car"></i> Car Name</th>
                        <th><i class="fa-solid fa-building"></i> Brand</th>
                        <th><i class="fa-solid fa-tag"></i> Price</th>
                        <th><i class="fa-solid fa-circle-info"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($product = mysqli_fetch_assoc($products_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                            <td>
                                <img src="../User/<?php echo htmlspecialchars($product['image_link']); ?>"
                                    alt="<?php echo htmlspecialchars($product['car_name']); ?>"
                                    style="width: 50px; height: 30px; object-fit: cover;">
                            </td>
                            <td><?php echo htmlspecialchars($product['car_name']); ?></td>
                            <td><?php echo htmlspecialchars($product['type_name']); ?></td>
                            <td><?php echo number_format($product['price']) . ' VND'; ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($product['status']); ?>">
                                    <?php echo htmlspecialchars($product['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button class="link" onclick="window.location.href='manage-products.php'">View All Products</button>
        </section>

        <!-- Orders Section -->
        <section class="admin-section s2">
            <h2><i class="fa-solid fa-list-check"></i> Recent New Orders</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="far fa-calendar-alt"></i> Order Date</th>
                        <th><i class="fas fa-user"></i> Customer</th>
                        <th><i class="fas fa-map-marker-alt"></i> Address</th>
                        <th><i class="fas fa-money-bill-wave"></i> Total Amount</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($orders_result)): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($order['order_id']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($order['full_name']); ?></strong>
                                <br>
                                <small><?php echo htmlspecialchars($order['username']); ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                            <td><?php echo number_format($order['total_amount']) . ' VND'; ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($order['order_status']); ?>">
                                    <?php echo htmlspecialchars($order['order_status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button class="link" onclick="window.location.href='manage-orders.php'">View All Orders</button>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Stagger animation for sections
            const sections = document.querySelectorAll('.admin-section');
            sections.forEach((section, index) => {
                section.style.animationDelay = `${index * 0.2}s`;
            });

            // Animate statistics numbers
            const statNumbers = document.querySelectorAll('.stat-box p');
            statNumbers.forEach(stat => {
                const finalNumber = parseInt(stat.textContent.replace(/[^0-9]/g, ''));
                animateNumber(stat, finalNumber);
            });

            // Add hover effect to table rows
            const tableRows = document.querySelectorAll('.admin-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function () {
                    this.style.transform = 'scale(1.01)';
                    this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
                });

                row.addEventListener('mouseleave', function () {
                    this.style.transform = 'scale(1)';
                    this.style.boxShadow = 'none';
                });
            });

            // Function to animate numbers
            function animateNumber(element, final) {
                let start = 0;
                const duration = 2000;
                const step = timestamp => {
                    if (!start) start = timestamp;
                    const progress = Math.min((timestamp - start) / duration, 1);
                    const current = Math.floor(progress * final);
                    element.textContent = current.toLocaleString() +
                        (element.textContent.includes('VND') ? ' VND' : '');

                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            // Add pulse animation to status badges
            const statusBadges = document.querySelectorAll('.status-badge');
            statusBadges.forEach(badge => {
                badge.addEventListener('mouseenter', function () {
                    this.style.transform = 'scale(1.1)';
                });

                badge.addEventListener('mouseleave', function () {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
    <script>
                // Add this to your existing DOMContentLoaded event listener
        document.addEventListener('DOMContentLoaded', function() {
            // Animate admin greeting
            const adminName = document.getElementById('admin-name');
            const letters = adminName.textContent.split('');
            adminName.textContent = '';
            
            letters.forEach((letter, i) => {
                const span = document.createElement('span');
                span.textContent = letter;
                span.style.opacity = '0';
                span.style.transform = 'translateY(-20px)';
                span.style.transition = `all 0.3s ease ${i * 0.1}s`;
                adminName.appendChild(span);
                
                // Trigger animation after a small delay
                setTimeout(() => {
                    span.style.opacity = '1';
                    span.style.transform = 'translateY(0)';
                }, 100);
            });
        
            // Add hover effect to table headers
            const tableHeaders = document.querySelectorAll('.admin-table th');
            tableHeaders.forEach(header => {
                header.addEventListener('mouseenter', function() {
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.style.transform = 'scale(1.2) rotate(5deg)';
                    }
                });
                
                header.addEventListener('mouseleave', function() {
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.style.transform = 'scale(1) rotate(0)';
                    }
                });
            });
        });
    </script>
</body>
<?php include 'footer.php'; ?>
<?php
include 'header.php';

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
    margin: 20px ;
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

.admin-table th, .admin-table td {
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
    background-color: #2c3e50; /* Darker color for admin navbar */
    overflow: hidden;
    font-weight: bold;
    padding: 10px 0;
    /* padding-left: 40px; */
}

.navbar a {
    color: #ecf0f1; /* Light text color */
    float: left;
    display: block;
    text-align: center;
    padding: 14px 20px;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s; /* Smooth transition */
}

/* Hover Effects for Links */
.navbar a:hover {
    background-color: #34495e; /* Slightly lighter background on hover */
    color: #1abc9c; /* Accent color for text on hover */
}

/* Active Link */
.navbar a.active {
    background-color: #1abc9c; /* Highlight color for active page */
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
    background-color: #1abc9c; /* Highlight for dropdown items on hover */
}

/* Show Dropdown on Hover */
.navbar .dropdown:hover .dropdown-content {
    display: block;
}

#logoheader{
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

Specific hover effect for Ban button
.admin-table button[style*="background-color: red;"] {
    background-color: #e74c3c;
    color: white;
    border: none;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.admin-table button[style*="background-color: red;"]:hover {
     background-color: #c0392b; /* Darker red on hover  */
    transform: scale(1.1); 
    /* Slight zoom effect  */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); 
    /* Add shadow  */
}
/* More Button Styling */
button.link {
    margin-top: 20px;
    display: inline-block;
    background-color: #1abc9c; /* Màu nền xanh ngọc */
    color: white; /* Màu chữ trắng */
    border: none;
    border-radius: 8px;
    padding: 10px 20px; /* Kích thước nút */
    font-size: 16px; /* Kích thước chữ */
    font-weight: bold; /* Đậm chữ */
    cursor: pointer; /* Hiển thị icon tay khi hover */
    transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Hiệu ứng mượt */
    text-align: center; /* Canh giữa văn bản */
}

/* Hover Effect for More Button */
button.link:hover {
    background-color: #16a085; /* Màu nền đậm hơn khi hover */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Đổ bóng khi hover */
}

/* Active State for More Button */
button.link:active {
    background-color: #0e7766; /* Màu tối hơn khi bấm */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Giảm độ cao bóng */
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
    <main>
        <section class="admin-section">
            <div class="admin-info">
                <span id="admin-greeting">Welcome, <span id="admin-name"><?php echo htmlspecialchars($_SESSION['username']) ?></span></span>
                <!-- <button id="logout-btn" onclick=""><a href="login.php"></a><i class="fa-solid fa-right-from-bracket">&nbsp;&nbsp;</i>Logout</button> -->
            </div>

            <p>Overview of recent activities and system status.</p>
            
            <!-- Quick Stats -->
            <div class="stats-container">
                <div class="stat-box">
                    <h2><i class="fa-solid fa-user-group">&nbsp;&nbsp;</i>Total Users</h2>
                    <!-- <p>2</p> -->
                </div>
                <div class="stat-box">
                    <h2><i class="fa-solid fa-list-check">&nbsp;&nbsp;</i>Orders </h2>
                    <!-- <p>1</p> -->
                </div>
                <div class="stat-box">
                    <h2><i class="fa-solid fa-wallet">&nbsp;&nbsp;</i>Revenue</h2>
                    <!-- <p>120,345,000,000 đ</p> -->
                </div>
            </div>
        </section>

        <!-- User Management -->
        <section class="admin-section">
            <h2><i class="fa-solid fa-users">&nbsp;&nbsp;</i>User Management</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- <td>DZT711</td>
                        <td>nguyenihuynsh7112005@gmail.com</td>
                        <td>Admin</td>
                        <td>
                            <button onclick="window.location.href='manage-users.php'"   style="background-color: red;"class="ban">Ban</button>
                            <button onclick="window.location.href='manage-users.php'" >Edit</button>
                            <button onclick="window.location.href='manage-users.php'" >Delete</button>
                        </td> -->
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
            <button class="link"  onclick="window.location.href='manage-users.php'">More</button>
        </section>

        <!-- Order Management -->
        <section class="admin-section">
            <h2><i class="fa-solid fa-list-check">&nbsp;&nbsp;</i>Order Management</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID&nbsp;&nbsp;&nbsp;</th>
                        <th class="customer">Customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th class="status">Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <!-- <td>12345</td>
                        <td>Huy Nguyen</td>
                        <td>Shipped</td>
                        <td>
                            <button onclick="window.location.href='manage-orders.php'">View</button>
                        </td> -->
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
            <button class="link"  onclick="window.location.href='manage-orders.php'">More</button>

        </section>
        <!-- <hr> -->
    </main>

    <!-- Footer -->
    <!-- <footer>
        <div class="copyright">
            <p>© 2024 Auto Car. All rights reserved.</p>
        </div>
    </footer> -->

 

</body>
</html>
<?php
include 'footer.php';

?>
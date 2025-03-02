<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="statics.css">
    <script src="statics.js"></script>
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<body>
        <!-- Header -->
        <header class="admin-header">
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
        <!-- <a href="reports.php"><i class="fa-solid fa-clipboard-check">&nbsp;&nbsp;</i>Reports</a> -->
        <!-- <a href="settings.php"><i class="fa-solid fa-gear">&nbsp;&nbsp;</i>Settings</a> -->
        <a href="manage-products.php" ><i class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;</i>Manage Products</a>

    </div>
    <main>
        <div id="staticsforproducts">
            <section class="admin-section">
                <h2><i class="fa-regular fa-clipboard">&nbsp;&nbsp;</i>Best-selling product</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Price</th>
                            <th>Speed</th>
                            <th>Quantity</th>
                            <th>Revenue</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">

                        
                        <!-- Products will be inserted here by JavaScript -->

                        
                    </tbody>
                </table>
            </section>
        </div>
        <div id="staticsforcustomers">
            <section class="admin-section">
                <h2><i class="fa-solid fa-users">&nbsp;&nbsp;</i>Top buyer in last 1 year</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Revenue</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>DZT711</td>
                            <td>nguyensihuynsh7112005@gmail.com</td>
                            <td>Admin</td>
                            <td>999,999,999,999 VND</td>
                            <td>

                                <button onclick="window.location.href='view-invoice.php'">View all bills</button>
                                
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </section>
        </div>
    </main>
    <footer>
        <div class="copyright">
            <p>© 2024 Auto Car. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
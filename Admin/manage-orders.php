<?php
include 'header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí hóa đơn</title>
    <!-- <script src="mo.js"></script> -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="mo.css"> -->
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">
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
    padding-left: 100px;
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
/* Filter Section */
.filter-section {
    background-color: white;
    padding: 20px;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out; /* Thêm hiệu ứng cho cả phần lọc khi hover */
}

.filter-section h2 {
    text-align: center;
    color: #2c3e50;
    font-size: 1.5em;
    margin-bottom: 20px;
    font-weight: bold;
}

.filter-section label {
    font-weight: bold;
    margin-right: 10px;
    color: #333;
}

.filter-section input,
.filter-section select,
.filter-section button {
    padding: 10px 15px;
    font-size: 1em;
    margin: 8px 5px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: all 0.3s ease-in-out;
}

/* Hiệu ứng hover cho các input, select và button */
.filter-section input:hover,
.filter-section select:hover,
.filter-section button:hover {
    background-color: #3498db;
    border-color: #2980b9;
    color: white;
    cursor: pointer;
}

.filter-section input:focus,
.filter-section select:focus,
.filter-section button:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.8); /* Thêm bóng cho khi focus */
}

.filter-section button {
    background-color: #3498db;
    color: white;
    cursor: pointer;
    font-weight: bold;
}

.filter-section button:hover {
    background-color: #2980b9;
    transform: scale(1.05); /* Hiệu ứng phóng to khi hover */
}

/* Các khoảng cách giữa các phần tử trong filter */
.filter-section .filters {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.filter-section .filters div {
    flex: 1 1 30%;
    display: flex;
    flex-direction: column;
}

/* Hiệu ứng cho các nhóm lọc khi hover */
.filter-section .filters div:hover {
    transform: translateY(-5px); /* Di chuyển nhẹ lên khi hover */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Thêm bóng cho khi hover */
    transition: all 0.3s ease-in-out;
}

/* Responsive: Chuyển đổi layout cho các màn hình nhỏ */
@media (max-width: 768px) {
    .filter-section .filters {
        flex-direction: column;
        align-items: center;
    }

    .filter-section .filters div {
        width: 100%;
        margin-bottom: 15px;
    }
}

</style>
<body>
    

    <main>
        <!-- Filter & Sorting Section -->
        <section class="filter-section">
            <h2>Filter & Sort Orders</h2>
            <!-- Date Range Filter -->
            <label for="start-date">Start Date:</label>
            <input type="date" id="start-date">
            <label for="end-date">End Date:</label>
            <input type="date" id="end-date">
            <br><br>
            <!-- Status Filter -->
            <label for="status-filter">Status:</label>
            <select id="status-filter">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="Shipped">Shipped</option>
                <option value="Confirmed">Confirmed</option>
                <option value="Delivered">Delivered</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            <br><br>
            <!-- Sort By Location -->
            <button id="sort-location">Sort by Location</button>
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
                        <th class="Date">Date</th>
                        <th class="Location">Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Random orders will be added dynamically here -->
                </tbody>
            </table>
        </section>
        <!-- <hr> -->
    </main>


</body>
</html>
<?php
include 'footer.php';
?>

<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí sản phẩm</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">
    <!-- <script src="mp.js"></script>
    <link rel="stylesheet" href="mp.css"> -->
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
/* Styling for Modals (Add Product and Edit Product) */
#addProductModal, #editProductModal {
    display: none; /* Hidden by default */
    position: fixed; /* Position fixed to the viewport */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    z-index: 1000; /* Ensure the modal is on top */
    width: 400px;
    max-width: 100%;
}

/* Styling for Form Inputs */
#addProductForm input, #editProductForm input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
}

#addProductForm input[type="file"], #editProductForm input[type="file"] {
    padding: 5px;
}

/* Styling for Buttons inside the Modals */
#addProductForm button, #editProductForm button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

#addProductForm button {
    background-color: #1abc9c;
    color: white;
    margin-bottom: 10px;
}

#editProductForm button {
    background-color: #007bff;
    color: white;
}

#addProductForm button:hover, #editProductForm button:hover {
    background-color: #16a085; /* Darker green for Add button */
}

#addProductForm button[type="button"], #editProductForm button[type="button"] {
    background-color: #e74c3c;
    margin-top: 10px;
}

#addProductForm button[type="button"]:hover, #editProductForm button[type="button"]:hover {
    background-color: #c0392b;
}

/* Close Button in Modals */
button[type="button"] {
    width: 48%;
    margin-right: 4%;
    background-color: #e74c3c;
}

button[type="button"]:hover {
    background-color: #c0392b;
}

/* Background Overlay when Modals are Active */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none; /* Hidden by default */
}

/* Adding some spacing and styling to the modal header */
#addProductModal h3, #editProductModal h3 {
    font-size: 20px;
    margin-bottom: 15px;
    font-weight: bold;
    text-align: center;
}
#editProductModal {
    width: 400px;
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

#editProductModal input[type="text"], #editProductModal input[type="number"] {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}

#editProductModal button {
    padding: 10px;
    border: none;
    background-color: #007BFF;
    color: white;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

#editProductModal button:hover {
    background-color: #0056b3;
}

#currentProductImage img {
    max-width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
}
/* Đặt kiểu cho overlay (màn che phía sau) */
#modalOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Màu nền mờ */
    display: none; /* Ẩn mặc định */
    z-index: 999; /* Đảm bảo nó hiển thị trên các phần tử khác */
}

/* Kiểu cho modal (form edit) */
#editProductModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Dịch chuyển nó về giữa */
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    display: none; /* Ẩn mặc định */
    z-index: 1000; /* Đảm bảo modal hiển thị trên overlay */
    width: 400px; /* Chiều rộng modal */
    max-width: 90%; /* Chiều rộng tối đa */
}

/* Định dạng các trường trong form */
#editProductModal input, 
#editProductModal select, 
#editProductModal textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Định dạng các nút trong form */
#editProductModal button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

#editProductModal button:hover {
    background-color: #45a049;
}
/* Đặt kiểu cho modal (form add product) */
#addProductModal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%); /* Căn giữa màn hình */
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
    display: none; /* Ẩn modal khi không cần thiết */
    z-index: 1000; /* Đảm bảo modal hiển thị trên overlay */
    width: 400px; /* Chiều rộng modal */
    max-width: 90%; /* Chiều rộng tối đa */
    box-sizing: border-box; /* Đảm bảo padding không làm thay đổi kích thước tổng thể */
}

/* Định dạng cho các input trong form */
#addProductModal input, 
#addProductModal select, 
#addProductModal textarea {
    width: 100%; /* Chiều rộng 100% để không bị tràn */
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; /* Đảm bảo padding không ảnh hưởng đến kích thước tổng thể */
}

/* Định dạng cho các nút trong form */
#addProductModal button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}

#addProductModal button:hover {
    background-color: #45a049;
}

/* Đảm bảo modal không bị tràn khi mở */
#modalOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none; /* Ẩn modal overlay khi không cần thiết */
    z-index: 999;
}

</style>
<body>
    <main>
        <section class="admin-section">
            <h2><i class="fa-solid fa-pen-to-square">&nbsp;&nbsp;</i>Product Management</h2>
            <button onclick="showAddProductForm()" id="add-user-btn" style="margin-bottom: 10px;">Add Product</button>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Speed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <!-- Products will be inserted here by JavaScript -->
                </tbody>
            </table>
        </section>
    </main>

    <!-- Add Product Modal -->
    <div id="addProductModal" style="display: none;">
        <h3>Add Product</h3>
        <form id="addProductForm">
            <input type="text" id="productName" placeholder="Product Name" required><br>
            <input type="number" id="productYear" placeholder="Year" required><br>
            <input type="number" id="productPrice" placeholder="Price" required><br>
            <input type="text" id="productSpeed" placeholder="Speed" required><br>
            <input type="file" id="productImage"><br>
            <button type="submit"onclick="window.alert('Đã thêm thành công')" >Add</button>
            <button type="button" onclick="closeAddProductForm()">Cancel</button>
        </form>
    </div>

    <!-- Edit Product Modal -->
<!-- Modal for Editing Product -->
<div id="editProductModal" style="display: none;">
    <h3>Edit Product</h3>
    <form id="editProductForm">
        <!-- Hiển thị ảnh sản phẩm hiện tại -->
        <div id="currentProductImage">
            <img id="currentImagePreview" src="../User/BMW 320I SPORT LINE 2023.webp" alt="Current Product Image" style="max-width: 200px; margin-bottom: 10px;">
        </div>

        <label for="editProductName">Product Name:</label>
        <input type="text" id="editProductName" placeholder="Product Name" required><br>
        
        <label for="editProductYear">Year:</label>
        <input type="number" id="editProductYear" placeholder="Year" required><br>
        
        <label for="editProductPrice">Price:</label>
        <input type="number" id="editProductPrice" placeholder="Price" required><br>
        
        <label for="editProductSpeed">Speed:</label>
        <input type="text" id="editProductSpeed" placeholder="Speed" required><br>
        
        <label for="editProductImage">Upload New Image (optional):</label>
        <input type="file" id="editProductImage"><br>
        
        <button type="button" onclick="window.alert('Đã sửa thành công')">Save</button>
        <button type="button" onclick="closeEditProductForm()">Cancel</button>
    </form>
</div>



    <div class="modal-overlay" id="modalOverlay"></div>


</body>

</html>
<?php
include 'footer.php';
?>

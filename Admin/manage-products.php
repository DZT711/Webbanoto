<?php
include 'header.php';
include '../User/connect.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>showNotification('You don't have permission to access this page!','warning'); window.location.href='index.php';</script>";
    exit();
}

// Xử lý thêm sản phẩm
if (isset($_POST['add_product'])) {
    $car_name = mysqli_real_escape_string($connect, $_POST['car_name']);
    // Check if car name already exists
    $check_query = "SELECT product_id FROM products WHERE car_name = '$car_name'";
    $check_result = mysqli_query($connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>
            showNotification('A product with this name already exists!', 'warning');
            setTimeout(() => {
                document.getElementById('car_name').focus();
            }, 500);
        </script>";
        exit();
    }

    $brand_id = mysqli_real_escape_string($connect, $_POST['brand_id']);
    $year = mysqli_real_escape_string($connect, $_POST['year']);
    $price = mysqli_real_escape_string($connect, $_POST['price']);
    $max_speed = mysqli_real_escape_string($connect, $_POST['max_speed']);
    $engine_name = mysqli_real_escape_string($connect, $_POST['engine_name']);
    $fuel_name = mysqli_real_escape_string($connect, $_POST['fuel_name']);
    $color = mysqli_real_escape_string($connect, $_POST['color']);
    $seat_number = mysqli_real_escape_string($connect, $_POST['seat_number']);
    $engine_power = mysqli_real_escape_string($connect, $_POST['engine_power']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);
    $fuel_capacity = mysqli_real_escape_string($connect, $_POST['fuel_capacity']);
    $car_description = mysqli_real_escape_string($connect, $_POST['car_description']);

    // Xử lý upload ảnh
    $image_link = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../User/uploads/';


        // Kiểm tra và tạo thư mục uploads nếu chưa tồn tại
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Đặt tên file với timestamp để tránh trùng lặp
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        // Di chuyển file upload vào thư mục đã chỉ định
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Lưu đường dẫn tương đối (sau ../User/)
            $image_link = 'uploads/' . $image_name;
        } else {
            echo "<script>showNotification('Couldn't upload the image!','error');</script>";
        }
    }

    $query = "INSERT INTO products (car_name, brand_id, year_manufacture, price, max_speed, engine_name, 
              fuel_name, color, seat_number, engine_power, image_link, status, fuel_capacity, car_description) 
              VALUES ('$car_name', '$brand_id', '$year', '$price', '$max_speed', '$engine_name', 
              '$fuel_name', '$color', '$seat_number', '$engine_power', '$image_link', '$status', '$fuel_capacity', '$car_description')";

    if (mysqli_query($connect, $query)) {
        echo "<script>showNotification('Add product successfully!', 'success');</script>";
    } else {
        echo "<script>showNotification('Error: " . mysqli_error($connect) . "', 'error');</script>";
    }
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['update_product'])) {
    $product_id = mysqli_real_escape_string($connect, $_POST['product_id']);
    $car_name = mysqli_real_escape_string($connect, $_POST['car_name']);
    $brand_id = mysqli_real_escape_string($connect, $_POST['brand_id']);
    $year = mysqli_real_escape_string($connect, $_POST['year']);
    $price = mysqli_real_escape_string($connect, $_POST['price']);
    $max_speed = mysqli_real_escape_string($connect, $_POST['max_speed']);
    $engine_name = mysqli_real_escape_string($connect, $_POST['engine_name']);
    $fuel_name = mysqli_real_escape_string($connect, $_POST['fuel_name']);
    $color = mysqli_real_escape_string($connect, $_POST['color']);
    $seat_number = mysqli_real_escape_string($connect, $_POST['seat_number']);
    $engine_power = mysqli_real_escape_string($connect, $_POST['engine_power']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);
    $fuel_capacity = mysqli_real_escape_string($connect, $_POST['fuel_capacity']);
    $car_description = mysqli_real_escape_string($connect, $_POST['car_description']);

    // Xử lý upload ảnh mới nếu có
    $image_update = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../User/uploads/';

        // Kiểm tra và tạo thư mục nếu chưa tồn tại
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_update = ", image_link = 'uploads/" . $image_name . "'";
        } else {
            echo "<script>showNotification('Couldn't upload the image!','error');</script>";
        }
    }

    $query = "UPDATE products SET 
              car_name = '$car_name', 
              brand_id = '$brand_id', 
              year_manufacture = '$year', 
              price = '$price', 
              max_speed = '$max_speed', 
              engine_name = '$engine_name', 
              fuel_name = '$fuel_name', 
              color = '$color', 
              seat_number = '$seat_number', 
              engine_power = '$engine_power',
              fuel_capacity = '$fuel_capacity',
            car_description = '$car_description', 
              status = '$status'
              $image_update
              WHERE product_id = $product_id";

    if (mysqli_query($connect, $query)) {
        echo "<script>showNotification('Update the product successfully!', 'success');</script>";
    } else {
        echo "<script>showNotification('Error: " . mysqli_error($connect) . "', 'error');</script>";
    }
}


// Add this to your existing POST handlers
if (isset($_POST['delete_product'])) {
    $product_id = mysqli_real_escape_string($connect, $_POST['product_id']);

    // First get the image path to delete the file
    $query = "SELECT image_link FROM products WHERE product_id = $product_id";
    $result = mysqli_query($connect, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Delete the image file
        $image_path = "../User/uploads/" . $product['image_link'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete from database
        $delete_query = "DELETE FROM products WHERE product_id = $product_id";
        if (mysqli_query($connect, $delete_query)) {
            echo "<script>showNotification('Product deleted successfully', 'success');</script>";
        } else {
            echo "<script>showNotification('Error deleting product', 'error');</script>";
        }
    }
    exit;
}

// Lấy danh sách hãng xe cho dropdown
$brands_query = "SELECT * FROM car_types ORDER BY type_name";
$brands_result = mysqli_query($connect, $brands_query);
$brands = [];
while ($brand = mysqli_fetch_assoc($brands_result)) {
    $brands[] = $brand;
}
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

    /* Specific hover effect for Ban */
     button .admin-table button[style*="background-color: red;"] {
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

    /* Styling for Modals (Add Product and Edit Product) */
    #addProductModal,
    #editProductModal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Position fixed to the viewport */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        /* Ensure the modal is on top */
        width: 400px;
        max-width: 100%;
    }

    /* Styling for Form Inputs */
    #addProductForm input,
    #editProductForm input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    #addProductForm input[type="file"],
    #editProductForm input[type="file"] {
        padding: 5px;
    }

    /* Styling for Buttons inside the Modals */
    #addProductForm button,
    #editProductForm button {
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

    #addProductForm button:hover,
    #editProductForm button:hover {
        background-color: #16a085;
        /* Darker green for Add button */
    }

    #addProductForm button[type="button"],
    #editProductForm button[type="button"] {
        background-color: #e74c3c;
        /* margin-top: 10px; */
    }

    #addProductForm button[type="button"]:hover,
    #editProductForm button[type="button"]:hover {
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
        display: none;
        /* Hidden by default */
    }

    /* Adding some spacing and styling to the modal header */
    #addProductModal h3,
    #editProductModal h3 {
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

    #editProductModal input[type="text"],
    #editProductModal input[type="number"] {
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
        background-color: rgba(0, 0, 0, 0.5);
        /* Màu nền mờ */
        display: none;
        /* Ẩn mặc định */
        z-index: 999;
        /* Đảm bảo nó hiển thị trên các phần tử khác */
    }

    /* Kiểu cho modal (form edit) */
    #editProductModal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* Dịch chuyển nó về giữa */
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
        display: none;
        /* Ẩn mặc định */
        z-index: 1000;
        /* Đảm bảo modal hiển thị trên overlay */
        width: 400px;
        /* Chiều rộng modal */
        max-width: 90%;
        /* Chiều rộng tối đa */
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
        transform: translate(-50%, -50%);
        /* Căn giữa màn hình */
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
        display: none;
        /* Ẩn modal khi không cần thiết */
        z-index: 1000;
        /* Đảm bảo modal hiển thị trên overlay */
        width: 400px;
        /* Chiều rộng modal */
        max-width: 90%;
        /* Chiều rộng tối đa */
        box-sizing: border-box;
        /* Đảm bảo padding không làm thay đổi kích thước tổng thể */
    }

    /* Định dạng cho các input trong form */
    #addProductModal input,
    #addProductModal select,
    #addProductModal textarea {
        width: 100%;
        /* Chiều rộng 100% để không bị tràn */
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        /* Đảm bảo padding không ảnh hưởng đến kích thước tổng thể */
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
        display: none;
        /* Ẩn modal overlay khi không cần thiết */
        z-index: 999;
    }
</style>
<style>
    /* Improved Modal Styling */
    #addProductModal,
    #editProductModal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        padding: 30px;
        width: 500px;
        max-width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    /* Modal Header */
    #addProductModal h3,
    #editProductModal h3 {
        font-size: 22px;
        font-weight: 600;
        color: #333;
        margin: 0 0 20px 0;
        text-align: center;
        border-bottom: 2px solid #1abc9c;
        padding-bottom: 10px;
    }

    /* Form Groups */
    #addProductForm div,
    #editProductForm div {
        margin-bottom: 16px;
    }

    /* Labels */
    #addProductForm label,
    #editProductForm label {
        display: block;
        font-weight: 500;
        margin-bottom: 6px;
        color: #444;
    }

    /* Form Controls */
    #addProductForm input,
    #addProductForm select,
    #editProductForm input,
    #editProductForm select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    #addProductForm input:focus,
    #addProductForm select:focus,
    #editProductForm input:focus,
    #editProductForm select:focus {
        border-color: #1abc9c;
        box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.2);
        outline: none;
        background-color: #fff;
    }

    /* File Input */
    #addProductForm input[type="file"],
    #editProductForm input[type="file"] {
        padding: 8px;
        background-color: #fff;
        border: 1px dashed #ccc;
    }

    /* Current Image Preview */
    #currentProductImage {
        text-align: center;
        margin-bottom: 20px;
    }

    #currentImagePreview {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Buttons Container */
    .form-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 25px;
    }

    /* Form Buttons */
    #addProductForm button,
    #editProductForm button {
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
        flex: 1;
        margin: 0 5px;
    }

    /* Save Button */
    #addProductForm button[type="submit"],
    #editProductForm button[type="submit"] {
        background-color: #1abc9c;
        color: white;
    }

    #addProductForm button[type="submit"]:hover,
    #editProductForm button[type="submit"]:hover {
        background-color: #16a085;
        transform: translateY(-2px);
    }

    /* Cancel Button */
    #addProductForm button[type="button"],
    #editProductForm button[type="button"] {
        background-color: #e74c3c;
        color: white;
    }

    #addProductForm button[type="button"]:hover,
    #editProductForm button[type="button"]:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
    }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 999;
        display: none;
        backdrop-filter: blur(3px);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {

        #addProductModal,
        #editProductModal {
            width: 95%;
            padding: 20px;
        }

        .form-buttons {
            flex-direction: column;
        }

        #addProductForm button,
        #editProductForm button {
            margin: 5px 0;
        }
    }

    /* Form Section Separator */
    .form-section {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }

    /* Required Field Indicator */
    .required:after {
        content: "*";
        color: #e74c3c;
        margin-left: 4px;
    }

    /* Status Options Styling */
    #status option,
    #edit_status option {
        padding: 8px;
    }

    /* Form Success Message */
    .form-success {
        background-color: #d4edda;
        color: #155724;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
        display: none;
    }
</style>
<style>
    /* Delete confirmation popup styles */
    #deleteConfirmModal {
        display: none;
    }

    #deleteConfirmModal .popup-content {
        max-width: 400px;
        text-align: center;
    }

    #deleteConfirmModal h3 {
        color: #dc3545;
        margin-bottom: 20px;
    }

    #deleteConfirmModal h3 i {
        margin-right: 10px;
    }

    #deleteConfirmModal p {
        margin-bottom: 25px;
        color: #666;
    }

    #deleteConfirmModal .popup-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    #deleteConfirmModal .confirm-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #deleteConfirmModal .confirm-btn:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    #deleteConfirmModal .cancel-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #deleteConfirmModal .cancel-btn:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }
</style>
<style>
    /* Add these styles to your existing CSS */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .popup .popup-content {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        position: relative;
        width: 400px;
        max-width: 90%;
        animation: popupFadeIn 0.3s ease;
    }

    @keyframes popupFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<style>
    /* Add Product Button Styling */
    #add-user-btn {
        background: #1abc9c;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    #add-user-btn i {
        font-size: 18px;
    }

    #add-user-btn:hover {
        background: #16a085;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Form Input Icons */
    .form-section div {
        position: relative;
    }

    .form-section input,
    .form-section select {
        padding-left: 35px !important;
    }

    /* .form-section i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color:rgb(0, 0, 0);
    opacity: 0.7;
} */

/* Table Header Icons */
.admin-table th i {
    margin-right: 8px;
    color:rgb(0, 0, 0);
}
.delete-btn{
    background-color:red !important;
}
</style>
<style>
        /* Add to your existing styles */

    
    .form-section i {
        /* position: absolute;
        left: 10px;
        top: 50%; */
        /* transform: translateY(-50%); */
        padding-right:10px;
        /* color:rgb(0, 0, 0); */
        opacity: 0.7;
        z-index: 1;
    }
    
    .form-section input:focus + i,
    .form-section select:focus + i {
        /* color: #16a085; */
        opacity: 1;
        padding-right:10px;
    }
    
    /* Style for file input icon */
    div:has(> input[type="file"]) {
        /* position: relative; */
    }
    
    div:has(> input[type="file"]) i {
        /* position: absolute;
        left: 10px;
        top: 50%; */
        /* transform: translateY(-50%); */
        /* color: #1abc9c; */
        opacity: 0.7;
        padding-right:10px;
    }
    
    /* Form buttons */
    .form-buttons button {
        /* display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px; */
    }
    
    .form-buttons button[type="submit"]::before {
        content: "\f0c7";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        padding-right:10px;
    }
    
    .form-buttons button[type="button"]::before {
        content: "\f00d";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        padding-right:10px;
}
</style>
<style>
        /* Add to your existing styles */
    #addImagePreview, #currentProductImage {
        text-align: center;
        margin: 15px 0;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    
    #addImagePreview img, #currentImagePreview {
        max-width: 200px;
        max-height: 150px;
        object-fit: cover;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    #addImagePreview img:hover, #currentImagePreview:hover {
        transform: scale(1.05);
    }
</style>
<style>
        /* Add to your existing styles */
    .form-section textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
        resize: vertical;
        min-height: 100px;
    }
    
    .form-section textarea:focus {
        border-color: #1abc9c;
        box-shadow: 0 0 0 3px rgba(26, 188, 156, 0.2);
        outline: none;
        background-color: #fff;
    }
</style>
<body>
    <main>
        <section class="admin-section">
    <h2><i class="fa-solid fa-pen-to-square">&nbsp;&nbsp;</i>Product Management</h2>
<button onclick="showAddProductForm()" id="add-user-btn">
    <i class="fa-solid fa-plus"></i>
    Add New Product
</button>
            <table class="admin-table">
                <thead>
    <tr>
        <th><i class="fa-solid fa-hashtag"></i> ID</th>
        <th><i class="fa-solid fa-image"></i> Image</th>
        <th><i class="fa-solid fa-car"></i> Car Name</th>
        <th><i class="fa-solid fa-building"></i> Brand</th>
        <th><i class="fa-solid fa-calendar"></i> Year</th>
        <th><i class="fa-solid fa-tag"></i> Price</th>
        <th><i class="fa-solid fa-gas-pump"></i> Fuel</th>
        <th><i class="fa-solid fa-oil-can"></i> Fuel Capacity</th>

        <th><i class="fa-solid fa-gear"></i> Engine Power</th>
        <th><i class="fa-solid fa-gears"></i> Engine</th>
        <th><i class="fa-solid fa-palette"></i> Color</th>
        <th><i class="fa-solid fa-users"></i> Seats</th>
        <th><i class="fa-solid fa-gauge"></i> Max Speed</th>
        <th><i class="fa-solid fa-circle-info"></i> Status</th>
        <th><i class="fa-solid fa-wrench"></i> Actions</th>
    </tr>
</thead>
                <tbody id="product-list">
                    <?php
                    // Lấy danh sách sản phẩm với tên hãng xe
                    $query = "SELECT p.*, c.type_name 
                              FROM products p 
                              LEFT JOIN car_types c ON p.brand_id = c.type_id 
                              ORDER BY p.product_id ASC";
                    $result = mysqli_query($connect, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['product_id'] . '</td>';
                            echo '<td><img src="../User/' . $row['image_link'] . '" alt="' . $row['car_name'] . '" style="width: 80px; height: 60px; object-fit: cover;"></td>';
                            echo '<td>' . $row['car_name'] . '</td>';
                            echo '<td>' . $row['type_name'] . '</td>';
                            echo '<td>' . $row['year_manufacture'] . '</td>';
                            echo '<td>' . number_format($row['price'], 0, ',', '.') . ' VND</td>';
                            echo '<td>' . $row['fuel_name'] . '</td>';
                            echo '<td>' . $row['fuel_capacity'] . ' </td>';
                            echo '<td>' . $row['engine_power'] . '</td>';
                            echo '<td>' . $row['engine_name'] . '</td>';
                            echo '<td>' . $row['color'] . '</td>';
                            echo '<td>' . $row['seat_number'] . '</td>';

                            echo '<td>' . $row['max_speed'] . '</td>';
                            echo '<td>' . getStatusLabel($row['status']) . '</td>';
                            echo '<td>
    <button onclick="showEditProductForm(' . $row['product_id'] . ')" class="edit-btn">
        <i class="fa-solid fa-edit"></i> Edit
    </button>
    <button onclick="confirmDeleteProduct(' . $row['product_id'] . ')" class="delete-btn">
        <i class="fa-solid fa-trash"></i> Delete
    </button>
</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="9">No products available</td></tr>';
                    }

                    function getStatusLabel($status)
                    {
                        switch ($status) {
                            case 'selling':
                                return '<span style="color: green;">selling</span>';
                            case 'hidden':
                                return '<span style="color: gray;">hidden</span>';
                            case 'discounting':
                                return '<span style="color: blue;">discounting</span>';
                            case 'soldout':
                                return '<span style="color: red;">sold out</span>';
                            default:
                                return $status;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>


<!-- Add Product Form -->
<div id="addProductModal" style="display: none;">
    <h3>Add New Product</h3>
    <form id="addProductForm" method="POST" enctype="multipart/form-data">
                <!-- Update the Add Product Form fields -->
        <div class="form-section">
            <div>
                <label for="car_name" class="required"><span>

                    <i class="fa-solid fa-car"></i>
                </span>Car Name:</label>
                
                <input type="text" id="car_name" name="car_name" required>
            </div>
            
            <div>
                <label for="brand_id" class="required">
                    <span>

                        <i class="fa-solid fa-building"></i>
                    </span>
                    Brand:</label>
                
                <select id="brand_id" name="brand_id" required>
                    <option value="">Select brand</option>
                    <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand['type_id'] ?>"><?= $brand['type_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label for="year" class="required"><span><i class="fa-solid fa-calendar"></i></span>Year of Manufacture:</label>
                
                <input type="number" id="year" name="year" min="1900" max="<?= date('Y') + 1 ?>" required>
            </div>
        </div>
        
        <div class="form-section">
            <div>
                <label for="price" class="required"><span><i class="fa-solid fa-tag"></i></span>Price (VND):</label>
                
                <input type="number" id="price" name="price" min="0" required>
            </div>
            
            <div>
                <label for="max_speed" class="required"><span><i class="fa-solid fa-gauge-high"></i></span>Maximum Speed:</label>
                
                <input type="text" id="max_speed" name="max_speed" required>
            </div>
        </div>
        
        <div class="form-section">
            <div>
                <label for="engine_name" class="required"><span><i class="fa-solid fa-gears"></i></span>Engine:</label>
                
                <input type="text" id="engine_name" name="engine_name" required>
            </div>
            
            <div>
                <label for="fuel_name" class="required"><span><i class="fa-solid fa-gas-pump"></i></span>Fuel Type:</label>
                
                <input type="text" id="fuel_name" name="fuel_name" required>
            </div>
            
                        <div class="form-section">
                <div>
        <label for="fuel_capacity" class="required">
            <span><i class="fa-solid fa-oil-can"></i></span>Fuel Capacity:
        </label>
        <input type="text" 
               id="fuel_capacity" 
               name="fuel_capacity" 
               placeholder="e.g., 65L, 100kWh, 5kg" 
               required>
    </div>
                
                <div>
                    <label for="car_description" class="required">
                        <span><i class="fa-solid fa-align-left"></i></span>Description:
                    </label>
                    <textarea id="car_description" name="car_description" rows="4" required></textarea>
                </div>
            </div>
            <div>
                <label for="color" class="required"><span><i class="fa-solid fa-palette"></i></span>Color:</label>
                
                <input type="text" id="color" name="color" required>
            </div>
        </div>
        
        <div class="form-section">
            <div>
                <label for="seat_number" class="required"><span><i class="fa-solid fa-users"></i></span>Number of Seats:</label>
                
                <input type="number" id="seat_number" name="seat_number" min="1" max="20" required>
            </div>
            
            <div>
                <label for="engine_power" class="required"><span><i class="fa-solid fa-gear"></i></span>Engine Power:</label>
                
                <input type="number" id="engine_power" name="engine_power" min="0" required>
            </div>
        </div>
        
        <div>
            <label for="image" class="required"><span><i class="fa-solid fa-image"></i></span>Image:</label>
            
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        
        <div>
            <label for="status" class="required"><span><i class="fa-solid fa-circle-info" style="padding-right: 10px; opacity:0.7;"></i></span>Status:</label>
            
            <select id="status" name="status" required>
                <option value="selling">Available</option>
                <option value="hidden">Hidden</option>
                <option value="discounting">On Sale</option>
                <option value="soldout">Sold Out</option>
            </select>
        </div>
<div class="form-buttons">
            <button type="submit" name="add_product">Add Product</button>
            <button type="button" onclick="closeAddProductForm()">Cancel</button>
        </div>
    </form>
</div>

<!-- Edit Product Form -->
<div id="editProductModal" style="display: none;">
    <h3>Edit Product Information</h3>
    <form id="editProductForm" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="edit_product_id" name="product_id">
        
        <div id="currentProductImage">
            <img id="currentImagePreview" src="" alt="Product Image">
        </div>
        
        <div class="form-section">
            <div>
                <label for="edit_car_name" class="required">Car Name:</label>
                <input type="text" id="edit_car_name" name="car_name" required>
            </div>
            
            <div>
                <label for="edit_brand_id" class="required">                    <span>

                        <i class="fa-solid fa-building"></i>
                    </span>Brand:</label>
                <select id="edit_brand_id" name="brand_id" required>
                    <option value="">Select brand</option>
                    <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand['type_id'] ?>"><?= $brand['type_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label for="edit_year" class="required"><span><i class="fa-solid fa-calendar"></i></span>Year of Manufacture:</label>
                <input type="number" id="edit_year" name="year" min="1900" max="<?= date('Y') + 1 ?>" required>
            </div>
        </div>
        
        <div class="form-section">
            <div>
                <label for="edit_price" class="required"><span><i class="fa-solid fa-tag"></i></span>Price (VND):</label>
                <input type="number" id="edit_price" name="price" min="0" required>
            </div>
            
            <div>
                <label for="edit_max_speed" class="required"><span><i class="fa-solid fa-gauge-high"></i></span>Maximum Speed:</label>
                <input type="text" id="edit_max_speed" name="max_speed" required>
            </div>
        </div>
        
        <div class="form-section">
            <div>
                <label for="edit_engine_name" class="required"><span><i class="fa-solid fa-gears"></i></span>Engine:</label>
                <input type="text" id="edit_engine_name" name="engine_name" required>
            </div>
            
            <div>
                <label for="edit_fuel_name" class="required"><span><i class="fa-solid fa-gas-pump"></i></span>Fuel Type:</label>
                <input type="text" id="edit_fuel_name" name="fuel_name" required>
            </div>
                        <div class="form-section">
                <div>
        <label for="edit_fuel_capacity" class="required">
            <span><i class="fa-solid fa-oil-can"></i></span>Fuel Capacity:
        </label>
        <input type="text" 
               id="edit_fuel_capacity" 
               name="fuel_capacity" 
               placeholder="e.g., 65L, 100kWh, 5kg" 
               required>
    </div>
                
                <div>
                    <label for="edit_car_description" class="required">
                        <span><i class="fa-solid fa-align-left"></i></span>Description:
                    </label>
                    <textarea id="edit_car_description" name="car_description" rows="4" required></textarea>
                </div>
            </div>
            <div>
                <label for="edit_color" class="required"><span><i class="fa-solid fa-palette"></i></span>Color:</label>
                <input type="text" id="edit_color" name="color" required>
            </div>
        </div>
        
        <div class="form-section">
            <div>
                <label for="edit_seat_number" class="required"><span><i class="fa-solid fa-users"></i></span>Number of Seats:</label>
                <input type="number" id="edit_seat_number" name="seat_number" min="1" max="20" required>
            </div>
            
            <div>
                <label for="edit_engine_power" class="required"><span><i class="fa-solid fa-gear"></i></span>Engine Power:</label>
                <input type="number" id="edit_engine_power" name="engine_power" min="0" required>
            </div>
        </div>
        
        <div>
            <label for="edit_image"><span><i class="fa-solid fa-image"></i></span>New Image (leave empty if unchanged):</label>
            <input type="file" id="edit_image" name="image" accept="image/*">
        </div>
        
        <div>
            <label for="edit_status" class="required"><span><i class="fa-solid fa-circle-info" style="padding-right: 10px ;opacity:0.7;"></i></span>Status:Status:</label>
            <select id="edit_status" name="status" required>
                <option value="selling">Available</option>
                <option value="hidden">Hidden</option>
                <option value="discounting">On Sale</option>
                <option value="soldout">Sold Out</option>
            </select>
        </div>
        
        <div class="form-buttons">
            <button type="submit" name="update_product">Save Changes</button>
            <button type="button" onclick="closeEditProductForm()">Cancel</button>
        </div>
    </form>
</div>

<!-- Update your delete confirmation modal HTML -->
<div id="deleteConfirmModal" class="popup">
    <div class="popup-content">
        <!-- <button type="button" class="close-btn" onclick="closeDeleteConfirm()">
            <i class="fa-solid fa-times"></i>
        </button> -->
        <h3><i class="fa-solid fa-trash"></i> Delete Product</h3>
        <p>Are you sure you want to delete this product? This action cannot be undone.</p>
        <form id="deleteForm" method="POST">
            <input type="hidden" name="delete_product" value="1">
            <input type="hidden" name="product_id" id="delete_product_id">
            <div class="popup-buttons">
                <button type="submit" class="confirm-btn">Delete</button>
                <button type="button" class="cancel-btn" onclick="closeDeleteConfirm()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modalOverlay"></div>
    <script>
        // Hiển thị form thêm sản phẩm
        function showAddProductForm() {
            document.getElementById('addProductForm').reset();
            document.getElementById('addProductModal').style.display = 'block';
            document.getElementById('modalOverlay').style.display = 'block';
        }
        
        // Đóng form thêm sản phẩm
        function closeAddProductForm() {
            document.getElementById('addProductModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        }
        
        // Hiển thị form sửa sản phẩm
                function showEditProductForm(productId) {
            // Send AJAX request to get product details
            fetch(`get_product.php?id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const product = data.product;
                        
                        // Fill form with product data
                        document.getElementById('edit_product_id').value = product.product_id;
                        document.getElementById('edit_car_name').value = product.car_name;
                        document.getElementById('edit_brand_id').value = product.brand_id;
                        document.getElementById('edit_year').value = product.year_manufacture;
                        document.getElementById('edit_price').value = product.price;
                        document.getElementById('edit_max_speed').value = product.max_speed;
                        document.getElementById('edit_engine_name').value = product.engine_name;
                        document.getElementById('edit_fuel_name').value = product.fuel_name;
                        document.getElementById('edit_color').value = product.color;
                        document.getElementById('edit_seat_number').value = product.seat_number;
                        document.getElementById('edit_engine_power').value = product.engine_power;
                        document.getElementById('edit_status').value = product.status;
                                                // Add this to the showEditProductForm function
                        document.getElementById('edit_fuel_capacity').value = product.fuel_capacity;
                        document.getElementById('edit_car_description').value = product.car_description;
                        // Show current image
                        document.getElementById('currentImagePreview').src = '../User/' + product.image_link;
                        
                        // Show modal
                        document.getElementById('editProductModal').style.display = 'block';
                        document.getElementById('modalOverlay').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error loading product information', 'error');
                });
        }
        
                // Replace the existing confirmDeleteProduct function
        // Update your JavaScript functions
        function confirmDeleteProduct(productId) {
            const modal = document.getElementById('deleteConfirmModal');
            const overlay = document.getElementById('modalOverlay');
            document.getElementById('delete_product_id').value = productId;
            
            modal.style.display = 'flex';
            overlay.style.display = 'block';
        }
        
        function closeDeleteConfirm() {
            const modal = document.getElementById('deleteConfirmModal');
            const overlay = document.getElementById('modalOverlay');
            
            modal.style.display = 'none';
            overlay.style.display = 'none';
        }
        
        // Update the delete form handler
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('deleteForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                fetch('manage-products.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    closeDeleteConfirm();
                    showNotification('Product deleted successfully', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error deleting product', 'error');
                });
            });
        });
        
        
        function closeEditProductForm() {
            document.getElementById('editProductModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        }
        
        

    </script>
    <script>
    // Image preview function for Add Product form
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            // Create preview container if it doesn't exist
            let previewContainer = document.getElementById('addImagePreview');
            if (!previewContainer) {
                previewContainer = document.createElement('div');
                previewContainer.id = 'addImagePreview';
                previewContainer.style.marginTop = '10px';
                this.parentElement.appendChild(previewContainer);
            }
            
            reader.onload = function(e) {
                previewContainer.innerHTML = `
                    <img src="${e.target.result}" 
                         style="max-width: 200px; 
                                max-height: 150px; 
                                object-fit: cover; 
                                border-radius: 4px; 
                                box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                `;
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Image preview function for Edit Product form
    document.getElementById('edit_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const currentPreview = document.getElementById('currentImagePreview');
            
            reader.onload = function(e) {
                currentPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>

</html>
<?php
include 'footer.php';
?>

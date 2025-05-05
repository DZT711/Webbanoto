<?php
include 'header.php';
// include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Store the intended destination
    $_SESSION['redirect_after_login'] = 'delivery.php';
    // Redirect to login page
    echo "<script>
        showNotification('Vui lòng đăng nhập để tiếp tục.','warning');
        window.location.href='login.php';
    </script>";
    exit();
}
$query = ' SELECT address,full_name FROM users_acc WHERE username = "' . $username . '" AND password = "' . $password . '" ';

$result = mysqli_query($connect, $query);
while ($row = mysqli_fetch_array($result)) {
    $address = $row['address'];
    $full_name = $row['full_name'];
    $_SESSION['full_name'] = $full_name;
    $_SESSION['address'] = $address;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM users_acc WHERE id = ?";
$stmt = mysqli_prepare($connect, $user_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);
$user_info = mysqli_fetch_assoc($user_result);
// Add this after your existing queries and before the HTML
// Replace the existing address query with this
// Update the address query and check
$addresses_query = "SELECT DISTINCT shipping_address FROM orders 
                   WHERE user_id = ? AND shipping_address IS NOT NULL 
                   ORDER BY order_date DESC LIMIT 5";
$stmt = mysqli_prepare($connect, $addresses_query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$saved_addresses = mysqli_stmt_get_result($stmt);
$has_saved_addresses = mysqli_num_rows($saved_addresses) > 0;

// Then update the address display code

// Add this code after getting user information and before the HTML
$cartItems = [];
$totalAmount = 0;

// Get cart items for the current user
$cart_query = "SELECT ci.*, p.*, ct.type_name, (ci.quantity * p.price) as subtotal 
               FROM cart_items ci
               JOIN cart c ON ci.cart_id = c.cart_id
               JOIN products p ON ci.product_id = p.product_id
               LEFT JOIN car_types ct ON p.brand_id = ct.type_id
               WHERE c.user_id = ? AND c.cart_status = 'activated'";

$stmt = mysqli_prepare($connect, $cart_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $cartItems[] = $row;
    $totalAmount += $row['subtotal'];
}

// Calculate VAT (if needed)
$vatRate = 10; // 0% as per your current display
$vatAmount = ($totalAmount * $vatRate) / 100;
$finalTotal = $totalAmount + $vatAmount;

$user_address_query = "SELECT address FROM users_acc WHERE id = ?";
$stmt = mysqli_prepare($connect, $user_address_query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$user_address_result = mysqli_stmt_get_result($stmt);
$user_address = mysqli_fetch_assoc($user_address_result);

// Then update the address select dropdown
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Địa chỉ vận chuyển</title>
    <!-- Add this in the head section -->
    <!-- Replace Google Maps script with Leaflet CSS and JS in the head section -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="delivery.css"> -->
    <script src="delivery.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<!-- <style>
        /* Add to your existing delivery.php styles */
    
    /* Title Container */
    .eight {
        height: 100px;
        background-color: #efefef;
        /* border-radius: 10px; */
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        width:1200px;
        margin-left:345px;
    }
    
    /* Title Styling */
    .eight h1 {
        padding-top: 30px;
        text-align: center;
        text-transform: uppercase;
        font-size: 26px;
        letter-spacing: 1px;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        grid-template-rows: 16px 0;
        grid-gap: 22px;
        color:rgb(172, 172, 172);
        font-family: Arial, Helvetica, sans-serif;
        background-color: #efefef;
        
        color: #2c3e50;
    }
    
    /* Title Lines */
    .eight h1:after,
    .eight h1:before {
        content: " ";
        display: block;
        border-bottom: 2px solid #ccc;
        background-color: #efefef;
    }
    
 
    /* Add this to your HTML right after the delivery-top section */ -->
</style>
<style>
    /* Delivery Page Container */
    .delivery {
        padding: 40px 0;
        background-color: #efefef;
    }

    /* Title Styling */
    /* .eight {
    height: 100px;
    background-color: #efefef;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 30px;
} */



    /* Progress Bar */
    .delivery-top-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 40px;
    }

    .delivery-top {
        height: 2px;
        width: 70%;
        background-color: #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 30px auto;
        max-width: 840px;
        position: relative;
    }

    .delivery-top-item {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .delivery-top-item i {
        color: #666;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .delivery-top-item.active {
        border-color: #007bff;
        background-color: #007bff;
    }

    .delivery-top-item.active i {
        color: #fff;
    }

    /* Content Layout */
    .delivery-content-row {
        display: flex;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Left Section - Form */
    .delivery-content-left {
        flex: 2;
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .input-group {
        margin-bottom: 20px;
        width: 590px;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        color: #2c3e50;
        font-weight: 500;
    }

    .input-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .input-group input:focus {
        border-color: #007bff;
        outline: none;
    }

    /* Right Section - Summary */
    .delivery-content-right {
        flex: 1;
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .delivery-content-right table {
        width: 100%;
        border-collapse: collapse;
    }

    .delivery-content-right th,
    .delivery-content-right td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .delivery-content-right th {
        font-weight: 600;
        color: #2c3e50;
        background-color: #f8f9fa;
        padding: 12px 2px;
    }

    /* .delivery-content-right th:first-child{
        padding-left: 12px;
    }
    .delivery-content-right th:last-child{
        padding-right: 12px;
    } */

    /* Action Buttons */
    .delivery-content-left-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        /* margin-top: 170px; */
    }

    #checkout-button {
        padding: 12px 24px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #checkout-button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .return {
        color: #666;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.3s ease;
    }

    .return:hover {
        color: #007bff;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .delivery-content-row {
            flex-direction: column;
        }

        .delivery-content-left,
        .delivery-content-right {
            width: 100%;
        }

        .delivery-content-left-button {
            flex-direction: column;
            gap: 15px;
        }

        #checkout-button {
            width: 100%;
        }
    }

    .registration-form {
        padding: 10px;
    }
</style>
<style>
    /* Update Title Container */
    .eight {
        height: 100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin: 20px auto;
        max-width: 1200px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Update Title Styling */
    .eight h1 {
        position: relative;
        padding: 0;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        color: #2c3e50;
        font-size: 26px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    /* Add underline accent */
    .eight h1::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--cart-primary);
        border-radius: 2px;
    }
</style>
<style>
    /* Title Container */
    .eight {
        height: 100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin: 20px auto;
        max-width: 1200px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Title Styling */
    .eight h1 {
        position: relative;
        padding: 0;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        color: #2c3e50;
        font-size: 26px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    /* Add underline accent */
    .eight h1::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: #007bff;
        border-radius: 2px;
    }

    /* Remove old title lines */
    .eight h1:before {
        content: none;
    }

    .VAT {
        color: #FF5733;
        /* Màu cam đỏ nổi bật */

    }

    .total-amount {
        color: #008000;
        /* Màu xanh lá cây tiêu chuẩn */

    }

    .amount {
        color: #1C4E80;
        /* Xanh dương đậm */

    }
</style>
<style>
    .delivery-content-right {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 600px;
    }

    /* Products List Section */
    .products-list {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .products-list table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .products-list th {
        background: #f8f9fa;
        padding: 15px;
        font-weight: 600;
        color: #2c3e50;
        text-transform: uppercase;
        font-size: 0.85em;
        letter-spacing: 0.5px;
    }

    .products-list td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    .product-brand {
        color: #666;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .product-name {
        color: #2c3e50;
        font-weight: 500;
    }

    /* Order Summary Section */
    .order-summary {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #eee;
    }

    .summary-row:last-child {
        border-bottom: none;
        padding-top: 20px;
        margin-top: 8px;
        border-top: 2px solid #eee;
    }

    .summary-label {
        color: #666;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-value {
        font-weight: 600;
    }

    /* Back Button */
    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 6px;
        color: #666;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .back-button:hover {
        background: #e9ecef;
        color: #2c3e50;
        transform: translateX(-2px);
    }

    .back-button i {
        font-size: 14px;
    }
</style>

<!-- Update the delivery content right section -->

<style>
    /* Input Group Fixes */
    .input-group {
        margin-bottom: 20px;
        width: 100%;
        /* Changed from 590px */
        max-width: 590px;
    }

    .input-group input {
        width: 95%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        background-color: #fff;
    }

    /* Products List Styling */
    .products-list {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .products-list table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Table Header Widths */
    .products-list th:nth-child(1) {
        width: 25%;
    }

    /* Brand */
    .products-list th:nth-child(2) {
        width: 35%;
    }

    /* Product Name */
    .products-list th:nth-child(3) {
        width: 15%;
    }

    /* Quantity */
    .products-list th:nth-child(4) {
        width: 10%;
    }

    /* Price */

    .products-list th {
        background: #f8f9fa;
        padding: 15px;
        font-weight: 600;
        color: #2c3e50;
        text-transform: uppercase;
        font-size: 0.85em;
        letter-spacing: 0.5px;
        white-space: nowrap;
        max-width: 110px;
    }

    /* Order Summary Section */
    .order-summary {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px dashed #eee;
    }

    .summary-row:last-child {
        border-bottom: none;
        padding-top: 20px;
        margin-top: 8px;
        border-top: 2px solid #eee;
        background-color: #f8f9fa;
        margin: 0 -20px;
        padding: 20px;
        border-radius: 0 0 12px 12px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .input-group {
            max-width: 100%;
        }

        .products-list th,
        .products-list td {
            padding: 10px;
        }

        .products-list th:nth-child(1) {
            width: 20%;
        }

        .products-list th:nth-child(2) {
            width: 30%;
        }

        .products-list th:nth-child(3) {
            width: 20%;
        }

        .products-list th:nth-child(4) {
            width: 15%;
        }
    }

    /* Add/update these styles */
    .delivery-top-item {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        transition: all 0.3s ease;
        position: relative;
        z-index: 2;
    }

    .delivery-top-item.active {
        border-color: #4CAF50;
        background-color: #4CAF50;
    }

    .delivery-top-item.active i {
        color: #fff;
    }

    /* Add progress line color */
    .delivery-top::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 2px;
        width: 50%;
        /* Adjust based on current step */
        background-color: #4CAF50;
        z-index: 1;
    }
</style>
<style>
    .address-input-container {
        position: relative;
        margin-bottom: 20px;
    }

    .map-container {
        height: 200px;
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #ddd;
    }

    #map {
        height: 100%;
        width: 100%;
    }

    .location-button {
        position: absolute;
        right: 10px;
        top: 70%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
    }

    .location-button:hover {
        color: #0056b3;
    }
</style>
<style>
    /* Update the map container styles */
    .map-container {
        height: 300px;
        margin-bottom: 15px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #ddd;
        z-index: 1;
    }

    #map {
        height: 100%;
        width: 100%;
        z-index: 1;
    }

    .leaflet-control-geocoder {
        z-index: 2;
    }
        /* Add to your existing styles */
        .address-selection {
            margin-bottom: 30px;
        }
        
        .address-method-label {
            margin-bottom: 15px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .address-methods {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .address-method {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .address-method input[type="radio"] {
            display: none;
        }
        
        .address-method label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .address-method input[type="radio"]:checked + label {
            border-color: #007bff;
            background-color: #f8f9fa;
            color: #007bff;
        }
        
        .saved-addresses {
            margin-bottom: 20px;
        }
        
        .address-select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 10px;
        }
</style>
<style>
.eight {
    height: auto;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin: 20px auto;
    padding: 20px 40px;
    width: fit-content;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.eight h1 {
    font-family: Arial, Helvetica, sans-serif;
    font-weight: 600;
    font-size: 26px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0;
    padding: 0;
    /* background: linear-gradient(90deg,rgb(255, 255, 255),#6D6E71, #0056B3); */
    background-size: 200% auto;
    color: #2c3e50; /* Fallback color */
    /* animation: gradientText 3s linear infinite; */
    /* height:32px; */
}

.eight h1 span {
    display: inline-block;
    opacity: 0;
    transform: translateY(20px);
    animation: revealLetters 0.5s ease forwards;
}

/* Gradient Animation */
@keyframes gradientText {
    0% { background-position: 0% 50%; }
    100% { background-position: 200% 50%; }
}

/* Letter Animation */
@keyframes revealLetters {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
/* Highlight Effect */
.eight::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(90, 90, 90, 0.8),
        transparent
    );
    animation: highlightSweep 3s ease-in-out infinite;
}

@keyframes highlightSweep {
    100% { left: 200%; }
}
</style>
<style>
    
</style>
<body>






    <!------------Delivery------------>
    <section class="delivery">
        <div class="container">
            <div class="delivery-top-wrap">
                <!-- Update the delivery top section -->
                <div class="delivery-top">
                    <div class="delivery-top-delivery delivery-top-item active">
                        <a href="cart.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>

                    <div class="delivery-top-address delivery-top-item active">
                        <a href="delivery.php">
                            <i class="fa-solid fa-location-dot"></i>
                        </a>
                    </div>

                    <div class="delivery-top-payment delivery-top-item">
                        <a href="payment.php">
                            <i class="fa-solid fa-money-check"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="eight">
            <h1>Thông Tin Vận Chuyển</h1>
        </div>

        <div class="delivery-content-row">
            <div class="delivery-content-left">
                <p><span class="info">Vui lòng nhập thông tin người nhận xe (nếu chưa có)</span></p>
                <div class="delivery-content-left-input-top row">
                    <div class="input-group">
                        <label>
                            <i class="fas fa-user"></i>
                            Họ tên:<span class="required-indicator">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name"
                            value="<?php echo htmlspecialchars($user_info['full_name'] ?? ''); ?>" required>
                        <!-- <i class="fas fa-user-circle"></i> -->
                    </div>
                
                    <div class="input-group">
                        <label>
                            <i class="fas fa-phone"></i>
                            Số điện thoại:<span class="required-indicator">*</span>
                        </label>
                        <input type="text" id="phone" name="phone"
                            value="<?php echo htmlspecialchars($user_info['phone_num'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>
                            <i class="fas fa-envelope"></i>
                            Email:<span class="required-indicator">*</span>
                        </label>
                        <input type="text" id="email" name="email"
                            value="<?php echo htmlspecialchars($user_info['email'] ?? ''); ?>" required>
                    </div>
                
                                        <!-- Update the address input section -->
                                        <!-- Update the address input section -->
                                        <!-- // Update the address input section with radio buttons -->
                    <div class="input-group address-selection">
                        <label class="address-method-label">Chọn phương thức nhập địa chỉ:</label>
                        
                        <div class="address-methods">
                            <div class="address-method">
                                <input type="radio" id="map-method" name="address-method" value="map" 
                                       <?php echo !$has_saved_addresses ? 'checked' : ''; ?>>
                                <label for="map-method">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Chọn vị trí trên bản đồ
                                </label>
                            </div>
                    
                            <?php if ($has_saved_addresses): ?>
                            <div class="address-method">
                                <input type="radio" id="saved-method" name="address-method" value="saved" checked>
                                <label for="saved-method">
                                    <i class="fas fa-history"></i>
                                    Sử dụng địa chỉ đã lưu
                                </label>
                            </div>
                            <?php endif; ?>
                        </div>
                    
                        <div id="saved-addresses" class="saved-addresses" style="display: <?php echo $has_saved_addresses ? 'block' : 'none'; ?>">
                            <select id="address-select" class="address-select" onchange="updateAddress(this.value)">
                                <option value="">-- Chọn địa chỉ --</option>
                                <?php if (!empty($user_address['address'])): ?>
                                    <option value="<?= htmlspecialchars($user_address['address']) ?>">
                                        <?= htmlspecialchars($user_address['address']) ?> (Dịa chỉ hiện tại)
                                    </option>
                                <?php endif; ?>
                                <!-- Keep your existing options -->
                                <?php while ($address = mysqli_fetch_assoc($saved_addresses)): ?>
                                    <option value="<?= htmlspecialchars($address['shipping_address']) ?>">
                                        <?= htmlspecialchars($address['shipping_address']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    
                        <div class="address-input-container">
                            <label for="address">
                                <i class="fas fa-map-marker-alt"></i>
                                Địa chỉ:<span class="required-indicator">*</span>
                            </label>
                            <input type="text" id="address" name="address" 
                                   value="<?php echo htmlspecialchars($user_info['address'] ?? ''); ?>" 
                                   placeholder="Nhập địa chỉ của bạn"
                                   required>
                            <button type="button" class="location-button" onclick="getCurrentLocation()">
                                <i class="fas fa-crosshairs"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div id="map-container" class="map-container">
                        <div id="map" style="height: 300px;"></div>
                    </div>
                    
                    <div id="map-container" class="map-container" style="display: <?php echo !$has_saved_addresses ? 'block' : 'none'; ?>">
                        <div id="map" style="height: 300px;"></div>
                    </div>
                    
                    <div class="input-group">
                        <div class="address-input-container" style="display: none;">
                            <input type="text" id="address" name="address"
                                value="<?php echo htmlspecialchars($user_info['address'] ?? ''); ?>" placeholder="Nhập địa chỉ của bạn"
                                required>
                            <button type="button" class="location-button" onclick="getCurrentLocation()">
                                <i class="fas fa-crosshairs"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div id="map-container" class="map-container" style="display: none;">
                        <div id="map" style="height: 300px;"></div>
                    </div>
                </div>
                
                <script>
                function saveDeliveryInfo() {
                    const deliveryData = {
                        full_name: document.getElementById('full_name').value,
                        phone: document.getElementById('phone').value,
                        address: document.getElementById('address').value
                    };
                
                    // Save to database
                    fetch('save_delivery.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(deliveryData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = 'payment.php';
                        } else {
                            showNotification('Có lỗi xảy ra. Vui lòng thử lại.','error');
                        }
                    });
                }
                </script>
                <script>
                    function toggleRegisterForm(show) {
                        const form = document.getElementById('registration-form');
                        if (show) {
                            form.style.display = 'block'; // Hiển thị form nếu chọn "Đăng ký"
                        } else {
                            form.style.display = 'block'; // Ẩn form nếu chọn "Khách lẻ"
                        }
                    }
                    toggleRegisterForm(true);
                </script>
                <div class="delivery-content-left-button row">
                    <button onclick="window.location.href='cart.php'" class="back-button" style="height:39px;cursor:pointer;">
                        <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng

                    </button>
                    <button id="checkout-button" onclick="navigateToPayment()">Tiếp tục&nbsp;&emsp;<i class="fas fa-arrow-right"></i> </button>
                    <script>
                        function navigateToPayment() {
                            // Chuyển hướng đến trang payment.php
                            window.location.href = "payment.php";
                        }
                    </script>
                </div>
            </div>
                        <div class="delivery-content-right">
    <div class="products-list">
        <table>
            <tr>
                <th><i class="fas fa-tag"></i> Thương hiệu</th>
                <th><i class="fas fa-car"></i> Tên sản phẩm</th>
                <th><i class="fas fa-sort-amount-up"></i> Số lượng</th>
                <th><i class="fas fa-dollar-sign"></i> Đơn Giá</th>
            </tr>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td>
                        <span class="product-brand">
                            <i class="fas fa-building"></i>
                            <?php echo htmlspecialchars($item['type_name'] ?? 'N/A'); ?>
                        </span>
                    </td>
                    <td>
                        <span class="product-name" style="text-transform: uppercase; color: gray;">
                            <?php echo htmlspecialchars($item['car_name']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td>
                        <p><?php echo number_format($item['price'], 0, ',', '.'); ?> ₫</p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="order-summary">
        <div class="summary-row">
            <span class="summary-label">
                <i class="fas fa-calculator"></i>
                Thành tiền
            </span>
            <span class="summary-value amount">
                <?php echo number_format($totalAmount, 0, ',', '.'); ?> ₫
            </span>
        </div>
        <div class="summary-row">
            <span class="summary-label">
                <i class="fas fa-percent"></i>
                Thuế VAT
            </span>
            <span class="summary-value VAT">
                <?php echo $vatRate; ?>%
            </span>
        </div>
        <div class="summary-row">
            <span class="summary-label">
                <i class="fas fa-money-bill-wave"></i>
                Tổng cộng
            </span>
            <span class="summary-value total-amount">
                <?php echo number_format($finalTotal, 0, ',', '.'); ?> ₫
            </span>
        </div>
    </div>
</div>

        </div>
    </section>

    <!------------footer----------->
<script>
let map, marker, geocoder;

function initMap() {
    // Default to Vietnam center
    const defaultLocation = [16.0474, 108.2062];
    
    // Initialize map
    map = L.map('map').setView(defaultLocation, 13);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Initialize marker
    marker = L.marker(defaultLocation, {
        draggable: true
    }).addTo(map);
    
    // Initialize geocoder
    geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const latlng = e.geocode.center;
        marker.setLatLng(latlng);
        map.setView(latlng, 16);
        reverseGeocode(latlng);
    })
    .addTo(map);
    
    // Handle marker drag
    marker.on('dragend', function() {
        const position = marker.getLatLng();
        reverseGeocode(position);
    });
    
    // Handle address input changes
    const addressInput = document.getElementById('address');
    addressInput.addEventListener('change', function() {
        geocoder.geocode(this.value);
    });

    // Try to get user's location on load
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const latlng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                marker.setLatLng(latlng);
                map.setView(latlng, 16);
                reverseGeocode(latlng);
            },
            (error) => {
                console.log('Error getting location:', error);
            }
        );
    }
}

function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                const latlng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                marker.setLatLng(latlng);
                map.setView(latlng, 16);
                reverseGeocode(latlng);
            },
            () => {
                showNotification('Không thể lấy vị trí hiện tại.', 'error');
            }
        );
    } else {
        showNotification('Trình duyệt không hỗ trợ định vị.', 'error');
    }
}

function reverseGeocode(latlng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latlng.lat}&lon=${latlng.lng}&format=json&accept-language=vi`)
        .then(response => response.json())
        .then(data => {
            if (data.address) {
                // Format address components
                const addressComponents = [];
                
                // Add specific components if they exist
                if (data.address.house_number) addressComponents.push(data.address.house_number);
                if (data.address.road) addressComponents.push(data.address.road);
                if (data.address.suburb) addressComponents.push(data.address.suburb);
                if (data.address.city_district) addressComponents.push(data.address.city_district);
                if (data.address.city) addressComponents.push(data.address.city);
                if (data.address.state) addressComponents.push(data.address.state);
                
                // Join components with commas
                const formattedAddress = addressComponents.join(', ');
                
                // Update input field
                document.getElementById('address').value = formattedAddress;
                
                // Show success notification
                showNotification('Đã cập nhật địa chỉ thành công', 'success');
            } else {
                showNotification('Không thể xác định địa chỉ từ vị trí này', 'error');
            }
        })
        .catch(() => {
            showNotification('Có lỗi khi lấy thông tin địa chỉ', 'error');
        });
}

// Initialize map when page loads
document.addEventListener('DOMContentLoaded', initMap);
</script>
<script>
        function navigateToPayment() {
        const fullName = document.getElementById('full_name').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;
    
        // Validate required fields
        if (!fullName || !phone || !address) {
            showNotification('Vui lòng điền đầy đủ thông tin giao hàng', 'error');
            return;
        }
    
        // Save delivery info
        const deliveryData = {
            full_name: fullName,
            phone: phone,
            address: address
        };
    
        fetch('save_delivery.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(deliveryData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'payment.php';
            } else {
                showNotification(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
            }
        })
        .catch(error => {
            showNotification('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
            console.error('Error:', error);
        });
    }
        // Add to your existing scripts
        function handleAddressMethodChange() {
            const mapMethod = document.getElementById('map-method');
            const savedAddresses = document.getElementById('saved-addresses');
            const addressInput = document.querySelector('.address-input-container');
            
            if (mapMethod.checked) {
                savedAddresses.style.display = 'none';
                addressInput.style.display = 'block';
                document.getElementById('address').value = '';
                initMap();
            } else {
                savedAddresses.style.display = 'block';
                const selectedAddress = document.getElementById('address-select').value;
                if (selectedAddress) {
                    document.getElementById('address').value = selectedAddress;
                }
            }
        }
        
        function updateAddress(value) {
            if (value) {
                document.getElementById('address').value = value;
            }
        }
        
        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const mapMethod = document.getElementById('map-method');
            const savedMethod = document.getElementById('saved-method');
            
            if (mapMethod) {
                mapMethod.addEventListener('change', handleAddressMethodChange);
            }
            if (savedMethod) {
                savedMethod.addEventListener('change', handleAddressMethodChange);
            }
            
            // Initialize map
            initMap();
        });
            document.addEventListener('DOMContentLoaded', function() {
        const title = document.querySelector('.eight h1');
        const text = title.textContent.trim();
        title.innerHTML = ''; // Clear the title
        
        // Create spans for each letter with proper delays
        text.split('').forEach((letter, index) => {
            const span = document.createElement('span');
            span.textContent = letter === ' ' ? '\u00A0' : letter; // Preserve spaces
            span.style.display = 'inline-block';
            span.style.opacity = '0';
            span.style.transform = 'translateY(20px)';
            span.style.transition = `all 0.5s ease ${index * 0.1}s`;
            title.appendChild(span);
            
            // Trigger animation after a small delay
            setTimeout(() => {
                span.style.opacity = '1';
                span.style.transform = 'translateY(0)';
            }, 100);
        });
    });
    
    // Update hover effect
    const titleContainer = document.querySelector('.eight');
    titleContainer.addEventListener('mouseenter', () => {
        const letters = titleContainer.querySelectorAll('h1 span');
        letters.forEach((letter, index) => {
            letter.style.transform = 'translateY(-5px)';
            letter.style.color = '#007bff';
            letter.style.transition = `all 0.3s ease ${index * 0.05}s`;
        });
    });
    
    titleContainer.addEventListener('mouseleave', () => {
        const letters = titleContainer.querySelectorAll('h1 span');
        letters.forEach((letter, index) => {
            letter.style.transform = 'translateY(0)';
            letter.style.color = '#2c3e50';
            letter.style.transition = `all 0.3s ease ${index * 0.05}s`;
        });
    });

</script>
</body>

</html>
<?php
include 'footer.php';
?>
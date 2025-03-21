<?php
include 'header.php';
include 'connect.php';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get cart items
$cartItems = [];
$totalAmount = 0;
$totalItems = 0;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // First, check if user has an active cart
    $check_cart = "SELECT cart_id FROM cart WHERE user_id = ? AND cart_status = 'activated'";
    $stmt = mysqli_prepare($connect, $check_cart);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $cart_result = mysqli_stmt_get_result($stmt);

    if (!mysqli_fetch_assoc($cart_result)) {
        // Create new cart if none exists
        $create_cart = "INSERT INTO cart (user_id, cart_status) VALUES (?, 'activated')";
        $stmt = mysqli_prepare($connect, $create_cart);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
    }

    // Now get cart items
    $query = "SELECT ci.*, p.*, ct.type_name 
              FROM cart_items ci
              JOIN cart c ON ci.cart_id = c.cart_id
              JOIN products p ON ci.product_id = p.product_id
              LEFT JOIN car_types ct ON p.brand_id = ct.type_id
              WHERE c.user_id = ? AND c.cart_status = 'activated'";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $cartItems[] = $row;
        $totalItems += $row['quantity'];
        $totalAmount += $row['price'] * $row['quantity'];
    }
} else {
    // Get items from session for guest user
    $cartItems = [];
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            // Get brand information for each product
            $query = "SELECT p.*, ct.type_name 
                     FROM products p 
                     LEFT JOIN car_types ct ON p.brand_id = ct.type_id 
                     WHERE p.product_id = ?";

            $stmt = mysqli_prepare($connect, $query);
            mysqli_stmt_bind_param($stmt, "i", $item['product_id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($product = mysqli_fetch_assoc($result)) {
                $cartItem = array_merge($item, [
                    'type_name' => $product['type_name'] ?? 'N/A'
                ]);
                $cartItems[] = $cartItem;
                $totalItems += $item['quantity'];
                $totalAmount += $item['price'] * $item['quantity'];
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="cart.css"> -->

    <script src="cart.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<style>
    /* Cart Page Container */
    .cart {
        --cart-primary: #007bff;
        --cart-secondary: #f8f9fa;
        --cart-accent: #0056b3;
        padding: 40px 0;
        background-color: #efefef;
    }

    /* Progress Bar Section */
    .cart-top-wrap {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cart-top {
        height: 2px;
        width: 70%;
        background-color: #909091;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 30px auto;
        max-width: 840px;
        position: relative;
    }

    .cart-top-item {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        position: relative;
        transition: all 0.3s ease;
        cursor: pointer;
        z-index: 2;
    }

    .cart-top-item i {
        color: #666;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .cart-top-item.active {
        border-color: var(--cart-primary);
        background-color: var(--cart-primary);
    }

    .cart-top-item.active i {
        color: #fff;
    }

    /* Cart Content Layout */
    .container {
        /* max-width: 1200px; */
        margin: 0 auto;
        padding: 0 20px;
    }

    .cart-content-row {
        display: flex;
        gap: 30px;
        margin-top: 40px;
    }

    /* Cart Items Table */
    .cart-content-left {
        flex: 2;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .cart-content-left table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-content-left th {
        padding: 15px;
        text-transform: uppercase;
        font-size: 0.9rem;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
        text-align: left;
    }

    .cart-content-left td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .cart-content-left img {
        width: 100px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .cart-content-left img:hover {
        transform: scale(1.05);
    }

    /* Quantity Controls */
    .cart-content-left input[type="number"] {
        width: 70px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
    }

    /* Cart Summary */
    .cart-content-right {
        flex: 1;
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .cart-content-right table {
        width: 100%;
        margin-bottom: 20px;
    }

    .cart-content-right th {
        padding: 15px;
        text-align: center;
        background-color: #f8f9fa;
        color: #495057;
        font-size: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .cart-content-right td {
        padding: 12px;
        border-bottom: 1px solid #e9ecef;
    }

    /* Action Buttons */
    .cart-content-right-button {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .cart-content-right-button button {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    #continue-shopping {
        background-color: #6c757d;
        color: white;
    }

    #checkout-button {
        background-color: var(--cart-primary);
        color: white;
    }

    #continue-shopping:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }

    #checkout-button:hover {
        background-color: var(--cart-accent);
        transform: translateY(-2px);
    }

    /* Remove Item Button */
    .remove-item {
        color: #dc3545;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .remove-item:hover {
        color: #c82333;
        transform: scale(1.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .cart-content-row {
            flex-direction: column;
        }

        .cart-content-left {
            overflow-x: auto;
        }

        .cart-content-left table {
            min-width: 600px;
        }

        .cart-top {
            width: 90%;
        }
    }

    /* Preserve Header Styles */
    .header-container {
        --header-bg: #f8f9fa;
        --header-text: #495057;
    }

    /* Preserve Cart Original Styles */
    .cart-top-cart {
        border: 1px solid rgb(7, 7, 7);
    }

    .cart-top-cart i {
        color: black;
    }
</style>
<!-- <style>
.cart-title {
    text-align: center;
    padding: 25px 0;
    margin: 0 0 20px 0;
    color: #2c3e50;
    font-size: 2rem;
    font-weight: 600;
    background-color: #fff;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
}

.cart-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background-color: var(--cart-primary);
    border-radius: 2px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.cart {
    padding: 20px 0 40px;
    background-color: #efefef;
}</style> -->
<style>
    h1 {
        position: relative;
        padding: 0;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        color: #666;
        font-size: 40px;
        /* color: #080808; */
        -webkit-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        height: 50px;
    }

    h1 span {
        display: block;
        font-size: 0.5em;
        line-height: 1.3;
    }

    h1 em {
        font-style: normal;
        font-weight: 600;
    }

    .eight {
        height: 100px;
        background-color: #efefef;
        /* border-radius: 10px; */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

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
    }

    .eight h1:after,
    .eight h1:before {
        content: " ";
        display: block;
        border-bottom: 2px solid #ccc;
        background-color: #efefef;
    }
</style>
<!-- <style>
        /* Update Title Container */
    .eight {
        height: 100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin: 20px auto;
        max-width: 1200px;
    }
    
    /* Update Title Styling */
    .eight h1 {
        position: relative;
        padding: 30px 0;
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
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--cart-primary);
        border-radius: 2px;
    }
    
    /* Remove old decorative lines */
    .eight h1:before {
        content: none;
    }
    
    /* Container spacing */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Section spacing */
    .cart {
        padding: 20px 0 40px;
        background-color: #efefef;
    } -->
</style>
<style>
    /* Update Title Container */
    .eight {
        height: 100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin: 20px auto;
        /* max-width: 1200px; */
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
        color: rgb(163, 163, 163);
        font-size: 26px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 5px;
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

    /* Update Title Container */
    .eight {
        height: 100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin: 20px auto;
        /* max-width: 1200px; */
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
        color: rgb(153, 153, 153);
        font-size: 26px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    /* Fix underline spacing */
    .eight h1::after {
        content: '';
        position: absolute;
        bottom: -8px;
        /* Changed from -15px to -8px */
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--cart-primary);
        border-radius: 2px;
    }

    .cart-content-left a {
        text-decoration: none;
        color: gray;
        font-weight: bold;
        text-transform: uppercase;
    }
</style>
<style>
    /* Update the cart image styling */
    .cart-content-left img {
        width: 150px;
        /* Slightly reduced from 180px */
        height: 100px;
        /* Reduced from 120px */
        object-fit: contain;
        /* Changed from cover to contain */
        border-radius: 8px;
        transition: transform 0.3s ease;
        background-color: #f8f9fa;
        /* Light background for transparent images */
        padding: 5px;
        /* Add some padding */
    }

    .cart-content-left img:hover {
        transform: scale(1.1);
    }

    /* Adjust the td padding to accommodate the image */
    .cart-content-left td:first-child {
        padding: 10px;
        width: 160px;
        /* Fixed width for image column */
    }

    /* Add icons styling */
    .cart-icon {
        margin-right: 8px;
        color: #666;
    }

    .price-icon {
        color: #28a745;
    }

    .quantity-icon {
        color: #007bff;
    }

    .total-icon {
        color: #17a2b8;
    }

    /* Style for empty cart message */
    .empty-cart-message {
        text-align: center;
        padding: 40px 0;
    }

    .empty-cart-message i:first-child {
        font-size: 30px;
        color: #6c757d;
        margin-bottom: 15px;
    }

    #cart-icon {
        padding-top: 20px;

    }
</style>
<style>
    /* Update quantity control styling */
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #ddd;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        background: #f8f9fa;
        border-color: #007bff;
        color: #007bff;
    }

    .quantity-input {
        width: 60px !important;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        margin: 0 5px;
    }

    /* Center delete button */
    .remove-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        margin: 0 auto;
        border: 1px solid #dc3545;
        border-radius: 50%;
        color: #dc3545;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-item:hover {
        background: #dc3545;
        color: white;
        /* transform: rotate(90deg); */
    }

    /* Delete all button */
    .delete-all-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-left: auto;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .delete-all-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .delete-all-btn i {
        font-size: 14px;
    }
</style>
<style>
    /* Checkbox styling */
    .product-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #007bff;
    }

    /* Delete selected button */
    .delete-selected-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
        transition: all 0.3s ease;
    }

    .delete-selected-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .delete-buttons-container {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }

    /* Confirmation Modal */
    .confirm-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .confirm-modal-content {
        position: relative;
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        width: 90%;
        max-width: 400px;
        border-radius: 8px;
        text-align: center;
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-100px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .confirm-modal-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }
</style>
<style>
    /* Update the delete buttons container styling */
    .delete-buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin: 15px;
        padding-right: 15px;
        position: relative;
        z-index: 1;
    }

    /* Style table layout */
    .cart-content-left table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Style checkbox column */
    .cart-content-left th:first-child,
    .cart-content-left td:first-child {
        width: 50px;
        text-align: center;
        padding: 15px 10px;
        vertical-align: middle;
    }

    /* Style checkboxes */
    .product-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #007bff;
        margin: 0 auto;
        display: block;
    }

    /* Style table header */
    .cart-content-left th {
        background-color: #f8f9fa;
        padding: 15px;
        text-transform: uppercase;
        font-size: 0.9rem;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
        text-align: center;
    }

    /* Align other columns */
    .cart-content-left td {
        text-align: center;
        vertical-align: middle;
        padding: 15px;
    }

    /* Style buttons */
    .delete-selected-btn,
    .delete-all-btn {
        min-width: 120px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .delete-selected-btn {
        background: #dc3545;
        color: white;
    }

    .delete-all-btn {
        background: #dc3545;
        color: white;
    }

    .delete-selected-btn:hover,
    .delete-all-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
</style>
<style>
    .empty-cart-message i {
        font-size: 48px;
        color: #6c757d;
    }

    .empty-cart-message p {
        font-size: 18px;
        color: #495057;
        margin: 10px 0;
    }

    .empty-cart-message #continue-shopping {
        min-width: 200px;
        height: 45px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 15px;
        padding: 0 20px;
    }

    .empty-cart-message #continue-shopping:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .empty-cart-message #continue-shopping i {
        font-size: 16px;
        color: white;
        margin: 0;
    }
</style>
<style>
    /* Style for empty cart message and button */


    .empty-cart-message i {
        font-size: 48px;
        color: #6c757d;
    }

    .empty-cart-message p {
        font-size: 18px;
        color: #495057;
        margin: 10px 0;
    }

    .empty-cart-message #continue-shopping {
        min-width: 200px;
        height: 45px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 20px auto 0;
        padding: 0 20px;
    }

    .empty-cart-message #continue-shopping:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .empty-cart-message #continue-shopping i {
        font-size: 16px;
        color: white;
        margin: 0;
    }

    /* Update the colspan for empty cart message */
    .cart-content-left td[colspan="5"] {
        padding: 40px 20px;
    }
</style>
<style>
    /* Update the delete buttons container styling */


    /* Style buttons */
    .delete-selected-btn,
    .delete-all-btn {
        min-width: 120px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .delete-selected-btn {
        background: #dc3545;
        color: white;
    }

    .delete-all-btn {
        background: #dc3545;
        color: white;
        margin: 0;
    }

    .delete-selected-btn:hover,
    .delete-all-btn:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Update cart content left padding */
    .cart-content-left {
        flex: 2;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .cart-content-left th {
        padding-right: 0 !important;
        padding-left: 0 !important;
    }

    .cart-content-left tr {
        border-radius: 12px;
    }

    .delete-buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 60px;
        padding: 0;
        border-top: 1px solid #e9ecef;
        background-color: #f8f9fa;
        border-radius: 0 0 12px 12px;
        /* margin-bottom:0; */
        /* margin-left:40 px; */
        /* margin-bottom:40 px; */
    }

    .container {
        margin-left: 300px;
        margin-right: 300px;
    }
</style>
<style>
    /* Add this to your existing CSS */
    .cart-content-left td:nth-child(4) {
        color: #666;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9em;
    }

    /* Update table column widths */
    .cart-content-left th:nth-child(1) {
        width: 50px;
    }

    /* Checkbox */
    .cart-content-left th:nth-child(2) {
        width: 160px;
    }

    /* Image */
    .cart-content-left th:nth-child(3) {
        width: auto;
    }

    /* Name */
    .cart-content-left th:nth-child(4) {
        width: 120px;
    }

    /* Brand */
    .cart-content-left th:nth-child(5) {
        width: 120px;
    }

    /* Quantity */
    .cart-content-left th:nth-child(6) {
        width: 120px;
    }

    /* Price */
    .cart-content-left th:nth-child(7) {
        width: 80px;
    }

    #price {
        color: #008000;
    }
</style>
<style>
    /* Update quantity control styling */
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 120px;
        height: 36px;
        border: 1px solid #ddd;
        border-radius: 20px;
        background: white;
        margin: 0 auto;
    }

    .quantity-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        color: #007bff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        color: #0056b3;
        transform: scale(1.1);
    }

    .quantity-input {
        width: 40px !important;
        border: none !important;
        text-align: center;
        font-weight: 500;
        color: #495057;
        padding: 0 !important;
        margin: 0 4px !important;
        -moz-appearance: textfield;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Update delete buttons container */
    .delete-buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 15px 20px;
        border-top: 1px solid #e9ecef;
        background: linear-gradient(to bottom, #f8f9fa, #fff);
        border-radius: 0 0 12px 12px;
        box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.02);
    }

    .delete-selected-btn,
    .delete-all-btn {
        min-width: 130px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 16px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #fff;
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .delete-selected-btn:hover,
    .delete-all-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
    }

    .delete-buttons-container i {
        font-size: 14px;
    }

    .cart {
        padding-bottom: 50vh;
    }
</style>
<style>

</style>

<body>

    <!------------cart------------->
    <section class="cart">
        <div class="container">
            <div class="cart-top-wrap">

                <div class="cart-top">
                    <div class="cart-top-cart cart-top-item">
                        <a href="cart.php">

                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>

                    <div class="cart-top-address cart-top-item">
                        <a href="delivery.php">

                            <i class="fa-solid fa-location-dot"></i>
                        </a>
                    </div>

                    <div class="cart-top-payment cart-top-item">
                        <a href="payment.php">

                            <i class="fa-solid fa-money-check"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="eight">
                <h1> ----------------------------------------------- Giỏ Hàng
                    -----------------------------------------------</h1>
            </div>

            <div class="cart-content-row">
                <div class="cart-content-left">


                    <!-- Update the quantity control in the table row -->

                    <table>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all" class="product-checkbox"
                                        onclick="toggleAllCheckboxes()"></th>
                                <th><i class="fa-solid fa-image cart-icon"></i>Hình ảnh xe</th>
                                <th><i class="fa-solid fa-tag cart-icon"></i>Tên </th>
                                <th><i class="fa-solid fa-car cart-icon"></i>Hãng</th>
                                <th><i class="fa-solid fa-sort-amount-up cart-icon"></i>Số lượng</th>
                                <th><i class="fa-solid fa-money-bill cart-icon"></i>Giá</th>
                                <th><i class="fa-solid fa-trash"></i>&nbsp;Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cartItems)): ?>
                                <?php foreach ($cartItems as $item): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="product-checkbox"
                                                value="<?php echo $item['product_id']; ?>"
                                                onchange="updateDeleteSelectedButton()">
                                        </td>
                                        <td>
                                            <img src="<?php echo htmlspecialchars($item['image_link']); ?>"
                                                alt="<?php echo htmlspecialchars($item['car_name']); ?>">
                                        </td>
                                        <td>
                                            <a href="car-details.php?name=<?php echo urlencode($item['car_name']); ?>">
                                                <?php echo htmlspecialchars($item['car_name']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($item['type_name'] ?? 'N/A'); ?>
                                        </td>
                                        <td>
                                            <div class="quantity-control">
                                                <button class="quantity-btn minus"
                                                    onclick="updateQuantity(<?php echo $item['product_id']; ?>, 'decrease')">
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                                <input type="number" class="quantity-input"
                                                    value="<?php echo $item['quantity']; ?>" min="1"
                                                    data-id="<?php echo $item['product_id']; ?>"
                                                    oninput="handleQuantityChange(this)">
                                                <button class="quantity-btn plus"
                                                    onclick="updateQuantity(<?php echo $item['product_id']; ?>, 'increase')">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td id="price">
                                            <p>
                                                <?php echo number_format($item['price'], 0, ',', '.'); ?> ₫
                                            </p>
                                        </td>
                                        <td>
                                            <span class="remove-item"
                                                onclick="removeCartItem(<?php echo $item['product_id']; ?>)">X</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="empty-cart-message">
                                        <i class="fa-solid fa-shopping-cart" id="cart-icon"></i>
                                        <p>Giỏ hàng của bạn đang trống</p>
                                        <button id="continue-shopping" onclick="window.location.href='index.php'">
                                            <i class="fa-solid fa-home"></i> Tiếp tục mua sắm
                                        </button>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Add the delete buttons container here -->
                    <div class="delete-buttons-container">
                        <button class="delete-selected-btn" onclick="deleteSelectedItems()" id="delete-selected-btn"
                            style="display: none;">
                            <i class="fa-solid fa-trash-alt"></i> Xóa đã chọn
                        </button>
                        <button class="delete-all-btn" onclick="confirmDeleteAll()">
                            <i class="fa-solid fa-trash-alt"></i> Xóa tất cả
                        </button>
                    </div>
                </div>
                <div class="cart-content-right">
                    <table>
                        <tr>
                            <th colspan="2">
                                <i class="fa-solid fa-shopping-cart cart-icon"></i>
                                TỔNG TIỀN GIỎ HÀNG
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-cubes quantity-icon"></i>
                                TỔNG SẢN PHẨM
                            </td>
                            <td id="total-items">
                                <?php echo $totalItems; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-calculator price-icon"></i>
                                TỔNG TIỀN
                            </td>
                            <td>
                                <p id="total-amount">
                                    <?php echo number_format($totalAmount, 0, ',', '.'); ?> VND
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa-solid fa-receipt total-icon"></i>
                                TẠM TÍNH
                            </td>
                            <td>
                                <p style="color: black; font-weight: bold;">
                                    <?php echo number_format($totalAmount, 0, ',', '.'); ?> VND
                                </p>
                            </td>
                        </tr>
                    </table>
                    <div class="cart-content-right-button">
                        <button id="continue-shopping" onclick="history.back()">TRỞ VỀ</button>
                        <!-- <button id="checkout-button" onclick="navigateToDelivery()">THANH TOÁN</button> -->
                        <button id="checkout-button" onclick="proceedToCheckout()">THANH TOÁN</button>
                    </div>

                    <!-- <div class="cart-content-right-dangnhap">
                        <p>TÀI KHOẢN</p>
                        <p>Hãy <a href="">Đăng nhập</a> tài khoản của bạn để tích điểm thành viên</p>
                    </div> -->

                    <!-- <script>
                        function navigateToDelivery() {
                            // Chuyển đến trang delivery.php
                            window.location.href = "delivery.php";
                        }

                        function goToHomePage() {
                            // Chuyển hướng về trang chủ
                            window.location.href = "index.php";
}

                    </script> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Confirmation Modals -->
    <div id="deleteConfirmModal" class="confirm-modal">
        <div class="confirm-modal-content">
            <h3>Xác nhận xóa</h3>
            <p id="deleteConfirmMessage"></p>
            <div class="confirm-modal-buttons">
                <button class="confirm-btn" onclick="executeDelete()">Xóa</button>
                <button class="cancel-btn" onclick="closeConfirmModal()">Hủy</button>
            </div>
        </div>
    </div>
    <script>
        function handleQuantityChange(input) {
            const productId = input.dataset.id;
            const quantity = input.value;

            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        function removeCartItem(productId) {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            }
        }

        // Update the proceedToCheckout function
        function proceedToCheckout() {
            const totalItems = <?php echo $totalItems; ?>;
            if (totalItems > 0) {
                <?php if (isset($_SESSION['user_id'])): ?>
                    window.location.href = 'delivery.php';
                <?php else: ?>
                    showNotification('Vui lòng đăng nhập để tiếp tục thanh toán', 'warning');
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 1500);
                <?php endif; ?>
            } else {
                showNotification('Giỏ hàng của bạn đang trống!', 'warning');
            }
        }
    </script>
    <script>
        // Add these new functions
        function updateQuantity(productId, action) {
            const input = document.querySelector(`input[data-id="${productId}"]`);
            let value = parseInt(input.value);

            if (action === 'increase') {
                value++;
            } else if (action === 'decrease' && value > 1) {
                value--;
            }

            input.value = value;
            handleQuantityChange(input);
        }

        function removeAllItems() {
            if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm?')) {
                fetch('remove_all_cart_items.php', {
                    method: 'POST',
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            }
        }
    </script>
    <script>

        // Update existing functions to use confirmations and notifications
        function handleQuantityChange(input) {
            const productId = input.dataset.id;
            const quantity = parseInt(input.value);

            if (quantity < 1) {
                showNotification('Số lượng không thể nhỏ hơn 1', 'error');
                input.value = 1;
                return;
            }

            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Đã cập nhật số lượng', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('Có lỗi xảy ra', 'error');
                    }
                });
        }

        function updateQuantity(productId, action) {
            const input = document.querySelector(`input[data-id="${productId}"]`);
            let value = parseInt(input.value);

            if (action === 'increase') {
                value++;
            } else if (action === 'decrease' && value > 1) {
                value--;
            } else if (value <= 1 && action === 'decrease') {
                showNotification('Số lượng không thể nhỏ hơn 1', 'error');
                return;
            }

            input.value = value;
            handleQuantityChange(input);
        }

        // Add event listeners for modal buttons
        document.addEventListener('DOMContentLoaded', function () {
            // Close modal when clicking outside
            window.onclick = function (event) {
                const modal = document.getElementById('deleteConfirmModal');
                if (event.target === modal) {
                    closeConfirmModal();
                }
            }

            // Add keyboard support for modal
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeConfirmModal();
                }
            });

            // Initialize select all checkbox state
            updateSelectAllCheckbox();
        });

        function updateSelectAllCheckbox() {
            const mainCheckbox = document.getElementById('select-all');
            const checkboxes = Array.from(document.getElementsByClassName('product-checkbox'))
                .filter(checkbox => checkbox !== mainCheckbox);

            if (checkboxes.length > 0) {
                const allChecked = checkboxes.every(checkbox => checkbox.checked);
                const someChecked = checkboxes.some(checkbox => checkbox.checked);

                mainCheckbox.checked = allChecked;
                mainCheckbox.indeterminate = someChecked && !allChecked;
            }
        }
    </script>

    <script>
        let deleteType = '';
        let selectedItems = [];

        // Notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;

            document.body.appendChild(notification);
            setTimeout(() => notification.classList.add('show'), 100);
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Checkbox functions
        function toggleAllCheckboxes() {
            const mainCheckbox = document.getElementById('select-all');
            const checkboxes = document.getElementsByClassName('product-checkbox');
            Array.from(checkboxes).forEach(checkbox => {
                if (checkbox !== mainCheckbox) {
                    checkbox.checked = mainCheckbox.checked;
                }
            });
            updateDeleteSelectedButton();
        }

        function updateDeleteSelectedButton() {
            const checkboxes = document.getElementsByClassName('product-checkbox');
            const deleteSelectedBtn = document.getElementById('delete-selected-btn');
            selectedItems = [];

            Array.from(checkboxes).forEach(checkbox => {
                if (checkbox.checked && checkbox.value) {
                    selectedItems.push(checkbox.value);
                }
            });

            if (deleteSelectedBtn) {
                deleteSelectedBtn.style.display = selectedItems.length > 0 ? 'flex' : 'none';
            }
        }

        // Delete functions
        function confirmDeleteAll() {
            showConfirmModal('Bạn có chắc muốn xóa tất cả sản phẩm?', 'all');
        }

        function deleteSelectedItems() {
            if (selectedItems.length > 0) {
                showConfirmModal('Bạn có chắc muốn xóa các sản phẩm đã chọn?', 'selected');
            }
        }

        function removeCartItem(productId) {
            showConfirmModal('Bạn có chắc muốn xóa sản phẩm này?', 'single');
            selectedItems = [productId];
        }

        // Modal functions
        function showConfirmModal(message, type) {
            deleteType = type;
            document.getElementById('deleteConfirmMessage').textContent = message;
            document.getElementById('deleteConfirmModal').style.display = 'block';
        }

        function closeConfirmModal() {
            document.getElementById('deleteConfirmModal').style.display = 'none';
        }

        function executeDelete() {
            closeConfirmModal();
            let url, body;

            switch (deleteType) {
                case 'all':
                    url = 'remove_all_cart_items.php';
                    body = '';
                    break;
                case 'selected':
                case 'single':
                    url = 'remove_selected_items.php';
                    body = JSON.stringify({ items: selectedItems });
                    break;
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: body
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Đã xóa sản phẩm thành công', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('Có lỗi xảy ra', 'error');
                    }
                });
        }

        // Quantity functions
        function handleQuantityChange(input) {
            const productId = input.dataset.id;
            const quantity = parseInt(input.value);

            if (quantity < 1) {
                showNotification('Số lượng không thể nhỏ hơn 1', 'error');
                input.value = 1;
                return;
            }

            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${quantity}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Đã cập nhật số lượng', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification('Có lỗi xảy ra', 'error');
                    }
                });
        }

        function updateQuantity(productId, action) {
            const input = document.querySelector(`input[data-id="${productId}"]`);
            let value = parseInt(input.value);

            if (action === 'increase') {
                value++;
            } else if (action === 'decrease' && value > 1) {
                value--;
            } else if (value <= 1 && action === 'decrease') {
                showNotification('Số lượng không thể nhỏ hơn 1', 'error');
                return;
            }

            input.value = value;
            handleQuantityChange(input);
        }

        // Checkout function
        function proceedToCheckout() {
            const totalItems = <?php echo $totalItems; ?>;
            if (totalItems > 0) {
                <?php if (isset($_SESSION['user_id'])): ?>
                    window.location.href = 'delivery.php';
                <?php else: ?>
                    showNotification('Vui lòng đăng nhập để tiếp tục thanh toán', 'warning');
                    setTimeout(() => window.location.href = 'login.php', 1500);
                <?php endif; ?>
            } else {
                showNotification('Giỏ hàng của bạn đang trống!', 'warning');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            updateDeleteSelectedButton();

            window.onclick = function (event) {
                if (event.target === document.getElementById('deleteConfirmModal')) {
                    closeConfirmModal();
                }
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeConfirmModal();
                }
            });
        });
    </script>
</body>

</html>
<?php

include 'footer.php';
?>
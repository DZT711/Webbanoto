<?php
// File: update_cart.php
session_start();
include 'connect.php';

header('Content-Type: application/json');

if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

if ($quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
    exit;
}

try {
    if (isset($_SESSION['user_id'])) {
        // Update quantity for logged-in user
        $user_id = $_SESSION['user_id'];
        
        // Get cart ID
        $cart_query = "SELECT cart_id FROM cart WHERE user_id = ? AND cart_status = 'activated'";
        $stmt = mysqli_prepare($connect, $cart_query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $cart_result = mysqli_stmt_get_result($stmt);
        $cart = mysqli_fetch_assoc($cart_result);
        
        if ($cart) {
            // Update cart item
            $update_query = "UPDATE cart_items SET quantity = ? 
                           WHERE cart_id = ? AND product_id = ?";
            $stmt = mysqli_prepare($connect, $update_query);
            mysqli_stmt_bind_param($stmt, "iii", $quantity, $cart['cart_id'], $product_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Failed to update cart");
            }
        }
    } else {
        // Update quantity for guest user
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        
        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
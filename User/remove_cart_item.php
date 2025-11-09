<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

if (!isset($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing product ID']);
    exit;
}

$product_id = intval($_POST['product_id']);

try {
    if (isset($_SESSION['user_id'])) {
        // Get cart ID
        $cart_query = "SELECT cart_id FROM cart WHERE user_id = ? AND cart_status = 'activated'";
        $stmt = mysqli_prepare($connect, $cart_query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $cart = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($cart) {
            // Delete item from cart
            $delete_query = "DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?";
            $stmt = mysqli_prepare($connect, $delete_query);
            mysqli_stmt_bind_param($stmt, "ii", $cart['cart_id'], $product_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Failed to delete item");
            }
        }
    } else {
        // Remove from session cart
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
                return $item['product_id'] != $product_id;
            });
        }
        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
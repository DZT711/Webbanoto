<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

try {
    if (isset($_SESSION['user_id'])) {
        // Get cart ID
        $cart_query = "SELECT cart_id FROM cart WHERE user_id = ? AND cart_status = 'activated'";
        $stmt = mysqli_prepare($connect, $cart_query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $cart = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($cart) {
            // Delete all items from cart
            $delete_query = "DELETE FROM cart_items WHERE cart_id = ?";
            $stmt = mysqli_prepare($connect, $delete_query);
            mysqli_stmt_bind_param($stmt, "i", $cart['cart_id']);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Failed to delete items");
            }
        }
    } else {
        // Clear session cart
        $_SESSION['cart'] = [];
        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
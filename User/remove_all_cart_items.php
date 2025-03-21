<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $success = false;

    try {
        mysqli_begin_transaction($connect);

        // Get cart_id
        $cart_query = "SELECT c.cart_id FROM cart c 
                      WHERE c.user_id = ? AND c.cart_status = 'activated'";
        $stmt = mysqli_prepare($connect, $cart_query);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $cart_result = mysqli_stmt_get_result($stmt);
        $cart = mysqli_fetch_assoc($cart_result);

        if ($cart) {
            // Delete all items from cart_items
            $delete_query = "DELETE FROM cart_items WHERE cart_id = ?";
            $stmt = mysqli_prepare($connect, $delete_query);
            mysqli_stmt_bind_param($stmt, "i", $cart['cart_id']);
            mysqli_stmt_execute($stmt);
            
            mysqli_commit($connect);
            $success = true;
        }

    } catch (Exception $e) {
        mysqli_rollback($connect);
        $success = false;
    }

    echo json_encode(['success' => $success]);
}
?>
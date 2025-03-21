<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
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
            // Update quantity in cart_items
            $update_query = "UPDATE cart_items SET quantity = ? 
                           WHERE cart_id = ? AND product_id = ?";
            $stmt = mysqli_prepare($connect, $update_query);
            mysqli_stmt_bind_param($stmt, "iii", $quantity, $cart['cart_id'], $product_id);
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
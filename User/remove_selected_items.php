<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true);
    $items = $data['items'] ?? [];
    $success = false;

    if (!empty($items)) {
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
                // Delete selected items from cart_items
                $items_str = implode(',', array_map('intval', $items));
                $delete_query = "DELETE FROM cart_items 
                               WHERE cart_id = ? AND product_id IN ($items_str)";
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
    }

    echo json_encode(['success' => $success]);
}
?>
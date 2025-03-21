<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "DELETE ci FROM cart_items ci 
                 JOIN cart c ON ci.cart_id = c.cart_id 
                 WHERE c.user_id = ? AND ci.product_id = ? AND c.status = 'active'";
        
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        $success = mysqli_stmt_execute($stmt);
    } else {
        $success = false;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                $success = true;
                break;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    
    echo json_encode(['success' => $success]);
}
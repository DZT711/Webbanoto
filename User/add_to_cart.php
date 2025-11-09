<?php
session_start();
include 'connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity'] ?? 1);
    $success = false;

    if (isset($_SESSION['user_id'])) {
        // For logged in users
        $user_id = $_SESSION['user_id'];

        // Start transaction
        mysqli_begin_transaction($connect);

        try {
            // Check if user has an active cart
            $cart_query = "SELECT cart_id FROM cart WHERE user_id = ? AND cart_status = 'activated'";
            $stmt = mysqli_prepare($connect, $cart_query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $cart_result = mysqli_stmt_get_result($stmt);

            if ($cart = mysqli_fetch_assoc($cart_result)) {
                $cart_id = $cart['cart_id'];
            } else {
                // Create new cart
                $create_cart = "INSERT INTO cart (user_id, cart_status) VALUES (?, 'activated')";
                $stmt = mysqli_prepare($connect, $create_cart);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $cart_id = mysqli_insert_id($connect);
            }

            // Check if product already exists in cart
            $check_query = "SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?";
            $stmt = mysqli_prepare($connect, $check_query);
            mysqli_stmt_bind_param($stmt, "ii", $cart_id, $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($item = mysqli_fetch_assoc($result)) {
                // Update quantity if product exists
                $new_quantity = $item['quantity'] + $quantity;
                $update_query = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_id = ?";
                $stmt = mysqli_prepare($connect, $update_query);
                mysqli_stmt_bind_param($stmt, "iii", $new_quantity, $cart_id, $product_id);
                mysqli_stmt_execute($stmt);
            } else {
                // Add new product to cart
                $insert_query = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($connect, $insert_query);
                mysqli_stmt_bind_param($stmt, "iii", $cart_id, $product_id, $quantity);
                mysqli_stmt_execute($stmt);
            }

            // Commit transaction
            mysqli_commit($connect);
            $success = true;

        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($connect);
            $success = false;
        }
    }  else {
        // For guest users
        $product_query = "SELECT p.*, ct.type_name 
                         FROM products p 
                         LEFT JOIN car_types ct ON p.brand_id = ct.type_id 
                         WHERE p.product_id = ? AND p.status IN ('selling', 'discounting')";

        $stmt = mysqli_prepare($connect, $product_query);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($product = mysqli_fetch_assoc($result)) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['product_id'] == $product_id) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $_SESSION['cart'][] = [
                    'product_id' => $product_id,
                    'car_name' => $product['car_name'],
                    'price' => $product['price'],
                    'image_link' => $product['image_link'],
                    'quantity' => $quantity,
                    'type_name' => $product['type_name'] ?? 'N/A',
                    'status' => $product['status'] // Add status field
                ];
            }
            $success = true;
        }
    }

    echo json_encode(['success' => $success]);
}

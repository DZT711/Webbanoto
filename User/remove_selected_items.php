<?php
session_start();
include 'connect.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['items']) || empty($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'No items selected']);
    exit;
}

try {
    if (isset($_SESSION['user_id'])) {
        // Get cart ID
        $cart_query = "SELECT cart_id FROM cart WHERE user_id = ? AND cart_status = 'activated'";
        $stmt = mysqli_prepare($connect, $cart_query);
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $cart = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($cart) {
            // Create placeholders for IN clause
            $placeholders = str_repeat('?,', count($data['items']) - 1) . '?';
            
            // Delete selected items from cart
            $delete_query = "DELETE FROM cart_items WHERE cart_id = ? AND product_id IN ($placeholders)";
            $stmt = mysqli_prepare($connect, $delete_query);
            
            // Prepare parameters array
            $params = array_merge([$cart['cart_id']], $data['items']);
            $types = str_repeat('i', count($params));
            
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Failed to delete items");
            }
        }
    } else {
        // Remove selected items from session cart
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($data) {
                return !in_array($item['product_id'], $data['items']);
            });
        }
        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
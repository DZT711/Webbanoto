<?php
// filepath: d:\xmapp\htdocs\WebbanotoPHP\User\dismiss_notification.php
session_start();

$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'];

if (isset($_SESSION['cart_notifications'])) {
    $_SESSION['cart_notifications'] = array_filter($_SESSION['cart_notifications'], function($notification) use ($product_id) {
        return $notification['product_id'] != $product_id;
    });
}

echo json_encode(['success' => true]);
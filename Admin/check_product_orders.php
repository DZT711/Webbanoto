<?php
include '../User/connect.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No product ID provided']);
    exit;
}

$product_id = intval($_GET['id']);

$query = "SELECT COUNT(*) as count FROM order_details WHERE product_id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

echo json_encode([
    'inOrders' => $result['count'] > 0
]);
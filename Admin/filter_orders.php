<?php
// filepath: d:\xmapp\htdocs\WebbanotoPHP\Admin\filter_orders.php


include 'connect.php';
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $filter_query = buildFilterQuery($data);
    $stmt = mysqli_prepare($connect, $filter_query['query']);
    
    if (!empty($filter_query['params'])) {
        mysqli_stmt_bind_param($stmt, $filter_query['types'], ...$filter_query['params']);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
    
    echo json_encode([
        'success' => true,
        'orders' => $orders
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
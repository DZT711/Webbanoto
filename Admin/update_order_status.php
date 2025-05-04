<?php
include 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['order_status'])) {
    try {
        $order_id = intval($_POST['order_id']);
        $status = mysqli_real_escape_string($connect, $_POST['order_status']);
        
        $update_query = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        $stmt = mysqli_prepare($connect, $update_query);
        mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Database update failed");
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
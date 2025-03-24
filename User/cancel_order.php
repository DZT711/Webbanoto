<?php
include 'header.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$order_id = intval($_POST['order_id']);
$user_id = $_SESSION['user_id'];

try {
    mysqli_begin_transaction($connect);

    // Check if order belongs to user and can be cancelled
    $check_query = "SELECT order_status FROM orders 
                   WHERE order_id = ? AND user_id = ? 
                   AND order_status IN ('initiated', 'is pending')";
    
    $stmt = mysqli_prepare($connect, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $order_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) === 0) {
        throw new Exception('Không thể hủy đơn hàng này');
    }

    // Update order status to cancelled
    $update_query = "UPDATE orders SET order_status = 'cancelled' WHERE order_id = ?";
    $stmt = mysqli_prepare($connect, $update_query);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Không thể cập nhật trạng thái đơn hàng');
    }

    mysqli_commit($connect);
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    mysqli_rollback($connect);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
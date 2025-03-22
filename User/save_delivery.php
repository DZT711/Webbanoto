<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để tiếp tục']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_SESSION['user_id'];

// Validate required fields
if (empty($data['full_name']) || empty($data['phone']) || empty($data['address'])) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin']);
    exit();
}

// Validate phone number format
if (!preg_match('/^[0-9]{10}$/', $data['phone'])) {
    echo json_encode(['success' => false, 'message' => 'Số điện thoại không hợp lệ']);
    exit();
}

try {
    mysqli_begin_transaction($connect);

    // Update user information first
    $update_user = "UPDATE users_acc SET 
                    full_name = ?,
                    phone_num = ?,
                    address = ?
                    WHERE id = ?";

    $stmt = mysqli_prepare($connect, $update_user);
    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $data['full_name'],
        $data['phone'],
        $data['address'],
        $user_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Không thể cập nhật thông tin người dùng');
    }

    // Get cart information
    $cart_query = "SELECT c.cart_id, ci.product_id, ci.quantity, p.price 
                   FROM cart c 
                   JOIN cart_items ci ON c.cart_id = ci.cart_id 
                   JOIN products p ON ci.product_id = p.product_id 
                   WHERE c.user_id = ? AND c.cart_status = 'activated'";

    $stmt = mysqli_prepare($connect, $cart_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $cart_result = mysqli_stmt_get_result($stmt);

    // Add check for empty cart
    if (mysqli_num_rows($cart_result) === 0) {
        throw new Exception('Giỏ hàng của bạn đang trống');
    }

    // Calculate total amount
    $total_amount = 0;
    while ($item = mysqli_fetch_assoc($cart_result)) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // Create new order
    $create_order = "INSERT INTO orders (user_id, order_date, shipping_address, expected_total_amount, order_status) 
                     VALUES (?, NOW(), ?, ?, 'is pending')";

    $stmt = mysqli_prepare($connect, $create_order);
    mysqli_stmt_bind_param($stmt, "isd", $user_id, $data['address'], $total_amount);
    mysqli_stmt_execute($stmt);
    $order_id = mysqli_insert_id($connect);

    // Transfer items from cart to order_details
    mysqli_data_seek($cart_result, 0);
    while ($item = mysqli_fetch_assoc($cart_result)) {
        $insert_detail = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                         VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $insert_detail);
        mysqli_stmt_bind_param($stmt, "iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        mysqli_stmt_execute($stmt);
    }

    // After successful order creation, deactivate the cart
    $update_cart = "UPDATE cart SET cart_status = 'deactivated' 
                    WHERE user_id = ? AND cart_status = 'activated'";
    $stmt = mysqli_prepare($connect, $update_cart);
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Không thể cập nhật trạng thái giỏ hàng');
    }

    mysqli_commit($connect);

    // Store order info in session for payment page
    $_SESSION['current_order_id'] = $order_id;
    $_SESSION['order_amount'] = $total_amount;

    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'message' => 'Đã lưu thông tin thành công'
    ]);

} catch (Exception $e) {
    mysqli_rollback($connect);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage() ?: 'Có lỗi xảy ra, vui lòng thử lại'
    ]);
}

mysqli_close($connect);
?>
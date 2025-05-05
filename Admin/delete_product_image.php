<?php
include '../User/connect.php';

// Kiểm tra nếu là request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Đọc dữ liệu JSON từ request body
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['image_id'])) {
        $image_id = mysqli_real_escape_string($connect, $data['image_id']);

        // Lấy đường dẫn hình ảnh trước khi xóa
        $query = "SELECT image_url FROM product_images WHERE image_id = $image_id";
        $result = mysqli_query($connect, $query);
        $image = mysqli_fetch_assoc($result);

        if ($image) {
            // Xóa file vật lý
            $file_path = '../User/' . $image['image_url'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }

            // Xóa khỏi CSDL
            $delete_query = "DELETE FROM product_images WHERE image_id = $image_id";
            if (mysqli_query($connect, $delete_query)) {
                echo json_encode(['success' => true, 'message' => 'Image deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database error']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Image not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No image ID provided']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

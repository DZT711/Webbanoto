<?php
include '../User/connect.php';

if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($connect, $_GET['id']);
    
    $query = "SELECT image_id, image_url FROM product_images WHERE product_id = $product_id ORDER BY sort_order";
    $result = mysqli_query($connect, $query);
    
    $images = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $images[] = [
            'image_id' => $row['image_id'],
            'image_url' => $row['image_url']
        ];
    }
    
    echo json_encode(['success' => true, 'images' => $images]);
} else {
    echo json_encode(['success' => false, 'message' => 'No product ID provided']);
}

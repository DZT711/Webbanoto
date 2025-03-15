<?php
include '../User/connect.php';

if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($connect, $_GET['id']);
    
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($connect, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode([
            'success' => true,
            'product' => $product
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Product not found'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No product ID provided'
    ]);
}
?>
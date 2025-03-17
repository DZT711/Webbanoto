<?php
include '../User/connect.php';

if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($connect, $_GET['id']);
    
    $query = "SELECT p.*, c.type_name 
              FROM products p 
              LEFT JOIN car_types c ON p.brand_id = c.type_id 
              WHERE p.product_id = '$product_id'";
              
    $result = mysqli_query($connect, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        
        // Prepare response
        $response = array(
            'success' => true,
            'product' => array(
                'product_id' => $product['product_id'],
                'car_name' => $product['car_name'],
                'brand_id' => $product['brand_id'],
                'year_manufacture' => $product['year_manufacture'],
                'price' => $product['price'],
                'max_speed' => $product['max_speed'],
                'engine_name' => $product['engine_name'],
                'fuel_name' => $product['fuel_name'],
                'color' => $product['color'],
                'seat_number' => $product['seat_number'],
                'engine_power' => $product['engine_power'],
                'status' => $product['status'],
                'image_link' => $product['image_link'],
                'fuel_capacity' => $product['fuel_capacity'],
                'car_description' => $product['car_description']
            )
        );
        
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        echo json_encode(array('success' => false, 'message' => 'Product not found'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'No product ID provided'));
}
?>
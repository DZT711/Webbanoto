<?php
function getPriceRanges($connect, $brand = null) {
    $sql = "SELECT MIN(price) as min_price, MAX(price) as max_price 
            FROM products p
            LEFT JOIN car_types c ON p.brand_id = c.type_id 
            WHERE status IN ('selling', 'discounting')";
    
    if ($brand) {
        $sql .= " AND c.type_name = ?";
    }
    
    $stmt = mysqli_prepare($connect, $sql);
    if ($brand) {
        mysqli_stmt_bind_param($stmt, "s", $brand);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $prices = mysqli_fetch_assoc($result);
    
    return [
        'min' => floor($prices['min_price'] / 1000000000), // Convert to billions
        'max' => ceil($prices['max_price'] / 1000000000)
    ];
}

function getYearRanges($connect, $brand = null) {
    $sql = "SELECT DISTINCT year_manufacture 
            FROM products p
            LEFT JOIN car_types c ON p.brand_id = c.type_id 
            WHERE status IN ('selling', 'discounting')";
    
    if ($brand) {
        $sql .= " AND c.type_name = ?";
    }
    
    $sql .= " ORDER BY year_manufacture DESC";
    
    $stmt = mysqli_prepare($connect, $sql);
    if ($brand) {
        mysqli_stmt_bind_param($stmt, "s", $brand);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $years = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $years[] = $row['year_manufacture'];
    }
    return $years;
}
?>
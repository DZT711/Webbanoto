<?php
include 'header.php';
include 'connect.php';



// $conditions = [];

// // Handle search query
// if (isset($_GET['query']) && !empty($_GET['query'])) {
//     $searchTerms = explode('+', trim($_GET['query']));
//     $searchTerms = array_map('trim', $searchTerms);

//     foreach ($searchTerms as $term) {
//         $term = mysqli_real_escape_string($connect, strtolower($term));
        
//         // Check for numeric comparisons
//         if (preg_match('/(giá|mã lực|dung tích|số chỗ|năm sản xuất|công suất|vận tốc tối đa):([<>=])(\d+)/', $term, $matches)) {
//             $field = $matches[1];
//             $operator = $matches[2];
//             $value = $matches[3];

//             $fieldMap = [
//                 'giá' => 'p.price',
//                 'mã lực' => 'p.engine_power',
//                 'dung tích' => 'p.fuel_capacity',
//                 'số chỗ' => 'p.seat_number',
//                 'năm sản xuất' => 'p.year_manufacture',
//                 'công suất' => 'p.engine_power',
//                 'vận tốc tối đa' => 'p.max_speed'
//             ];

//             if (isset($fieldMap[$field])) {
//                 $conditions[] = "{$fieldMap[$field]} $operator $value";
//             }
//         } else {
//             // Regular text search - only search relevant fields
//             $conditions[] = "(LOWER(p.car_name) LIKE '%$term%' OR LOWER(c.type_name) LIKE '%$term%')";
//         }
//     }
// }

// // Handle filters - only add conditions for non-empty inputs
// if (!empty($_GET['brand'])) {
//     $brand = mysqli_real_escape_string($connect, strtolower($_GET['brand']));
//     $conditions[] = "LOWER(c.type_name) = '$brand'";
// }

// // Price range
// if (!empty($_GET['price_min'])) {
//     $price_min = mysqli_real_escape_string($connect, $_GET['price_min']);
//     $conditions[] = "p.price >= $price_min";
// }
// if (!empty($_GET['price_max'])) {
//     $price_max = mysqli_real_escape_string($connect, $_GET['price_max']);
//     $conditions[] = "p.price <= $price_max";
// }

// // Only add other filter conditions if they are actually set
// $filterFields = [
//     'color' => ['field' => 'p.color', 'type' => 'text'],
//     'engine' => ['field' => 'p.engine_name', 'type' => 'text'],
//     'fuel' => ['field' => 'p.fuel_name', 'type' => 'text'],
//     'status' => ['field' => 'p.status', 'type' => 'exact']
// ];

// foreach ($filterFields as $param => $config) {
//     if (!empty($_GET[$param])) {
//         $value = mysqli_real_escape_string($connect, strtolower($_GET[$param]));
//         if ($config['type'] === 'text') {
//             $conditions[] = "LOWER({$config['field']}) LIKE '%$value%'";
//         } else {
//             $conditions[] = "{$config['field']} = '$value'";
//         }
//     }
// }

// // Handle numeric range filters
// $rangeFields = [
//     'speed' => 'p.max_speed',
//     'power' => 'p.engine_power',
//     'capacity' => 'p.fuel_capacity',
//     'seats' => 'p.seat_number',
//     'year' => 'p.year_manufacture'
// ];

// foreach ($rangeFields as $param => $field) {
//     if (!empty($_GET[$param . '_min'])) {
//         $min = mysqli_real_escape_string($connect, $_GET[$param . '_min']);
//         $conditions[] = "$field >= $min";
//     }
//     if (!empty($_GET[$param . '_max'])) {
//         $max = mysqli_real_escape_string($connect, $_GET[$param . '_max']);
//         $conditions[] = "$field <= $max";
//     }
// }

// // Build final query
// $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// $query = "SELECT p.*, c.type_name 
//           FROM products p 
//           LEFT JOIN car_types c ON p.brand_id = c.type_id 
//           $whereClause
//           ORDER BY p.product_id DESC";

// $result = mysqli_query($connect, $query);
// $searchResults = [];
// if ($result) {
//     $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
// }
// echo $query;


// $conditions = [];
// $searchResults = [];

// // Handle search query
// if (isset($_GET['query']) && !empty($_GET['query'])) {
//     $searchTerms = explode('+', trim($_GET['query']));
//     $searchTerms = array_map('trim', $searchTerms);

//     foreach ($searchTerms as $term) {
//         $term = mysqli_real_escape_string($connect, strtolower($term));
        
//         // Pattern for numeric comparisons with Vietnamese terms
//         $pattern = '/(giá|mã lực|dung tích|số chỗ|năm sản xuất|công suất|vận tốc tối đa)(\s*)(>|<|=)(\s*)(\d+)/u';
        
//         if (preg_match($pattern, $term, $matches)) {
//             $field = $matches[1];
//             $operator = $matches[3];
//             $value = $matches[5];

//             // Map Vietnamese terms to database columns
//             $fieldMap = [
//                 'giá' => 'p.price',
//                 'mã lực' => 'p.engine_power',
//                 'dung tích' => 'p.fuel_capacity',
//                 'số chỗ' => 'p.seat_number',
//                 'năm sản xuất' => 'p.year_manufacture',
//                 'công suất' => 'p.engine_power',
//                 'vận tốc tối đa' => 'p.max_speed'
//             ];

//             if (isset($fieldMap[$field])) {
//                 $conditions[] = "{$fieldMap[$field]} $operator $value";
//             }
//         } else {
//             // Regular text search for all relevant fields
//             $textConditions = [
//                 "LOWER(p.car_name) LIKE '%$term%'",
//                 "LOWER(c.type_name) LIKE '%$term%'",
//                 "LOWER(p.color) LIKE '%$term%'",
//                 "LOWER(p.engine_name) LIKE '%$term%'",
//                 "LOWER(p.fuel_name) LIKE '%$term%'",
//                 "CAST(p.max_speed AS CHAR) LIKE '%$term%'",
//                 "CAST(p.year_manufacture AS CHAR) LIKE '%$term%'",
//                 "CAST(p.seat_number AS CHAR) LIKE '%$term%'",
//                 "CAST(p.fuel_capacity AS CHAR) LIKE '%$term%'",
//                 "CAST(p.engine_power AS CHAR) LIKE '%$term%'"
//             ];
//             $conditions[] = "(" . implode(" OR ", $textConditions) . ")";
//         }
//     }
// }

// // Build and execute query
// $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

// $query = "SELECT p.*, c.type_name 
//           FROM products p 
//           LEFT JOIN car_types c ON p.brand_id = c.type_id 
//           $whereClause
//           ORDER BY p.product_id DESC";

// $result = mysqli_query($connect, $query);
// if ($result) {
//     $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
// }


// At the top of your file after includes
$conditions = [];
$searchResults = [];

// Handle search query
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchTerms = explode('+', trim($_GET['query']));
    $searchTerms = array_map('trim', $searchTerms);

    foreach ($searchTerms as $term) {
        $term = mysqli_real_escape_string($connect, strtolower($term));
        
        // Pattern for numeric comparisons with Vietnamese terms
        $pattern = '/(giá|mã lực|dung tích|số chỗ|năm sản xuất|công suất|vận tốc tối đa)(\s*)(>|<|=)(\s*)(\d+)/u';
        
        if (preg_match($pattern, $term, $matches)) {
            $field = $matches[1];
            $operator = $matches[3];
            $value = $matches[5];

            $fieldMap = [
                'giá' => 'p.price',
                'mã lực' => 'p.engine_power',
                'dung tích' => 'p.fuel_capacity',
                'số chỗ' => 'p.seat_number',
                'năm sản xuất' => 'p.year_manufacture',
                'công suất' => 'p.engine_power',
                'vận tốc tối đa' => 'p.max_speed'
            ];

            if (isset($fieldMap[$field])) {
                $conditions[] = "{$fieldMap[$field]} $operator $value";
            }
        } else {
            // Regular text search
            $textConditions = [
                "LOWER(p.car_name) LIKE '%$term%'",
                "LOWER(c.type_name) LIKE '%$term%'",
                "LOWER(p.color) LIKE '%$term%'",
                "LOWER(p.engine_name) LIKE '%$term%'",
                "LOWER(p.fuel_name) LIKE '%$term%'"
            ];
            $conditions[] = "(" . implode(" OR ", $textConditions) . ")";
        }
    }
}

// Handle filters
if (!empty($_GET['brand'])) {
    $brand = mysqli_real_escape_string($connect, $_GET['brand']);
    $conditions[] = "LOWER(c.type_name) = LOWER('$brand')";
}

// Handle range filters
$rangeFilters = [
    'price' => 'p.price',
    'speed' => 'p.max_speed',
    'power' => 'p.engine_power',
    'capacity' => 'p.fuel_capacity',
    'seats' => 'p.seat_number',
    'year' => 'p.year_manufacture'
];

foreach ($rangeFilters as $param => $field) {
    if (!empty($_GET[$param . '_min'])) {
        $min = mysqli_real_escape_string($connect, $_GET[$param . '_min']);
        $conditions[] = "$field >= $min";
    }
    if (!empty($_GET[$param . '_max'])) {
        $max = mysqli_real_escape_string($connect, $_GET[$param . '_max']);
        $conditions[] = "$field <= $max";
    }
}

// Handle text filters
if (!empty($_GET['color'])) {
    $color = mysqli_real_escape_string($connect, $_GET['color']);
    $conditions[] = "LOWER(p.color) LIKE LOWER('%$color%')";
}

if (!empty($_GET['engine'])) {
    $engine = mysqli_real_escape_string($connect, $_GET['engine']);
    $conditions[] = "LOWER(p.engine_name) LIKE LOWER('%$engine%')";
}

if (!empty($_GET['fuel'])) {
    $fuel = mysqli_real_escape_string($connect, $_GET['fuel']);
    $conditions[] = "LOWER(p.fuel_name) LIKE LOWER('%$fuel%')";
}

if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($connect, $_GET['status']);
    $conditions[] = "p.status = '$status'";
}

// Build and execute final query
$whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

$query = "SELECT p.*, c.type_name 
          FROM products p 
          LEFT JOIN car_types c ON p.brand_id = c.type_id 
          $whereClause
          ORDER BY p.product_id DESC";

$result = mysqli_query($connect, $query);
if ($result) {
    $searchResults = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="vi">
<ty>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    
    <style>
        .results {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .result-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .result-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .car-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .car-info p {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
        }

        .car-info i {
            color: #1abc9c;
            width: 20px;
            text-align: center;
        }

        .car-name {
            grid-column: 1 / -1;
            color: #2c3e50;
            font-size: 1.5em;
            margin: 0 0 10px 0;
        }

        .price {
            grid-column: 1 / -1;
            color: #e74c3c;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
            margin-left: 10px;
        }

        .search-header {
            background: rgb(220, 220, 220);
            padding: 15px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-header form {
            flex-grow: 1;
            display: flex;
            gap: 10px;
        }

        .search-header input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 1070px;
            padding-left: 20px;
        }

        .search-header button {
            padding: 10px 20px;
            background:rgb(0, 0, 0);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .no-results {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1em;
        }

        @media (max-width: 768px) {
            .result-item {
                grid-template-columns: 1fr;
            }

            .car-info {
                grid-template-columns: 1fr;
            }
        }
        body{
            margin:0;
        }
        a{
            text-decoration: none;
            color: #333;

        }
        .main-content{
            background-color:rgb(230, 230, 230);
            padding: 100px;
            padding-top: 0;
        }
        .search-header{
            padding:-100px;
            padding-left: 350px ;
            padding-right: 350px ;
            margin-left: -100px;
            margin-right: -100px;
            padding-top: 20px;
            padding-bottom: 20px;
        }
    </style>
        <style>
        /* Add these styles to your existing CSS */
        .search-container {
            position: relative;
            flex-grow: 1;
        }
    
        .search-help {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
            z-index: 1000;
        }
        
        .search-container:hover .search-help {
            display: block;
        }
        
        .search-help p {
            margin: 0;
            font-weight: bold;
            color: #333;
        }
        
        .search-help ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 0 0;
        }
        
        .search-help li {
            margin: 5px 0;
            color: #666;
            font-size: 0.9em;
            padding-left: 15px;
        }
    
        .search-help li:first-child {
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
    </style>
    <style>
        /* Add these status badge styles after your existing .status-badge class */
    .status-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    /* Status-specific styles */
    .status-selling {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
        animation: pulse 2s infinite;
    }
    
    .status-selling::before {
        content: '\f155';
        font-family: 'Font Awesome 6 Free';
    }
    
    .status-discounting {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        animation: flash 1.5s infinite;
    }
    
    .status-discounting::before {
        content: '\f02c';
        font-family: 'Font Awesome 6 Free';
    }
    
    .status-hidden {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        color: white;
        opacity: 0.8;
    }
    
    .status-hidden::before {
        content: '\f070';
        font-family: 'Font Awesome 6 Free';
    }
    
    .status-soldout {
        background: linear-gradient(135deg, #34495e, #2c3e50);
        color: white;
    }
    
    .status-soldout::before {
        content: '\f05e';
        font-family: 'Font Awesome 6 Free';
    }
    
    /* Animations */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes flash {
        0% { opacity: 1; }
        50% { opacity: 0.8; }
        100% { opacity: 1; }
    }
</style>
<style>
        /* Add to your existing styles */
    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        margin: 20px 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .filter-item label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #666;
        font-weight: 500;
    }
    
    .filter-item label i {
        color: #1abc9c;
    }
    
    .range-inputs {
        display: flex;
        gap: 10px;
    }
    
    .range-inputs input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .filter-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        justify-content: center;
    }
    
    .filter-btn, .reset-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .filter-btn {
        background: #1abc9c;
        color: white;
    }
    
    .reset-btn {
        background: #e74c3c;
        color: white;
    }
    
    .filter-btn:hover, .reset-btn:hover {
        transform: translateY(-2px);
    }
    .filter-section{
        background-color: rgb(220,220,220);
        padding-left:350px;
        padding-right:350px;
                    margin-left: -100px;
            margin-right: -100px;
            margin-top: 0px;
    }
    .filter-section select, .filter-section input[type=text]{
        height:30px;
        border:none;
    }
</style>
</head>
<body>
    <div class="main-content">

                <div class="search-header">
            <a href="index.php" class="home">
                <i class="fa-solid fa-house"></i>
            </a>
    <form action="search-results.php" method="GET" id="searchFilterForm">
        <div class="search-container">
            <input type="text" 
                   name="query" 
                   placeholder="Tìm kiếm (vd: BMW + giá:<500000000 + số chỗ:>4)..." 
                   value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
            <div class="search-help">
                        <p>Cú pháp tìm kiếm:</p>
                        <ul>
                            <li>Tìm thông thường: BMW + đen + 2023</li>
                            <li>So sánh số: giá:>500000000</li>
                            <li>Các trường hỗ trợ so sánh:</li>
                            <li>- giá: (VND)</li>
                            <li>- mã lực: (HP)</li>
                            <li>- dung tích: (L/kWh)</li>
                            <li>- số chỗ: (chỗ)</li>
                            <li>- năm sản xuất: (năm)</li>
                            <li>- vận tốc tối đa: (km/h)</li>
                        </ul>
                    </div>
                </div>
                
                <!-- <button type="submit">
                    <i class="fa fa-search"></i>
                </button> -->
            <!-- </form> -->
        </div>
<div class="filter-section">
    <div class="filter-grid">
        <div class="filter-item">
            <label><i class="fas fa-building"></i> Hãng xe:</label>
            <select name="brand">
                <option value="">Tất cả</option>
                <?php
                $brand_query = "SELECT DISTINCT type_name FROM car_types ORDER BY type_name";
                $brand_result = mysqli_query($connect, $brand_query);
                while ($brand = mysqli_fetch_assoc($brand_result)) {
                    $selected = (isset($_GET['brand']) && strtolower($_GET['brand']) === strtolower($brand['type_name'])) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($brand['type_name']) . "' $selected>" . $brand['type_name'] . "</option>";
                }
                ?>
            </select>
            </div>

            <div class="filter-item">
                <label><i class="fas fa-tag"></i> Giá (VND):</label>
                <div class="range-inputs">
                    <input type="number" name="price_min" placeholder="Từ" 
                           value="<?php echo htmlspecialchars($_GET['price_min'] ?? ''); ?>">
                    <input type="number" name="price_max" placeholder="Đến"
                           value="<?php echo htmlspecialchars($_GET['price_max'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-palette"></i> Màu sắc:</label>
                <input type="text" name="color" placeholder="Màu xe"
                       value="<?php echo htmlspecialchars($_GET['color'] ?? ''); ?>">
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-gears"></i> Động cơ:</label>
                <input type="text" name="engine" placeholder="Tên động cơ"
                       value="<?php echo htmlspecialchars($_GET['engine'] ?? ''); ?>">
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-gas-pump"></i> Nhiên liệu:</label>
                <input type="text" name="fuel" placeholder="Loại nhiên liệu"
                       value="<?php echo htmlspecialchars($_GET['fuel'] ?? ''); ?>">
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-gauge"></i> Tốc độ tối đa (km/h):</label>
                <div class="range-inputs">
                    <input type="number" name="speed_min" placeholder="Từ"
                           value="<?php echo htmlspecialchars($_GET['speed_min'] ?? ''); ?>">
                    <input type="number" name="speed_max" placeholder="Đến"
                           value="<?php echo htmlspecialchars($_GET['speed_max'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-gear"></i> Công suất (HP):</label>
                <div class="range-inputs">
                    <input type="number" name="power_min" placeholder="Từ"
                           value="<?php echo htmlspecialchars($_GET['power_min'] ?? ''); ?>">
                    <input type="number" name="power_max" placeholder="Đến"
                           value="<?php echo htmlspecialchars($_GET['power_max'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-oil-can"></i> Dung tích:</label>
                <div class="range-inputs">
                    <input type="number" name="capacity_min" placeholder="Từ"
                           value="<?php echo htmlspecialchars($_GET['capacity_min'] ?? ''); ?>">
                    <input type="number" name="capacity_max" placeholder="Đến"
                           value="<?php echo htmlspecialchars($_GET['capacity_max'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-users"></i> Số chỗ ngồi:</label>
                <div class="range-inputs">
                    <input type="number" name="seats_min" placeholder="Từ"
                           value="<?php echo htmlspecialchars($_GET['seats_min'] ?? ''); ?>">
                    <input type="number" name="seats_max" placeholder="Đến"
                           value="<?php echo htmlspecialchars($_GET['seats_max'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-calendar"></i> Năm sản xuất:</label>
                <div class="range-inputs">
                    <input type="number" name="year_min" placeholder="Từ"
                           value="<?php echo htmlspecialchars($_GET['year_min'] ?? ''); ?>">
                    <input type="number" name="year_max" placeholder="Đến"
                           value="<?php echo htmlspecialchars($_GET['year_max'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="filter-item">
                <label><i class="fas fa-info-circle"></i> Trạng thái:</label>
                <select name="status">
                    <option value="">Tất cả</option>
                    <?php
                    $statuses = [
                        'selling' => 'Đang bán',
                        'discounting' => 'Đang giảm giá',
                        'hidden' => 'Đã ẩn',
                        'soldout' => 'Đã bán'
                    ];
                    foreach ($statuses as $value => $label) {
                        $selected = (isset($_GET['status']) && $_GET['status'] === $value) ? 'selected' : '';
                        echo "<option value='$value' $selected>$label</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

    <div class="filter-buttons">
        <button type="submit" class="filter-btn">
            <i class="fas fa-filter"></i> Lọc
        </button>
        <button type="button" class="reset-btn" onclick="window.location='search-results.php'">
            <i class="fas fa-undo"></i> Đặt lại
        </button>
    </div>
</div>
</form>
        <div class="results">
        <?php if (empty($searchResults)): ?>
                <div class="no-results">
                    <p>Không tìm thấy kết quả phù hợp.</p>
                </div>
        <?php else: ?>
                <?php foreach ($searchResults as $car): ?>
                        <a href="car-details.php?name=<?php echo urlencode($car['car_name']); ?>" class="car-link">
                            <div class="result-item">
                                <img src="<?php echo $car['image_link']; ?>" alt="<?php echo $car['car_name']; ?>" class="car-image">
                        <div class="car-info">
                            <h2 class="car-name"><?php echo $car['car_name']; ?></h2>
                            <p class="price"><?php echo number_format($car['price'], 0, ',', '.'); ?> VND</p>
                            <p><i class="fas fa-building"></i> Hãng: <?php echo $car['type_name']; ?></p>
                            <p><i class="fas fa-calendar"></i> Năm Sản Xuất: <?php echo $car['year_manufacture']; ?></p>
                            <p><i class="fas fa-palette"></i> Màu: <?php echo $car['color']; ?></p>
                            <p><i class="fas fa-gears"></i> Động cơ: <?php echo $car['engine_name']; ?></p>
                            <p><i class="fas fa-gas-pump"></i> Nhiên liệu: <?php echo $car['fuel_name']; ?></p>
                            <p><i class="fas fa-oil-can"></i> Dung tích: <?php echo $car['fuel_capacity']; ?></p>
                            <p><i class="fas fa-gear"></i> Công suất: <?php echo $car['engine_power']; ?> HP</p>
                            <p><i class="fas fa-users"></i> Số chỗ: <?php echo $car['seat_number']; ?></p>
                            <p><i class="fas fa-gauge"></i> Vận tốc tối đa: <?php echo $car['max_speed']; ?> km/h</p>
                            <p>
                                <i class="fas fa-info-circle"></i> 
                                Trạng thái: 
                                <span class="status-badge status-<?php echo $car['status']; ?>">
                                    <?php 
                                    switch($car['status']) {
                                        case 'selling': echo 'Đang bán'; break;
                                        case 'discounting': echo 'Đang giảm giá'; break;
                                        case 'hidden': echo 'Tạm thời ẩn'; break;
                                        case 'soldout': echo 'Hết hàng'; break;
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preserve form values after submission
    const urlParams = new URLSearchParams(window.location.search);
    for (const [key, value] of urlParams) {
        const element = document.querySelector(`[name="${key}"]`);
        if (element) {
            if (element.tagName === 'SELECT') {
                // Handle select elements
                const option = Array.from(element.options).find(opt => opt.value.toLowerCase() === value.toLowerCase());
                if (option) option.selected = true;
            } else {
                // Handle other input types
                element.value = value;
            }
        }
    }

    // Handle form reset
    const resetBtn = document.querySelector('.reset-btn');
    resetBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('searchFilterForm');
        form.reset();
        window.location.href = 'search-results.php';
    });

    // Handle form submission
    const form = document.getElementById('searchFilterForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Create URL params
        const formData = new FormData(form);
        const params = new URLSearchParams();

        // Only add non-empty values to URL
        for (const [key, value] of formData.entries()) {
            if (value.trim() !== '') {
                params.append(key, value.trim());
            }
        }

        // Redirect with query parameters
        const queryString = params.toString();
        window.location.href = `search-results.php${queryString ? '?' + queryString : ''}`;
    });

    // Handle range inputs validation
    const rangeInputs = document.querySelectorAll('.range-inputs');
    rangeInputs.forEach(container => {
        const minInput = container.querySelector('[name$="_min"]');
        const maxInput = container.querySelector('[name$="_max"]');
        
        if (minInput && maxInput) {
            minInput.addEventListener('change', () => validateRange(minInput, maxInput));
            maxInput.addEventListener('change', () => validateRange(minInput, maxInput));
        }
    });

    function validateRange(min, max) {
        if (min.value && max.value) {
            if (parseInt(min.value) > parseInt(max.value)) {
                alert('Giá trị tối thiểu không thể lớn hơn giá trị tối đa');
                min.value = '';
                max.value = '';
            }
        }
    }

    // Add debounced search functionality
    const searchInput = document.querySelector('input[name="query"]');
    let searchTimeout;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = e.target.value.trim();
            if (query.length >= 2) { // Only search if 2 or more characters
                form.submit();
            }
        }, 500); // Wait 500ms after user stops typing
    });

    // Add tooltips for range inputs
    const rangeContainers = document.querySelectorAll('.range-inputs');
    rangeContainers.forEach(container => {
        const inputs = container.querySelectorAll('input');
        inputs.forEach(input => {
            input.title = input.placeholder;
        });
    });
});
</script>
</script>
</body>
</html>
<?php include 'footer.php'; ?>
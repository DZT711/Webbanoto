<?php
include 'header.php';
include 'connect.php';

$query = "SELECT p.*, c.type_name 
          FROM products p 
          LEFT JOIN car_types c ON p.brand_id = c.type_id 
          WHERE c.type_name = 'BMW' 
          AND p.status IN ('selling', 'discounting')
          ORDER BY p.product_id DESC";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($connect));
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BMW</title>
        <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
        <script src="bmw.js"></script>
        <!-- <link rel="stylesheet" href="style.css"> -->

        <!-- <link rel="stylesheet" href="stylebmw.css">> -->
        <link rel="icon" href="bmw.png" type="image/png">

    </head>
    <style>
                /* BMW Page Specific Container */
        .bmw-content {
            --bmw-primary: #007bff;
            --bmw-secondary: #f8f9fa;
            --bmw-accent: #0056b3;
            padding: 20px;
            background-color: #efefef;
        }
        
        /* Hero Section */
        .bmw-content h1 {
            text-align: center;
            background-image: url('joyful_christmas_drive_1920x1080.webp');
            min-height: 50vh;
            padding: 50px;
            color: rgb(255, 255, 255);
            font-weight: normal;
            background-size: cover;
            background-position: center;
            /* background-attachment: fixed; */
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        /* Filter Section */

        
        .bmw-content .s1, .bmw-content .s2 {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .bmw-content .filter-section select {
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: white;
        }
        
        .bmw-content .filter-section select:hover {
            border-color: var(--bmw-primary);
        }
        
        .bmw-content .filter-section select:focus {
            outline: none;
            border-color: var(--bmw-primary);
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }
        
        /* Products Grid */
        .bmw-content .ctn21 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px;
            margin-top: 20px;
        }
        
        /* Product Card */
        .bmw-content .nc-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .bmw-content .nc-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        
        .bmw-content .carpic {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .bmw-content .nc-item:hover .carpic {
            transform: scale(1.05);
        }
        
        .bmw-content .cith2 {
            color: var(--bmw-primary);
            padding: 15px;
            margin: 0;
            font-size: 1.2rem;
        }
        
        .bmw-content .cit {
            color: #666;
            padding: 0 15px 15px;
            margin: 0;
            font-weight: 500;
        }
        
        .bmw-content .carinfo {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            padding: 15px;
            gap: 10px;
            border-top: 1px solid #eee;
            background: #f8f9fa;
        }
        
        .bmw-content .carinfo i {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .bmw-content .filter-section {
                flex-direction: column;
                gap: 20px;
            }
        
            .bmw-content .ctn21 {
                padding: 20px;
                gap: 20px;
            }
        
            .bmw-content .carinfo {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        .linkcar {
            text-decoration: none;
            color: black;
        }
    </style>
    <style>
                .filter-section {
            padding: 25px;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: center;
            gap: 60px;
            margin: 30px auto;
            max-width: 800px;
            transition: all 0.3s ease;
            margin-left:500px;
            align-items: center;
            align-self: center;
            align-content: center;
        }
        
        .filter-section:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        
        .s1, .s2 {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .filter-section label {
            color: #2c3e50;
            font-weight: 500;
            font-size: 1rem;
            white-space: nowrap;
        }
        
        .filter-section select {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: white;
            color: #2c3e50;
            font-size: 0.95rem;
            min-width: 180px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232c3e50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: calc(100% - 12px) center;
            padding-right: 35px;
        }
        
        .filter-section select:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }
        
        .filter-section select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        }
        
        /* Add icons to labels */
        .s1 label::before {
            content: '\f3d1';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-right: 8px;
            color: #007bff;
        }
        
        .s2 label::before {
            content: '\f073';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            margin-right: 8px;
            color: #007bff;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .filter-section {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
                margin: 20px;
            }
        
            .s1, .s2 {
                width: 100%;
                justify-content: space-between;
            }
        
            .filter-section select {
                flex: 1;
                min-width: 150px;
            }
        }
        .info{
            font-family:' Font Awesome 5 Free';
        }

    </style>
    <style>
                /* Update main styles */
        main {
            padding: 0 !important; /* Force override any other padding */
            margin: 0;
        }
        
        /* Update BMW content container */
        .bmw-content {
            --bmw-primary: #007bff;
            --bmw-secondary: #f8f9fa;
            --bmw-accent: #0056b3;
            padding: 20px 20px 0 20px; /* Remove bottom padding */
            background-color: #efefef;
        }
        
        /* Update container for products */
        .ctn21 {
            padding: 40px 40px 0 40px; /* Remove bottom padding */
            margin-bottom: 0; /* Remove bottom margin */
        }
        
        /* Update footer spacing if needed */
        footer {
            margin-top: 0; /* Remove top margin from footer */
        }
    </style>
        <style>
    /* Add to your existing styles */
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 1;
    }
    
    .status-discounting {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        animation: pulse 1.5s infinite;
    }
    
    .status-discounting::before {
        content: '\f02c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }
    
    .no-cars {
        text-align: center;
        padding: 40px;
        color: #666;
        font-size: 1.1em;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin: 20px auto;
        max-width: 500px;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .nc-item{
            max-width: 360px !important;
            

    }
    .carinfo{
        height: 54px;
    }

    </style>
    <body>

        
        <main >
            <div class="bmw-content">
    <!-- Your existing BMW content -->
    <h1 style="text-align: center;background-image: url('joyful_christmas_drive_1920x1080.webp');min-height: 100vh;padding: 50px;color: rgb(255, 255, 255);font-weight: normal;">BMW - Bayerische Motoren Werke AG</h1>
    <div id="newcar">

            <!-- Bộ lọc sản phẩm -->
            <div class="filter-section">
                <div class="s1">

                    <label for="priceFilter">Lọc theo giá:</label>
                    <select id="priceFilter" onchange="filterProducts()">
                        <option value="all">Tất cả</option>
                        <option value="below10b">Từ 1 tới 2 tỷ</option>
                        <option value="10to20b">Từ 2 tới 5 tỷ</option>
                        <option value="above20b">Trên 10 tỷ</option>
                    </select>
                </div>
                <div class="s2">

                    <label for="yearFilter" >Lọc theo năm:</label>
                    <select id="yearFilter" onchange="filterProducts()">
                        <option value="all">Tất cả</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
            </div>
    
    <!-- Các sản phẩm -->

    <div class="ctn21">
                
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="nc-item" data-price="' . $row['price'] . '" data-year="' . $row['year_manufacture'] . '">';
                    echo '<a href="car-details.php?name=' . urlencode($row['car_name']) . '" class="linkcar">';
                    
                    // Add status badge for discounting items
                    if ($row['status'] == 'discounting') {
                        echo '<div class="status-badge status-discounting">Đang giảm giá</div>';
                    }
                    
                    echo '<img class="carpic" src="../User/' . $row['image_link'] . '" alt="' . $row['car_name'] . '">';
                    echo '<h2 class="cith2">' . number_format($row['price'], 0, ',', '.') . ' VND</h2>';
                    echo '<p class="cit">' . $row['car_name'] . '</p>';
                    echo '<div class="carinfo">';
                    echo '<i class="fas fa-car">
                    <span class="info">
                    ' . $row['seat_number'] . ' chỗ
                    </span>
                    </i>';
                    echo '<i class="fas fa-gas-pump"><span class="info">' . $row['fuel_name'] . '</span></i>';
                    echo '<i class="fa-solid fa-wrench">
                                    <span class="info">'.
                                     $row['engine_power'] . '
                                    Mã lực
                                    </span>
                                </i>';
                    echo '<i class="fas fa-tachometer-alt"><span class="info">' . $row['max_speed'] . ' km/h</span></i>';
                    echo '<i class="fas fa-calendar-alt"><span class="info">' . $row['year_manufacture'] . '</span></i>';
                    echo '<i class="fa-solid fa-location-dot"><span class="info">TP.HCM</span></i>';
                    echo '</div>';
                    echo '</a></div>';
                }
            } else {
                echo '<div class="no-cars">>Xin lỗi chúng tôi hiện không còn xe BMW nào đang bán .</div>';
            }
            ?>
        
    </div>
    </div>
</div>
</main>

        
        

    </body>               
</html>        
<?php
include 'footer.php';
?>
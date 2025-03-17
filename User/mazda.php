<?php
include 'header.php';
include 'connect.php';

// Get only Mazda cars with selling or discounting status
$query = "SELECT p.*, c.type_name 
          FROM products p 
          LEFT JOIN car_types c ON p.brand_id = c.type_id 
          WHERE c.type_name = 'Mazda' 
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
        <title>MAZDA</title>
        <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
        <!-- <link rel="stylesheet" href="style.css"> -->
        <!-- <link rel="stylesheet" href="stylemazda.css"> -->
        <script src="mazda.js"></script>
        <link rel="icon" href="png-transparent-mazda-biante-logo-mazda3-car-mazda-angle-emblem-text-thumbnail.png" type="image/png">

    </head>
    <style>
        <style>
    /* Mazda Page Container */
    .mazda-content {
        --mazda-primary: #007bff;
        --mazda-secondary: #f8f9fa;
        --mazda-accent: #0056b3;
        padding: 20px;
        background-color: #efefef;
    }
    
    /* Hero Section */
    .mazda-content h1 {
        text-align: center;
        background-image: url('madzabanner.png');
        min-height: 100vh;
        padding: 50px;
        color: #CDD2D0;
        font-weight: normal;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        background-color: #555
    }
    
    /* Filter Section */
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
    }
    
    .filter-section:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    
    .s1, .s2 {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    /* Filter Labels and Icons */
    .filter-section label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #2c3e50;
        font-weight: 500;
        font-size: 1rem;
        white-space: nowrap;
    }
    
    .filter-section label i {
        color: var(--mazda-primary);
        font-size: 1.1rem;
    }
    
    /* Filter Select Inputs */
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
        background-repeat: no-repeat;
        background-position: calc(100% - 12px) center;
        padding-right: 35px;
    }
    
    .filter-section select:hover {
        border-color: var(--mazda-primary);
        background-color: #f8f9fa;
    }
    
    /* Products Grid */
    .ctn21 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        padding: 40px;
        margin-top: 20px;
    }
    
    /* Product Cards */
    .nc-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .nc-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    
    /* Car Images */
    .carpic {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .nc-item:hover .carpic {
        transform: scale(1.05);
    }
    
    /* Car Details */
    .cith2 {
        color: var(--mazda-primary);
        padding: 15px;
        margin: 0;
        font-size: 1.2rem;
    }
    
    .cit {
        color: #666;
        padding: 0 15px 15px;
        margin: 0;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    /* Car Info Icons */
    .carinfo {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        padding: 15px;
        gap: 10px;
        border-top: 1px solid #eee;
        background: #f8f9fa;
    }
    
    .carinfo i {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #666;
        font-size: 0.9rem;
    }
    
    .info {
        font-family: 'Times New Roman', Times, serif;
        color: #666;
        font-size: 0.9rem;
    }
    
    /* Links */
    .linkcar {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    /* Responsive Design */
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
    
        .ctn21 {
            padding: 20px;
            gap: 20px;
        }
    
        .carinfo {
            grid-template-columns: repeat(2, 1fr);
        }
    
        .mazda-content h1 {
            min-height: 50vh;
            margin: 0;
        }
    }
    
    /* Preserve Header Styles */
    .header-container {
        --header-bg: #f8f9fa;
        --header-text: #495057;
    }
    </style>
    <style>
        /* Add to your filter section styles */
    .filter-section label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #2c3e50;
        font-weight: 500;
        font-size: 1rem;
        white-space: nowrap;
    }
    
    .filter-section label i {
        color: var(--mazda-primary);
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    
    .filter-section label:hover i {
        transform: scale(1.1);
    }
    
    .filter-section select {
        padding-left: 35px;
        background-position: calc(100% - 12px) center, 12px center;
        background-image: 
            url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%232c3e50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    }
    </style>
    <style>
    .title{
        background-color:rgb(220, 220, 220);
        margin-top:-1.3em;
    }        
    .ctn21{
        margin-bottom: 50px;
    }
        .nc-item{
            max-width: 360px !important;

    }
    .carinfo{
        height: 54px;
    }

    </style>
        <style>
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
    .title {
    background-color: rgb(235, 235, 235);
    margin-top: -0.3em;
    height: 95vh;
    padding-top: 20px;
    padding-bottom: 20px;
}
    </style>
    <body>

    <div class="title">

        <h1 style="text-align: center;background-image: url('MAZDA-BANNER-1-copy.webp');min-height: 80vh;padding: 50px;color: rgb(255, 255, 255);background-repeat: no-repeat;margin-right:7em;margin-left: 7em;margin-bottom: -7em;color: #CDD2D0;">Mazda Motors</h1>
    </div>
        <!-- <br><br><br><br><br>
        <br><br><br><br><br>
        <br> -->
            <div id="newcar">
                <!-- Bộ lọc sản phẩm -->
                                <!-- Update the filter section -->
                <div class="filter-section">
                    <div class="s1">
                        <label for="priceFilter">
                            <i class="fas fa-tags"></i>
                            Lọc theo giá:
                        </label>
                        <select id="priceFilter" onchange="filterProducts()">
                            <option value="all">Tất cả</option>
                            <option value="below10b">Dưới 500 triệu</option>
                            <option value="10to20b">Từ 500 triệu tới 1 tỷ</option>
                            <option value="above20b">Trên 1 tỷ</option>
                        </select>
                    </div>
                    <div class="s2">
                        <label for="yearFilter">
                            <i class="fas fa-calendar"></i>
                            Lọc theo năm:
                        </label>
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
                                echo '<div class="status-badge status-discounting">';
                                echo '<i class="fa-solid fa-tag"></i>Đang giảm giá';
                                echo '</div>';
                            }
                            
                            echo '<img class="carpic" src="../User/' . $row['image_link'] . '" alt="' . $row['car_name'] . '">';
                            echo '<h2 class="cith2">' . number_format($row['price'], 0, ',', '.') . ' VND</h2>';
                            echo '<p class="cit">' . $row['car_name'] . '</p>';
                            
                            echo '<div class="carinfo">';
                            echo '<i class="fas fa-car"><span class="info">' . $row['seat_number'] . ' chỗ</span></i>';
                            echo '<i class="fas fa-gas-pump"><span class="info">' . $row['fuel_name'] . '</span></i>';
                            echo '<i class="fa-solid fa-wrench">
                                    <span class="info">' .
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
                        echo '<div class="no-cars">Xin lỗi chúng tôi hiện không còn xe Mazda nào đang bán. </div>';
                    }
                    ?>
                </div>
            </div>
        </main>
        

        
    </body>               
</html>        
<?php
include 'footer.php';
?>
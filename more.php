<?php
include 'header.php';
include 'connect.php';

$query = "SELECT p.*, c.type_name 
          FROM products p 
          LEFT JOIN car_types c ON p.brand_id = c.type_id 
          ORDER BY p.product_id DESC";
$result = mysqli_query($connect, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách xe đang bán</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="more.css">
    <script src="more.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>


</head>
<style>
    /* Add this CSS to more.php */
    /* Main layout */
    main {
        max-width: 1440px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Filter section */
    .filter-section {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .s1,
    .s2 {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        min-width: 150px;
    }

    /* Car grid layout */
    .ctn21 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        padding: 20px 0;
    }

    /* Car card styling */
    .nc-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .nc-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Car image */
    .carpic {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .nc-item:hover .carpic {
        transform: scale(1.05);
    }

    /* Car details */
    .cith2 {
        color: #007bff;
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

    /* Car info section */
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
        padding-left: 5px;
        font-weight: bold;
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Status badges */
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        z-index: 1;
    }

    .status-badge.selling {
        background: #28a745;
        color: white;
    }

    .status-badge.discounting {
        background: #dc3545;
        color: white;
    }

    .status-badge.hidden {
        background: #6c757d;
        color: white;
    }

    /* Responsive design */
    @media (max-width: 1200px) {
        .ctn21 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .filter-section {
            flex-direction: column;
        }

        .ctn21 {
            grid-template-columns: 1fr;
        }

        .carinfo {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
<style>
    /* Add this CSS to more.php */
    /* Main layout */
    main {
        max-width: 1440px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Filter section */
    .filter-section {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .s1,
    .s2 {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        min-width: 150px;
    }

    /* Car grid layout */
    .ctn21 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        padding: 20px 0;
    }

    /* Car card styling */
    .nc-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .nc-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Car image */
    .carpic {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .nc-item:hover .carpic {
        transform: scale(1.05);
    }

    /* Car details */
    .cith2 {
        color: #007bff;
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

    /* Car info section */
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
        padding-left: 5px;
        font-weight: bold;
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Status badges */
    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        z-index: 1;
    }

    .status-badge.selling {
        background: #28a745;
        color: white;
    }

    .status-badge.discounting {
        background: #dc3545;
        color: white;
    }

    .status-badge.hidden {
        background: #6c757d;
        color: white;
    }

    /* Responsive design */
    @media (max-width: 1200px) {
        .ctn21 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .filter-section {
            flex-direction: column;
        }

        .ctn21 {
            grid-template-columns: 1fr;
        }

        .carinfo {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
<style>
    /* Status badges styling */
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        z-index: 1;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Selling status */
    .status-selling {
        background: linear-gradient(135deg, #2ecc71, #27ae60);
        color: white;
    }

    .status-selling::before {
        content: '\f155';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }

    /* Discounting status */
    .status-discounting {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
        animation: pulse 1.5s infinite;
    }

    .status-discounting::before {
        content: '\f295';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }

    /* Hidden status */
    .status-hidden {
        background: linear-gradient(135deg, #95a5a6, #7f8c8d);
        color: white;
    }

    .status-hidden::before {
        content: '\f070';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }

    /* Sold out status */
    .status-soldout {
        background: linear-gradient(135deg, #34495e, #2c3e50);
        color: white;
    }

    .status-soldout::before {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }

    /* Card effects based on status */
    .nc-item[data-status="discounting"] .cith2 {
        color: #e74c3c;
        position: relative;
    }

    .nc-item[data-status="discounting"] .cith2::after {
        content: 'Giảm giá';
        position: absolute;
        bottom: -5px;
        right: 15px;
        font-size: 12px;
        color: #e74c3c;
        font-weight: bold;
    }

    .nc-item[data-status="hidden"] {
        opacity: 0.75;
        filter: grayscale(20%);
    }

    .nc-item[data-status="soldout"] {
        filter: grayscale(40%);
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        100% {
            transform: scale(1);
        }
    }

    /* Hover effects */
    .nc-item:hover .status-badge {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .status-badge {
            font-size: 12px;
            padding: 6px 12px;
        }
    }
</style>
<style>
    /* Add or update in your existing styles section */
    .linkcar {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .linkcar:hover,
    .linkcar:visited,
    .linkcar:active {
        text-decoration: none;
        color: inherit;
    }

    /* Update the car title styles to ensure consistency */
    .linkcar .cit {
        color: #666;
        text-decoration: none;
    }

    .linkcar .cith2 {
        text-decoration: none;
    }
    /* Enhanced Footer Marquee Styling */
.site-footer {
    padding: 30px 0;
    background: linear-gradient(to right, #2c3e50, #3498db);
    color: #fff;
    position: relative;
    overflow: hidden;
}

/* Marquee wrapper with transparent background */
.marquee-wrapper {
    overflow: hidden;
    position: relative;
    width: 100%;
    background-color: transparent;
    padding: 20px 0;
}

/* Car listing carousel */
.marquee-list {
    display: flex;
    animation: marquee 60s linear infinite;
    padding: 0;
    margin: 0;
    list-style: none;
    gap: 40px;
}

/* Pause animation on hover */
.marquee-list:hover {
    animation-play-state: paused;
}

/* Each car item in the marquee */
.marquee-item {
    flex: 0 0 auto;
    width: 280px;
    padding: 15px;
    margin: 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.marquee-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
    background: rgba(255, 255, 255, 0.2);
}

/* Car image container */
.marquee-item .carpic-container {
    width: 100%;
    height: 180px;
    overflow: hidden;
    border-radius: 10px;
    margin-bottom: 15px;
    position: relative;
}

/* Car image styling */
.marquee-item .carpic {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.marquee-item:hover .carpic {
    transform: scale(1.08);
}

/* Car title styling */
.marquee-item .cith2 {
    font-size: 18px;
    color: #fff;
    margin: 12px 0 8px;
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

/* Car name styling */
.marquee-item .cit {
    font-size: 14px;
    color: #ecf0f1;
    margin-bottom: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Car info icons section */
.marquee-item .carinfo {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding: 12px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    margin-top: 10px;
}

/* Car info icon styling */
.marquee-item .carinfo i {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.85);
    font-size: 12px;
    white-space: nowrap;
}

/* Text info next to icons */
.marquee-item .info {
    margin-left: 8px;
    font-weight: 500;
    color: #fff;
}

/* Status badges */
.marquee-item .status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 7px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Status badge variations */
.status-selling {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
}

.status-discounting {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    animation: pulse 1.5s infinite;
}

.status-hidden {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
}

.status-soldout {
    background: linear-gradient(135deg, #34495e, #2c3e50);
    color: white;
}

/* Link styling */
.marquee-item .linkcar {
    text-decoration: none;
    color: inherit;
    display: block;
}

/* Marquee animation */
@keyframes marquee {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

/* Pulse animation for discounting status */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .marquee-item {
        width: 220px;
    }
    
    .marquee-item .carpic-container {
        height: 140px;
    }
    
    .marquee-item .carinfo {
        grid-template-columns: 1fr;
    }
}
/* Enhanced Footer Marquee Styling */
.site-footer {
    padding: 30px 0;
    background: linear-gradient(to right, #2c3e50, #3498db);
    color: #fff;
    position: relative;
    overflow: hidden;
}

/* Marquee wrapper with transparent background */
.marquee-wrapper {
    overflow: hidden;
    position: relative;
    width: 100%;
    background-color: transparent;
    padding: 20px 0;
}

/* Car listing carousel */
.marquee-list {
    display: flex;
    animation: marquee 60s linear infinite;
    padding: 0;
    margin: 0;
    list-style: none;
    gap: 40px;
}

/* Pause animation on hover */
.marquee-list:hover {
    animation-play-state: paused;
}

/* Each car item in the marquee */
.marquee-item {
    flex: 0 0 auto;
    width: 340px;
    padding: 15px;
    margin: 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    position: relative;
    border: none;
}

.marquee-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.25);
    background: rgba(255, 255, 255, 0.2);
}

/* Car image container */
.marquee-item .carpic-container {
    width: 100%;
    height: 200px;
    overflow: hidden;
    border-radius: 10px;
    margin-bottom: 15px;
    position: relative;
}

/* Car image styling */
.marquee-item .carpic {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.marquee-item:hover .carpic {
    transform: scale(1.08);
}

/* Car title styling */
.marquee-item .cith2 {
    font-size: 18px;
    color: #fff;
    margin: 12px 0 8px;
    font-weight: 700;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

/* Car name styling */
.marquee-item .cit {
    font-size: 14px;
    color: #ecf0f1;
    margin-bottom: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Car info icons section */
.marquee-item .carinfo {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    padding: 12px 0;
    margin-top: 10px;
    border: none;
}

/* Car info icon styling */
.marquee-item .carinfo i {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.85);
    font-size: 14px;
    white-space: nowrap;
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 12px;
    border-radius: 20px;
}

/* Text info next to icons */
.marquee-item .info {
    margin-left: 8px;
    font-weight: 500;
    color: #fff;
}

/* Status badges */
.marquee-item .status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 7px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Status badge variations */
.status-selling {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
}

.status-discounting {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    animation: pulse 1.5s infinite;
}

.status-hidden {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: white;
}

.status-soldout {
    background: linear-gradient(135deg, #34495e, #2c3e50);
    color: white;
}

/* Link styling */
.marquee-item .linkcar {
    text-decoration: none;
    color: inherit;
    display: block;
}

/* Marquee animation */
@keyframes marquee {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

/* Pulse animation for discounting status */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .marquee-item {
        width: 280px;
    }
    
    .marquee-item .carpic-container {
        height: 160px;
    }
    
    .marquee-item .carinfo {
        justify-content: center;
    }
}
</style>

<body>








    <main>
        <div id="webtitle">
            <h1>Garage xe</h1>
        </div>
        <div id="newcar">
            <div class="filter-section">
                <div class="s1">

                    <label for="priceFilter">Lọc theo giá:</label>
                    <select id="priceFilter" onchange="filterProducts()">
                        <option value="all">Tất cả</option>
                        <option value="below10b">Dưới 1 tỷ</option>
                        <option value="10to20b">Từ 1 tới 10 tỷ</option>
                        <option value="above20b">Trên 10 tỷ</option>
                    </select>
                </div>
                <div class="s2">

                    <label for="yearFilter">Lọc theo năm:</label>
                    <select id="yearFilter" onchange="filterProducts()">
                        <option value="all">Tất cả</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
            </div>

            <div class="ctn21">
            <?php
if (mysqli_num_rows($result) > 0) {
    echo '<footer class="site-footer">';
    echo '<div class="marquee-wrapper">';
    echo '<ul class="marquee-list">';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li class="marquee-item" data-status="' . $row['status'] . '" 
               data-price="' . $row['price'] . '" 
               data-year="' . $row['year_manufacture'] . '">';

        // Link to car details
        echo '<a href="car-details.php?name=' . urlencode($row['car_name']) . '" class="linkcar">';

        // Status badge
        $statusText = '';
        $statusIcon = '';
        switch ($row['status']) {
            case 'selling':
                $statusText = 'Xe đang bán';
                $statusIcon = '<i class="fas fa-check-circle"></i>';
                break;
            case 'discounting':
                $statusText = 'Đang giảm giá';
                $statusIcon = '<i class="fas fa-tag"></i>';
                break;
            case 'hidden':
                $statusText = 'Xe tạm ẩn';
                $statusIcon = '<i class="fas fa-eye-slash"></i>';
                break;
            case 'soldout':
                $statusText = 'Đã bán hết';
                $statusIcon = '<i class="fas fa-check"></i>';
                break;
        }
        echo '<div class="status-badge status-' . $row['status'] . '">' . $statusIcon . ' ' . $statusText . '</div>';

        // Car image container for consistent sizing
        echo '<div class="carpic-container">';
        echo '<img class="carpic" src="../User/' . $row['image_link'] . '" alt="' . $row['car_name'] . '">';
        echo '</div>';

        // Car price
        echo '<h2 class="cith2">' . number_format($row['price'], 0, ',', '.') . ' VND</h2>';

        // Car name
        echo '<p class="cit">' . $row['car_name'] . '</p>';

        // Car info - simplified without property frames
        echo '<div class="carinfo">';
        echo '<i class="fas fa-car"><span class="info">' . $row['seat_number'] . ' chỗ</span></i>';
        echo '<i class="fas fa-gas-pump"><span class="info">' . $row['fuel_name'] . '</span></i>';
        echo '<i class="fas fa-tachometer-alt"><span class="info">' . $row['max_speed'] . ' km/h</span></i>';
        echo '<i class="fas fa-calendar-alt"><span class="info">' . $row['year_manufacture'] . '</span></i>';
        echo '</div>'; // End carinfo

        echo '</a>';
        echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
    echo '</footer>';
} else {
    echo '<p>Không có xe nào.</p>';
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
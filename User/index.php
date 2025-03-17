<?php
include 'header.php';
include 'connect.php';
?>
<?php
// Replace the existing cars array with this updated version
// $cars = [
//     [
//         'name' => 'BMW 320i Sportline',
//         'price' => 1529000000,
//         'year' => 2024,
//         'speed' => '235 km/h',
//         'location' => 'TP.HCM',
//         'image' => '3-series.jpeg',
//         'enginepower' => 184, // số mã lực
//         'engine_name' => '2.0L I4', // tên động cơ
//         'seating_capacity' => 5 // số chỗ
//     ],
//     [
//         'name' => 'BMW 330i M Sport',
//         'price' => 1629000000,
//         'year' => 2023,
//         'speed' => '250 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'trang-alpine-3.webp',
//         'enginepower' => 258,
//         'engine_name' => '2.0L I4',
//         'seating_capacity' => 5
//     ],
//     [
//         'name' => 'BMW 430i Convertible M Sport',
//         'price' => 2629000000,
//         'year' => 2021,
//         'speed' => '250 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'bmw3.png',
//         'enginepower' => 258,
//         'engine_name' => '2.0L I4',
//         'seating_capacity' => 4
//     ],
//     [
//         'name' => 'BMW 735i M Sport',
//         'price' => 4499000000,
//         'year' => 2023,
//         'speed' => '250 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'bmw4.png',
//         'enginepower' => 286,
//         'engine_name' => '3.0L I6',
//         'seating_capacity' => 5
//     ],
//     [
//         'name' => 'BMW XM',
//         'price' => 10990000000,
//         'year' => 2022,
//         'speed' => '250 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'bmw5.jpg',
//         'enginepower' => 653,
//         'engine_name' => '4.4L V8',
//         'seating_capacity' => 5
//     ],
//     [
//         'name' => 'MAZDA 6',
//         'price' => 899000000,
//         'year' => 2023,
//         'speed' => '220 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'mazda1.png',
//         'enginepower' => 188,
//         'engine_name' => '2.5L I4',
//         'seating_capacity' => 5
//     ],
//     [
//         'name' => 'MAZDA 2',
//         'price' => 420000000,
//         'year' => 2021,
//         'speed' => '220 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'mazda2.jpg',
//         'enginepower' => 110,
//         'engine_name' => '1.5L I4',
//         'seating_capacity' => 5
//     ],
//     [
//         'name' => 'MAZDA 3',
//         'price' => 579000000,
//         'year' => 2022,
//         'speed' => '187 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'mazda3.png',
//         'enginepower' => 153,
//         'engine_name' => '2.0L I4',
//         'seating_capacity' => 5
//     ],
//     [
//         'name' => 'MAZDA CX-5',
//         'price' => 829000000,
//         'year' => 2023,
//         'speed' => '220 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'mazda4.png',
//         'enginepower' => 188,
//         'engine_name' => '2.5L I4',
//         'seating_capacity' => 5
//     ],
//     [
//         'name' => 'MAZDA CX-8',
//         'price' => 1109000000,
//         'year' => 2024,
//         'speed' => '240 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'mazda5.webp',
//         'enginepower' => 188,
//         'engine_name' => '2.5L I4',
//         'seating_capacity' => 7
//     ],
//     [
//         'name' => 'Lamborghini Aventador SVJ',
//         'price' => 60000000000,
//         'year' => 2021,
//         'speed' => '310 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'lambo1.jpg',
//         'enginepower' => 770,
//         'engine_name' => '6.5L V12',
//         'seating_capacity' => 2
//     ],
//     [
//         'name' => 'Lamborghini Gallardo',
//         'price' => 50000000000,
//         'year' => 2022,
//         'speed' => '309 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'lambo2.png',
//         'enginepower' => 570,
//         'engine_name' => '5.2L V10',
//         'seating_capacity' => 2
//     ],
//     [
//         'name' => 'Lamborghini Huracan',
//         'price' => 7100000000,
//         'year' => 2023,
//         'speed' => '325 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'lambo3.jpg',
//         'enginepower' => 640,
//         'engine_name' => '5.2L V10',
//         'seating_capacity' => 2
//     ],
//     [
//         'name' => 'Lamborghini Aventador LP 770-4 SVJ',
//         'price' => 12000000000,
//         'year' => 2024,
//         'speed' => '350 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'lambo4.jpg',
//         'enginepower' => 770,
//         'engine_name' => '6.5L V12',
//         'seating_capacity' => 2
//     ],
//     [
//         'name' => 'Lamborghini Huracan Tecnica',
//         'price' => 17900000000,
//         'year' => 2024,
//         'speed' => '325 km/h',
//         'location' => 'TP.HCM',
//         'image' => 'lambo5.jpg',
//         'enginepower' => 610,
//         'engine_name' => 'V10 5.2L',
//         'seating_capacity' => 2
//     ]
//     ]; 


// Get products with selling or discounting status
$query = "SELECT * FROM products 
          WHERE status IN ('selling', 'discounting') 
          ORDER BY RAND()"; // Using RAND() for random ordering
$result = mysqli_query($connect, $query);

$cars = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cars[] = array(
        'name' => $row['car_name'],
        'price' => $row['price'],
        'year' => $row['year_manufacture'],
        'speed' => $row['max_speed'],
        'location' => 'TP.HCM', // You might want to add this field to your database
        'image' => $row['image_link'],
        'enginepower' => $row['engine_power'],
        'engine_name' => $row['engine_name'],
        'seating_capacity' => $row['seat_number'],
        'status' => $row['status']
    );
}

// Get current page number
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$carsPerPage = 3;

// Calculate total pages
$totalCars = count($cars);
$totalPages = ceil($totalCars / $carsPerPage);

// Ensure page is within valid range
$page = max(1, min($page, $totalPages));

// Get cars for current page
$startIndex = ($page - 1) * $carsPerPage;
$currentCars = array_slice($cars, $startIndex, $carsPerPage);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web kinh doanh xe hàng hiệu</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <script src="index.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">

    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
</head>
<style>
    .ctn-img {
        margin-top: -5.1em;
        position: relative;
        background-color: rgb(220, 220, 220);

    }

    .ctn-img .wp {
        width: 60vw;
        height: 75vh;
        box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.6);
        margin: 5rem auto;
        overflow: hidden;
        background-color: white;

    }

    .ctn-img .wp-hld {
        display: grid;
        grid-template-columns: repeat(6, 100%);
        height: 100%;
        width: 100%;
        animation: slider 30s ease-in-out infinite alternate;
        margin-bottom: 50px;
    }

    .ctn-img #img1 {
        background-image: url('lambo1.jpg');
        background-size: cover;
        background-position: center;
        max-height: 650px;



    }

    .ctn-img #img2 {
        background-image: url('lambo2.png');
        background-size: cover;
        background-position: center;
        max-height: 650px;
    }

    .ctn-img #img3 {
        background-image: url('lambo3.jpg');
        background-size: cover;
        background-position: center;
        max-height: 650px;
    }

    .ctn-img #img4 {
        background-image: url('lambo4.jpg');
        background-size: cover;
        background-position: center;
        max-height: 650px;
    }

    .ctn-img #img5 {
        background-image: url('lambo5.jpg');
        background-size: cover;
        background-position: center;
        max-height: 650px;
    }

    .ctn-img #img6 {
        background-image: url('lambo6.jpg');
        background-size: cover;
        background-position: center;
        max-height: 650px;
    }

    .ctn-img .btn-hld .btn {
        background-color: rgb(131, 117, 117);
        width: 15px;
        height: 15px;
        border-radius: 15px;
        display: inline-block;
        margin: .3rem;
    }

    .ctn-img .btn-hld {
        position: absolute;
        left: 45%;
        bottom: 0%;
    }

    .btn:hover {
        box-shadow: 0px 0px 7px 4px rgba(0, 255, 255, 0.6);
    }

    @keyframes slider {
        0% {
            transform: translateX(0%);
        }

        10% {
            transform: translateX(-100%);
        }

        20% {
            transform: translateX(-100%);
        }

        30% {
            transform: translateX(-200%);
        }

        40% {
            transform: translateX(-200%);
        }

        50% {
            transform: translateX(-300%);
        }

        60% {
            transform: translateX(-300%);
        }

        70% {
            transform: translateX(-400%);
        }

        80% {
            transform: translateX(-400%);
        }

        90% {
            transform: translateX(-500%);
        }

        100% {
            transform: translateX(-500%);
        }
    }



    #searchbar {
        width: 700px;
        /* Half of the image slider's width */
        margin: 2px auto;
        /* Center the search bar */
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #ffffff;
        padding: 20px;

        border-radius: 15px;
    }

    #searchbar input[type="text"] {
        max-width: 500px;
        /* Adjust as needed */
        padding: 10px;
        min-width: 400px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #F5F5F5
    }

    #searchbar .search:hover {
        border: 1px solid #333;
    }

    #searchbar button {
        padding: 10px;
        border: none;
        background-color: #333;
        color: white;
        cursor: pointer;
        border-radius: 4px;
        margin-left: 5px;
    }

    #searchbar button:hover {
        background-color: #000;
    }
</style>
<style>
    .ds-md-sb {
        background-color: #ffffff;
        padding: 30px;
        margin: 20px;
        margin-left: 320px;
        margin-right: 320px;
        border: 2px solid rgb(227, 219, 219);
        border-radius: 15px;
    }

    #ds-md {
        text-align: center;
    }

    #ctn21 {
        display: flex;
        justify-content: center;
        gap: 20px;
        /* Khoảng cách giữa các phần tử */
    }

    .lgb {
        border: 2px solid gray;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-radius: 15px;
    }

    .lgb:hover {
        border: 2px solid black;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        border-radius: 15px;
    }

    .lg-b {
        max-width: 100px;
        /* Điều chỉnh kích thước hình ảnh nếu cần */
    }

    .lg {
        text-align: center;
        text-decoration: none;
        color: gray;

        font-weight: bold;
    }

    .lg:hover {
        color: rgba(59, 130, 246, 0.5);
    }

    #ds-md-title {
        color: gray;
    }

    #newcar {
        background-color: #ffffff;
        padding: 30px;
        margin: 20px;
        margin-left: 320px;
        margin-right: 320px;
        border: 2px solid rgb(227, 219, 219);
        border-radius: 15px;
    }

    #why {
        background-color: #ffffff;
        padding: 10px;
        margin: 20px;
        margin-left: 320px;
        margin-right: 320px;
        border: 2px solid rgb(227, 219, 219);
        border-radius: 15px;
    }

    .nc-title {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        background-color: #ffffff;
        padding: -20px;
        /* Thêm padding 10px */
        margin: 10px;

    }

    .why-title {

        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        background-color: #ffffff;
        padding: 10px;
        /* Thêm padding 10px */
        margin: 10px;
        margin-bottom: 50px;
    }

    .hct {
        border: 1px solid #ccc;
        border-radius: 15px;
        background-color: #00B3FC;
        padding: 10px;
        padding-left: 100px;
        padding-right: 100px;
    }

    .wco {
        border: 1px solid #ccc;
        border-radius: 15px;
        background-color: #00B3FC;
        padding: 10px;
        padding-left: 100px;
        padding-right: 100px;
        text-transform: uppercase;
    }

    .morecar {
        border: 1px solid #ccc;
        border-radius: 15px;
        background-color: #00B3FC;
        padding: 10px;
        padding-left: 70px;
        padding-right: 70px;
    }

    .morecar:hover {
        background-color: #007BFF;
    }

    /* .carpic{

    max-height: 60vh;

} */
    .linkcar {
        text-decoration: none;

    }

    .cith2 {
        color: black;
        padding-left: 40px;

    }

    .cit {
        color: gray;
        text-transform: uppercase;
        font-weight: bold;
        padding-left: 40px;

    }

    .nc-item {
        border: 1px solid black;
        margin-bottom: 50px;
        border-radius: 15px;
        overflow: hidden;
        /* Đảm bảo phần vượt quá sẽ bị ẩn */
    }

    .nc-item:hover {
        box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.5);
    }

    .carinfo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-left: 40px;
        padding-right: 40px;

        color: black;
    }

    .info {
        padding-left: 5px;
        font-family: 'Times New Roman', Times, serif;
    }

    .more {
        text-transform: uppercase;
        text-decoration: none;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        color: #ffffff;
        font-weight: lighter;
        font-size: 25px;
    }
</style>
<style>
    /* Car List Container */
    #newcar {
        padding: 40px;
        background-color: rgb(255, 255, 255);
    }

    /* Grid Layout */
    .ctn21 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        padding: 40px;
        margin-top: 20px;
    }

    /* Car Card Styling */
    .nc-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .nc-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Car Image */
    .carpic {
        width: 100%;
        height: 200px;
        max-height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .nc-item:hover .carpic {
        transform: scale(1.05);
    }

    /* Car Details */
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
        padding-left: 5px;
        font-weight: bolder;
        color: #666;
    }

    /* Section Titles */
    /* .nc-title {
    text-align: center;
    margin: 40px 0;
    background-color:#EFEFEF;
} */

    .hct,
    .morecar {
        display: inline-block;
        background-color: #007bff;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .morecar:hover {
        background-color: #0056b3;
    }

    /* Links */
    .linkcar {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .ctn21 {
            padding: 20px;
            gap: 20px;
        }

        .carinfo {
            grid-template-columns: repeat(2, 1fr);
        }

        #newcar {
            padding: 20px;
        }
    }

    /* More Button */
    .more {
        color: white;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 500;
        font-family: Arial, sans-serif;
    }

    body {
        margin: 0;
    }

    .fctn {}
</style>
<style>
    /* Add to your existing CSS */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 30px 0;
    }

    .page-link {
        padding: 8px 16px;
        border: 1px solid #007bff;
        border-radius: 4px;
        color: #007bff;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background-color: #007bff;
        color: white;
    }

    .page-link.active {
        background-color: #007bff;
        color: white;
        pointer-events: none;
    }

    /* Add to your existing pagination styles */
    .page-nav {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 8px 16px;
        background-color: #fff;
        border: 1px solid #007bff;
        color: #007bff;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .page-nav:hover {
        background-color: #007bff;
        color: white;
    }

    .page-nav i {
        font-size: 0.8rem;
    }

    /* Update existing pagination styles */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin: 30px 0;
    }
</style>
<style>
    /* Add to your existing styles */
    .garage-btn-container {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    .garage-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 30px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .garage-btn:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .garage-btn i {
        font-size: 1.1rem;
    }

    /* Update Car Info Icons Grid */
    .carinfo {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 15px;
        padding: 15px;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .carinfo {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
<style>
    /* Add to your existing styles */
    .nc-item {
        position: relative;
        max-width: 357px;
    }

    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #ff4757;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }
</style>

<body>

    <div class="" style="background-color:rgb(220, 220, 220);height:5vh;"></div>
    <main>
        <div class="fctn">

            <div class="ctn-img">
                <div class="wp">
                    <div class="wp-hld">
                        <div id="img1"></div>
                        <div id="img2"></div>
                        <div id="img3"></div>
                        <div id="img4"></div>
                        <div id="img5"></div>
                        <div id="img6"></div>
                    </div>
                </div>
                <div class="btn-hld">
                    <a href="#img1" class="btn" id="btn1"></a>
                    <a href="#img2" class="btn" id="btn2"></a>
                    <a href="#img3" class="btn" id="btn3"></a>
                    <a href="#img4" class="btn" id="btn4"></a>
                    <a href="#img5" class="btn" id="btn5"></a>
                    <a href="#img6" class="btn" id="btn6"></a>
                </div>
            </div>
        </div>
        <div class="ds-md-sb">

            <div id="searchbar">
                <form action="search-results.php" method="GET" style="display: flex; align-items: center;">
                    <input type="text" class="search" id="search" name="query"
                        placeholder="Nhập hãng xe vd: Lamborghini,...."
                        style="flex: 1; padding: 10px; font-size: 16px;">
                    <button type="submit"
                        style="padding: 10px 20px; font-size: 16px; margin-left: 5px; cursor: pointer;">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
            <div id="ds-md">
                <h1 id="ds-md-title">Kiểu Dáng/ Hãng Xe Phổ Biến</h1>
                <div id="ctn21">
                    <div class="lgb">
                        <a class="lg" href="BMW.php">
                            <img class="lg-b" src="BMW.png" alt="">
                            <br>
                            BMW
                        </a>
                    </div>
                    <div class="lgb">
                        <a class="lg" href="Lamborghini.php">
                            <img class="lg-b" src="images.png" alt="">
                            <br>
                            Lamborghini
                        </a>
                    </div>
                    <div class="lgb">
                        <a class="lg" href="Mazda.php">
                            <img class="lg-b"
                                src="png-transparent-mazda-biante-logo-mazda3-car-mazda-angle-emblem-text-thumbnail.png"
                                alt="">
                            <br>
                            Mazda
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div id="view"></div>

        <div id="newcar">
            <div class="nc-title">
                <h2 class="hot-car">
                    <span class="hct">

                        Xe Bán Chạy
                    </span>
                </h2>

            </div>
            <div class="ctn21">
                <?php foreach ($currentCars as $car): ?>
                    <div class="nc-item">
                        <a href="car-details.php?name=<?= urlencode($car['name']) ?>" class="linkcar">
                            <img class="carpic" src="<?= $car['image'] ?>" alt="<?= $car['name'] ?>">
                            <h2 class="cith2"><?= number_format($car['price'], 0, ',', '.') ?> VND</h2>
                            <p class="cit"><?= $car['name'] ?></p>
                            <div class="carinfo">
                                <i class="fas fa-car">
                                    <span class="info"><?= $car['seating_capacity'] ?> chỗ</span>
                                </i>
                                <i class="fa-solid fa-gear"> <!-- Changed from fas fa-engine -->
                                    <span class="info"><?= $car['engine_name'] ?></span>
                                </i>
                                <i class="fa-solid fa-wrench"> <!-- Changed to engine icon -->
                                    <span class="info"><?= $car['enginepower'] ?>&nbsp;Mã lực</span>
                                </i>
                                <i class="fas fa-tachometer-alt">
                                    <span class="info"><?= $car['speed'] ?></span>
                                </i>
                                <i class="fas fa-calendar-alt">
                                    <span class="info"><?= $car['year'] ?></span>
                                </i>
                                <i class="fa-solid fa-location-dot">
                                    <span class="info"><?= $car['location'] ?></span>
                                </i>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <!-- Replace the existing pagination div -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>#view" class="page-link page-nav">
                        <i class="fas fa-chevron-left"></i> Prev
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>#view" class="page-link <?= $i === $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>#view" class="page-link page-nav">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
            <!-- Add this after the pagination div -->
            <div class="garage-btn-container">
                <a href="more.php" class="garage-btn">
                    <i class="fas fa-warehouse"></i>
                    Garage Xe
                </a>
            </div>

        </div>

    </main>


</body>

</html>

<?php
include 'footer.php';
?>
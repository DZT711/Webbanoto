<?php
include 'header.php';
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách xe đang bán</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="more.css">
    <script src="more.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>


</head>
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

        <div class="ctn21">
              
        <div class="nc-item" data-price="1529000000" data-year="2024">
            <a href="bmw320.php" class="linkcar">
                
                <img class="carpic" src="3-series.jpeg" alt="bmw1">
                <h2 class="cith2"> 1.529.000.000 VND</h2>
                <p class="cit">BMW 320i Sportline</p>
                <div class="carinfo">
                    <i class="fas fa-car">
                        <span class="info">
                            4 chỗ
                        </span>
                    </i>
                    <i class="fas fa-gas-pump">
                        <span class="info">Xăng</span>
                    </i>
                    <i class="fas fa-tachometer-alt">
                        <span class="info">
                            235 km/h
                        </span>
                    </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">
                                2024
                            </span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">

                                TP.HCM
                            </span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="1629000000" data-year="2023">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="trang-alpine-3.webp" alt="bmw2" >
                    <h2 class="cith2"> 1.629.000.000 VND</h2>
                    <p class="cit">BMW 330i M SPort </p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">
                                4 chỗ
                            </span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">
                                250 km/h
                            </span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">
                                2023
                            </span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info" >

                                TP.HCM
                            </span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="2629000000" data-year="2021">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="bmw3.png" alt="bmw3">
                    <h2 class="cith2"> 2.629.000.000 VND</h2>
                    <p class="cit">430i Convertible M Sport</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">
                                4 chỗ
                            </span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">
                                250 km/h
                            </span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">
                                2021
                            </span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">

                                TP.HCM
                            </span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="4499000000" data-year="2023">
                <a href="bmw320.php" class="linkcar">

                    <img class="carpic" src="bmw4.png" alt="bmw4">
                    <h2 class="cith2"> 4.499.000.000 VND</h2>
                    <p class="cit">BMW 735i M sport</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">
                                4 chỗ
                            </span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">
                                250 km/h
                            </span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">
                                2023
                            </span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">

                                TP.HCM
                            </span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="10990000000" data-year="2022">
                <a href="bmw320.php" class="linkcar">

                    <img class="carpic" src="bmw5.jpg" alt="bmw5">
                    <h2 class="cith2"> 10.990.000.000 VND</h2>
                    <p class="cit">BMW XM</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">
                                4 chỗ
                            </span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">
                                250 km/h
                            </span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">
                                2022
                            </span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">
                                TP.HCM
                            </span>
                        </i>
                    </div>
                </a>
            </div>
            
            <div class="nc-item" data-price="899000000" data-year="2023">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="mazda1.png" alt="mazda1">
                    <h2 class="cith2"> 899.000.000 VND</h2>
                    <p class="cit">MAZDA 6</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">4 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">220 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2023</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="420000000" data-year="2021">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="mazda2.jpg" alt="mazda2">
                    <h2 class="cith2"> 420.000.000 VND</h2>
                    <p class="cit">MAZDA 2</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">4 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">220 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2021</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="579000000" data-year="2022">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="mazda3.png" alt="mazda3">
                    <h2 class="cith2"> 579.000.000 VND</h2>
                    <p class="cit">MAZDA 3</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">4 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">187 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2022</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="829000000" data-year="2023">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="mazda4.png" alt="mazda4">
                    <h2 class="cith2"> 829.000.000 VND</h2>
                    <p class="cit">MAZDA CX-5</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">4 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">220 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2023</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="1109000000" data-year="2024">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="mazda5.webp" alt="mazda5">
                    <h2 class="cith2"> 1.109.000.000 VND</h2>
                    <p class="cit">MAZDA CX-8</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">4 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">240 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2024</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            
            <div class="nc-item" data-price="60000000000" data-year="2021">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="lambo1.jpg" alt="lambo1">
                    <h2 class="cith2"> 60.000.000.000 VND</h2>
                    <p class="cit">Lamborghini Aventador SVJ</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">2 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">310 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2021</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="50000000000" data-year="2022">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="lambo2.png" alt="lambo2">
                    <h2 class="cith2"> 5.000.000.000 VND</h2>
                    <p class="cit">Lamborghini Gallardo</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">2 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">309 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2022</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="7100000000" data-year="2023">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="lambo3.jpg" alt="lambo3">
                    <h2 class="cith2"> 7.100.000.000 VND</h2>
                    <p class="cit">Lamborghini Huracan</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">2 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">325 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2023</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="12000000000" data-year="2024">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="lambo4.jpg" alt="lambo4">
                    <h2 class="cith2"> 12.000.000.000 VND</h2>
                    <p class="cit">Lamborghini Aventador LP 770-4 SVJ</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">2 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">350 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2024</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
            <div class="nc-item" data-price="17900000000" data-year="2024">
                <a href="bmw320.php" class="linkcar">
                    <img class="carpic" src="lambo5.jpg" alt="lambo5">
                    <h2 class="cith2"> 17.900.000.000 VND</h2>
                    <p class="cit">Lamborghini Huracan Tecnica</p>
                    <div class="carinfo">
                        <i class="fas fa-car">
                            <span class="info">2 chỗ</span>
                        </i>
                        <i class="fas fa-gas-pump">
                            <span class="info">Xăng</span>
                        </i>
                        <i class="fas fa-tachometer-alt">
                            <span class="info">325 km/h</span>
                        </i>
                        <i class="fas fa-calendar-alt">
                            <span class="info">2024</span>
                        </i>
                        <i class="fa-solid fa-location-dot">
                            <span class="info">TP.HCM</span>
                        </i>
                    </div>
                </a>
            </div>
        
        </div>
    </div>
</main>


</body>
</html>
<?php
include 'footer.php';
?>
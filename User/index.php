<?php
include 'header.php';
include 'connect.php';
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
    /* .logo{
    display: flex;
    justify-content: center;

    }


    header {
        
        align-items: center;
        background-color: #f8f8f8;
    }
    main{
        align-items: center;
        

        background-color: #EFEFEF;
    }
    body {
        font-family: Arial, sans-serif;
    }

    .navbar {
        background-color: white;
        overflow: hidden;
        text-transform: uppercase;
        font-weight: bold;
    }
    
    .navbar a {
        color: rgb(109,110,113);
        float: left;
        display: block;

        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    .navbar a:hover, .dropdown:hover .dropbtn {
        border-bottom: 2px solid rgb(33, 158, 199);
    }

    /* CSS cho dropdown 
    .dropdown {
        
        float: left;
        overflow: hidden;
        text-transform: uppercase;
        font-weight: bold;
        color: rgb(109,110,113);
    }

    .dropdown .dropbtn {
        font-size: 16px;
        text-transform: uppercase;
        font-weight: bold;
        color: rgb(109,110,113);
        border: none;
        outline: none;

        padding: 14px 16px;
        background-color: inherit;
        margin: 0;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: rgb(218, 218, 218) ;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }
    

    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .dropdown-content a:hover {
        background-color: rgb(128, 112, 112);
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
    .dropdown:hover .dropdown-content::after {
        content: '';
    } */

    .ctn-img {
        margin-top: -4.1em;
        position: relative;
        background-color: rgb(196, 193, 193);

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
        0% { transform: translateX(0%); }
        10% { transform: translateX(-100%); }
        20% { transform: translateX(-100%); }
        30% { transform: translateX(-200%); }
        40% { transform: translateX(-200%); }
        50% { transform: translateX(-300%); }
        60% { transform: translateX(-300%); }
        70% { transform: translateX(-400%); }
        80% { transform: translateX(-400%); }
        90% { transform: translateX(-500%); }
        100% { transform: translateX(-500%); }
    }
    /* #tlp{
        text-align: center;
        background-color: white;
        overflow: hidden;
        text-transform: uppercase;
        font-weight: bolder;
        padding: 14px 16px;
    } */


    #searchbar {
        width: 700px; /* Half of the image slider's width */
        margin: 2px auto; /* Center the search bar */
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #ffffff;
        padding: 20px;

        border-radius: 15px;
    }
    
    #searchbar input[type="text"] {
        max-width: 500px; /* Adjust as needed */
        padding: 10px;
        min-width: 400px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #F5F5F5
    }
#searchbar .search:hover{
    border:1px solid #333;
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
     #searchbar {
        width: 700px; /* Half of the image slider's width */
        margin: 2px auto; /* Center the search bar */
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #ffffff;
        padding: 20px;

        border-radius: 15px;
    }
    
    #searchbar input[type="text"] {
        max-width: 500px; /* Adjust as needed */
        padding: 10px;
        min-width: 400px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #F5F5F5
    }
#searchbar .search:hover{
    border:1px solid #333;
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
.ds-md-sb{
background-color: #ffffff;
padding :30px;
margin :20px;
margin-left:320px;
margin-right: 320px;
border: 2px solid rgb(227,219,219);
border-radius: 15px;
}
#ds-md {
    text-align: center;
}

#ctn21 {
    display: flex;
    justify-content: center;
    gap: 20px; /* Khoảng cách giữa các phần tử */
}

.lgb {
    border: 2px solid gray;
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius:15px ;
}
.lgb:hover{
    border: 2px solid black;
    padding: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    border-radius:15px ;
}

.lg-b {
    max-width: 100px; /* Điều chỉnh kích thước hình ảnh nếu cần */
}

.lg {
    text-align: center;
    text-decoration: none;
    color: gray;
    
    font-weight: bold;
}
.lg:hover{
    color: rgba(59, 130, 246, 0.5);
}
#ds-md-title{
    color: gray;
}
#newcar{
background-color: #ffffff;
padding :30px;
margin :20px;
margin-left:320px;
margin-right: 320px;
border: 2px solid rgb(227,219,219);
border-radius: 15px;
}

#why{
background-color: #ffffff;
padding :10px;
margin :20px;
margin-left:320px;
margin-right: 320px;
border: 2px solid rgb(227,219,219);
border-radius: 15px;
}

.nc-title {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
    background-color: #ffffff;
    padding: -20px; /* Thêm padding 10px */
    margin: 10px;

}

.why-title {

    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
    background-color: #ffffff;
    padding: 10px; /* Thêm padding 10px */
    margin: 10px;
    margin-bottom: 50px;
}

.hct{
    text-transform: uppercase;
    border: 1px solid #ccc;
    border-radius:15px ;
    background-color: #00B3FC;
    padding: 10px;
    padding-left: 100px;
    padding-right: 100px;
}
.wco{
    border: 1px solid #ccc;
    border-radius:15px ;
    background-color: #00B3FC;
    padding: 10px;
    padding-left: 100px;
    padding-right: 100px;
    text-transform: uppercase;
}
.morecar{
    border: 1px solid #ccc;
    border-radius:15px ;
    background-color: #00B3FC;
    padding: 10px;
    padding-left: 70px;
    padding-right: 70px;
}
.morecar:hover{
background-color: #007BFF;
}
.carpic{

    max-height: 60vh;

}
.linkcar{
    text-decoration: none;

}
.cith2{
    color: black;
    padding-left: 40px;

}
.cit{
    color:gray;
    text-transform: uppercase;
    font-weight: bold;
    padding-left: 40px;

}
.nc-item {
    border: 1px solid black;
    margin-bottom: 50px;
    border-radius: 15px;
    overflow: hidden; /* Đảm bảo phần vượt quá sẽ bị ẩn */
}
.nc-item:hover{
    box-shadow: 0px 0px 10px 2px rgba(0, 0, 0, 0.5);
}
.carinfo{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-left: 40px;
    padding-right: 40px;
    margin-bottom: 20px;
    color: black;
}
.info{
    padding-left: 5px;
    font-family: 'Times New Roman', Times, serif;
}
.more{
    text-transform: uppercase;
    text-decoration: none;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    color: #ffffff;
    font-weight:lighter;
    font-size: 25px;
}
</style>
<style>
/* Car List Container */
#newcar {
    padding: 40px;
    background-color: #efefef;
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
    font-family: Arial, sans-serif;
    padding-left: 5px;
    color: #666;
}

/* Section Titles */
.nc-title {
    text-align: center;
    margin: 40px 0;
    background-color:#EFEFEF;
}

.hct, .morecar {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 12px 30px;
    border-radius: 8px;
    text-transform: uppercase;
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
</style>
    <body>


<main >
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
        <div class="ds-md-sb">

            <div id="searchbar">
                <form action="search-results.php" method="GET" style="display: flex; align-items: center;">
                    <input type="text" class="search" id="search" name="query" placeholder="Nhập hãng xe vd: Lamborghini,...." style="flex: 1; padding: 10px; font-size: 16px;">
                    <button type="submit" style="padding: 10px 20px; font-size: 16px; margin-left: 5px; cursor: pointer;">
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
                            <img class="lg-b" src="png-transparent-mazda-biante-logo-mazda3-car-mazda-angle-emblem-text-thumbnail.png" alt="">
                            <br>
                            Mazda
                        </a>
                    </div>
                </div>
            </div>
            
        </div>

        <div id="newcar">
            <div class="nc-title">
                <h2 class="hot-car">
                    <span class="hct">

                        Xe Bán Chạy
                    </span>
                </h2>

            </div>
            <div class="ctn21">
                <div class="nc-item">
                    <a href="bmw320.php" class="linkcar">

                        <img class="carpic" src="lambo1.jpg" alt="lambo1">
                        <h2 class="cith2"> 60.000.000.000 VND</h2>
                        <p class="cit">Lamborghini Aventador SVJ</p>
                        <div class="carinfo">
                            <i class="fas fa-car">
                                <span class="info">
                                    2 chỗ
                                </span>
                            </i>
                            <i class="fas fa-gas-pump">
                                <span class="info">Xăng</span>
                            </i>
                            <i class="fas fa-tachometer-alt">
                                <span class="info">
                                    150 km/h
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
                <div class="nc-item">
                    <a href="bmw320.php" class="linkcar">

                        <img class="carpic" src="lambo2.png" alt="lambo2">
                        <h2 class="cith2"> 5.000.000.000 VND</h2>
                        <p class="cit">Lamborghini Gallardo</p>
                        <div class="carinfo">
                            <i class="fas fa-car">
                                <span class="info">
                                    2 chỗ
                                </span>
                            </i>

                            <i class="fas fa-gas-pump">
                                <span class="info">Xăng</span>
                            </i>
                            <i class="fas fa-tachometer-alt">
                                <span class="info">
                                    160 km/h
                                </span>
                            </i>
                            <i class="fas fa-calendar-alt">
                                <span class="info">
                                    2022
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
                <div class="nc-item">
                    <a href="bmw320.php" class="linkcar">

                        <img class="carpic" src="lambo3.jpg" alt="lambo3">
                        <h2 class="cith2"> 7.100.000.000 VND</h2>
                        <p class="cit">Lamborghini Huracan</p>
                        <div class="carinfo">
                            <i class="fas fa-car">
                                <span class="info">
                                    2 chỗ
                                </span>
                            </i>
                            <i class="fas fa-gas-pump">
                                <span class="info">Xăng</span>
                            </i>
                            <i class="fas fa-tachometer-alt">
                                <span class="info">
                                    170 km/h
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
                
            </div>
            <div class="nc-title">
                <h2 class="more-car">
                    <span class="morecar">

                        <a class="more" href="more.php"><small>Xem Thêm</small></a>
                    </span>
                </h2>

            </div>
        </div>
        
    </main>


</body>
</html>
<?php
include 'footer.php';
?>
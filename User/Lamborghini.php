<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lamborghini</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="stylelamborghini.css">
        <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
        <script src="lamborghini.js"></script>
        <link rel="icon" href="images.png" type="image/png">

    </head>
    <body>
        <header>
            <div class="logo">
                <a class="nav" href="Lamborghini.php">
                    <img src="dp56vcf7.png" alt="logo"    height="120px" >
                </a>
            </div>
        </header>
        <div class="login-register-ctn">
            <div class="login-register">
                <div class="lg"></div>
                <a href="#" id="login-btn"><i class="fa-solid fa-right-to-bracket">&nbsp;&nbsp;</i>Đăng nhập</a>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="space">|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <a href="#" id="register-btn"><i class="fas fa-user-plus">&nbsp;&nbsp;</i>Đăng ký</a>
                <span>&nbsp;&nbsp;</span>
                <a href="#" id="logout-btn" style="display:none;"><i class="fa-solid fa-right-from-bracket">&nbsp;&nbsp;</i>Đăng xuất </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                <span id="user-info" style="display:none;">Xin chào, <i class="fa-regular fa-user">&nbsp;&nbsp;</i><span id="username-display"></span>!</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div id="login-form" class="form" style="display:none;">
                <h2 class="lg-rgt-title">Đăng nhập</h2>
                <form>
                    <label for="username"><i class="fa-regular fa-user">&nbsp;&nbsp;</i>Tên đăng nhập:</label>
                    <input type="text" id="username" name="username" required placeholder="Tên đăng nhập">
                    <label for="password"><i class="fa-solid fa-lock">&nbsp;&nbsp;</i>Mật khẩu:</label>
                    <input type="password" id="password" name="password" required placeholder="Mật khẩu">
                    <button type="submit">Đăng nhập</button>
                </form>
            </div>
            <div id="register-form" class="form" style="display:none;">
                <h2 class="lg-rgt-title">Đăng ký</h2>
                <form>
                    <label for="new-username"><i class="fa-regular fa-user">&nbsp;&nbsp;</i>Tên đăng nhập:</label>
                    <input type="text" id="new-username" name="username" required placeholder="Tên đăng nhập">
                    <label for="new-password"><i class="fa-solid fa-lock">&nbsp;&nbsp;</i>Mật khẩu:</label>
                    <input type="password" id="new-password" name="password" required placeholder="Mật khẩu">
                    <label for="confirm-password"><i class="fa-solid fa-lock">&nbsp;&nbsp;</i>Xác nhận mật khẩu:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required placeholder="Xác nhận mật khẩu">
                    <button type="submit">Đăng ký</button>
                </form>
            </div>
        </div>
        <header>
            <div class="navbar">
    
                <a href="index.php" class="homelink" >Trang Chủ</a>
                <div class="dropdown">
                    <button class="dropbtn" style="cursor: pointer;">Xe Đang Bán <i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="index.php">Thương Hiệu <i class="fa-solid fa-caret-left"></i></a>
                        <a href="more.php">Mức Giá <i class="fa-solid fa-caret-left"></i></a>
                        <a href="more.php">Năm Sản Xuất <i class="fa-solid fa-caret-left"></i></a>
                    </div>
                </div>
                <a href="billhistory.php">Xem lịch sử mua hàng</a>
                <a href="#about">Giới Thiệu</a>
                <a href="#contact">Liên Hệ</a>
                <a href="../Admin/login.php">Admin</a>

            <div id="tlp">
                    <span class="Hotline">Hotline 1: 090 123 4567&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <span class="Hotline">Hotline 2: 080 123 4567</span>
                </div>
            </div>
                    </header>  
        <main >
            <h1 style="text-align: center;background-image: url('art_basel_2024_cover.webp');min-height: 60vh;padding: 50px;color: rgb(0,186,211);">Automobili Lamborghini S.p.A</h1>

            <!-- Bộ lọc sản phẩm -->
            <div id="newcar">
                <div class="filter-section">
                    <div class="s1">
                        <label for="priceFilter">Lọc theo giá:</label>
                        <select id="priceFilter" onchange="filterProducts()">
                            <option value="all">Tất cả</option>
                            <option value="below10b">Dưới 10 tỷ</option>
                            <option value="10to20b">Từ 10 đến 20 tỷ</option>
                            <option value="above20b">Trên 20 tỷ</option>
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
                
                <!-- Các sản phẩm -->
                <div class="ctn21">
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

        <hr>
        <footer>
            <div id="if-ct">
                <div class="if">
                    <img src="dp56vcf7.png" alt="logo" class="image1">
                    <div class="if-text">
        
                        <h2 class="if-title" id="about">
                            giới thiệu
                        </h2>
                        <small class="if-content">
                            AUTO CAR là đơn vị chuyên hoạt động trong lĩnh vực kinh doanh các loại xe, đặc biệt là siêu xe                             Với tiêu chí tập trung vào những xe chính hãng, chất lượng cao, còn bảo hành chính hãng và giá cả tối ưu nhất. 
                            Với tiêu chí tập trung vào những xe chính hãng, chất lượng cao, còn bảo hành chính hãng và giá cả tối ưu nhất. 
                            Tất cả các xe bán ra đều được trải qua quy trình kiểm tra nghiêm ngặt để đảm bảo tiêu chuẩn chất lượng cũng như độ an toàn cho khách hàng. 
                            Ngoài ra, công ty sẽ ký văn bản cam kết để bảo đảm sự minh bạch, trung thực với khách hàng, giúp khách hàng tăng thêm sự yên tâm và tin tưởng vào sản phẩm dịch vụ của chúng tôi.
                          
                        </small>
                        <br><br>
                        <small>
                            Tiêu chí của chúng tôi: Chỉ Xe Chất - Giá Tốt Nhất !
                        </small>
        
                    </div>
                    <div class="ct-text" id="contact">
                        <h2 class="ct-title">
                            thông tin liên hệ
                        </h2>
                        <div class="ct-item">
                            <i class="fa fa-phone" style="line-height: 0.2;"></i>
                            <p>0987654321</p>
                            <p>Hotline 1: 090 123 4567</p>
                            <p>Hotline 2: 080 123 4567</p>
                        </div>
                        <div class="ct-item">
                            <i class="fa fa-envelope"></i>
                            <p>email@auto.com</p>
                        </div>
                        <div class="ct-item">
                            <i class="fa fa-map-marker"></i>
                            <p>105 Bà Huyện Thanh Quan, P. Võ Thị Sáu, Q.3, TP.HCM</p>
                
                         </div>
                    </div>
                </div>
        <hr style="color: lightslategray;">
        <div class="copyright">
            <p>Copyright © 2024 Auto Car. All rights reserved.</p>
            <small>
                Chính sách thanh toán - Chính sách khiếu nại - Chính sách vận chuyển
            </small>  
            <br>
            <small>
                
                Chính sách bảo hành - Chính sách kiểm hàng - Chính sách bảo mật thông tin
            </small>
        </div>
        </footer>

    </body>               
</html>        

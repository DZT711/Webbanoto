<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Địa chỉ vận chuyển</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="delivery.css">
    <script src="delivery.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>

<body>
    <header>
        <div class="logo">
            <a class="nav" href="index.php">
                <img src="dp56vcf7.png" alt="logo" height="120px">
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
            <a href="#" id="logout-btn" style="display:none;"><i
                    class="fa-solid fa-right-from-bracket">&nbsp;&nbsp;</i>Đăng xuất
            </a><span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
            <span id="user-info" style="display:none;">Xin chào, <i class="fa-regular fa-user">&nbsp;&nbsp;</i><span
                    id="username-display"></span>!</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                <input type="password" id="confirm-password" name="confirm-password" required
                    placeholder="Xác nhận mật khẩu">
                <button type="submit">Đăng ký</button>
            </form>
        </div>
    </div>

    <hr>
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

    <!------------Delivery------------>
    <section class="delivery">
        <div class="container">
            <div class="delivery-top-wrap">
                <div class="delivery-top">
                    <div class="delivery-top-delivery delivery-top-item">
                        <a href="cart.php">

                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>

                    <div class="delivery-top-address delivery-top-item">
                        <a href="delivery.php">

                            <i class="fa-solid fa-location-dot"></i>
                        </a>
                    </div>

                    <div class="delivery-top-payment delivery-top-item">
                        <a href="payment.php">

                            <i class="fa-solid fa-money-check"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="delivery-content-row">
            <div class="delivery-content-left">
                <p><span class="info">Vui lòng chọn địa chỉ giao hàng</span></p>
                <!-- <div class="delvery-content-left-dangnhap row">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <p><span class="info">Đăng nhập nếu bạn đã có tài khoản</span></p>
                </div> -->
                <!-- <div class="delivery-content-left-khachle row">
                    <input id="radio-guest" name="loaikhach" type="radio" onclick="toggleRegisterForm(false)">
                    <p><span style="font-weight: bold;">Khách lẻ </span> (Nếu bạn không muốn lưu lại thông tin)</p>
                </div>
                <div class="delivery-content-left-dangky row">
                    <input id="radio-register" name="loaikhach" type="radio" onclick="toggleRegisterForm(true)">
                    <p><span style="font-weight: bold;">Đăng ký </span> (Tạo mới tài khoản với thông tin bên dưới)</p>
                </div> -->
                <div id="registration-form" class="delivery-content-left-input-top row" style="display: none;">
                    <div class="input-group">
                        <label for="">Họ tên<span style="color: red;">*</span></label>
                        <input type="text" placeholder="Nhập họ tên">
                    </div>
                    <div class="input-group">
                        <label for="">Số điện thoại<span style="color: red;">*</span></label>
                        <input type="text" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="input-group">
                        <label for="">Tỉnh/Tp<span style="color: red;">*</span></label>
                        <input type="text" placeholder="Nhập tỉnh/thành phố">
                    </div>
                    <div class="input-group">
                        <label for="">Quận/huyện<span style="color: red;">*</span></label>
                        <input type="text" placeholder="Nhập quận/huyện">
                    </div>
                    <div class="input-group">
                        <label for="">Địa chỉ<span style="color: red;">*</span></label>
                        <input type="text" placeholder="Nhập địa chỉ cụ thể">
                    </div>
                </div>
                <script>
                    function toggleRegisterForm(show) {
                        const form = document.getElementById('registration-form');
                        if (show) {
                            form.style.display = 'block'; // Hiển thị form nếu chọn "Đăng ký"
                        } else {
                            form.style.display = 'block'; // Ẩn form nếu chọn "Khách lẻ"
                        }
                    }
                    toggleRegisterForm(true);
                </script>
                <div class="delivery-content-left-button row">
                    <a href="cart.php"><span>&#171;</span>
                        <p><span class="return">Quay lại giỏ hàng</span></p>
                    </a>
                    <button id="checkout-button" onclick="navigateToPayment()">THANH TOÁN VÀ GIAO HÀNG</button>
                    <script>
                        function navigateToPayment() {
                            // Chuyển hướng đến trang payment.php
                            window.location.href = "payment.php";
                        }
                    </script>
                </div>
            </div>
            <div class="delivery-content-right">
                <table>
                    <tr>
                        <th>Thương hiệu</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                    <tr>
                        <td>BMW</td>
                        <td>BMW 320I SPORT LINE 2023</td>
                        <td>1</td>
                        <td>
                            <p>1,189,000,000VND</p>
                        </td>
                    </tr>
                    <tr>
                        <td>BMW</td>
                        <td>
                            <p>BMW 520I LUXURY 2021</p>
                        </td>
                        <td>1</td>
                        <td>
                            <p>1,450,000,000VND</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">TẠM TÍNH</td>
                        <td style="font-weight: bold;">
                            <p>2,639,000,000VND</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">THUẾ VAT</td>
                        <td style="font-weight: bold;">
                            <p>0%</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;" colspan="3">TỔNG</td>
                        <td style="font-weight: bold;">
                            <p>2,639,000,000VND</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    <!------------footer----------->
    <footer>
        <div id="if-ct">
            <div class="if">
                <img src="dp56vcf7.png" alt="logo" class="image1">
                <div class="if-text">
    
                    <h2 class="if-title">
                        giới thiệu
                    </h2>
                    <small class="if-content" id="about">
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
                <div class="ct-text">
                    <h2 class="ct-title">
                        thông tin liên hệ
                    </h2>
                    <div class="ct-item">
                        <i class="fa fa-phone" style="line-height: 0.2;"></i>
                        <p id="contact">0987654321</p>
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
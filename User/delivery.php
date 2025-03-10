<?php
include 'header.php';
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Địa chỉ vận chuyển</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="delivery.css"> -->
    <script src="delivery.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<!-- <style>
        /* Add to your existing delivery.php styles */
    
    /* Title Container */
    .eight {
        height: 100px;
        background-color: #efefef;
        /* border-radius: 10px; */
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        width:1200px;
        margin-left:345px;
    }
    
    /* Title Styling */
    .eight h1 {
        padding-top: 30px;
        text-align: center;
        text-transform: uppercase;
        font-size: 26px;
        letter-spacing: 1px;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        grid-template-rows: 16px 0;
        grid-gap: 22px;
        color:rgb(172, 172, 172);
        font-family: Arial, Helvetica, sans-serif;
        background-color: #efefef;
        
        color: #2c3e50;
    }
    
    /* Title Lines */
    .eight h1:after,
    .eight h1:before {
        content: " ";
        display: block;
        border-bottom: 2px solid #ccc;
        background-color: #efefef;
    }
    
 
    /* Add this to your HTML right after the delivery-top section */ -->
</style>
<style>
/* Delivery Page Container */
.delivery {
    padding: 40px 0;
    background-color: #efefef;
}

/* Title Styling */
/* .eight {
    height: 100px;
    background-color: #efefef;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 30px;
} */



/* Progress Bar */
.delivery-top-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 40px;
}

.delivery-top {
    height: 2px;
    width: 70%;
    background-color: #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 30px auto;
    max-width: 840px;
    position: relative;
}

.delivery-top-item {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.delivery-top-item i {
    color: #666;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.delivery-top-item.active {
    border-color: #007bff;
    background-color: #007bff;
}

.delivery-top-item.active i {
    color: #fff;
}

/* Content Layout */
.delivery-content-row {
    display: flex;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Left Section - Form */
.delivery-content-left {
    flex: 2;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.input-group {
    margin-bottom: 20px;
    width:590px;
}

.input-group label {
    display: block;
    margin-bottom: 8px;
    color: #2c3e50;
    font-weight: 500;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.input-group input:focus {
    border-color: #007bff;
    outline: none;
}

/* Right Section - Summary */
.delivery-content-right {
    flex: 1;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.delivery-content-right table {
    width: 100%;
    border-collapse: collapse;
}

.delivery-content-right th,
.delivery-content-right td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.delivery-content-right th {
    font-weight: 600;
    color: #2c3e50;
    background-color: #f8f9fa;
}

/* Action Buttons */
.delivery-content-left-button {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
}

#checkout-button {
    padding: 12px 24px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

#checkout-button:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

.return {
    color: #666;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: color 0.3s ease;
}

.return:hover {
    color: #007bff;
}

/* Responsive Design */
@media (max-width: 768px) {
    .delivery-content-row {
        flex-direction: column;
    }

    .delivery-content-left,
    .delivery-content-right {
        width: 100%;
    }

    .delivery-content-left-button {
        flex-direction: column;
        gap: 15px;
    }

    #checkout-button {
        width: 100%;
    }
}
.registration-form{
padding: 10px;
}
</style>
<style>
    /* Update Title Container */
    .eight {
        height: 100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin: 20px auto;
        max-width: 1200px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Update Title Styling */
    .eight h1 {
        position: relative;
        padding: 0;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        color: #2c3e50;
        font-size: 26px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    
    /* Add underline accent */
    .eight h1::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: var(--cart-primary);
        border-radius: 2px;
    }    
</style>
<style>
        /* Title Container */
    .eight {
        height: 100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin: 20px auto;
        max-width: 1200px;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Title Styling */
    .eight h1 {
        position: relative;
        padding: 0;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-weight: 600;
        color: #2c3e50;
        font-size: 26px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }
    
    /* Add underline accent */
    .eight h1::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background-color: #007bff;
        border-radius: 2px;
    }
    
    /* Remove old title lines */
    .eight h1:before {
        content: none;
    }
</style>
<body>
    

    

    

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


            <div class="eight">
                <h1>Thông Tin Vận Chuyển</h1>
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
                    <a href="cart.php">
                        <p><span class="return"><span>&#171;</span>Quay lại giỏ hàng</span></p>
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
    
</body>

                    </html>
<?php
include 'footer.php';
?>
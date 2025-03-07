<?php
include 'header.php';
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="cart.css"> -->

    <script src="cart.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<style>/* Cart Page Container */
.cart {
    --cart-primary: #007bff;
    --cart-secondary: #f8f9fa;
    --cart-accent: #0056b3;
    padding: 40px 0;
    background-color: #efefef;
}

/* Progress Bar Section */
.cart-top-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
}

.cart-top {
    height: 2px;
    width: 70%;
    background-color: #909091;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 30px auto;
    max-width: 840px;
    position: relative;
}

.cart-top-item {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #ddd;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    position: relative;
    transition: all 0.3s ease;
    cursor: pointer;
    z-index: 2;
}

.cart-top-item i {
    color: #666;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.cart-top-item.active {
    border-color: var(--cart-primary);
    background-color: var(--cart-primary);
}

.cart-top-item.active i {
    color: #fff;
}

/* Cart Content Layout */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.cart-content-row {
    display: flex;
    gap: 30px;
    margin-top: 40px;
}

/* Cart Items Table */
.cart-content-left {
    flex: 2;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.cart-content-left table {
    width: 100%;
    border-collapse: collapse;
}

.cart-content-left th {
    padding: 15px;
    text-transform: uppercase;
    font-size: 0.9rem;
    color: #495057;
    border-bottom: 2px solid #e9ecef;
    text-align: left;
}

.cart-content-left td {
    padding: 15px;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

.cart-content-left img {
    width: 100px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.cart-content-left img:hover {
    transform: scale(1.05);
}

/* Quantity Controls */
.cart-content-left input[type="number"] {
    width: 70px;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
}

/* Cart Summary */
.cart-content-right {
    flex: 1;
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    height: fit-content;
}

.cart-content-right table {
    width: 100%;
    margin-bottom: 20px;
}

.cart-content-right th {
    padding: 15px;
    text-align: center;
    background-color: #f8f9fa;
    color: #495057;
    font-size: 1rem;
    border-bottom: 2px solid #e9ecef;
}

.cart-content-right td {
    padding: 12px;
    border-bottom: 1px solid #e9ecef;
}

/* Action Buttons */
.cart-content-right-button {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.cart-content-right-button button {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

#continue-shopping {
    background-color: #6c757d;
    color: white;
}

#checkout-button {
    background-color: var(--cart-primary);
    color: white;
}

#continue-shopping:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
}

#checkout-button:hover {
    background-color: var(--cart-accent);
    transform: translateY(-2px);
}

/* Remove Item Button */
.remove-item {
    color: #dc3545;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
}

.remove-item:hover {
    color: #c82333;
    transform: scale(1.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .cart-content-row {
        flex-direction: column;
    }

    .cart-content-left {
        overflow-x: auto;
    }

    .cart-content-left table {
        min-width: 600px;
    }

    .cart-top {
        width: 90%;
    }
}

/* Preserve Header Styles */
.header-container {
    --header-bg: #f8f9fa;
    --header-text: #495057;
}

/* Preserve Cart Original Styles */
.cart-top-cart {
    border: 1px solid rgb(7, 7, 7);
}

.cart-top-cart i {
    color: black;
}</style>
<style>/* Title styling for cart page */

.cart-title {
    text-align: center;
    padding: 25px 0;
    margin: 0 0 20px 0;
    color: #2c3e50;
    font-size: 2rem;
    font-weight: 600;
    background-color: #fff;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-radius: 8px;
}

.cart-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background-color: var(--cart-primary);
    border-radius: 2px;
}

/* Update container spacing */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Adjust cart section spacing */
.cart {
    padding: 20px 0 40px;
    background-color: #efefef;
}</style>
<style>
    h1 {
  position: relative;
  padding: 0;
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
  font-weight: bold;
  color: #666;
  font-size: 40px;
  /* color: #080808; */
  -webkit-transition: all 0.4s ease 0s;
  -o-transition: all 0.4s ease 0s;
  transition: all 0.4s ease 0s;
  height: 50px;
}

h1 span {
  display: block;
  font-size: 0.5em;
  line-height: 1.3;
}
h1 em {
  font-style: normal;
  font-weight: 600;
}
.eight{
    height :100px;
    background-color: #efefef;
    /* border-radius: 10px; */
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.eight h1 {
    padding-top: 30px;
  text-align:center;
 
  text-transform:uppercase;
  font-size:26px; letter-spacing:1px;
  
  display: grid;
  grid-template-columns: 1fr auto 1fr;
  grid-template-rows: 16px 0;
  grid-gap: 22px;
}

.eight h1:after,.eight h1:before {
  content: " ";
  display: block;
  border-bottom: 2px solid #ccc;
  background-color:#efefef  ;
}

</style>
<body>
    
    <!------------cart------------->
    <section class="cart">
        <div class="container">
            <div class="cart-top-wrap">
                
                <div class="cart-top">
                    <div class="cart-top-cart cart-top-item">
                        <a href="cart.php">

                            <i class="fa-solid fa-cart-shopping"></i>
                        </a>
                    </div>

                    <div class="cart-top-addres cart-top-item">
                        <a href="delivery.php">

                            <i class="fa-solid fa-location-dot"></i>
                        </a>
                    </div>

                    <div class="cart-top-payment cart-top-item">
                        <a href="payment.php">

                            <i class="fa-solid fa-money-check"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="eight">
  <h1>Giỏ Hàng</h1>
</div>
      
            <div class="cart-content-row">
                <div class="cart-content-left"><table>
                    <tr>
                        <th>Thương hiệu</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Xóa</th>
                    </tr>
                    <tr>
                        <td><img src="3-series.jpeg" alt="BMW 320i Sportline"></td>
                        <td>
                            <p>BMW 320i Sportline</p>
                        </td>
                        <td><input type="number" value="1" min="1"oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>1,529,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="trang-alpine-3.webp" alt="BMW 330i M Sport"></td>
                        <td>
                            <p>BMW 330i M Sport</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>1,629,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="bmw3.png" alt="430i Convertible M Sport"></td>
                        <td>
                            <p>430i Convertible M Sport</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>2,629,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="bmw4.png" alt="BMW 735i M Sport"></td>
                        <td>
                            <p>BMW 735i M Sport</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>4,499,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="bmw5.jpg" alt="BMW XM"></td>
                        <td>
                            <p>BMW XM</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>10,990,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="mazda1.png" alt="MAZDA 6"></td>
                        <td>
                            <p>MAZDA 6</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>899,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="mazda2.jpg" alt="MAZDA 2"></td>
                        <td>
                            <p>MAZDA 2</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>420,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="mazda3.png" alt="MAZDA 3"></td>
                        <td>
                            <p>MAZDA 3</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>579,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="mazda4.png" alt="MAZDA CX-5"></td>
                        <td>
                            <p>MAZDA CX-5</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>829,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="mazda5.webp" alt="MAZDA CX-8"></td>
                        <td>
                            <p>MAZDA CX-8</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>1,109,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="lambo1.jpg" alt="Lamborghini Aventador SVJ"></td>
                        <td>
                            <p>Lamborghini Aventador SVJ</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>60,000,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="lambo2.png" alt="Lamborghini Gallardo"></td>
                        <td>
                            <p>Lamborghini Gallardo</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>50,000,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="lambo3.jpg" alt="Lamborghini Huracan"></td>
                        <td>
                            <p>Lamborghini Huracan</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>7,100,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="lambo4.jpg" alt="Lamborghini Aventador LP 770-4 SVJ"></td>
                        <td>
                            <p>Lamborghini Aventador LP 770-4 SVJ</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>12,000,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                    <tr>
                        <td><img src="lambo5.jpg" alt="Lamborghini Huracan Tecnica"></td>
                        <td>
                            <p>Lamborghini Huracan Tecnica</p>
                        </td>
                        <td><input type="number" value="1" min="1" oninput="handleQuantityChange(this)"></td>
                        <td>
                            <p>17,900,000,000 VND</p>
                        </td>
                        <td><span class="remove-item" onclick="removeCartItem(this)">X</span></td>
                    </tr>
                </table>
                </div>
                <div class="cart-content-right">
                    <table>
                        <tr>
                            <th colspan="2">TỔNG TIỀN GIỎ HÀNG</th>
                        </tr>
                        <tr>
                            <td>TỔNG SẢN PHẨM</td>
                            <td>2</td>
                        </tr>
                        <tr>
                            <td>TỔNG TIỀN</td>
                            <td>
                                <p>2.639.000.000VND</p>
                            </td>
                        </tr>
                        <tr>
                            <td>TẠM TÍNH</td>
                            <td>
                                <p style="color:black ;font-weight:bold ; ">2.639.000.000VND</p>
                            </td>
                        </tr>
                    </table>
                    <div class="cart-content-right-button">
                        <button id="continue-shopping"onclick="history.back()">TRỞ VỀ</button>
                        <!-- <button id="checkout-button" onclick="navigateToDelivery()">THANH TOÁN</button> -->
                        <button id="checkout-button" >THANH TOÁN</button>
                    </div>

                    <!-- <div class="cart-content-right-dangnhap">
                        <p>TÀI KHOẢN</p>
                        <p>Hãy <a href="">Đăng nhập</a> tài khoản của bạn để tích điểm thành viên</p>
                    </div> -->

                    <!-- <script>
                        function navigateToDelivery() {
                            // Chuyển đến trang delivery.php
                            window.location.href = "delivery.php";
                        }

                        function goToHomePage() {
                            // Chuyển hướng về trang chủ
                            window.location.href = "index.php";
}

                    </script> -->
                </div>
            </div>
        </div>
    </section>

    <!------------footer----------->
    
</body>

</html>
<?php

include 'footer.php';
?>
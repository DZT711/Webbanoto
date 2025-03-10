<?php
include 'header.php';
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <!-- <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="payment.css"> -->
    <script src="payment.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<style>
/* Payment Page Container */
.payment {
    padding: 40px 0;
    background-color: #efefef;
}

/* Progress Bar Section */
.payment-top-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
}

.payment-top {
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

.payment-top-item {
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
    z-index: 2;
}

.payment-top-item i {
    color: #666;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.payment-top-item.active {
    border-color: #007bff;
    background-color: #007bff;
}

.payment-top-item.active i {
    color: #fff;
}

/* Payment Content Layout */
.payment-content {
    display: flex;
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Payment Columns */
.payment-column {
    flex: 1;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Form Elements */
.payment-column input[type="text"],
.payment-column input[type="radio"] {
    width: 500px;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ddd;
    border-radius: 6px;
    transition: border-color 0.3s ease;
}

.payment-column input[type="text"]:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.payment-column input[type="radio"] {
    width: auto;
    margin-right: 10px;
}

/* Labels and Text */
.payment-column p,
.payment-column label {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 0.95rem;
}

.payment-column p strong {
    font-weight: 600;
}

/* Action Buttons */
.payment-content-right-button {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 30px;
}

.cbtn {
    padding: 12px 24px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.cbtn:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .payment-content {
        flex-direction: column;
    }

    .payment-column {
        width: 100%;
    }

    .payment-content-right-button {
        flex-direction: column;
    }

    .cbtn {
        width: 100%;
    }
}

/* Preserve Header Styles */
.header-container {
    --header-bg: #f8f9fa;
    --header-text: #495057;
}

/* Add this to ensure proper spacing */
main {
    padding: 0;
    margin: 0;
}
</style>
<!-- <style>
.eight {
    height: 100px;
    background-color: #efefef;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    margin-bottom: 30px;
}
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
    } -->
</style>

<style>
/* Add these styles to your existing CSS */
.links-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.payment-content-right-button {
    display: flex;
    gap: 20px;
    margin-top: 30px;
    width: 100%;
}

.return-btn {
    padding: 12px 24px;
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.pay-btn {
    padding: 12px 24px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.return-btn:hover,
.pay-btn:hover {
    transform: translateY(-2px);
}

.return-btn:hover {
    background-color: #5a6268;
}

.pay-btn:hover {
    background-color: #0056b3;
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
    .eight h1:before,
    .eight h1:after {
        content: none;
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
        display: inline-block; /* Add this */
    }
    
    /* Add underline accent */
    .eight h1::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 0; /* Change this */
        width: 100%; /* Change this */
        height: 3px;
        background-color: #007bff;
        border-radius: 2px;
        transform: none; /* Remove transform */
    }
    
    /* Remove any conflicting styles */
    .eight h1:before {
        display: none;
    }
        /* Update Title Container and Styling */
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
    
    /* Fix underline accent to match cart.php */
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
    
    /* Remove any conflicting styles */
    .eight h1:before {
        display: none;
    }
</style>
<body>
    



    <!------------payment----------------->
    <section class="payment">
        <div class="container">
            <div class="payment-top-wrap">
                <div class="payment-top">
                   <div class="payment-top-cart payment-top-item">
                    <a href="cart.php">

                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                   </div> 
        
                   <div class="payment-top-address payment-top-item">
                    <a href="delivery.php">

                        <i class="fa-solid fa-location-dot"></i>
                    </a>    
                   </div> 
        
                   <div class="payment-top-payment payment-top-item">
                    <a href="payment.php">

                        <i class="fa-solid fa-money-check"></i>
                    </a>    
                    </div> 
                </div>
            </div>
        <div class="container">
            <div class="eight">
                <h1>Thông Tin Vận Chuyển</h1>
            </div>
            <div class="payment-content row">
            <!----Thanh toán bằng thẻ tín dụng-->
            <div class="payment-column payment-column-left">
                <div class="payment-content-left-method-payment-item">
                    <input name="method-payment" type="radio" id="credit-card-option">
                    <label for="" style="font-weight: bold; text-align: left;">Thanh toán bằng thẻ tín dụng</label>
                </div>
                <div class="payment-content-left-method-payment">
                    <p>(Mọi giao dịch đều được bảo mật và mã hóa, thông tin thẻ tín dụng sẽ không được lưu lại.)</p>
                    <div style="margin-top: 10px;">
                        <p>Nhập thông tin thẻ Visa:</p>
                        <input type="text" class="input-text" placeholder="Số thẻ Visa">
                        <input type="text" class="input-text" placeholder="Họ tên trên thẻ">
                        <input type="text" class="input-text" placeholder="Ngày hết hạn (MM/YY)">
                        <input type="text" class="input-text" placeholder="Mã CVV">
                    </div>
                </div>
            </div>

                <!--Thanh toán bằng thẻ ATM--->
                <div class="payment-column payment-column-right">
                    <div class="payment-content-right-method-payment-item">
                        <input name="method-payment" type="radio" id="atm-option">
                        <label for="" style="font-weight: bold; text-align: left;">Thanh toán bằng thẻ ATM<labap>
                    </div>
                    <div class="payment-content-right-method-payment">
                        <div style="margin-top: 10px;">
                            <p>Nhập thông tin thẻ ATM:</p>
                            <input type="text" class="input-text" placeholder="Số thẻ ATM">
                            <input type="text" class="input-text" placeholder="Tên ngân hàng">
                            <input type="text" class="input-text" placeholder="Tên chủ tài khoản">
                        </div>

                    <!----Thanh toán bằng tiền mặt-->
                    <div class="payment-content-right-method-payment-item">
                        <input name="method-payment" type="radio" id="cash-option">
                        <label for="cash-option" style="color: black;font-weight: bold;">Thanh toán bằng tiền mặt</label>
                    </div>
                </div>
            </div>
        </div>
                   <!-- Quà tặng và nút Thanh toán trên cùng hàng -->
                    <div class="payment-content-right-button" style=" justify-content: space-between; align-items: center; margin-top: 20px;">
                        <!-- Nút chọn quà tặng -->
                    <!-- <button id="gift-btn" style="padding: 10px; width: 49%; border: 1px solid #ccc; border-radius: 5px; background-color: #f9f9f9; color: black; cursor: pointer;" >
                        Chọn quà tặng
                    </button> -->

                    <!-- Danh sách quà tặng (ẩn mặc định) -->
                    <!-- <ul id="gift-options" style="display: none; position: absolute; top: 100%; left: 0; width: 70%; background-color: white; border: 1px solid #ccc; border-radius: 5px; list-style: none; padding: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); z-index: 100;">
                        <li style="padding: 5px; cursor: pointer;" onclick="selectGift('Bọc vô lăng')">Bọc vô lăng</li>
                        <li style="padding: 5px; cursor: pointer;" onclick="selectGift('Trang trí xe')">Trang trí xe</li>
                        <li style="padding: 5px; cursor: pointer;" onclick="selectGift('Vệ sinh xe')">Vệ sinh xe</li>
                        <li style="padding: 5px; cursor: pointer;" onclick="selectGift('Nước hoa xe hơi')">Nước hoa xe hơi</li>
                    </ul> -->
                </div>
                <!-- Replace the existing button section -->
<div class="links-container">
<a href="delivery.php" class="return-btn">
<i class="fas fa-arrow-left"></i>
TRỞ VỀ
</a>
<a href="review.php" class="pay-btn">
THANH TOÁN
<i class="fas fa-arrow-right"></i>
</a>
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
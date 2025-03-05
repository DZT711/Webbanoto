<?php
include 'header.php';
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMW 330i M Sport - Chi Tiết</title>
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">

    <!-- <link rel="stylesheet" href="bmw320.css"> -->
</head>
<style>
        /* Main container styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    
    main {
        padding: 40px 0;
        background-color: #f4f4f4;
    }
    
    .container {
        width: 90%;
        max-width: 1200px;
        margin: 20px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Car Details Section */
    .car-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }
    
    .car-image {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .car-image img {
        width: 100%;
        height: auto;
        transition: transform 0.3s ease;
    }
    
    .car-image:hover img {
        transform: scale(1.05);
    }
    
    .car-info {
        padding: 20px;
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .car-info h2 {
        color: #007bff;
        font-size: 2rem;
        margin-bottom: 20px;
        font-weight: 600;
    }
    
    .car-info p {
        color: #495057;
        margin: 15px 0;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .car-info p strong {
        color: #2c3e50;
        min-width: 120px;
    }
    
    /* Features and Safety Sections */
    .car-features, .car-safety {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        margin: 20px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .car-features h3, .car-safety h3 {
        color: #2c3e50;
        font-size: 1.5rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .car-features ul, .car-safety ul {
        list-style: none;
        padding: 0;
    }
    
    .car-features li, .car-safety li {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        color: #555;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .car-features li:before, .car-safety li:before {
        content: '✓';
        color: #28a745;
        font-weight: bold;
    }
    
    /* Action Buttons */
    .actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 40px;
    }
    
    .btn {
        padding: 15px 30px;
        font-size: 1.1rem;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .primary {
        background-color: #007bff;
        color: #fff;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }
    
    .primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }
    
    .secondary {
        background-color: #6c757d;
        color: #fff;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 20px;
        }
    
        .car-details {
            grid-template-columns: 1fr;
        }
    
        .car-info h2 {
            font-size: 1.5rem;
        }
    
        .car-info p {
            font-size: 1rem;
        }
    
        .actions {
            flex-direction: column;
        }
    
        .btn {
            width: 100%;
        }
    }
    
    /* Preserve header styles */
    .header-container {
        --header-bg: #f8f9fa;
        --header-text: #495057;
    }
    
    /* Preserve footer styles */
    footer {
        background-color: #F7F7F7;
        margin-top: 50px;
    }
</style>
<body>
    <header>
        <div class="logo">
            <a class="nav" href="bmw.php"> 
            </a>
        </div>
    </header>

    <main>
        <!-- Car Info Section -->
        <div class="container">
            <div class="car-details">
                <div class="car-image">
                    <img src="3-series.jpeg" alt="BMW 320i Sport Line 2023">
                </div>
            <div class="car-info">
                <h2>1.629.000.000 VND</h2>
                <p><strong>Model:</strong> BMW 330i M Sport</p>
                <p><strong>Năm Sản Xuất:</strong> 2023</p>
                <p><strong>Loại xe:</strong> Thể thao</p>
                <p><strong>Động cơ:</strong> B48; Turbo TwinPower 2.0L, I4</p>
                <p><strong>Tốc độ tối đa:</strong> 250 km/h</p>
                <p><strong>Địa chỉ:</strong> TP.HCM</p>
        </div>

        <!-- Car Features Section -->
        <div class="car-features">
            <h3>⚙️ Option Nổi Bật</h3>
            <ul>
                <li>Núm xoay điều khiển iDrive Touch & hệ điều hành BMW 7.0</li>
                <li>Hệ thống âm thanh loa BMW Hifi 10 loa công suất 205W</li>
                <li>Điều hòa 3 vùng độc lập có cửa gió phía sau.</li>
                <li>Động cơ 4 xy-lanh thẳng hàng I4 tăng áp cổng nạp kép công nghệ BMW TwinPower-Turbo đi cùng hộp số tự động 8 cấp.</li>
                <li>Lưới tản nhiệt được thiết kế hình quả thận, xung quanh được viền crom mạ bạc.</li>
                <li>Màn hình thông tin giải trí có kích thước 10.25 inch, kết nối Apple Carplay, sạc không dây.</li>
                <li>Cụm đèn trước trang bị công nghệ LED toàn phần, mở rộng góc đánh lái, bật/tắt tự động.</li>
                <li>Bộ la zăng 18 inch, 10 nan bạc với lốp 225/45R18.</li>
            </ul>
        </div>

        <!-- Safety Features Section -->
        <div class="car-safety">
            <h3>⚙️ Tính Năng An Toàn Thông Minh</h3>
            <ul>
                <li>ABS là hệ thống chống bó cứng phanh.</li>
                <li>Thân xe điện tử với hệ thống ổn định DSC.</li>
                <li>Cảm biến cảnh báo va chạm trực diện với hệ thống báo động hoàn hảo.</li>
                <li>Hệ thống cảnh báo chệch làn đường.</li>
                <li>Hệ thống cảnh báo áp suất lốp.</li>
                <li>Hệ thống Parking Assistant tích hợp camera lùi.</li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="actions">
            <button class="btn primary" onclick="window.location.href='cart.php'">Thêm vào giỏ hàng</button>
            <button class="btn secondary" onclick="history.back()">Trở về</button>
        </div>
    </main>
</body>
</html>
<?php
include 'footer.php';
?>
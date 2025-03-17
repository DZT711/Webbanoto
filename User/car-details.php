<?php
include 'header.php';
include 'connect.php';

// Get car name from URL
if (!isset($_GET['name'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$car_name = mysqli_real_escape_string($connect, $_GET['name']);

// Get product details with car type using car_name
$query = "SELECT p.*, c.type_name 
          FROM products p 
          LEFT JOIN car_types c ON p.brand_id = c.type_id 
          WHERE p.car_name = '$car_name'";
$result = mysqli_query($connect, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}

$car = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car['car_name']; ?> - Chi Tiết</title>
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
</head>

<style>
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
    
    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        margin-left: 10px;
    }

    .status-selling { background-color: #28a745; color: white; }
    .status-discounting { background-color: #dc3545; color: white; }
    .status-hidden { background-color: #6c757d; color: white; }
    .status-soldout { background-color: #343a40; color: white; }

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
    }
    
    
    .actions {
        display: flex;
        gap: 20px;
        margin-top: 30px;
        padding: 20px 0;
        border-top: 1px solid #eee;
    }
    
    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }
    
    .btn.primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }
    
    .btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    }
    
    .btn.primary:active {
        transform: translateY(0);
    }
    
    .btn.secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .btn.secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
    }
    
    .btn.secondary:active {
        transform: translateY(0);
    }
    
    /* Add icons to buttons */
    .btn.primary::before {
        content: '\f07a';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }
    
    .btn.secondary::before {
        content: '\f060';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .actions {
            flex-direction: column;
            gap: 15px;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
            padding: 15px;
        }
    }   
    .car-info i{
        padding-right: 10px;
    }
    .car-title{
        color: rgb(150,150,150);
        text-transform: uppercase;
    }
</style>


<body>
    <main>
        <div class="container">
            <div class="car-details">
                <div class="car-image">
                    <img src="<?php echo $car['image_link']; ?>" alt="<?php echo $car['car_name']; ?>">
                </div>
                <div class="car-info">
            <h1 class="car-title"><?php echo $car['car_name']; ?></h1>
            <h2><i class="fas fa-tag"></i> Giá: <?php echo number_format($car['price'], 0, ',', '.'); ?> VND</h2>
            <p><strong><i class="fas fa-car"></i>Thương Hiệu:</strong> <?php echo $car['type_name']; ?></p>
            <p><strong><i class="fas fa-calendar-alt"></i>Năm Sản Xuất:</strong> <?php echo $car['year_manufacture']; ?></p>
            <p><strong><i class="fas fa-gears"></i>Động Cơ:</strong> <?php echo $car['engine_name']; ?></p>
            <p><strong><i class="fas fa-gear"></i>Mã Lực:</strong> <?php echo $car['engine_power']; ?> HP</p>
            <p><strong><i class="fas fa-gas-pump"></i>Loại Nhiên Liệu:</strong> <?php echo $car['fuel_name']; ?></p>
            <p><strong><i class="fas fa-oil-can"></i>Sức Chứa Nhiên Liệu:</strong> <?php echo $car['fuel_capacity']; ?></p>
            <p><strong><i class="fas fa-palette"></i>Màu:</strong> <?php echo $car['color']; ?></p>
            <p><strong><i class="fas fa-users"></i>Số Chỗ Ngồi:</strong> <?php echo $car['seat_number']; ?> chỗ</p>
            <p><strong><i class="fas fa-tachometer-alt"></i>Vận Tốc Tối Đa:</strong> <?php echo $car['max_speed']; ?> km/h</p>
            <p>
                <strong><i class="fas fa-info-circle"></i>Tình Trạng Xe:</strong>
                <span class="status-badge status-<?php echo $car['status']; ?>">
                    <?php 
                    switch($car['status']) {
                        case 'selling': echo 'Đang bán'; break;
                        case 'discounting': echo 'Đang giảm giá'; break;
                        case 'hidden': echo 'Tạm thời ẩn'; break;
                        case 'soldout': echo 'Hết hàng'; break;
                    }
                    ?>
                </span>
            </p>
        </div>
    </div>

            <?php if (!empty($car['car_description'])): ?>
            <div class="car-description">
                <h3><i class="fa-solid fa-screwdriver-wrench" style="padding-right: 10px;"></i>Mô Tả:</h3>
                <p><?php echo nl2br($car['car_description']); ?></p>
            </div>
            <?php endif; ?>

                                    <div class="actions">
                <button class="btn secondary" onclick="history.back()">Trở về</button>
                <?php if ($car['status'] != 'soldout'): ?>
                <button class="btn primary" onclick="window.location.href='cart.php?name=<?php echo urlencode($car['car_name']); ?>'">
                    Thêm vào giỏ hàng
                </button>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>

<?php include 'footer.php'; ?>
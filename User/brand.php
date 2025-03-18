<?php
include 'header.php';
include 'connect.php';

if (!isset($_GET['type'])) {
    header('Location: index.php');
    exit();
}

$brand_name = mysqli_real_escape_string($connect, $_GET['type']);

// Get brand details
$brand_query = "SELECT * FROM car_types WHERE type_name = '$brand_name'";
$brand_result = mysqli_query($connect, $brand_query);
$brand = mysqli_fetch_assoc($brand_result);

if (!$brand) {
    header('Location: index.php');
    exit();
}

// Get brand's cars
$query = "SELECT p.*, c.type_name 
          FROM products p 
          LEFT JOIN car_types c ON p.brand_id = c.type_id 
          WHERE c.type_name = '$brand_name' 
          AND p.status IN ('selling', 'discounting')
          ORDER BY p.product_id DESC";
$result = mysqli_query($connect, $query);
// Count the number of cars
$car_count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($brand_name); ?> - Xe Hơi</title>
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>
    <link rel="icon" href="<?php echo htmlspecialchars($brand['logo_url']); ?>" type="image/png">
    <style>
        .brand-content {
            padding: 20px 20px 0 20px;
            background-color: #efefef;
        }

        .brand-header {
            text-align: center;
            /* min-height: 50vh; */
            text-transform: uppercase;
            padding: 50px;
            color: white;
            font-weight: normal;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .filter-section {
            padding: 25px;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: center;
            gap: 60px;
            margin: 30px auto;
            max-width: 800px;
            transition: all 0.3s ease;
        }

        .s1,
        .s2 {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .filter-section select {
            padding: 12px 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 180px;
        }

        .ctn21 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px;
        }

        .nc-item {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            max-width: 360px;
        }

        .nc-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .carpic {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

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
        }

        .carinfo {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            padding: 15px;
            gap: 10px;
            border-top: 1px solid #eee;
            background: #f8f9fa;
            height: 54px;
        }

        .carinfo i {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            font-size: 0.9rem;
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1;
        }

        .status-discounting {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            animation: pulse 1.5s infinite;
        }

        .linkcar {
            text-decoration: none;
            color: black;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .info {
            font-family: 'Times New Roman', Times, serif;
        }

        main {
            padding-bottom: 0 !important;
        }

        .brand-header {
            text-align: center;
            padding: 40px 0;
            background: rgb(207, 207, 207);
            /* margin-bottom: 30px; */
        }
    </style>
</head>

<body>
    <main>
        <?php if ($car_count > 0): ?>
            <div class="brand-header">
                <img src="<?php echo htmlspecialchars($brand['logo_url']); ?>"
                    alt="<?php echo htmlspecialchars($brand_name); ?>" class="brand-logo">
                <h1 class="brand-title"><?php echo htmlspecialchars($brand_name); ?></h1>
            </div>
            <div class="brand-content">
                <div id="newcar">
                    <div class="filter-section">
                        <div class="s1">
                            <label for="priceFilter">Lọc theo giá:</label>
                            <select id="priceFilter" onchange="filterProducts()">
                                <option value="all">Tất cả</option>
                                <option value="below10b">Từ 1 tới 2 tỷ</option>
                                <option value="10to20b">Từ 2 tới 5 tỷ</option>
                                <option value="above20b">Trên 10 tỷ</option>
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

                    <div class="ctn21">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <div class="nc-item" data-price="<?php echo $row['price']; ?>"
                                data-year="<?php echo $row['year_manufacture']; ?>">
                                <a href="car-details.php?name=<?php echo urlencode($row['car_name']); ?>" class="linkcar">
                                    <?php if ($row['status'] == 'discounting'): ?>
                                        <div class="status-badge status-discounting">Đang giảm giá</div>
                                    <?php endif; ?>
                                    <img class="carpic" src="<?php echo htmlspecialchars($row['image_link']); ?>"
                                        alt="<?php echo htmlspecialchars($row['car_name']); ?>">
                                    <h2 class="cith2"><?php echo number_format($row['price'], 0, ',', '.'); ?> VND</h2>
                                    <p class="cit"><?php echo htmlspecialchars($row['car_name']); ?></p>
                                    <div class="carinfo">
                                        <i class="fas fa-car"><span class="info"><?php echo $row['seat_number']; ?>
                                                chỗ</span></i>
                                        <i class="fas fa-gas-pump"><span
                                                class="info"><?php echo htmlspecialchars($row['fuel_name']); ?></span></i>
                                        <i class="fa-solid fa-wrench"><span class="info"><?php echo $row['engine_power']; ?>
                                                HP</span></i>
                                        <i class="fas fa-tachometer-alt"><span class="info"><?php echo $row['max_speed']; ?>
                                                km/h</span></i>
                                        <i class="fas fa-calendar-alt"><span
                                                class="info"><?php echo $row['year_manufacture']; ?></span></i>
                                        <i class="fa-solid fa-location-dot"><span class="info">TP.HCM</span></i>
                                    </div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="brand-header">
                <img src="<?php echo htmlspecialchars($brand['logo_url']); ?>"
                    alt="<?php echo htmlspecialchars($brand_name); ?>" class="brand-logo">
                <h1 class="brand-title"><?php echo htmlspecialchars($brand_name); ?></h1>
            </div>
            <script>
                // Show notification when no cars are found
                document.addEventListener('DOMContentLoaded', function () {
                    showNotification(
                        "Xin lỗi, hiện tại không có xe <?php echo htmlspecialchars($brand_name); ?> nào đang bán.",
                        "info"
                    );
                });
            </script>
            <div class="no-cars-message" style="text-align: center; padding: 50px;">
                <p>Không có xe <?php echo htmlspecialchars($brand_name); ?> nào đang bán.</p>
                <a href="index.php" class="back-home">
                    <i class="fas fa-home"></i> Về trang chủ
                </a>
            </div>
        <?php endif; ?>
    </main>

    <script>
        function filterProducts() {
            const priceFilter = document.getElementById('priceFilter').value;
            const yearFilter = document.getElementById('yearFilter').value;
            const items = document.querySelectorAll('.nc-item');

            items.forEach(item => {
                const price = parseInt(item.dataset.price);
                const year = item.dataset.year;
                let showByPrice = true;
                let showByYear = true;

                if (priceFilter !== 'all') {
                    if (priceFilter === 'below10b' && price >= 2000000000) showByPrice = false;
                    if (priceFilter === '10to20b' && (price < 2000000000 || price > 5000000000)) showByPrice = false;
                    if (priceFilter === 'above20b' && price <= 10000000000) showByPrice = false;
                }

                if (yearFilter !== 'all' && year !== yearFilter) {
                    showByYear = false;
                }

                item.style.display = (showByPrice && showByYear) ? 'block' : 'none';
            });
        }
    </script>
</body>

</html>

<?php include 'footer.php'; ?>
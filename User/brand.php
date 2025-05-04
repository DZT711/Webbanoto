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
            text-transform: uppercase;
            font-weight: bold;
        }

        .carinfo {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            padding: 15px;
            gap: 10px;
            border-top: 1px solid #eee;
            background: #f8f9fa;
            white-space: nowrap;
            /* height: 54px; */
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
    <style>
        .brand-header {
            text-align: center;
            padding: 40px 0;
            background: rgb(255, 255, 255);
            border-radius: 15px;
            margin: 20px 320px;
            border: 2px solid rgb(227, 219, 219);
        }

        .brand-logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .lgb {
            border: 2px solid gray;
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .lgb:hover {
            border-color: black;
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .lg-b {
            max-width: 100px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .lgb:hover .lg-b {
            transform: scale(1.05);
        }

        .brand-title {
            color: gray;
            text-transform: uppercase;
            margin: 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        @media (max-width: 1200px) {
            .brand-header {
                margin: 20px;
            }
        }
    </style>
    <style>
        /* Enhanced Brand Header Animation */
        .brand-header {
            position: relative;
            overflow: hidden;
            animation: fadeInDown 0.8s ease-out;
        }

        .brand-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }

        /* Enhanced Filter Section */
        .filter-section {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s ease-out forwards;
            animation-delay: 0.3s;
        }

        .filter-section select {
            /* background: linear-gradient(145deg, #ffffff, #f5f5f5); */
            box-shadow: 5px 5px 10px #d9d9d9, -5px -5px 10px #ffffff;
        }

        .filter-section select:hover {
            transform: translateY(-2px);
            box-shadow: 7px 7px 15px #d9d9d9, -7px -7px 15px #ffffff;
        }

        /* Enhanced Car Items */
        .nc-item {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .ctn21 {
            perspective: 1000px;
        }

        .nc-item:hover .carpic {
            transform: scale(1.05);
        }

        .carpic {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .carinfo i {
            position: relative;
            overflow: hidden;
        }

        .carinfo i::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #007bff;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .carinfo i:hover::after {
            transform: scaleX(1);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            100% {
                left: 100%;
            }
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading Skeleton */
        .skeleton-loader {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            to {
                background-position: -200% 0;
            }
        }
        .brand-header {
            position: relative;
            overflow: hidden;
            text-align: center;
            padding: 40px 0;
            background: rgb(255, 255, 255);
            border-radius: 15px;
            margin: 20px 320px;
            border: 2px solid rgb(227, 219, 219);
            animation: fadeInDown 0.8s ease-out;
        }
        
        .brand-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.8) 50%,
                transparent 100%
            );
            animation: shimmer 2s infinite linear;
        }
        
        @keyframes shimmer {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        } 
        /* Add z-index to ensure content stays above the shimmer effect */
        .lgb {
            position: relative;
            z-index: 1;
        }
    </style> 

    <style>
        .brand-header {
            position: relative;
            overflow: hidden;
            text-align: center;
            padding: 40px 0;
            background: rgb(255, 255, 255);
            border-radius: 15px;
            margin: 20px 320px;
            border: 2px solid rgb(227, 219, 219);
            animation: fadeInDown 0.8s ease-out;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
    
        .brand-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent 0%,
                rgba(145, 145, 145, 0.8) 50%,
                transparent 100%
            );
            animation: shimmer 2s infinite linear;
            pointer-events: none; /* Ensures the shimmer doesn't interfere with clicks */
            z-index: 2; /* Place above content but below text */
        }
    
        .brand-logo-container {
            position: relative;
            /* z-index: 3;  */
        }
        
    
        .lgb {
            position: relative;
            border: 2px solid gray;
            padding: 20px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            z-index: 3;
        }
    
        @keyframes shimmer {
            0% {
                left: -100%;
            }
            100% {
                left: 100%;
            }
        }
    
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        @media (max-width: 1200px) {
            .brand-header {
                margin: 20px;
            }
        }
       body.dark-theme .brand-header{
        background:rgb(43, 59, 77);
       } 
       body.dark-theme .brand-content{
        background:#33475C !important;
       }
    </style>
</head>

<body>
    <main>
            

        <?php if ($car_count > 0): ?>
            <div class="brand-header">
                <!-- <div class="brand-logo-container"> -->
                    <!-- <div class="lgb"> -->
                        <img class="lg-b" 
                             src="https://img.logo.dev/<?php echo htmlspecialchars($brand['type_name']); ?>.com" 
                             alt="<?php echo htmlspecialchars($brand['type_name']); ?>" 
                             class="brand-logo">
                        <h1 class="brand-title"><?php echo htmlspecialchars($brand_name); ?></h1>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
            <div class="brand-content">
                <div id="newcar">
                                        <?php
                    include 'functions.php';
                    // Get dynamic ranges for current brand
                    $price_ranges = getPriceRanges($connect, $brand_name);
                    $years = getYearRanges($connect, $brand_name);
                    ?>
                    
                    <div class="filter-section">
                        <div class="s1">
                            <label for="priceFilter">
                                <i class="fas fa-tags"></i>
                                Lọc theo giá:
                            </label>
                            <select id="priceFilter" onchange="filterProducts()">
                                <option value="all">Tất cả</option>
                                <?php
                                $step = 1; // Billion VND steps
                                for ($i = $price_ranges['min']; $i < $price_ranges['max']; $i += $step) {
                                    $next = $i + $step;
                                    echo "<option value='{$i}-{$next}'>{$i} tỷ - {$next} tỷ</option>";
                                }
                                echo "<option value='{$price_ranges['max']}+'>Trên {$price_ranges['max']} tỷ</option>";
                                ?>
                            </select>
                        </div>
                        <div class="s2">
                            <label for="yearFilter">
                                <i class="fas fa-calendar"></i>
                                Lọc theo năm:
                            </label>
                            <select id="yearFilter" onchange="filterProducts()">
                                <option value="all">Tất cả</option>
                                <?php foreach ($years as $year): ?>
                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="ctn21">
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <div class="nc-item" data-price="<?php echo $row['price']; ?>"
                                data-year="<?php echo $row['year_manufacture']; ?>">
                                <a href="car-details.php?name=<?php echo urlencode($row['car_name']); ?>" class="linkcar">
                                    <?php if ($row['status'] == 'discounting'): ?>
                                        <div class="status-badge status-discounting">
                                            <i class="fas fa-tags"></i>
                                            Đang giảm giá
                                        </div>
                                    <?php endif; ?>
                                    <img class="carpic" data-src="<?php echo htmlspecialchars($row['image_link']); ?>"
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
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
                <div class="brand-logo-container">
                    <div class="lgb">
                        <img class="lg-b"
                            src="https://img.logo.dev/<?php echo htmlspecialchars($brand['type_name']); ?>.com"
                            alt="<?php echo htmlspecialchars($brand['type_name']); ?>">
                        <h1 class="brand-title"><?php echo htmlspecialchars($brand_name); ?></h1>
                    </div>
                </div>
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
    // Define filterProducts in global scope
    function filterProducts() {
        const priceFilter = document.getElementById('priceFilter').value;
        const yearFilter = document.getElementById('yearFilter').value;
        const items = document.querySelectorAll('.nc-item');
        let visibleCount = 0;
    
        items.forEach(item => {
            const price = parseInt(item.dataset.price);
            const year = item.dataset.year;
            let showByPrice = true;
            let showByYear = true;
    
            // Price filter logic
            if (priceFilter !== 'all') {
                if (priceFilter.includes('-')) {
                    const [min, max] = priceFilter.split('-').map(x => parseFloat(x) * 1000000000);
                    showByPrice = price >= min && price < max;
                } else if (priceFilter.includes('+')) {
                    const min = parseFloat(priceFilter.replace('+', '')) * 1000000000;
                    showByPrice = price >= min;
                }
            }
    
            // Year filter logic
            if (yearFilter !== 'all') {
                showByYear = year === yearFilter;
            }
    
            // Show item if it passes either all active filters
            const shouldShow = (priceFilter === 'all' || showByPrice) && 
                             (yearFilter === 'all' || showByYear);
    
            if (shouldShow) {
                item.style.display = 'block';
                item.style.animation = 'fadeInUp 0.5s ease-out forwards';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
    
        // Update the results count
        updateResultsCount(visibleCount);
    
        // Show notification if no results
        if (visibleCount === 0) {
            showNotification('Không tìm thấy xe phù hợp với bộ lọc đã chọn', 'info');
        }
    }
    
    // Define helper functions in global scope
    function updateResultsCount(count) {
        const resultsDiv = document.getElementById('filterResults') || createResultsDiv();
        resultsDiv.textContent = `Đang hiển thị ${count} xe`;
        resultsDiv.style.color = count === 0 ? '#dc3545' : '#666';
    }
    
    function createResultsDiv() {
        const div = document.createElement('div');
        div.id = 'filterResults';
        div.style.textAlign = 'center';
        div.style.marginTop = '20px';
        div.style.color = '#666';
        document.querySelector('.filter-section').after(div);
        return div;
    }
    
    // Keep initialization code in DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function () {
        // Stagger animation for car items
        const items = document.querySelectorAll('.nc-item');
        items.forEach((item, index) => {
            item.style.animationDelay = `${0.1 * index}s`;
        });
    
        // Initialize lazy loading
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('skeleton-loader');
                        observer.unobserve(img);
                    }
                });
            });
    
            document.querySelectorAll('.carpic').forEach(img => {
                img.classList.add('skeleton-loader');
                imageObserver.observe(img);
            });
        }
    });
    </script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Stagger animation for car items
            const items = document.querySelectorAll('.nc-item');
            items.forEach((item, index) => {
                item.style.animationDelay = `${0.1 * index}s`;
            });

            // Smooth scroll for filter changes
            function smoothScroll(target) {
                const element = document.querySelector(target);
                window.scrollTo({
                    top: element.offsetTop - 100,
                    behavior: 'smooth'
                });
            }

            // function filterProducts() {
            //     const priceFilter = document.getElementById('priceFilter').value;
            //     const yearFilter = document.getElementById('yearFilter').value;
            //     const items = document.querySelectorAll('.nc-item');
            //     let visibleCount = 0;
            
            //     items.forEach(item => {
            //         const price = parseInt(item.dataset.price);
            //         const year = item.dataset.year;
            //         let showByPrice = true;
            //         let showByYear = true;
            
            //         // Price filter logic
            //         if (priceFilter !== 'all') {
            //             if (priceFilter.includes('-')) {
            //                 const [min, max] = priceFilter.split('-').map(x => parseFloat(x) * 1000000000);
            //                 showByPrice = price >= min && price < max;
            //             } else if (priceFilter.includes('+')) {
            //                 const min = parseFloat(priceFilter.replace('+', '')) * 1000000000;
            //                 showByPrice = price >= min;
            //             }
            //         }
            
            //         // Year filter logic
            //         if (yearFilter !== 'all') {
            //             showByYear = year === yearFilter;
            //         }
            
            //         // Show item if it passes either all active filters
            //         const shouldShow = (priceFilter === 'all' || showByPrice) && 
            //                          (yearFilter === 'all' || showByYear);
            
            //         if (shouldShow) {
            //             item.style.display = 'block';
            //             item.style.animation = 'fadeInUp 0.5s ease-out forwards';
            //             visibleCount++;
            //         } else {
            //             item.style.display = 'none';
            //         }
            //     });
            
            //     // Update the results count
            //     updateResultsCount(visibleCount);
            
            //     // Show notification if no results
            //     if (visibleCount === 0) {
            //         showNotification('Không tìm thấy xe phù hợp với bộ lọc đã chọn', 'info');
            //     }
            // }
            
            // function updateResultsCount(count) {
            //     const resultsDiv = document.getElementById('filterResults') || createResultsDiv();
            //     resultsDiv.textContent = `Đang hiển thị ${count} xe`;
            //     resultsDiv.style.color = count === 0 ? '#dc3545' : '#666';
            // }
            
            // function createResultsDiv() {
            //     const div = document.createElement('div');
            //     div.id = 'filterResults';
            //     div.style.textAlign = 'center';
            //     div.style.marginTop = '20px';
            //     div.style.color = '#666';
            //     document.querySelector('.filter-section').after(div);
            //     return div;
            // }

            // Lazy loading for images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('skeleton-loader');
                            observer.unobserve(img);
                        }
                    });
                });

                document.querySelectorAll('.carpic').forEach(img => {
                    img.classList.add('skeleton-loader');
                    imageObserver.observe(img);
                });
            }
        });
    </script> -->
</body>

</html>

<?php include 'footer.php'; ?>
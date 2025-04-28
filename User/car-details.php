<?php
include 'header.php';
include 'connect.php';

// Get car name from URL
if (!isset($_GET['name'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit();
}
// First, modify the PHP section to fetch additional images

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
$product_id = $car['product_id'];
$additional_images_query = "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC";
$stmt = mysqli_prepare($connect, $additional_images_query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$additional_images_result = mysqli_stmt_get_result($stmt);

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
        gap: 20px;
        margin-bottom: 40px;
    }

    .car-image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 600px;
        height: 400px;
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
        background: linear-gradient(to bottom right, #ffffff, #f1f3f5);
        border-radius: 10px;
        padding: 10px;
        max-width: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        font-family: 'Segoe UI', sans-serif;
        line-height: 1.4;
        transition: all 0.3s ease-in-out;
    }

    .car-info:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
    }

    .car-title {
        font-size: 30px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0;
        margin-top: 0;
        text-align: left;
    }

    .car-info h2 {
        font-size: 25px;
        color: #007bff;
        margin-bottom: 0;
        /* margin-top: 0; */
        font-weight: bold;
        text-align: left;
    }

    .car-features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px 24px;
        margin-top: 12px;
    }

    .car-features-left,
    .car-features-right {
        display: flex;
        flex-direction: column;
        gap: 14px;
        justify-content: space-between;
    }

    .car-feature-item {
        font-size: 13px;
        color: #495057;
        display: flex;
        align-items: center;
        /* gap: 10px; */
        margin: 0;
        line-height: 1.5;
        padding: 5px 0;
    }

    .car-feature-item strong {
        color: #2c3e50;
        font-weight: 600;
        min-width: 130px;
        flex-shrink: 0;
    }

    .car-info i {
        color: #0d6efd;
        font-size: 18px;
        min-width: 18px;
        text-align: center;
        flex-shrink: 0;
    }

    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .status-selling {
        background-color: #28a745;
        color: #fff;
    }

    .status-discounting {
        background-color: #dc3545;
        color: #fff;
    }

    .status-hidden {
        background-color: #6c757d;
        color: #fff;
    }

    .status-soldout {
        background-color: #343a40;
        color: #fff;
    }

    @media (max-width: 768px) {
        .car-features {
            grid-template-columns: 1fr;
        }

        .car-title,
        .car-info h2 {
            text-align: center;
        }

        .car-feature-item strong {
            min-width: 110px;
        }
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

    .car-info i {
        padding-right: 10px;
    }

    .car-title {
        color: rgb(150, 150, 150);
        text-transform: uppercase;
    }

    .car-info:hover {
        background-color: #f0f0f0;
        transition: background-color 0.3s ease-in-out;
    }

    /* add hover effect for the car-features and car-safety divs */
    .car-features:hover,
    .car-safety:hover {
        background-color: #f9f9f9;
        transition: background-color 0.3s ease-in-out;
    }

    .active {
        border: 4px solid #007bff;
        /* Blue border for active thumbnail */
        opacity: 1;
        /* Full opacity for active thumbnail */
    }

    .thumbnail-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .thumbnail {
        width: 80px;
        height: 60px;
        margin: 0 5px;
        cursor: pointer;
        opacity: 0.7;
        /* Reduced opacity for inactive thumbnails */
        transition: opacity 0.3s ease-in-out;
        /* Smooth transition for opacity change */
    }

    .thumbnail:hover {
        opacity: 1;
        /* Full opacity on hover */
    }

    /* .thumbnail-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    gap: 20px; Added gap for better spacing between thumbnails */
    /* } */
    /* animation while change the image */
    .animation {
        transition: opacity 0.5s ease-in-out;
        /* Smooth transition for image change */
    }

    /* Add a hover effect to the buttons */
    .btn:hover {
        background-color: #0056b3;
        /* Darker blue on hover */
        color: white;
        /* White text on hover */
        transform: scale(1.05);
        /* Slightly enlarge the button on hover */
        transition: all 0.3s ease-in-out;
        /* Smooth transition for all properties */
    }

    /* ...existing code... */

    /* Add these new styles at the end of your CSS file */
    .fade {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    .fade-in {
        opacity: 1;
    }

    .car-image img {
        width: 600px;
        height: 350px;
        max-width: 600px;
        border: 2px solid #f4f4f4;
        border-radius: 10px;
        object-fit: contain;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    /* ...existing code... */

    .active {
        border: 4px solid #007bff;
        opacity: 1;
        transform: scale(1.1);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        z-index: 1;
    }

    .thumbnail {
        width: 80px;
        height: 60px;
        margin: 0 5px;
        cursor: pointer;
        opacity: 0.7;
        transition: all 0.3s ease-in-out;
        position: relative;
        border: 4px solid transparent;
    }

    .thumbnail:hover {
        opacity: 1;
        transform: scale(1.05);
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
    }
</style>
<style>
    thumbnail-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
        padding: 10px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .thumbnail {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border: 2px solid transparent;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        opacity: 0.7;
    }

    .thumbnail:hover {
        opacity: 1;
        transform: scale(1.05);
    }

    .thumbnail.active {
        border-color: #007bff;
        opacity: 1;
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }

    .arrow {
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .arrow:hover {
        background: rgba(0, 0, 0, 0.8);
        transform: scale(1.1);
    }

    .car-image img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        transition: opacity 0.5s ease;
    }
</style>

<body>
    <main>
        <div class="container">
            <div class="car-details">
                <div class="car-image">
                    <img id="mainImage" src="../User/<?php echo $car['image_link']; ?>"
                        alt="<?php echo $car['car_name']; ?>">
                </div>

                <div class="car-info">
                    <h1 class="car-title"><?php echo $car['car_name']; ?></h1>
                    <h2><i class="fas fa-tag"></i> Giá: <?php echo number_format($car['price'], 0, ',', '.'); ?> VND
                    </h2>

                    <div class="car-features">
                        <div class="car-features-left">
                            <p class="car-feature-item"><i class="fas fa-car"></i><strong>Thương Hiệu:</strong>
                                <span style="text-transform: uppercase;">

                                    <?php echo $car['type_name']; ?>
                                </span>
                            </p>
                            <p class="car-feature-item"><i class="fas fa-calendar-alt"></i><strong>Năm Sản
                                    Xuất:</strong> <?php echo $car['year_manufacture']; ?></p>
                            <p class="car-feature-item"><i class="fas fa-gears"></i><strong>Động Cơ:</strong>
                                <?php echo $car['engine_name']; ?></p>
                            <p class="car-feature-item"><i class="fas fa-gear"></i><strong>Mã Lực:</strong>
                                <?php echo $car['engine_power']; ?> HP</p>
                            <p class="car-feature-item"><i class="fas fa-gas-pump"></i><strong>Loại Nhiên Liệu:</strong>
                                <?php echo $car['fuel_name']; ?></p>
                        </div>

                        <div class="car-features-right">
                            <p class="car-feature-item"><i class="fas fa-oil-can"></i><strong>Sức Chứa Nhiên
                                    Liệu:</strong> <?php echo $car['fuel_capacity']; ?></p>
                            <p class="car-feature-item"><i class="fas fa-palette"></i><strong>Màu:</strong>
                                <?php echo $car['color']; ?></p>
                            <p class="car-feature-item"><i class="fas fa-users"></i><strong>Số Chỗ Ngồi:</strong>
                                <?php echo $car['seat_number']; ?> chỗ</p>
                            <p class="car-feature-item"><i class="fas fa-tachometer-alt"></i><strong>Vận Tốc Tối
                                    Đa:</strong> <?php echo $car['max_speed']; ?> km/h</p>
                            <p class="car-feature-item">
                                <i class="fas fa-info-circle"></i><strong>Tình Trạng Xe:</strong>
                                <span class="status-badge status-<?php echo $car['status']; ?>">
                                    <?php
                                    switch ($car['status']) {
                                        case 'selling':
                                            echo 'Đang bán';
                                            break;
                                        case 'discounting':
                                            echo 'Đang giảm giá';
                                            break;
                                        case 'hidden':
                                            echo 'Tạm thời ẩn';
                                            break;
                                        case 'soldout':
                                            echo 'Hết hàng';
                                            break;
                                    }
                                    ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <div class="thumbnail-container">
                <button class="arrow" onclick="prevImage()">&#10094;</button>

                <!-- Main product image thumbnail -->
                <img src="../User/<?php echo $car['image_link']; ?>" class="thumbnail active"
                    alt="<?php echo $car['car_name']; ?>"
                    onclick="changeImage('../User/<?php echo $car['image_link']; ?>', this)">

                <!-- Additional images thumbnails -->
                <?php while ($image = mysqli_fetch_assoc($additional_images_result)): ?>
                    <img src="../User/<?php echo $image['image_url']; ?>" class="thumbnail"
                        alt="<?php echo $car['car_name']; ?>"
                        onclick="changeImage('../User/<?php echo $image['image_url']; ?>', this)">
                <?php endwhile; ?>

                <button class="arrow" onclick="nextImage()">&#10095;</button>
            </div>
        
        <?php if (!empty($car['car_description'])): ?>
            <div class="car-description">
                <h3><i class="fa-solid fa-screwdriver-wrench" style="padding-right: 10px;"></i>Mô Tả:</h3>
                <p><?php echo nl2br($car['car_description']); ?></p>
            </div>
        <?php endif; ?>

        <div class="actions">
            <button class="btn secondary" onclick="history.back()">Trở về</button>
            <?php if ($car['status'] != 'soldout' && $car['status'] != 'hidden'): ?>
                <button class="btn primary" onclick="addToCart(<?php echo $car['product_id']; ?>)">
                    Thêm vào giỏ hàng
                </button>
            <?php endif; ?>
        </div>
        </div>
    </main>
    <script>
        function addToCart(productId) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=1`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Thêm vào giỏ hàng thành công!', 'success');
                        setTimeout(() => {
                            window.location.href = 'cart.php';
                        }, 1500);
                    } else {
                        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                    }
                })
                .catch(error => {
                    showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                });
        }
    </script>
    <script>
        //    function changeImage(imageSrc) {
        //         const mainImage = document.getElementById("mainImage");
        //         mainImage.src = imageSrc;
        //         // imageSrc.classList.add("active");
        //         const thumbnails = document.querySelectorAll('.thumbnail');
        //         thumbnails.forEach(thumbnail => {
        //             thumbnail.classList.remove("active");
        //         });
        //         const activeThumbnail = Array.from(thumbnails).find(thumbnail => thumbnail.src.includes(imageSrc));
        //         if (activeThumbnail) {
        //             activeThumbnail.classList.add("active");
        //         }
        //     }
        function nextImage() {
            const thumbnails = document.querySelectorAll('.thumbnail');
            const activeThumb = document.querySelector('.thumbnail.active');
            let nextThumb = activeThumb.nextElementSibling;

            if (!nextThumb || !nextThumb.classList.contains('thumbnail')) {
                nextThumb = thumbnails[0];
            }

            changeImage(nextThumb.src, nextThumb);
        }

        function prevImage() {
            const thumbnails = document.querySelectorAll('.thumbnail');
            const activeThumb = document.querySelector('.thumbnail.active');
            let prevThumb = activeThumb.previousElementSibling;

            if (!prevThumb || !prevThumb.classList.contains('thumbnail')) {
                prevThumb = thumbnails[thumbnails.length - 1];
            }

            changeImage(prevThumb.src, prevThumb);
        }
        // Replace the existing changeImage function with this updated version:
        function changeImage(src, thumbnail) {
            const mainImage = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail');

            // Fade out effect
            mainImage.style.opacity = '0';

            setTimeout(() => {
                mainImage.src = src;
                // Fade in effect
                mainImage.style.opacity = '1';

                // Update active thumbnail
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                thumbnail.classList.add('active');
            }, 500);
        }

        setInterval(nextImage, 5000);
        // Update the autoChangeImage function to use a longer interval
        function autoChangeImage() {
            const thumbnails = document.querySelectorAll('.thumbnail');
            let currentIndex = Array.from(thumbnails).findIndex(thumbnail => thumbnail.src.includes(document.getElementById('mainImage').src));
            const nextIndex = (currentIndex + 1) % thumbnails.length;
            changeImage(thumbnails[nextIndex].src);
        }
        // setInterval(autoChangeImage, 3000);
        // Changed to 5 seconds to allow for animation


    </script>
</body>

</html>

<?php include 'footer.php'; ?>
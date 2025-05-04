<?php
include 'header.php';
include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Vì sao chọn chúng tôi</title>
</head>
<style>
    .about-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        background-color: #fff;
    }

    .section {
        margin-bottom: 40px;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .section-title {
        color: #007bff;
        font-size: 24px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }

    .section-content {
        color: #444;
        line-height: 1.8;
        font-size: 16px;
        text-align: justify;
    }

    .logo-section {
        text-align: center;
        margin-bottom: 30px;
    }

    .image {
        width: 150px;
        height: auto;
        margin-bottom: 20px;
    }

    .highlight {
        color: #007bff;
        font-weight: bold;
    }
</style>
<style>
    .section {
        margin-bottom: 40px;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .section:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(to right, #007bff, #00ff88);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .section:hover::before {
        transform: scaleX(1);
    }

    .highlight {
        position: relative;
        display: inline-block;
    }

    .highlight::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #007bff;
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.3s ease;
    }

    .highlight:hover::after {
        transform: scaleX(1);
        transform-origin: left;
    }

    .image {
        width: 150px;
        height: auto;
        margin-bottom: 20px;
        transition: transform 0.5s ease;
    }

    .image:hover {
        transform: scale(1.1) rotate(5deg);
    }

    .section-title {
        position: relative;
        overflow: hidden;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(to right, #007bff, transparent);
        animation: borderFlow 2s infinite;
    }

    @keyframes borderFlow {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
    }

    .section-content {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .section.visible .section-content {
        opacity: 1;
        transform: translateY(0);
    }
</style>
<style>
    /* // ...existing styles... */

    .section-title {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .section-title i {
        font-size: 28px;
        color: #007bff;
        transition: transform 0.3s ease;
    }

    .section:hover .section-title i {
        transform: scale(1.2);
    }
</style>

<body>
    <div class="about-container">
        <div class="section" data-aos="fade-up">
            <div class="logo-section">
                <img src="dp56vcf7.png" alt="AutoCar Logo" class="image">

                <h1 class="section-title"><i class="fas fa-star"></i>Vì sao chọn chúng tôi</h1>
            </div>
            <div class="section-content">
                <p><span class="highlight">AUTO CAR</span> là đơn vị chuyên hoạt động trong lĩnh vực kinh doanh các loại
                    xe, đặc biệt là Siêu Xe.</p>
                <p>Với tiêu chí tập trung vào những xe chính hãng, chất lượng cao, còn bảo hành chính hãng và giá cả tối
                    ưu nhất.</p>
                <p>Tất cả các xe bán ra đều được trải qua quy trình kiểm tra nghiêm ngặt để đảm bảo tiêu chuẩn chất
                    lượng cũng như độ an toàn cho khách hàng.</p>
                <p>Ngoài ra, công ty sẽ ký văn bản cam kết để bảo đảm sự minh bạch, trung thực với khách hàng, giúp
                    khách hàng tăng thêm sự yên tâm và tin tưởng vào sản phẩm dịch vụ của chúng tôi.</p>
            </div>
        </div>

        <div class="section" data-aos="fade-up">
            <i class="fas fa-building"></i>
            <h2 class="section-title">Giới thiệu chung</h2>
            <div class="section-content">
                <p>AutoCar là địa chỉ tin cậy dành cho những khách hàng đam mê xe cao cấp, nơi hội tụ những mẫu xe sang
                    trọng từ các thương hiệu danh tiếng trên toàn cầu. Với sứ mệnh mang đến trải nghiệm mua sắm xe hơi
                    trực tuyến an toàn, tiện lợi và đẳng cấp, AutoCar tự hào là cầu nối giữa người tiêu dùng và những
                    sản phẩm xe ô tô chất lượng, được tuyển chọn kỹ lưỡng nhằm đáp ứng mọi tiêu chuẩn khắt khe nhất của
                    khách hàng.</p>
            </div>
        </div>

        <div class="section" data-aos="fade-up">
            <i class="fas fa-desktop"></i>
            <h2 class="section-title">Hệ thống bán hàng trực tuyến hiện đại</h2>
            <div class="section-content">
                <p>Trên nền tảng website hiện đại và thân thiện với người dùng, AutoCar cung cấp đầy đủ thông tin chi
                    tiết về các mẫu xe cao cấp – từ tính năng kỹ thuật, thiết kế nội thất cho đến các chương trình ưu
                    đãi và dịch vụ hậu mãi chu đáo. Mỗi chiếc xe được giới thiệu không chỉ là sản phẩm, mà còn là biểu
                    tượng của đẳng cấp và phong cách sống, giúp khách hàng dễ dàng lựa chọn cho mình chiếc xe phù hợp
                    nhất.</p>
            </div>
        </div>

        <div class="section" data-aos="fade-up">
            <i class="fas fa-users"></i>
            <h2 class="section-title">Đội ngũ chuyên nghiệp và cam kết chất lượng</h2>
            <div class="section-content">
                <p>Đằng sau thành công của AutoCar là đội ngũ nhân viên chuyên nghiệp, giàu kinh nghiệm và luôn đặt sự
                    hài lòng của khách hàng lên hàng đầu. Từ khâu tư vấn đến chăm sóc sau bán hàng, chúng tôi cam kết
                    mang lại trải nghiệm mua xe trực tuyến trọn vẹn, an tâm và đầy cảm hứng. AutoCar luôn nỗ lực đổi mới
                    và cải tiến dịch vụ, nhằm không ngừng khẳng định vị thế hàng đầu trong phân khúc xe cao cấp trực
                    tuyến.</p>
            </div>
        </div>
    </div>
    <script>
        // Add this before closing </body> tag
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize AOS
            AOS.init({
                duration: 1000,
                once: true
            });

            // Intersection Observer for sections
            const sections = document.querySelectorAll('.section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            sections.forEach(section => {
                observer.observe(section);
            });

            // Add data-aos attributes to sections
            sections.forEach((section, index) => {
                section.setAttribute('data-aos', index % 2 === 0 ? 'fade-right' : 'fade-left');
                section.setAttribute('data-aos-delay', index * 100);
            });
        });
    </script>
</body>

</html>
<?php
include 'footer.php';
?>
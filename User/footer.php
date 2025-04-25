
<style>
    .t-i{
    margin-top: 2em;
    color: black;
    font-family: 'calibri';
    text-align: left;
    padding: 20px;
}
#if-ct{

    color: black;
    font-family: 'Times New Roman', Times, serif;
    text-align: left;
    padding: 10px;
}
.image{
    max-width: 25%;

    float: left;
    margin-right: 1em;
margin-bottom: 1em;
}
.image1{
    max-width: 15%;
    margin-right: 1em;
    margin-bottom: 1em;
    float:left;
    border: 1px solid lightblue;
    border-radius: 15px;
    padding:10px;
    margin-top: 5em;
}
main{
    padding-bottom:40px;

}

footer{

    background-color: #F7F7F7;

}
.if{
    padding :10px;
    margin :20px;
    margin-left:320px;
    margin-right: 320px;
    height: 50vh;
    display:flex;
    align-items: flex-start;
}
.if-title{
    margin-top: 1em;
    color: rgb(152,152,155);
    font-family: 'calibri';
    text-align: left;
    font-size: 25px;
    text-transform: uppercase;
}
.ct-title{
    margin-top: 1em;
    color: rgb(152,152,155);
    font-family: 'calibri';
    text-align: left;
    font-size: 25px;
    text-transform: uppercase;
}
.if-text{
    color: rgb(152,152,155);
    font-family: 'calibri';
    margin-left: 5em;
    max-width: 40%;
}
.ct-text{
    color: rgb(152,152,155);
    font-family: 'calibri';
    margin-left: 2em;
    max-width: 40%;
}
.copyright{
    color: rgb(138, 138, 138);
    background-color: rgb(238, 238, 238);
    font-family: 'calibri';
    text-align: center;
    align-items: center;
}
/* Add to your existing styles */
.social-links {
    margin-top: 20px;
    display: flex;
    gap: 15px;
    align-items: center;
}

.social-links a {
    color: #666;
    font-size: 24px;
    transition: all 0.3s ease;
}

.social-links a:hover {
    transform: translateY(-3px) !important;
}

.social-links .fa-facebook:hover { color: #1877f2; }
.social-links .fa-youtube:hover { color: #ff0000; }
.social-links .fa-x-twitter:hover { color: #000000; }
.social-links .fa-github:hover { color: #333; }
.social-links .fa-linkedin:hover { color: #0077b5; }
</style>
<style>
        /* Add these styles to your existing footer styles */
    .if {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .image1 {
        transition: transform 0.3s ease;
    }
    
    .image1:hover {
        transform: rotate(5deg) scale(1.05);
    }
    
    .if-title, .ct-title {
        position: relative;
        overflow: hidden;
    }
    
    .if-title::after, .ct-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: #007bff;
        transition: width 0.3s ease;
    }
    
    .if-title:hover::after, .ct-title:hover::after {
        width: 100px;
    }
    
    /* .ct-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        transition: transform 0.3s ease;
    }
     */
    .ct-item:hover {
        transform: translateX(10px);
    }
    
    .ct-item i {
        color: #007bff;
        transition: transform 0.3s ease;
    }
    
    .ct-item:hover i {
        transform: scale(1.2);
    }
    
    
    
    .copyright {
        position: relative;
        overflow: hidden;
    }
    
    .copyright::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 1px;
        background: linear-gradient(to right, transparent, #007bff, transparent);
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Add hover effects for copyright links */
    .copyright small {
        display: block;
        transition: color 0.3s ease;
    }
    
    .copyright small:hover {
        color: #007bff;
        cursor: pointer;
    }
    
    /* Responsive animations */
    @media (max-width: 768px) {
        .if {
            flex-direction: column;
            height: auto;
        }
        
        .if-text, .ct-text {
            max-width: 100%;
            margin-left: 0;
        }
    }
</style>
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
                <h2 class="ct-title" id="contact">
                    thông tin liên hệ
                </h2>
                 <div class="social-links">
        <a href="https://facebook.com" target="_blank" title="Facebook">
            <i class="fab fa-facebook"></i>
        </a>
        <!-- <a href="https://zalo.me/autocar" target="_blank" title="Zalo">
            <img src="zalo-icon.png" alt="Zalo" style="width: 24px; height: 24px;">
        </a> -->
        <a href="https://youtube.com" target="_blank" title="YouTube">
            <i class="fab fa-youtube"></i>
        </a>
        <a href="https://twitter.com" target="_blank" title="X (Twitter)">
            <i class="fab fa-x-twitter"></i>
        </a>
        <a href="https://github.com" target="_blank" title="GitHub">
            <i class="fab fa-github"></i>
        </a>
        <a href="https://linkedin.com/company" target="_blank" title="LinkedIn">
            <i class="fab fa-linkedin"></i>
        </a>
        <br><br><br><br>
    </div>
                <div class="ct-item">
                    <i class="fa fa-phone" style="line-height: 0.2;"></i>
                    <p>0987654321</p>
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
<!-- <hr style="color: lightslategray;"> -->
<div class="copyright" style=" height: 20vh; " >
    <br><br><br><br>

    <p>Copyright © <?php echo date('Y'); ?> Auto Car. All rights reserved.</p>
    <small>
        Chính sách thanh toán - Chính sách khiếu nại - Chính sách vận chuyển
    </small>  
    <br>
    <small>
        
        Chính sách bảo hành - Chính sách kiểm hàng - Chính sách bảo mật thông tin
    </small>
    <!-- <p style="font-size: large;font-weight: bolder;text-decoration: underline;">Main page by: Huy Nguyen</p> -->
</div>
</footer>
<script>
// Intersection Observer for smooth reveal animations
document.addEventListener('DOMContentLoaded', function() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    // Observe footer elements
    document.querySelectorAll('.ct-item, .social-links a').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.5s ease';
        observer.observe(el);
    });
});
</script>
<?php
include 'header.php';
include 'connect.php';

if(isset($_POST['inbox']))
{
    echo'<script>showNotification("Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ phản hồi lại sớm nhất có thể!","info")</script>';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ - Công Ty Ô Tô</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        } */
    </style>
        <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
    
        .contact-form {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            position: relative;
        }
    
        h1::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: #007bff;
            margin: 10px auto;
            border-radius: 2px;
        }
    
        .form-group {
            margin-bottom: 20px;
        }
    
        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }
    
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
    .logout-btn{
        margin-top: 0px;
    }
        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
            outline: none;
        }
    
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: block;
            margin: 30px auto 0;
        }
    
        button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
    
        .company-info {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #eee;
        }
    
        .company-info h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
        }
    
        .company-info p {
            color: #666;
            margin: 10px 0;
            line-height: 1.6;
        }
    
        .company-info strong {
            color: #2c3e50;
        }
    
        @media (max-width: 768px) {
            .contact-form {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
        <style>
        /* Form animations and effects */
        .contact-form {
            animation: slideIn 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }
    
        .contact-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, #007bff, #00ff88);
            animation: borderFlow 2s infinite;
        }
    
        .form-group {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards;
        }
    
        .form-group:nth-child(1) { animation-delay: 0.2s; }
        .form-group:nth-child(2) { animation-delay: 0.3s; }
        .form-group:nth-child(3) { animation-delay: 0.4s; }
        .form-group:nth-child(4) { animation-delay: 0.5s; }
        .form-group:nth-child(5) { animation-delay: 0.6s; }
    
        input, textarea {
            transition: all 0.3s ease;
        }
    
        input:focus, textarea:focus {
            transform: scale(1.01);
        }
    
        button[type="submit"] {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
    
        button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
            z-index: -1;
        }
    
        button[type="submit"]:hover::before {
            width: 300%;
            height: 300%;
        }
    
        .company-info {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.5s ease forwards 0.7s;
        }
    
        .company-info p {
            position: relative;
            padding-left: 25px;
            transition: transform 0.3s ease;
        }
    
        .company-info p:hover {
            transform: translateX(10px);
        }
    
        @keyframes slideIn {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
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
    
        @keyframes borderFlow {
            0% { left: -100%; }
            100% { left: 100%; }
        }
    
        /* Form validation visual feedback */
        input:valid, textarea:valid {
            border-color: #28a745;
        }
    
        input:invalid:not(:placeholder-shown),
        textarea:invalid:not(:placeholder-shown) {
            border-color: #dc3545;
        }
    </style>
</head>
<body>
        <div class="contact-form">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <form action="contact.php" method="POST">
            <div class="form-group">
                <label for="name">Họ và Tên:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Số Điện Thoại:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="subject">Chủ Đề:</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            
            <div class="form-group">
                <label for="message">Nội Dung:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            
            <button type="submit" name="inbox">Gửi Tin Nhắn</button>
        </form>
    
        <div class="company-info">
            <h2>Thông Tin Công Ty</h2>
            <p><strong>Công Ty TNHH Ô Tô ABC</strong></p>
            <p>📍 Địa chỉ: 123 Đường XYZ, Quận 1, TP.HCM</p>
            <p>📞 Điện thoại: (028) 1234 5678</p>
            <p>📧 Email: contact@autocompany.com</p>
            <p>⏰ Giờ làm việc: Thứ 2 - Chủ Nhật: 8:00 - 20:00</p>
        </div>
    </div>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form field animations
        const formFields = document.querySelectorAll('input, textarea');
        
        formFields.forEach(field => {
            field.addEventListener('focus', function() {
                this.closest('.form-group').style.transform = 'translateX(10px)';
            });
    
            field.addEventListener('blur', function() {
                this.closest('.form-group').style.transform = 'translateX(0)';
            });
        });
    
        // Live validation feedback
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                
                const invalidFields = form.querySelectorAll(':invalid');
                invalidFields.forEach(field => {
                    field.closest('.form-group').style.animation = 'shake 0.5s ease';
                    setTimeout(() => {
                        field.closest('.form-group').style.animation = '';
                    }, 500);
                });
            }
        });
    
        // Add shake animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
        `;
        document.head.appendChild(style);
    });
    </script>
</body>
</html>
<?php
include 'footer.php';
?>
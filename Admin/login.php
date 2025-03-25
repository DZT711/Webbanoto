<?php
session_start();
include '../User/connect.php';

// Check for logout message
if (isset($_SESSION['logout_message'])) {
    echo "<script>
            window.onload = function() {
                showNotification('{$_SESSION['logout_message']}', 'info');
            }
        </script>";
    unset($_SESSION['logout_message']); // Remove the message after showing it
}//need notification features for testing the connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">

    <link rel="icon" href="../User/dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

</head>
<style>
        /* Notification styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #333;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transform: translateX(150%);
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    
        .notification.show {
            transform: translateX(0);
        }
    
        /* Notification types */
        .notification.success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
    
        .notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
    
        .notification.info {
            background-color: #cce5ff;
            color: #004085;
            border-left: 4px solid #007bff;
        }
    
        .notification.warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }
    body{
    background-image: url(download.jpg);
    /* background-size: cover; */
    background-repeat: no-repeat;
}
        /* Responsive design */
        @media (max-width: 768px) {
            .notification {
                width: 90%;
                top: 10px;
                right: 50%;
                transform: translateX(50%) translateY(-100%);
            }
    
            .notification.show {
                transform: translateX(50%) translateY(0);
            }
        }
    
</style>
<style>
        /* Add this to your existing styles */
    .back-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: white;
        text-decoration: none;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .back-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    .back-btn i {
        font-size: 18px;
        transition: transform 0.3s ease;
    }
    
    .back-btn:hover i {
        transform: translateX(-3px);
    }
    
    @media (max-width: 768px) {
        .back-btn {
            top: 10px;
            left: 10px;
            padding: 10px 20px;
            font-size: 14px;
        }
    }
</style>
<style>
    
</style>
<style>
    /* Notification styles */
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 4px;
        background-color: #f8f9fa;
        color: #333;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transform: translateX(150%);
        transition: transform 0.3s ease-in-out;
        z-index: 1000;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .notification.show {
        transform: translateX(0);
    }

    /* Notification types */
    .notification.success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .notification.error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .notification.warning {
        background-color: #fff3cd;
        color: #856404;
        border-left: 4px solid #ffc107;
    }

    .notification.info {
        background-color: #cce5ff;
        color: #004085;
        border-left: 4px solid #007bff;
    }

    /* Login form styles */
    .login-container {
        max-width: 400px;
        margin: 100px auto;
        padding: 20px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    .login-container h2 {
        margin-bottom: 20px;
        color: #fff;
        font-size: 24px;
    }

    .login-container label {
        display: block;
        margin-bottom: 10px;
        color: #fff;
        font-size: 16px;
    }

    .login-container input {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color:#9CB2BD;
    }

    .login-container input:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        outline: none;
    }

    .login-container button {
        background-color: rgb(4, 59, 107);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .login-container button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .notification {
            width: 90%;
            top: 10px;
            right: 50%;
            transform: translateX(50%) translateY(-100%);
        }

        .notification.show {
            transform: translateX(50%) translateY(0);
        }

        .login-container {
            margin: 50px auto;
            padding: 15px;
        }
    }

</style>
<style>
    /* Add at the top of your existing styles */
    /* body {
        margin: 0;
        min-height: 100vh;
        background: linear-gradient(45deg, #1a1a1a, #000033);
        overflow: hidden;
        position: relative;
    } */

    .stars {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
    }

    .star {
        position: absolute;
        background: white;
        border-radius: 50%;
        animation: twinkle var(--duration) infinite;
        opacity: 0;
    }

    @keyframes twinkle {
        0% { opacity: 0; transform: translateY(0); }
        50% { opacity: 1; }
        100% { opacity: 0; transform: translateY(-20px); }
    }

    /* Make login container float above stars */
    .login-container {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>
<style>
    .shooting-star {
        width: 2px !important;
        height: 2px !important;
        background: linear-gradient(90deg, white, transparent) !important;
        animation: shoot 1s linear !important;
        transform: rotate(-45deg);
    }

    @keyframes shoot {
        from {
            transform: translateX(0) translateY(0) rotate(-45deg) scale(1);
            opacity: 1;
        }
        to {
            transform: translateX(200px) translateY(200px) rotate(-45deg) scale(0.2);
            opacity: 0;
        }
    }
/* Add to your existing styles */
.starlight-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
    background: linear-gradient(45deg, rgba(0,0,0,0.3), rgba(0,0,51,0.3));
}

.stars {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 2;
}

/* .star {
    position: absolute;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    animation: twinkle var(--duration) infinite;
    opacity: 0;
    mix-blend-mode: screen;
} */

@keyframes twinkle {
    0% { opacity: 0; transform: translateY(0); }
    50% { opacity: 0.8; }
    100% { opacity: 0; transform: translateY(-20px); }
}

/* .shooting-star {
    width: 2px !important;
    height: 2px !important;
    background: linear-gradient(90deg, rgba(255,255,255,0.8), transparent) !important;
    animation: shoot 1s linear !important;
    transform: rotate(-45deg);
    mix-blend-mode: screen;
} */

@keyframes shoot {
    from {
        transform: translateX(-100px) translateY(-100px) rotate(-45deg) scale(1);
        opacity: 1;
    }
    to {
        transform: translateX(200px) translateY(200px) rotate(-45deg) scale(0.2);
        opacity: 0;
    }
}
/* Update star sizes and animations */
.star {
    position: absolute;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    animation: twinkle var(--duration) infinite;
    opacity: 0;
    mix-blend-mode: screen;
    box-shadow: 0 0 4px rgba(255, 255, 255, 0.8);
}

/* Make shooting stars bigger */
.shooting-star {
    width: 4px !important;
    height: 4px !important;
    background: linear-gradient(90deg, rgba(255,255,255,0.9), transparent) !important;
    box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
}

</style>
<style>
    /* Password field styles */
    .password-field {
        position: relative;
        width: 100%;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 35%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        transition: all 0.3s ease;
        padding: 5px;
    }

    .password-toggle:hover {
        color: #007bff;
    }

    /* Adjust input padding to accommodate the icon */
    .password-field input {
        padding-right: 35px;
    }
</style>
<body>
        <!-- Add this right after <body> tag -->
    <a href="../User/index.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
        Trở về
    </a>
    <div id="notification" class="notification"></div>
    <div class="login-container">
        <h2>Login</h2>
        <form id="admin-login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="username"><i class="fa-regular fa-user">&nbsp;&nbsp;</i>Username:</label>
            <input type="text" id="username" name="usn" class="input" required>
            
            <label for="password"><i class="fa-solid fa-lock">&nbsp;&nbsp;</i>Password:</label>
            <div class="password-field">
                <input type="password" id="password" name="pass" class="input" required>
                <i class="fa-solid fa-eye-slash password-toggle" id="togglePassword"></i>
            </div>
            
            <button type="submit" name="login" id="btn">Login</button>
        </form>
        <!-- <p id="error-message" style="color: red; display: none;">Invalid username or password. Please try again.</p> -->
    </div>

    <script>
        function showNotification(message, type) {
        const notification = document.getElementById('notification');
        let icon = '';
        
        // Set icon based on notification type
        switch(type) {
            case 'success':
                icon = '<i class="fa-solid fa-circle-check"></i>';
                break;
            case 'error':
                icon = '<i class="fa-solid fa-circle-xmark"></i>';
                break;
            case 'warning':
                icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                break;
            case 'info':
                icon = '<i class="fa-solid fa-circle-info"></i>';
                break;
        }
        
        notification.innerHTML = `${icon} ${message}`;
        notification.className = `notification ${type}`;
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Hide notification after 5 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.textContent = '';
            }, 300);
        }, 5000);
    }
    </script>
        <script>
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            let icon = '';
            
            // Set icon based on notification type
            switch(type) {
                case 'success':
                    icon = '<i class="fa-solid fa-circle-check"></i>';
                    break;
                case 'error':
                    icon = '<i class="fa-solid fa-circle-xmark"></i>';
                    break;
                case 'warning':
                    icon = '<i class="fa-solid fa-triangle-exclamation"></i>';
                    break;
                case 'info':
                    icon = '<i class="fa-solid fa-circle-info"></i>';
                    break;
            }
            
            notification.innerHTML = `${icon} ${message}`;
            notification.className = `notification ${type}`;
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Hide notification after 5 seconds
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    notification.textContent = '';
                }, 300);
            }, 5000);
        }
        // Replace your existing createStars function
 function createStars() {
     const overlay = document.createElement('div');
     overlay.className = 'starlight-overlay';
     document.body.appendChild(overlay);
 
     const stars = document.createElement('div');
     stars.className = 'stars';
     document.body.appendChild(stars);
 
      for (let i = 0; i < 100; i++) {
        const star = document.createElement('div');
        star.className = 'star';
        
        // Random position
        star.style.left = `${Math.random() * 100}%`;
        star.style.top = `${Math.random() * 100}%`;
        
        // Bigger random size (increased from 2 to 4)
        const size = `${Math.random() * 4}px`;
        star.style.width = size;
        star.style.height = size;
        
        // Random animation duration
        star.style.setProperty('--duration', `${2 + Math.random() * 4}s`);
        
        // Random delay
        star.style.animationDelay = `${Math.random() * 4}s`;
        
        stars.appendChild(star);
    }
 }
 
 // Add this function to create shooting stars
 function createShootingStar() {
     const stars = document.querySelector('.stars');
     if (!stars) return;
 
     const shootingStar = document.createElement('div');
     shootingStar.className = 'star shooting-star';
     shootingStar.style.left = `${Math.random() * 100}%`;
     shootingStar.style.top = `${Math.random() * 50}%`;
     stars.appendChild(shootingStar);
     
     setTimeout(() => shootingStar.remove(), 1000);
 }
 
 // Initialize
 document.addEventListener('DOMContentLoaded', () => {
     createStars();
     setInterval(createShootingStar, 8000);
 });
    </script>
        <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
    
        togglePassword.addEventListener('click', function() {
            // Toggle password visibility
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
            
            // Add click animation
            this.style.transform = 'translateY(-50%) scale(0.8)';
            setTimeout(() => {
                this.style.transform = 'translateY(-50%) scale(1)';
            }, 100);
        });
    </script>
</body>
</html>
<?php
if ($connect) {
    // echo "<script>
    //         showNotification('Database connected successfully', 'success');
    //     </script>";
} else {
    echo "<script>
            showNotification('Database connection failed ', 'error');
        </script>";
}
if (isset($_POST['login'])) {
    $username = filter_input(INPUT_POST, "usn", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
        echo "<script>showNotification('Bạn cần phải nhập tất cả thông tin để đăng nhập', 'warning');</script>";
        exit();
    } else {
        $sql = "SELECT * FROM users_acc WHERE username='$username'";
        $result = mysqli_query($connect, $sql);

        // First check if username exists
        if (mysqli_num_rows($result) === 0) {
            echo "<script>showNotification('Tên đăng nhập hoặc mật khẩu không đúng!!', 'warning');</script>";
            exit();
        }

        // Only fetch row if username exists
        $row = mysqli_fetch_assoc($result);

        // Now check password
        if ($row["password"] != $password) {
            echo "<script>showNotification('Tên đăng nhập hoặc mật khẩu không đúng!!', 'warning');</script>";
            exit();
        }

        // Check account status
        if ($row['status'] == 'banned' || $row['status'] == 'disabled') {
            $viestatus = ($row['status'] == 'banned') ? 'cấm' : 'vô hiệu hóa';
            echo "<script>showNotification('Tài khoản của bạn hiện bị {$viestatus}. Vui lòng liên hệ với quản trị viên để biết thêm thông tin', 'error');</script>";
            exit();
        }

        if ($row['role'] != 'admin') {
            echo "<script>showNotification('Bạn không có quyền truy cập trang này', 'error');</script>";
            exit();
        }
        else{

            // Login successful
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["email"] = $row["email"];
        $_SESSION["status"] = $row["status"];
        $_SESSION["phone_num"] = $row["phone_num"];
        $_SESSION["register_date"] = $row["register_date"];
        $_SESSION["role"] = $row["role"];
        $_SESSION['first_login'] = true;
        $_SESSION['full_name'] = null;
        $_SESSION['address'] = null;

        echo "<script>showNotification('Đăng nhập thành công. Vui lòng chờ một lát...', 'success');</script>";
        echo "<script>
        setTimeout(function() {
            window.location.href = 'index.php';
            }, 1000);
            </script>";
            
        }
    }
}
?>

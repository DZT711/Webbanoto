<?php
    session_start();
    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
    $password = isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : '';
    $email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
    $status = isset($_SESSION['status']) ? htmlspecialchars($_SESSION['status']) : '';
    $phone_num = isset($_SESSION['phone_num']) ? htmlspecialchars($_SESSION['phone_num']) : ''; // Removed $ from key
    $register_date = isset($_SESSION['register_date']) ? htmlspecialchars($_SESSION['register_date']) : ''; // Removed $ from key
    if (isset($_POST["logout"])) {
        session_destroy();
        session_start();
        
        $_SESSION['logout_message'] = "Bạn đã đăng xuất thành công.";
        header("Location: login.php");
        exit();
    }
    // Add this new variable for first login check
$showLoginNotification = false;
if (isset($_SESSION['first_login']) && $_SESSION['first_login'] === true) {
    $showLoginNotification = true;
    $_SESSION['first_login'] = false; // Reset the flag
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title></title> -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <script src="index.js"></script>
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <script src="https://kit.fontawesome.com/8341c679e5.js" crossorigin="anonymous"></script>

        <style>
            
               .navbar {
            background-color: #f8f9fa;
            
            text-transform: uppercase;
            font-weight: bold;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 0 200px; /* Add horizontal margins */
            height: 50px;
            
        }
        
        .nav-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .nav-link {
            color: rgb(109,110,113);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background-color: #e9ecef;
            color: #007bff;
        }
        
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 4px;
            z-index: 1000;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-content a {
            color: rgb(109,110,113);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }
        
        .dropdown-content a:hover {
            background-color: #f8f9fa;
            color: #007bff;
        }
        
        .nav-right {
            display: flex;
            gap: 2rem;
        }
        
        .hotline {
            color: #333;
            font-weight: 500;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 0.5rem;
            }
        
            .nav-left {
                flex-direction: column;
                width: 100%;
            }
        
            .nav-right {
                flex-direction: column;
                align-items: center;
                margin-top: 1rem;
                gap: 0.5rem;
            }
        
            .dropdown-content {
                position: static;
                width: 100%;
                box-shadow: none;
            }
        }
        header {
        
        align-items: center;

    }
    
    </style>
        <style>

.logo{
display: flex;
justify-content: center;
}
body {
    font-family: Arial, sans-serif;
}
</style>
<style>
       /* Add these styles to your existing CSS */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2000;
        animation: fadeIn 0.3s;
    }
    
    .modal-content {
        position: relative;
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        width: 90%;
        max-width: 400px;
        border-radius: 8px;
        text-align: center;
        animation: slideIn 0.3s;
    }
    
    .confirm-btn, .cancel-btn {
        padding: 10px 20px;
        margin: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .confirm-btn {
        background-color: #dc3545;
        color: white;
    }
    
    .cancel-btn {
        background-color: #6c757d;
        color: white;
    }
    
    .confirm-btn:hover {
        background-color: #c82333;
    }
    
    .cancel-btn:hover {
        background-color: #5a6268;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from { transform: translateY(-100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .modal-content {
            margin: 30% auto;
        }
    }
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
        /* Add these styles to your existing CSS */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 2000;
        animation: fadeIn 0.3s;
    }
    
    .modal-content {
        position: relative;
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        width: 90%;
        max-width: 400px;
        border-radius: 8px;
        text-align: center;
        animation: slideIn 0.3s;
    }
    
    .confirm-btn, .cancel-btn {
        padding: 10px 20px;
        margin: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .confirm-btn {
        background-color: #dc3545;
        color: white;
    }
    
    .cancel-btn {
        background-color: #6c757d;
        color: white;
    }
    
    .confirm-btn:hover {
        background-color: #c82333;
    }
    
    .cancel-btn:hover {
        background-color: #5a6268;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideIn {
        from { transform: translateY(-100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @media (max-width: 768px) {
        .modal-content {
            margin: 30% auto;
        }
    }
</style>
<style>
    

.login-register a {
    margin: 0 10px;
    text-decoration: none;
    color: #333;
}

.form {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.form .lg-rgt-title {
    margin-top: 0;
}

.form label {
    display: block;
    margin: 10px 0 5px;
}

.form input {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

.form button {
    padding: 10px 15px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form button:hover {
    background-color: #0056b3;
}


.login-register-ctn {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    max-height: 100vh;
    
}

.login-register {
    padding-top: 15px;

}

.login-register a {
    margin: 0 10;
}
.login-register a:hover {
    margin: 0 10;
text-decoration: underline;
color:lightslategray;
}
</style>
<style>
        /* Add to your existing CSS */
    .login-register-ctn {
        background-color: #f0f0f0;
        padding-right: 200px;
        display: flex;
        justify-content: flex-end;
        height: 50px;
    }
    
    .login-register {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-top: 20px;
    }
    
    .user-greeting {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #333;
    }
    
    .username-link {
        color: #007bff;
        text-decoration: none;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 5px;
        
    }
    
    .username-link:hover {
        text-decoration: underline;
        color: #0056b3;
    }
    
    .logout-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: background-color 0.3s;
    }
    
    .logout-btn:hover {
        background-color: #c82333;
    }
    
    .auth-link {
        color: #333;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .auth-link:hover {
        color: #007bff;
    }
    
    .separator {
        color: #666;
    }
    
    @media (max-width: 768px) {
        .login-register-ctn {
            justify-content: center;
        }
        
        .login-register {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
    <body>
    <header>
    <div id="notification" class="notification"></div>
        <div class="logo">
            <a class="nav" href="index.php">
                <img src="dp56vcf7.png" alt="logo"    height="120px" >
            </a>
        </div>
    </header>
        <!-- Replace the entire login-register-ctn div with this -->
    <div class="login-register-ctn">
        <div class="login-register">
            <?php if(isset($_SESSION['username'])): ?>
                <!-- Logged in state -->
                 <br><br>
                <span class="user-greeting">
                    <span>Xin chào,</span>
                    <a href="userinfor.php" class="username-link">
                        <i class="fa-regular fa-user"></i>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <button type="button"
                            id="logout-btn" 
                            onclick="showLogoutModal(event)"
                            class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Đăng xuất
                    </button>
                </span>
            <?php else: ?>
                <!-- Not logged in state -->
                <a href="login.php" id="login-btn" class="auth-link">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Đăng nhập
                </a>
                <span class="separator">|</span>
                                <!-- Replace the sign up link with this -->
                                <!-- Replace the existing signup link -->
                <a href="login.php#signup" class="auth-link">
                    <i class="fas fa-user-plus"></i>
                    Đăng ký
                </a>
                <span class="separator">|</span>
            <?php endif; ?>
        </div>
    </div>

    <hr>

        <nav class="navbar">

        <div class="nav-left">
            <a href="index.php" class="nav-link homelink">
                <i class="fa-solid fa-house"></i> Trang Chủ
            </a>
            
            <div class="dropdown">
                <a href="#" class="nav-link dropbtn">
                    <i class="fa-solid fa-car"></i> Xe Đang Bán 
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <a href="#ds-md">
                        <i class="fa-solid fa-tag"></i> Thương Hiệu
                    </a>
                    <a href="more.php">
                        <i class="fa-solid fa-money-bill"></i> Mức Giá
                    </a>
                    <a href="more.php">
                        <i class="fa-solid fa-calendar"></i> Năm Sản Xuất
                    </a>
                </div>
            </div>
    
            <!-- <a href="billhistory.php" class="nav-link">
                <i class="fa-solid fa-clock-rotate-left"></i> Lịch sử mua hàng
            </a> -->
            <a href="#about" class="nav-link">
                <i class="fa-solid fa-info-circle"></i> Giới Thiệu
            </a>
            <a href="#contact" class="nav-link">
                <i class="fa-solid fa-envelope"></i> Liên Hệ
            </a>
            <a href="../Admin/login.php" class="nav-link">
                <i class="fa-solid fa-user-shield"></i> Admin
            </a>
        </div>

        <div class="nav-right" id="tlp">
            <span class="hotline">
                <i class="fa-solid fa-phone"></i> Hotline 1: 090 123 4567
            </span>
            <span class="hotline">
                <i class="fa-solid fa-phone"></i> Hotline 2: 080 123 4567
            </span>
        </div>
    </nav>
<!-- Add this right before closing </body> tag -->
<div id="logoutModal" class="modal">
    <div class="modal-content">
        <h3>Xác nhận đăng xuất</h3>
        <p>Bạn có chắc chắn muốn đăng xuất không?</p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="submit" name="logout" value="Đăng xuất" class="confirm-btn">
            <button type="button" class="cancel-btn" onclick="closeLogoutModal()">Hủy</button>
        </form>
    </div>
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
    <?php if ($showLoginNotification): ?>
    showNotification("Đăng nhập thành công. Chào mừng <?php echo htmlspecialchars($username); ?>!", "success");
    <?php endif; ?>        // showNotification('Login successful!', 'success');
    // showNotification('Error occurred!', 'error');
    // showNotification('Please wait...', 'info');
    // showNotification('Warning message', 'warning');
    </script>
    <script>
                // Add this JavaScript before the closing </body> tag
        
        function showLogoutModal(event) {
            event.preventDefault();
            document.getElementById('logoutModal').style.display = 'block';
        }
        
        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('logoutModal');
            if (event.target == modal) {
                closeLogoutModal();
            }
        }
        
    </script>

</body>

</html>
<?php
    // session_destroy();
    // header('Location: index.php');
    // exit();
?>
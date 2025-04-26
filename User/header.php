<?php
session_start();
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '';
$password = isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : '';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
$status = isset($_SESSION['status']) ? htmlspecialchars($_SESSION['status']) : '';
$phone_num = isset($_SESSION['phone_num']) ? htmlspecialchars($_SESSION['phone_num']) : ''; // Removed $ from key
$register_date = isset($_SESSION['register_date']) ? htmlspecialchars($_SESSION['register_date']) : '';
// Removed $from key
$full_name = isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : '';
$address = isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : '';
$role = isset($_SESSION['role'])
    ? htmlspecialchars($_SESSION['role']) : '';
if (isset($_POST["logout"])) {
    session_destroy();
    session_start();
    $_SESSION['logout_message'] = "Bạn đã đăng xuất thành công.";
    header("Location: login.php");
    exit();
} // Add thisnew variable for first login check
$showLoginNotification = false;
if (isset($_SESSION['first_login']) && $_SESSION['first_login'] === true) {
    $showLoginNotification = true;
    $_SESSION['first_login'] = false; // Reset the flag 
}
include 'connect.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0 100px;
            /* Add horizontal margins */
            height: 50px;

        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            color: rgb(109, 110, 113);
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
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 1000;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: rgb(109, 110, 113);
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
        .logo {
            display: flex;
            justify-content: center;
            background-color: white;
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

        .confirm-btn,
        .cancel-btn {
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
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .confirm-btn,
        .cancel-btn {
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
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .modal-content {
                margin: 30% auto;
            }
        }
    </style>
    <style>
        .login-register-ctn {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;

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
            color: lightslategray;
        }
    </style>
    <style>
        /* Add to your existing CSS */
        .login-register-ctn {
            background-color: rgb(230, 230, 230);
            /* padding-right: 200px; */
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

            color: #333;
        }

        .username-link {
            color: gray;
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
    <style>
        /* Add these styles to your existing navbar styles */
        .brand-dropdown {
            position: relative;
        }

        .sub-dropdown {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            background-color: #fff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .brand-dropdown:hover .sub-dropdown {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .brand-dropdown>a {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sub-dropdown a {
            padding: 12px 16px;
            color: rgb(109, 110, 113);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .sub-dropdown a:hover {
            background-color: #f8f9fa;
            color: #007bff;
            padding-left: 20px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <style>
        /* Update these styles in your header.php */
        .user-greeting {
            display: flex;
            align-items: center;
            /* Increased gap */
            color: #333;
            font-size: 14px;
            /* Base font size */
            padding-top: 5px;
        }

        .username-link {
            color: gray;
            text-decoration: none;
            font-weight: 600;
            /* Slightly bolder */
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .username-link:hover {
            background-color: rgba(0, 123, 255, 0.1);
            color: #0056b3;
        }

        .logout-btn {
            background-color: transparent;
            /* Changed to transparent */
            color: #dc3545;
            /* Red text */
            border: 1px solid #dc3545;
            /* Red border */
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            height: 35px;
            /* Fixed height */
        }

        .logout-btn:hover {
            background-color: #dc3545;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(220, 53, 69, 0.2);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        .logout-btn i {
            font-size: 14px;
            /* Match icon size */
        }

        /* Additional professional touches */
        .loggedin {
            display: flex;
            align-items: center;
            padding: 5px 15px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    </style>
    <style>
        .login-register-ctn {
            padding: 0 70px;
            /* Match navbar padding */
            display: flex;
            justify-content: flex-end;
            height: 50px;
            /* border-bottom: 1px solid rgb(190, 190, 190);  */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .login-register {
            display: flex;
            align-items: center;
            height: 100%;
            /* gap: 15px; */
        }

        /* Logged in state styles */
        .loggedin {
            display: flex;
            align-items: center;

            background-color: #f0f0f0;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .user-greeting {
            display: flex;
            align-items: center;
            /* gap: 15px; */
            color: #495057;
            font-size: 14px;
        }

        .username-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            /* gap: 8px; */
            padding: 6px 12px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .username-link:hover {
            background-color: rgba(0, 123, 255, 0.1);
            color: #0056b3;
        }

        .logout-btn {
            background-color: transparent;
            color: #dc3545;
            border: 1px solid #dc3545;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #dc3545;
            color: white;
        }

        /* Not logged in state styles */
        .notlogin {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px 15px;
        }

        .auth-link {
            color: #495057;
            text-decoration: none;
            display: flex;
            align-items: center;
            /* gap: 8px; */
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .auth-link:hover {
            background-color: rgba(0, 123, 255, 0.1);
            color: #007bff;
        }

        .separator {
            color: #333;
            margin: 0 5px;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .login-register-ctn {
                padding: 0 20px;
                justify-content: center;
            }

            .login-register {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    <style>
        /* Logo animations */
        .logo a img {
            transition: transform 0.3s ease;
        }

        .logo a:hover img {
            transform: scale(1.05);
        }

        /* Navbar animations */
        .navbar {
            animation: slideInDown 0.5s ease;
            transition: box-shadow 0.3s ease;
        }

        .navbar:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Navigation link effects */
        .nav-link {
            position: relative;
            overflow: hidden;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #007bff;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        /* Dropdown animations */
        .dropdown-content {
            transform-origin: top;
            transition: transform 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            transform: scaleY(0);
        }

        .dropdown:hover .dropdown-content {
            opacity: 1;
            transform: scaleY(1);
        }

        /* Sub-dropdown animations */
        .sub-dropdown {
            transition: transform 0.3s ease, opacity 0.3s ease;
            transform: translateX(-10px);
            opacity: 0;
        }

        .brand-dropdown:hover .sub-dropdown {
            transform: translateX(0);
            opacity: 1;
        }

        /* Hotline pulse effect */
        .hotline i {
            animation: pulse 2s infinite;
        }

        /* User greeting animations */
        .user-greeting {
            animation: fadeInRight 0.5s ease;
        }

        .username-link {
            transition: all 0.3s ease;
        }

        .username-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
        }

        /* Logout button animations */
        .logout-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .logout-btn:hover::before {
            width: 300%;
            height: 300%;
        }

        /* Notification refinements */
        .notification {
            animation: slideInRight 0.5s ease;
        }

        /* New keyframe animations */
        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Page load animation */
        body {
            animation: fadeIn 0.5s ease;
        }

        /* Responsive animations */
        @media (max-width: 768px) {
            .navbar {
                animation: fadeIn 0.5s ease;
            }

            .nav-left {
                animation: slideInDown 0.5s ease;
            }
        }

        /* Updated dropdown animations */
        .dropdown-content {
            transform-origin: top;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
        }

        .dropdown-content a {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transition-delay: calc(var(--index) * 0.1s);
        }

        .dropdown:hover .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown:hover .dropdown-content a {
            opacity: 1;
            transform: translateX(0);
        }

        /* Enhanced sub-dropdown animations */
        .sub-dropdown {
            transform-origin: left center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            visibility: hidden;
            transform: translateX(-20px) scaleX(0.9);
        }

        .sub-dropdown a {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transition-delay: calc(var(--index) * 0.1s);
        }

        .brand-dropdown:hover .sub-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateX(0) scaleX(1);
        }

        .brand-dropdown:hover .sub-dropdown a {
            opacity: 1;
            transform: translateX(0);
        }

        /* Updated logout modal animations */
        .modal {
            display: none;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
            display: block;
        }

        .modal-content {
            transform: scale(0.7) translateY(-50px);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal.show .modal-content {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        /* Updated buttons animations */
        .confirm-btn,
        .cancel-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .confirm-btn::before,
        .cancel-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .confirm-btn:hover::before,
        .cancel-btn:hover::before {
            width: 300%;
            height: 300%;
        }
    </style>
    <style>
        /* Add these styles after your existing dropdown styles */
        .price-dropdown {
            position: relative;
        }

        .price-dropdown .sub-dropdown {
            min-width: 220px;
            /* Wider to accommodate price ranges */
        }

        .price-dropdown .sub-dropdown a {
            white-space: nowrap;
            padding: 12px 10px;
        }

        .price-dropdown .sub-dropdown a i {
            color: #1abc9c;
            width: 20px;
            text-align: center;
        }

        .price-dropdown:hover .sub-dropdown {
            display: block;
        }

        .price-dropdown .sub-dropdown a:hover {
            background-color: #f8f9fa;
            color: #007bff;
            padding-left: 25px;
        }
    </style>
    <style>
        .nav-search {
            display: flex;
            align-items: center;
            position: relative;
        }

        .nav-search input[type="text"] {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 20px 0 0 20px;
            outline: none;
            transition: all 0.3s ease;
            font-size: 14px;
            width: 170px;
        }

        .nav-search input[type="text"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
            width: 200px;
        }

        .nav-search button {
            padding: 6px 12px;
            border: none;
            background-color: #DCDCDC;
            color: white;
            border-radius: 0 20px 20px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
            height: 30px;
        }

        .nav-search button:hover {
            background-color: #0056b3;
        }

        .nav-search i.fa-search {
            font-size: 14px;
        }
    </style>
    <style>
        /* #tlp {
  display: flex;           /* đảm bảo flex 
  flex-direction: column;  /* xếp dọc: item 2 xuống dưới item 1 
  align-items: flex-start; /* canh trái (tuỳ chỉnh) 
  gap: 0.25rem;            /* khoảng cách giữa 2 dòng 
  font-size: 14px;       /* kích thước chữ 
} */
        #tlp {
            font-size: 14px;
        }

        .dropbtn {
            font-weight: bold;
        }

        /* Enhanced login-register-ctn styles */
        .login-register-ctn {
            padding: 0 70px;
            display: flex;
            justify-content: flex-end;
            height: 50px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .login-register {
            display: flex;
            align-items: center;
            height: 100%;
            gap: 20px;
        }

        /* Logged in state */
        .loggedin {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            background: white;
            border-radius: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .loggedin:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .user-greeting {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #495057;
        }

        .username-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 20px;
            transition: all 0.3s ease;
            background: rgba(0, 123, 255, 0.1);
        }

        .username-link:hover {
            background: rgba(0, 123, 255, 0.2);
            transform: translateY(-1px);
        }

        /* Not logged in state */
        .notlogin {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 8px;
            background: white;
            border-radius: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .auth-link {
            color: #495057;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .auth-link:hover {
            color: #007bff;
            background: rgba(0, 123, 255, 0.1);
            transform: translateY(-1px);
        }

        .auth-link i {
            transition: transform 0.3s ease;
        }

        .auth-link:hover i {
            transform: scale(1.2);
        }

        .separator {
            color: #dee2e6;
            margin: 0 5px;
            font-weight: 300;
        }

        /* Cart link specific styles */
        .auth-link.cart-link {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .auth-link.cart-link:hover {
            background: rgba(40, 167, 69, 0.2);
            color: #218838;
        }

        /* Animations */
        @keyframes slideDown {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-register-ctn {
            animation: slideDown 0.5s ease-out;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .login-register-ctn {
                padding: 0 20px;
            }

            .notlogin {
                flex-wrap: wrap;
                justify-content: center;
            }

            .auth-link {
                padding: 6px 10px;
                font-size: 13px;
            }
        }
    </style>

<body>
    <header>
        <div id="notification" class="notification"></div>
        <div class="logo">
            <a class="nav" href="index.php">
                <img src="dp56vcf7.png" alt="logo" height="120px">
            </a>
        </div>
    </header>
    <!-- Replace the entire login-register-ctn div with this -->


    <nav class="navbar">

        <div class="nav-left">
            <a href="index.php" class="nav-link homelink">
                <i class="fa-solid fa-house"></i> Trang Chủ
            </a>

            <div class="dropdown">
                <a href="#" class="nav-link dropbtn">
                    <i class="fa-solid fa-car"></i> các loại xe
                    <i class="fa fa-caret-down"></i>
                </a>
                <!-- Replace the existing dropdown-content div in header.php -->
                <!-- // Replace the static sub-dropdown div with this dynamic version -->
                <div class="dropdown-content">
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa-solid fa-tag"></i> Thương Hiệu
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <?php
                            // Query to get all car types/brands
                            $brand_query = "SELECT * FROM car_types ORDER BY type_name";
                            $brand_result = mysqli_query($connect, $brand_query);

                            if ($brand_result && mysqli_num_rows($brand_result) > 0) {
                                while ($brand = mysqli_fetch_assoc($brand_result)) {
                                    echo '<a href="brand.php?type=' . urlencode($brand['type_name']) . '">';
                                    echo '<i class="fa-solid fa-car"></i> ' . htmlspecialchars($brand['type_name']);
                                    echo '</a>';
                                }
                            } else {
                                echo '<a href="#">';
                                echo '<i class="fa-solid fa-exclamation-triangle"></i> Không có thương hiệu';
                                echo '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    <!-- // Replace the existing price link with this dropdown structure -->
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa-solid fa-money-bill"></i> Mức Giá
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <a href="search-results.php?price_max=99999999">
                                <i class="fa-solid fa-coins"></i> Dưới 100 triệu
                            </a>
                            <a href="search-results.php?price_min=100000000&price_max=500000000">
                                <i class="fa-solid fa-coins"></i> Từ 100 triệu đến 500 triệu
                            </a>
                            <a href="search-results.php?price_min=500000000&price_max=1000000000">
                                <i class="fa-solid fa-coins"></i> Từ 500 triệu đến 1 tỷ
                            </a>
                            <a href="search-results.php?price_min=1000000000&price_max=5000000000">
                                <i class="fa-solid fa-coins"></i> từ 1 tỷ đến 5 tỷ
                            </a>
                            <a href="search-results.php?price_min=5000000000&price_max=10000000000">
                                <i class="fa-solid fa-coins"></i> từ 5 tỷ đến 10 tỷ
                            </a>
                            <a href="search-results.php?price_min=10000000001">
                                <i class="fa-solid fa-coins"></i> trên 10 tỷ
                            </a>

                        </div>
                    </div>
                    <!-- // Replace the existing year link with this dropdown structure -->
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa-solid fa-calendar"></i> Năm Sản Xuất
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <?php
                            // Query to get distinct years from products
                            $year_query = "SELECT DISTINCT year_manufacture FROM products WHERE status IN ('selling', 'discounting') ORDER BY year_manufacture ASC";
                            $year_result = mysqli_query($connect, $year_query);

                            if ($year_result && mysqli_num_rows($year_result) > 0) {
                                while ($year = mysqli_fetch_assoc($year_result)) {
                                    echo '<a href="search-results.php?year_min=' . $year['year_manufacture'] . '&year_max=' . $year['year_manufacture'] . '">';
                                    echo '<i class="fa-solid fa-calendar-day"></i> Năm ' . htmlspecialchars($year['year_manufacture']);
                                    echo '</a>';
                                }
                            } else {
                                echo '<a href="#">';
                                echo '<i class="fa-solid fa-exclamation-triangle"></i> Không có dữ liệu năm';
                                echo '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa-solid fa-car-side"></i> Tình Trạng Xe
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <a href="search-results.php?status=selling">
                                <i class="fa-solid fa-car"></i> Đang bán
                            </a>
                            <a href="search-results.php?status=discounting">
                                <i class="fa-solid fa-car"></i> Giảm giá
                            </a>
                            <a href="search-results.php?status=soldout">
                                <i class="fa-solid fa-car"></i> Hết hàng
                            </a>
                        </div>
                    </div>
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa-solid fa-gas-pump"></i>
                            loại nhiên liệu
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <a href="search-results.php?fuel=petrol">
                                <i class="fa-solid fa-gas-pump"></i> Xăng
                            </a>
                            <a href="search-results.php?fuel=diesel">
                                <i class="fa-solid fa-gas-pump"></i> Diesel
                            </a>
                            <a href="search-results.php?fuel=electric">
                                <i class="fa-solid fa-bolt"></i> Điện
                            </a>
                            <a href="search-results.php?fuel=hybrid">
                                <i class="fa-solid fa-car-battery"></i> Hybrid
                            </a>
                        </div>
                    </div>
                    <!-- <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa-solid fa-paint-brush"></i>
                            màu xe
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <?php
                            // $color_query = "SELECT DISTINCT color FROM products WHERE status IN ('selling', 'discounting') ORDER BY color ASC";
                            // $color_result = mysqli_query($connect, $color_query);
                            

                            // if ($color_result && mysqli_num_rows($color_result) > 0) {
                            //     while ($color = mysqli_fetch_assoc($color_result)) {
                            //         echo '<a href="search-results.php?color=' . urlencode($color['color']) . '">';
                            //         echo '<i class="fa-solid fa-paint-brush"></i> Màu ' . htmlspecialchars($color['color']);
                            //         echo '</a>';
                            //     }
                            // } else {
                            //     echo '<a href="#">';
                            //     echo '<i class="fa-solid fa-exclamation-triangle"></i> Không có dữ liệu màu';
                            //     echo '</a>';
                            // }
                            ?>

                        </div>
                    </div> -->
                    <div class="brand-dropdown">
                        <a href="" class="nav-link dropbtn">
                            <i class="fa fa-gear"></i>
                            động cơ
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <?php
                            $engine_query = "SELECT DISTINCT engine_name FROM products WHERE status IN ('selling', 'discounting') ORDER BY engine_name ASC";
                            $engine_result = mysqli_query($connect, $engine_query);
                            if ($engine_result && mysqli_num_rows($engine_result) > 0) {
                                while ($engine = mysqli_fetch_assoc($engine_result)) {
                                    echo '<a href="search-results.php?engine=' . urlencode($engine['engine_name']) . '">';
                                    echo '<i class="fa-solid fa-car-battery"></i> ' . htmlspecialchars($engine['engine_name']);
                                    echo '</a>';
                                }
                            } else {
                                echo '<a href="#">';
                                echo '<i class="fa-solid fa-exclamation-triangle"></i> Không có dữ liệu động cơ';
                                echo '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown">
                <a href="#" class="nav-link dropbtn">
                    <i class="fa-solid fa-wrench"></i> Thông số xe
                    <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown-content">
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa fa-gears"></i>
                            Mã lực
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <a href="search-results.php?power_min=0&power_max=99">
                                <i class="fa-solid fa-car"></i> Dưới 100 mã lực
                            </a>
                            <a href="search-results.php?power_min=100&power_max=200">
                                <i class="fa-solid fa-car"></i> Từ 100 đến 200 mã lực
                            </a>
                            <a href="search-results.php?power_min=200&power_max=300">
                                <i class="fa-solid fa-car"></i> Từ 200 đến 300 mã lực
                            </a>
                            <a href="search-results.php?power_min=301">
                                <i class="fa-solid fa-car"></i> Trên 300 mã lực
                            </a>
                        </div>

                    </div>
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa fa-users"></i>
                            Số chỗ
                            <i class="fa fa-caret-right"></i>

                        </a>
                        <div class="sub-dropdown">
                            <?php
                            $seats_query = "SELECT DISTINCT seat_number FROM products WHERE status IN ('selling', 'discounting') ORDER BY seat_number ASC";
                            $seats_result = mysqli_query($connect, $seats_query);
                            if ($seats_result && mysqli_num_rows($seats_result) > 0) {
                                while ($row = mysqli_fetch_assoc($seats_result)) {
                                    $seats = $row['seat_number'];
                                    echo '<a href="search-results.php?seats_min=' . $seats . '&seats_max=' . $seats . '">';
                                    echo '<i class="fa-solid fa-car"></i> ' . htmlspecialchars($seats) . ' chỗ';
                                    echo '</a>';
                                }
                            } else {
                                echo '<a href="#">';
                                echo '<i class="fa-solid fa-exclamation-triangle"></i> Không có dữ liệu số chỗ';
                                echo '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="brand-dropdown">
                        <a href="#" class="nav-link dropbtn">
                            <i class="fa fa-tachometer-alt"></i>
                            Tốc độ tối đa
                            <i class="fa fa-caret-right"></i>
                        </a>
                        <div class="sub-dropdown">
                            <a href="search-results.php?speed_min=0&speed_max=99">
                                <i class="fa-solid fa-car"></i> Dưới 100 km/h
                            </a>
                            <a href="search-results.php?speed_min=100&speed_max=200">
                                <i class="fa-solid fa-car"></i> Từ 100 đến 200 km/h
                            </a>
                            <a href="search-results.php?speed_min=200&speed_max=300">
                                <i class="fa-solid fa-car"></i> Từ 200 đến 300 km/h
                            </a>
                            <a href="search-results.php?speed_min=300&speed_max=400">
                                <i class="fa-solid fa-car"></i> Từ 300 đến 400 km/h
                            </a>
                            <a href="search-results.php?speed_min=400&speed_max=500">
                                <i class="fa-solid fa-car"></i> Từ 400 đến 500 km/h
                            </a>
                            <a href="search-results.php?speed_min=501">
                                <i class="fa-solid fa-car"></i> Trên 500 km/h
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <a href="cart.php" class="nav-link" ><i style="padding-right: 5px;" class="fa-solid fa-cart-shopping"></i>Giỏ hàng</a> -->

            <!-- <a href="billhistory.php" class="nav-link">
                <i class="fa-solid fa-clock-rotate-left"></i> Lịch sử mua hàng
                </a> -->
            <a href="aboutus.php" class="nav-link">
                <i class="fa-solid fa-info-circle"></i> Giới Thiệu
            </a>
            <a href="contact.php" class="nav-link">
                <i class="fa-solid fa-envelope"></i> Liên Hệ
            </a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="../Admin/login.php" class="nav-link">
                    <i class="fa-solid fa-user-shield"></i> Admin
                </a>
            <?php endif; ?>
            <form class="nav-search" action="search-results.php" method="GET">
                <input type="text" id="search" name="query" placeholder="">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>


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
    <div class="login-register-ctn">
        <div class="login-register">
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Logged in state -->
                <div class="loggedin">
                    <span class="user-greeting">
                        <span>Xin chào,</span>
                        <a href="userinfor.php" class="username-link">
                            <i class="fa-regular fa-user"></i>
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <button type="button" id="logout-btn" onclick="showLogoutModal(event)" class="logout-btn">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Đăng xuất
                        </button>
                    </span>
                </div>
            <?php else: ?>
                <!-- Not logged in state -->
                <div class="notlogin">
                    <a href="cart.php" class="auth-link cart-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Giỏ hàng của tôi
                    </a>
                    <span class="separator">•</span>
                    <a href="login.php" id="login-btn" class="auth-link">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        Đăng nhập
                    </a>
                    <span class="separator">•</span>
                    <a href="login.php#signup" class="auth-link">
                        <i class="fas fa-user-plus"></i>
                        Đăng ký
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
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
            switch (type) {
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
        function showLogoutModal(event) {
            event.preventDefault();
            const modal = document.getElementById('logoutModal');
            modal.style.display = 'block';
            // Add show class after a small delay to trigger animations
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('show');
            // Wait for animations to complete before hiding
            setTimeout(() => {
                modal.style.display = 'none';
            }, 400);
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('logoutModal');
            if (event.target == modal) {
                closeLogoutModal();
            }
        }

    </script>
    <script>
        // Mảng các câu sẽ hiển thị
        const placeholders = [
            "Tìm kiếm sản phẩm...",
            "Nhập tên xe yêu thích...",
            <?php
            // Query to get product names
            $query = "SELECT car_name FROM products WHERE status IN ('selling', 'discounting') ORDER BY RAND() LIMIT 20";
            $result = mysqli_query($connect, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '" ' . addslashes($row['car_name']) . '...",' . "\n";
                }
            }
            ?>
        ];

        const inputEl = document.getElementById("search");
        let idx = 0;           // index câu hiện tại
        let charIdx = 0;       // index ký tự đang gõ
        let isDeleting = false;// đang trong quá trình xoá?
        const typingSpeed = 100;    // tốc độ gõ ký tự (ms)
        const deletingSpeed = 50;   // tốc độ xoá ký tự (ms)
        const delayBetween = 2000;  // dừng giữa hai câu (ms)

        function typePlaceholder() {
            const fullText = placeholders[idx];

            if (!isDeleting) {
                // gõ thêm 1 ký tự
                inputEl.placeholder = fullText.substring(0, charIdx + 1);
                charIdx++;
                if (charIdx === fullText.length) {
                    // khi gõ xong cả câu, dừng rồi chuyển qua xoá
                    isDeleting = true;
                    return setTimeout(typePlaceholder, delayBetween);
                }
                setTimeout(typePlaceholder, typingSpeed);

            } else {
                // xoá dần 1 ký tự
                inputEl.placeholder = fullText.substring(0, charIdx - 1);
                charIdx--;
                if (charIdx === 0) {
                    // xoá hết thì chuyển sang câu kế tiếp
                    isDeleting = false;
                    idx = (idx + 1) % placeholders.length;
                    return setTimeout(typePlaceholder, typingSpeed);
                }
                setTimeout(typePlaceholder, deletingSpeed);
            }
        }

        // Khởi động hiệu ứng
        document.addEventListener("DOMContentLoaded", typePlaceholder);
    </script>
</body>

</html>
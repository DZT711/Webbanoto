<?php
include 'header.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="dp56vcf7.png" type="image/png">
    <title>Thông tin người dùng</title>
    <style>
        .user-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #6c757d;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            margin-bottom: 1rem;
            transition: background-color 0.3s;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }

        .user-info {
            margin-bottom: 2rem;
        }

        .info-row {
            display: flex;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            font-weight: bold;
            width: 150px;
            color: #666;
        }

        .info-value {
            flex: 1;
            color: #333;
        }

        /* .nav-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: #0056b3;
        } */

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: bold;
        }

        .status-activated {
            background-color: #28a745;
            color: white;
        }

        .status-banned {
            background-color: #dc3545;
            color: white;
        }

        .status-disabled {
            background-color: #6c757d;
            color: white;
        }

        @media (max-width: 768px) {
            .user-container {
                margin: 1rem;
                padding: 1rem;
            }

            .info-row {
                flex-direction: column;
                gap: 0.5rem;
            }

            .info-label {
                width: 100%;
            }

            .nav-links {
                flex-direction: column;
            }

            .nav-link {
                width: 100%;
                justify-content: center;
            }
        }
        main{
            background-color: #efefef;
        }
        body{
            background-color: #efefef;
        }
        header{
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <main>

        <div class="user-container">
            <a href="javascript:history.back()" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
            Trở về
        </a>

        <h2><i class="fa-solid fa-user"></i> Thông tin người dùng</h2>
        
        <div class="user-info">
            <div class="info-row">
                <div class="info-label">Tên người dùng:</div>
                <div class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
            </div>
            
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value"><?php echo htmlspecialchars($_SESSION['email']); ?></div>
            </div>

            <div class="info-row">
                <div class="info-label">Số điện thoại:</div>
                <div class="info-value"><?php echo htmlspecialchars($_SESSION['phone_num']); ?></div>
            </div>

            <div class="info-row">
                <div class="info-label">Ngày đăng ký:</div>
                <div class="info-value"><?php echo htmlspecialchars($_SESSION['register_date']); ?></div>
            </div>

            <div class="info-row">
                <div class="info-label">Trạng thái:</div>
                <div class="info-value">
                    <?php 
                        $statusClass = 'status-' . strtolower($_SESSION['status']);
                        $statusText = '';
                        switch($_SESSION['status']) {
                            case 'activated':
                                $statusText = 'Hoạt động';
                                break;
                            case 'banned':
                                $statusText = 'Đã bị cấm';
                                break;
                            case 'disabled':
                                $statusText = 'Vô hiệu hóa';
                                break;
                            default:
                                $statusText = $_SESSION['status'];
                        }
                        echo "<span class='status-badge {$statusClass}'>{$statusText}</span>";
                    ?>
                </div>
            </div>
        </div>

        <div class="nav-links">
            <a href="cart.php" class="nav-link">
                <i class="fa-solid fa-shopping-cart"></i>
                Giỏ hàng của tôi
            </a>
            <a href="billhistory.php" class="nav-link">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Lịch sử mua hàng
            </a>
        </div>
    </div>
</main>
</body>
</html>

<?php
include "footer.php";
?>
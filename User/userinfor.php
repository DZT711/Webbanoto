<?php
include 'header.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
// Add edit form handling
if (isset($_POST['edit_profile'])) { {
        // Connect to database
        include 'connect.php';

        $username = mysqli_real_escape_string($connect, $_POST['username']);
        $email = mysqli_real_escape_string($connect, $_POST['email']);
        $phone_num = mysqli_real_escape_string($connect, $_POST['phone_num']);
        $full_name = mysqli_real_escape_string($connect, $_POST['full_name']);
        $address = mysqli_real_escape_string($connect, $_POST['address']);

        $sql = "UPDATE users_acc SET 
            username = '$username',
            email = '$email',
            phone_num = '$phone_num',
            full_name = '$full_name',
            address = '$address'";

        // Add password update only if new password is provided
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql .= ", password = '$password'";
        }

        $sql .= " WHERE username = '" . $_SESSION['username'] . "'";

        if (mysqli_query($connect, $sql)) {
            // Update session variables
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['phone_num'] = $phone_num;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['address'] = $address;

            echo "<script>showNotification('Cập nhật thông tin thành công!',success);</script>";
            echo "<script>window.location.href='userinfor.php';</script>";
        } else {
            echo "<script>showNotification('Lỗi cập nhật thông tin: " . mysqli_error($connect) . "',error);</script>";
        }
    }}

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
        <!-- Add these styles to your existing CSS -->
    
    <style>
                /* Add these styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .modal.show {
            opacity: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            position: relative;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }
        
        .modal.show .modal-content {
            transform: translateY(0);
        }
        
        .close-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }
        
        .close-btn:hover {
            color: #dc3545;
        }
    </style>
        <style>
            .edit-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background-color: #007bff;
                color: white;
                padding: 0.5rem 1rem;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.3s ease;
                margin: 1rem 0;
            }

            .edit-btn:hover {
                background-color: #0056b3;
                transform: translateY(-1px);
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }

            .edit-btn:active {
                transform: translateY(0);
            }
        </style>
        <style>
                        .edit-btn {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                background-color: #007bff;
                color: white;
                padding: 0.5rem 1rem;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-bottom: 1rem;
            }
            
            .edit-btn:hover {
                background-color: #0056b3;
            }
            
            .edit-form {
                display: none;
                margin-top: 1rem;
                background-color: #f8f9fa;
                padding: 1rem;
                border-radius: 4px;
                border: 1px solid #dee2e6;
            }
            
            .edit-form.show {
                display: block;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            .form-group label {
                display: block;
                margin-bottom: 0.5rem;
                font-weight: bold;
                color: #666;
            }
            
            .form-group input {
                width: 100%;
                padding: 0.5rem;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            
            .submit-btn {
                background-color: #28a745;
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 4px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .submit-btn:hover {
                background-color: #218838;
            }
            #edit{
                background-color: #fff;
                border: none;
                height: 37px;
            }
            #edit:hover{
                background-color:rgb(241, 241, 241);
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
            <!-- Username - Always required -->
            <div class="info-row">
                <div class="info-label">Tên người dùng:</div>
                <div class="info-value"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
            </div>
        
            <!-- Password - Always required -->
            <div class="info-row">
                <div class="info-label">Mật khẩu:</div>
                <div class="info-value"><?php echo htmlspecialchars($_SESSION['password']); ?></div>
            </div>
            
            <!-- Email -->
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">
                    <?php echo isset($_SESSION['email']) && !empty($_SESSION['email']) 
                        ? htmlspecialchars($_SESSION['email']) 
                        : 'Không có'; ?>
                </div>
            </div>
        
            <!-- Phone number -->
            <div class="info-row">
                <div class="info-label">Số điện thoại:</div>
                <div class="info-value">
                    <?php echo isset($_SESSION['phone_num']) && !empty($_SESSION['phone_num']) 
                        ? htmlspecialchars($_SESSION['phone_num']) 
                        : 'Không có'; ?>
                </div>
            </div>
        
            <!-- Register date -->
            <div class="info-row">
                <div class="info-label">Ngày đăng ký:</div>
                <div class="info-value">
                    <?php echo isset($_SESSION['register_date']) && !empty($_SESSION['register_date']) 
                        ? htmlspecialchars($_SESSION['register_date']) 
                        : 'Không có'; ?>
                </div>
            </div>
        
            <!-- Full name -->
            <div class="info-row">
                <div class="info-label">Họ tên:</div>
                <div class="info-value">
                    <?php echo isset($_SESSION['full_name']) && !empty($_SESSION['full_name']) 
                        ? htmlspecialchars($_SESSION['full_name']) 
                        : 'Không có'; ?>
                </div>
            </div>
        
            <!-- Address -->
            <div class="info-row">
                <div class="info-label">Địa chỉ:</div>
                <div class="info-value">
                    <?php echo isset($_SESSION['address']) && !empty($_SESSION['address']) 
                        ? htmlspecialchars($_SESSION['address']) 
                        : 'Không có'; ?>
                </div>
            </div>
        
            <!-- Status -->
            <div class="info-row">
                <div class="info-label">Trạng thái:</div>
                <div class="info-value">
                    <?php 
                    if (isset($_SESSION['status']) && !empty($_SESSION['status'])) {
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
                    } else {
                        echo 'Không có';
                    }
                    ?>
                </div>
            </div>
        </div>
<!-- Replace the existing edit form with this modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <button type="button" class="close-btn" onclick="closeEditForm()">&times;</button>
        <h2>Chỉnh sửa thông tin</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="editForm">
            <div class="form-group">
                <label>Tên người dùng:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
            </div>
            <div class="form-group">
                <label>Mật khẩu mới:</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu mới">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="tel" name="phone_num" value="<?php echo isset($_SESSION['phone_num']) ? htmlspecialchars($_SESSION['phone_num']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Họ tên:</label>
                <input type="text" name="full_name" value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : ''; ?>">
            </div>
            <div class="form-group">
                <label>Địa chỉ:</label>
                <input type="text" name="address" value="<?php echo isset($_SESSION['address']) ? htmlspecialchars($_SESSION['address']) : ''; ?>">
            </div>
            <input type="submit" name="edit_profile" value="Lưu thay đổi" class="submit-btn">
        </form>
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
    <button class="nav-link" id="edit" onclick="toggleEditForm()">
        <i class="fa-solid fa-user-edit"></i>
        Chỉnh sửa thông tin
    </button>
</div>
</main>
<script>

function toggleEditForm() {
    const modal = document.getElementById('editModal');
    modal.classList.add('show');
}

function closeEditForm() {
    const modal = document.getElementById('editModal');
    modal.classList.remove('show');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (event.target == modal) {
        closeEditForm();
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditForm();
    }
});

</script>
</body>
</html>

<?php
include "footer.php";
?>

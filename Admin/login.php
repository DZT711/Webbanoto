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
}//neeed notification features for testing the connection
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
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="admin-login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="username"><i class="fa-regular fa-user">&nbsp;&nbsp;</i>Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password"><i class="fa-solid fa-lock">&nbsp;&nbsp;</i>Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" name="login">Login</button>
        </form>
        <p id="error-message" style="color: red; display: none;">Invalid username or password. Please try again.</p>
    </div>

    <script>

    </script>
</body>
</html>
<?php

?>

<?php
$sever = "localhost";
$accountname = "root";
$userpassword = "";
$database_name = "webbanoto";

$connect = "";

try {
    $connect = mysqli_connect($sever, $accountname, $userpassword, $database_name);
    if ($connect && !isset($_SESSION['logout_message'])) {
        // echo "<script>showNotification('Connected to database successfully', 'success');</script>";
    }
} catch (mysqli_sql_exception) {
    echo "<script>showNotification('Connection failed please reload the page', 'error');</script>";
}
?>
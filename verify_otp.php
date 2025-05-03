<?php
session_start();
 
require 'db_connect.php';

$roll_number = $_SESSION['roll_number'];
$entered_otp = $_POST['otp'];
$current_time = date('Y-m-d H:i:s');

$sql = "SELECT otp, expires_at FROM otp_verification WHERE roll_number = '$roll_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['otp'] == $entered_otp && $current_time <= $row['expires_at']) {
        // Set verified = 1 in users table
        $update_sql = "INSERT INTO users (roll_number, verified) VALUES ('$roll_number', 1) 
                       ON DUPLICATE KEY UPDATE verified = 1";
        $conn->query($update_sql);

        $_SESSION['verified'] = 1; // Store in session for set_password.php
        header("Location: set_password.php"); //nav to set_password.php
        exit();
    } else {
        echo "Invalid or expired OTP.";
		?><html><body><a href="register.php">Go back to Register</a></body></html><?php
    }
} else {
    echo "OTP not found.";
}
$conn->close();
?>
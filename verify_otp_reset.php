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

        $_SESSION['verified'] = 1; // Store in session for reset_password.php
        header("Location: reset_password.php"); //nav to reset_password.php
        exit();
    } else {
        echo "Invalid or expired OTP.";
		?><html><body><a href="index.php">Go back to login page</a></body></html><?php
    }
} else {
    echo "OTP not found.";
}
$conn->close();
?>
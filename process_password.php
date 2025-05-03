<?php
session_start();
if (!isset($_SESSION['roll_number'])) {
    header("Location: register.php"); // Redirection if session is missing
    exit();
}
 
require 'db_connect.php';
// Validate password input
if (!isset($_POST['password']) || empty($_POST['password'])) {
    $_SESSION['message'] = "Password cannot be empty.";
    $_SESSION['msg_type'] = "danger";
    header("Location: set_password.php");
    exit();
}

$roll_number = $_SESSION['roll_number'];
$new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Use a prepared statement to prevent SQL injection
$stmt = $conn->prepare("UPDATE users SET password=? WHERE roll_number=?");
$stmt->bind_param("ss", $new_password, $roll_number);

if ($stmt->execute()) {
    $_SESSION['message'] = "Password set successfully!";
    $_SESSION['msg_type'] = "success";
	$_SESSION['roll_number'] = $roll_number; // Ensuring session persists

    header("Location:home.php");//nav to home page 
    exit();
} else {
    $_SESSION['message'] = "Error updating password.";
    $_SESSION['msg_type'] = "danger";
    header("Location: set_password.php");
    exit();
}

$stmt->close();
$conn->close();
?>

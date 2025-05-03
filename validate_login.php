<?php
session_start();
 
require 'db_connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_number = $_POST['roll_number'];
    $password = $_POST['password'];

    // Checking if the user exists in the database
    $sql = "SELECT * FROM users WHERE roll_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $roll_number); // Bind the roll_number to the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        //if User found
        $row = $result->fetch_assoc();
        
        // Checking if the entered password matches the stored password (hashed)
        if (password_verify($password, $row['password'])) {
            $_SESSION['roll_number'] = $roll_number; // Save roll_number in session
            header("Location: home.php"); //nav to home.php on successful login
            exit();
        } else {
            // Incorrect password 
            echo "<script>alert('Incorrect password!'); window.location.href='index.php';</script>";
        }
    }
	else {
        // Roll number not found in the database
        echo "<script>alert('Roll number not found!'); window.location.href='index.php';</script>";
    }
	

    $stmt->close();
	}

$conn->close();
?>
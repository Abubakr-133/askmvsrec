<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password == $confirm_password && strlen($password) > 6) {
        // Hash the password and update in the users table
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $conn = new mysqli('localhost', 'root', '', 'ASK-MVSREC');
        $sql = "UPDATE users SET password = '$hashed_password' WHERE roll_number = '" . $_SESSION['roll_number'] . "'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Password updated successfully!";
            // Redirect to login page
            header("Location: index.php");
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Passwords do not match or password is too short!";
    }
}
?>

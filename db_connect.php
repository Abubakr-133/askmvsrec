<?php
$servername="localhost";
$username="root";
$password="";
$database="ask-mvsrec";
//$servername = "sql202.infinityfree.com";
//$username = "if0_38687921";  // Default XAMPP user
//$password = "133733222451";  // Default is empty in XAMPP
//$database = "sql202.infinityfree.com"; //database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
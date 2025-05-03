<?php
session_start(); // Start session
 
require 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['roll_number'])) {
    die("You must be logged in to submit an announcement.");
}

$roll_number = $_SESSION['roll_number'];
$message = ""; // Feedback message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = trim($_POST['content']);

    if (empty($content)) {
        die("❌ Announcement text is required!");
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO announcements (roll_number, content, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $roll_number, $content);

    if ($stmt->execute()) {
        echo "✅ Announcement submitted successfully!";
        header("Location: announcement.php"); // Redirect after successful submission
        exit();
    } else {
        die("❌ Error submitting announcement: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>

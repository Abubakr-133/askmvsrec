<?php
session_start();
 
require 'db_connect.php';

if (!isset($_SESSION['roll_number'])) {
    die("You must be logged in to delete answers.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['answer_id'])) {
        die("Invalid request.");
    }

    $answer_id = intval($_POST['answer_id']);
    $roll_number = $_SESSION['roll_number'];

    // Check if the user owns this answer
    $stmt = $conn->prepare("SELECT * FROM answers WHERE id = ? AND roll_number = ?");
    $stmt->bind_param("is", $answer_id, $roll_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("You can only delete your own answers.");
    }
	
    // Delete the answer
    $deleteStmt = $conn->prepare("DELETE FROM answers WHERE id = ?");
    $deleteStmt->bind_param("i", $answer_id);

    if ($deleteStmt->execute()) {
        header("Location: QA.php"); // Redirect back after deletion
        exit();
    } else {
        echo "Error deleting answer: " . $deleteStmt->error;
    }

    $stmt->close();
    $deleteStmt->close();
}
$conn->close();
?>

<?php
session_start();
 
require 'db_connect.php';

if (!isset($_SESSION['roll_number'])) {
    die("You must be logged in to answer questions.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['question_id']) || !isset($_POST['answer'])) {
        die("Invalid request.");
    }

    $question_id = intval($_POST['question_id']);
    $answer = trim($_POST['answer']);
    $roll_number = $_SESSION['roll_number'];

    if (empty($answer)) {
        die("Answer cannot be empty.");
    }

    $stmt = $conn->prepare("INSERT INTO answers (question_id, roll_number, answer, created_at, `like`, `dislike`) VALUES (?, ?, ?, NOW(), 0, 0)");
    $stmt->bind_param("iss", $question_id, $roll_number, $answer);

    if ($stmt->execute()) {
        header("Location: QA.php"); // Redirect back to the question display page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

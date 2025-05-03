<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['roll_number'])) {
    die("You must be logged in to submit a question.");
}

$roll_number = $_SESSION['roll_number'];
$message = "";
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = trim($_POST['question']);

    if (empty($question)) {
        $message = "Question cannot be empty!";
    } else {
        $stmt = $conn->prepare("INSERT INTO questions (roll_number, question, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $roll_number, $question);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: QA.php"); 
            exit();
        } else {
            $message = "Error submitting question.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ask a Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body style="background-color:#05472A;">

<div style="background-color:green" class="container">
    <h3 style="color:white" class="text-center">Ask a Question</h3>
    <hr>
    
    <?php if (!empty($message)) { ?>
        <div style="background-color:green" class="alert alert-danger"><?php echo $message; ?></div>
    <?php } ?>
    
    <form method="POST" action="">
        <div style="background-color:green" class="mb-3">
            <label for="question" class="form-label"><span style="color:white"><strong>Your Question</strong></span></label>
            <textarea class="form-control" id="question" name="question" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-submit w-100">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

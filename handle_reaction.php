<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// DB Connection
$conn = new mysqli("localhost", "root", "", "ask-mvsrec");
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Session check
if (!isset($_SESSION['roll_number'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$roll_number = $_SESSION['roll_number'];
$content_id = intval($_POST['id'] ?? 0);
$content_type = $_POST['type'] ?? '';
$action = $_POST['action'] ?? '';

if (!$content_id || !in_array($content_type, ['question', 'answer']) || !in_array($action, ['like', 'dislike'])) {
    echo json_encode(["error" => "Invalid parameters"]);
    exit;
}

// Determine table name
$table = $content_type === 'question' ? 'questions' : 'answers';

// Check existing reaction
$stmt = $conn->prepare("SELECT reaction_type FROM reactions WHERE roll_number = ? AND content_type = ? AND content_id = ?");
$stmt->bind_param("ssi", $roll_number, $content_type, $content_id);
$stmt->execute();
$result = $stmt->get_result();
$existing = $result->fetch_assoc();

if ($existing) {
    $previous = $existing['reaction_type'];

    if ($previous === $action) {
        // Remove reaction (toggle off)
        $stmt = $conn->prepare("DELETE FROM reactions WHERE roll_number = ? AND content_type = ? AND content_id = ?");
        $stmt->bind_param("ssi", $roll_number, $content_type, $content_id);
        $stmt->execute();

        // Decrement that reaction count in the original table
        $stmt = $conn->prepare("UPDATE $table SET `$action` = `$action` - 1 WHERE id = ?");
        $stmt->bind_param("i", $content_id);
        $stmt->execute();

        $user_reaction = null;

    } else {
        // Switch reaction
        $stmt = $conn->prepare("UPDATE reactions SET reaction_type = ? WHERE roll_number = ? AND content_type = ? AND content_id = ?");
        $stmt->bind_param("sssi", $action, $roll_number, $content_type, $content_id);
        $stmt->execute();

        // Decrement previous, increment new
        $stmt = $conn->prepare("UPDATE $table SET `$previous` = `$previous` - 1, `$action` = `$action` + 1 WHERE id = ?");
        $stmt->bind_param("i", $content_id);
        $stmt->execute();

        $user_reaction = $action;
    }

} else {
    // New reaction
    $stmt = $conn->prepare("INSERT INTO reactions (roll_number, content_type, content_id, reaction_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $roll_number, $content_type, $content_id, $action);
    $stmt->execute();

    // Increment the count
    $stmt = $conn->prepare("UPDATE $table SET `$action` = `$action` + 1 WHERE id = ?");
    $stmt->bind_param("i", $content_id);
    $stmt->execute();

    $user_reaction = $action;
}

// Fetch updated counts
$stmt = $conn->prepare("SELECT `like`, `dislike` FROM $table WHERE id = ?");
$stmt->bind_param("i", $content_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
    "success" => true,
    "like" => (int) $row['like'],
    "dislike" => (int) $row['dislike'],
    "user_reaction" => $user_reaction
]);

$conn->close();
?>

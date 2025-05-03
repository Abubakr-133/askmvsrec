<?php
require 'db_connect.php';
session_start();

$response = ['success' => false];

if (!isset($_SESSION['roll_number'])) {
    $response['message'] = "Not logged in.";
    echo json_encode($response);
    exit;
}

$roll_number = $_SESSION['roll_number'];
$content_id = $_POST['id'];
$content_type = $_POST['type']; // 'announcement'
$action = $_POST['action'];     // 'like' or 'dislike'

// Check existing reaction
$checkQuery = $conn->prepare("SELECT reaction_type FROM reactions WHERE roll_number = ? AND content_id = ? AND content_type = ?");
$checkQuery->bind_param("sis", $roll_number, $content_id, $content_type);
$checkQuery->execute();
$result = $checkQuery->get_result();
$existing = $result->fetch_assoc();
$checkQuery->close();

$previous = $existing['reaction_type'] ?? null;

$conn->begin_transaction();

try {
    // Remove old reaction if it exists
    if ($previous) {
        if ($previous === 'like') {
            $conn->query("UPDATE announcements SET likes = likes - 1 WHERE id = $content_id");
        } else if ($previous === 'dislike') {
            $conn->query("UPDATE announcements SET dislikes = dislikes - 1 WHERE id = $content_id");
        }

        $deleteStmt = $conn->prepare("DELETE FROM reactions WHERE roll_number = ? AND content_id = ? AND content_type = ?");
        $deleteStmt->bind_param("sis", $roll_number, $content_id, $content_type);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    // Add new reaction if not the same as previous
    if ($action !== $previous) {
        $insertStmt = $conn->prepare("INSERT INTO reactions (roll_number, content_id, content_type, reaction_type) VALUES (?, ?, ?, ?)");
        $insertStmt->bind_param("siss", $roll_number, $content_id, $content_type, $action);
        $insertStmt->execute();
        $insertStmt->close();

        if ($action === 'like') {
            $conn->query("UPDATE announcements SET likes = likes + 1 WHERE id = $content_id");
        } else if ($action === 'dislike') {
            $conn->query("UPDATE announcements SET dislikes = dislikes + 1 WHERE id = $content_id");
        }
    }

    $counts = $conn->query("SELECT likes, dislikes FROM announcements WHERE id = $content_id")->fetch_assoc();

    $conn->commit();

    $response['success'] = true;
    $response['like'] = $counts['likes'];
    $response['dislike'] = $counts['dislikes'];
    $response['user_reacted'] = ($action === $previous) ? '' : $action;
} catch (Exception $e) {
    $conn->rollback();
    $response['message'] = "Something went wrong: " . $e->getMessage();
}

echo json_encode($response);
?>

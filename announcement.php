<?php 
include 'home.php'; 
require 'db_connect.php';


if (!isset($_SESSION['roll_number'])) {
    die("You must be logged in to view announcements.");
}
$roll_number = $_SESSION['roll_number'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .truncate {
            overflow: hidden;
            max-height: 7.2em; /* ~4 lines */
            white-space: pre-wrap;
        }
        .show-more {
            color: blue;
            cursor: pointer;
            margin-top: 5px;
            display: inline-block;
        }
        .reaction-btn.btn-success {
            background-color: #198754;
            color: white;
        }
        .reaction-btn.btn-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div style='background-color:#1E1E2F  ' class="container mt-4">
        <h1 style="color:yellow;" class="mb-4">Announcements</h1>
        <?php
        $announcementQuery = "SELECT q.id, q.roll_number, q.content, q.created_at, q.likes, q.dislikes 
                              FROM announcements q 
                              JOIN users u ON q.roll_number = u.roll_number 
                              ORDER BY q.created_at DESC";
        $announcementResult = $conn->query($announcementQuery);

        if ($announcementResult->num_rows > 0) {
            while ($announcement = $announcementResult->fetch_assoc()) {
                $reactionStmt = $conn->prepare("SELECT reaction_type FROM reactions WHERE content_id = ? AND content_type = 'announcement' AND roll_number = ?");
                $reactionStmt->bind_param("is", $announcement['id'], $roll_number);
                $reactionStmt->execute();
                $reactionResult = $reactionStmt->get_result();
                $userReaction = $reactionResult->fetch_assoc()['reaction_type'] ?? '';
                $reactionStmt->close();

                $content = nl2br(htmlspecialchars($announcement['content']));
                $isLong = strlen(strip_tags($content)) > 400;

                echo "<div style='background-color: #27293D  ;' class='card mb-3'>";
                echo "<div class='card-body'>";
                echo "<h6 style='color:white' class='card-title small-text'>" . htmlspecialchars($announcement['roll_number']) . "</h6>";

                echo "<div style='background-color:#fff5ee' class='card-text content-box " . ($isLong ? "truncate" : "") . "'>" . $content . "</div>";
                if ($isLong) {
                    echo "<span class='show-more'>Show More</span>";
                }

                echo "<p style='color:white' class='text mt-2'>Posted on: " . $announcement['created_at'] . "</p>";

                echo "<div class='reaction-group' data-type='announcement' data-id='" . $announcement['id'] . "'>";
                echo "<button style='color:white' class='btn btn reaction-btn me-2 " . ($userReaction === 'like' ? "btn-success" : "") . "' 
                        data-id='" . $announcement['id'] . "' 
                        data-type='announcement' 
                        data-action='like'>
                        👍 <span class='like-count'>" . $announcement['likes'] . "</span>
                      </button>";
                echo "<button style='color:white' class='btn btn reaction-btn " . ($userReaction === 'dislike' ? "btn-danger" : "") . "' 
                        data-id='" . $announcement['id'] . "' 
                        data-type='announcement' 
                        data-action='dislike'>
                        👎 <span class='dislike-count'>" . $announcement['dislikes'] . "</span>
                      </button>";
                echo "</div>";

                echo "</div></div>";
            }
        } else {
            echo "<p>No announcements found.</p>";
        }
        ?>
    </div>

    <script>
    $(document).ready(function () {
        $('.reaction-btn').click(function () {
            var $button = $(this);
            var id = $button.data('id');
            var type = $button.data('type');
            var action = $button.data('action');

            $.ajax({
                url: 'announcement_handle_reaction.php',
                type: 'POST',
                data: {
                    id: id,
                    type: type,
                    action: action
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        let $group = $button.closest('.reaction-group');
                        $group.find("[data-action='like']").removeClass('btn-success');
                        $group.find("[data-action='dislike']").removeClass('btn-danger');

                        if (response.user_reacted === 'like') {
                            $group.find("[data-action='like']").addClass('btn-success');
                        } else if (response.user_reacted === 'dislike') {
                            $group.find("[data-action='dislike']").addClass('btn-danger');
                        }

                        $group.find("[data-action='like'] .like-count").text(response.like);
                        $group.find("[data-action='dislike'] .dislike-count").text(response.dislike);
                    } else {
                        alert(response.message || "Something went wrong.");
                    }
                },
                error: function (xhr) {
                    console.error("AJAX error:", xhr.responseText);
                }
            });
        });

        // Show more / less functionality
        $(document).on('click', '.show-more', function () {
            var $this = $(this);
            var $content = $this.prev('.content-box');
            $content.toggleClass('truncate');
            $this.text($content.hasClass('truncate') ? 'Show More' : 'Show Less');
        });
    });
    </script>
</body>
</html>
<?php $conn->close(); ?>

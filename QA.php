<?php include 'home.php'; 

require 'db_connect.php';
if (!isset($_SESSION['roll_number'])) {
    die("You must be logged in to view questions.");
}
$roll_number = $_SESSION['roll_number'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .hidden { display: none; }
        .truncate { max-height: 4.5em; overflow: hidden; }
        .small-text { font-size: 0.9em; }
        .large-text { font-size: 1.2em; font-weight: bold; }
        .settings-menu { position: relative; display: inline-block; }
        .settings-dropdown { display: none; position: absolute; right: 0; background: white; border: 1px solid #ccc; padding: 5px; }
    </style>
</head>
<body style="background-color: #121212; color: #E0E0E0;">
    <div class="container mt-4" style="background-color:#1E1E2F; padding: 20px; border-radius: 10px;">
        <h1 style="color:yellow" class="mb-4">Questions</h1>
        <?php
        $questionQuery = "SELECT q.id, q.roll_number, q.question, q.created_at, q.like, q.dislike FROM questions q JOIN users u ON q.roll_number = u.roll_number ORDER BY q.created_at DESC";
        $questionResult = $conn->query($questionQuery);

        if ($questionResult->num_rows > 0) {
            while ($question = $questionResult->fetch_assoc()) {
                echo "<div class='card mb-3' style='background-color: #27293D; color: #E0E0E0;'>";
                echo "<div class='card-body'>";
                echo "<h6 class='card-title small-text'>" . htmlspecialchars($question['roll_number']) . "</h6>";
                echo "<p class='card-text large-text'>" . nl2br(htmlspecialchars($question['question'])) . "</p>";
                echo "<p style='color:#AAAAAA;'>Posted on: " . $question['created_at'] . "</p>";
                echo "<div class='reaction-group' data-type='question' data-id='" . $question['id'] . "'>";
                echo "<button class='btn me-2 reaction-btn' style='background-color:#3E8EDE; color:white;' data-id='" . $question['id'] . "' data-type='question' data-action='like'>👍 <span class='like-count'>" . $question['like'] . "</span></button>";
                echo "<button class='btn reaction-btn' style='background-color:#3E8EDE; color:white;' data-id='" . $question['id'] . "' data-type='question' data-action='dislike'>👎 <span class='dislike-count'>" . $question['dislike'] . "</span></button>";
                echo "</div>";
                echo "<button class='btn mt-2 answer-toggle' data-id='" . $question['id'] . "' style='background-color:#3E8EDE; color:white;'>Answer</button>";
                echo "<form method='POST' action='submit_answer.php' class='answer-form mt-2 hidden' id='answer-form-" . $question['id'] . "'>";
                echo "<input type='hidden' name='question_id' value='" . $question['id'] . "'>";
                echo "<textarea name='answer' class='form-control mb-2' required placeholder='Write your answer...'></textarea>";
                echo "<button type='submit' class='btn' style='background-color:#3E8EDE; color:white;'>Submit Answer</button>";
                echo "</form>";

                $answerQuery = "SELECT a.id, a.answer, a.created_at, u.roll_number, a.like, a.dislike FROM answers a JOIN users u ON a.roll_number = u.roll_number WHERE a.question_id = " . $question['id'] . " ORDER BY a.created_at ASC";
                $answerResult = $conn->query($answerQuery);
                if ($answerResult->num_rows > 0) {
                    echo "<div class='card mt-3 p-2' style='border: 2px solid #3d2b1f;background-color:#DCDCDC;'>";
                    echo "<h5 style='color:black;'>&nbsp;&nbsp;Answers:</h5>";
                    while ($answer = $answerResult->fetch_assoc()) {
                        $answerText = nl2br(htmlspecialchars($answer['answer']));
                        echo "<div class='border p-2 mt-2' style='background-color:#DCDCDC; border:none !important;'>";
                        echo "<strong style='color:black;' class='small-text'>" . htmlspecialchars($answer['roll_number']) . "</strong>";
                        echo "<p style='color:black;' class='answer-text truncate' id='answer-text-" . $answer['id'] . "'>" . $answerText . "</p>";
                        echo "<span class='show-more' style='cursor:pointer; color:#3E8EDE;' onclick=\"toggleShowMore('answer-text-" . $answer['id'] . "', this)\">Show More</span>";
                        echo "<p style='color:black;'>Answered on: " . $answer['created_at'] . "</p>";
                        echo "<div class='reaction-group' data-type='answer' data-id='" . $answer['id'] . "'>";
                        echo "<button class='btn me-2 reaction-btn' style='background-color:#3E8EDE; color:white;' data-id='" . $answer['id'] . "' data-type='answer' data-action='like'>👍 <span class='like-count'>" . $answer['like'] . "</span></button>";
                        echo "<button class='btn reaction-btn' style='background-color:#3E8EDE; color:white;' data-id='" . $answer['id'] . "' data-type='answer' data-action='dislike'>👎 <span class='dislike-count'>" . $answer['dislike'] . "</span></button>";
                        echo "</div>";
                        if ($answer['roll_number'] == $_SESSION['roll_number']) {
                            echo "<div class='settings-menu'>";
                            echo "<button class='btn btn' onclick='toggleSettings(this)' style='color:black;'><strong>&#8942;</strong></button>";
                            echo "<div class='settings-dropdown'>";
                            echo "<form method='POST' action='delete_answer.php'>";
                            echo "<input type='hidden' name='answer_id' value='" . $answer['id'] . "'>";
                            echo "<button type='submit' class='btn btn-sm btn-danger'>Delete</button>";
                            echo "<hr></form>";
                            echo "</div></div>";
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                }
                echo "</div></div>";
            }
        } else {
            echo "<p style='color:#E0E0E0;'>No questions found.</p>";
        }
        ?>
    </div>

    <script>
        function toggleSettings(button) {
            $(button).next('.settings-dropdown').toggle();
        }

        $(document).ready(function () {
            $('.answer-toggle').click(function () {
                var id = $(this).data('id');
                $('#answer-form-' + id).toggleClass('hidden');
            });

            $('.reaction-btn').click(function () {
                var $button = $(this);
                var id = $button.data('id');
                var type = $button.data('type');
                var action = $button.data('action');

                $.ajax({
                    url: 'handle_reaction.php',
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
                            $group.find("[data-action='like']").html('👍 <span class="like-count">' + response.like + '</span>');
                            $group.find("[data-action='dislike']").html('👎 <span class="dislike-count">' + response.dislike + '</span>');
                        } else {
                            alert(response.message || "Something went wrong.");
                        }
                    },
                    error: function (xhr) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });
            });
        });

        function toggleShowMore(textId, btn) {
            var textElement = document.getElementById(textId);
            if (textElement.classList.contains('truncate')) {
                textElement.classList.remove('truncate');
                btn.textContent = "Show Less";
            } else {
                textElement.classList.add('truncate');
                btn.textContent = "Show More";
            }
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>

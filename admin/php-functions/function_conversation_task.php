<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    $taskid = $_POST['task-id'];
    $comment_by = $_SESSION['pt-admin-id'] ?? null;

    if (!$comment || !$taskid || !$comment_by) {
        echo "Missing required data";
        exit;
    }

    $stmt = $con->prepare("
        INSERT INTO task_conversation (
            tconv_task_id,
            tconv_comment_by_pt_id,
            tconv_comment,
            tconv_comment_date_time,
            created_at,
            updated_at
        ) VALUES (?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'))
    ");

    $stmt->bind_param("iis", $taskid, $comment_by, $comment);

    if ($stmt->execute()) {
        echo "Comment posted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

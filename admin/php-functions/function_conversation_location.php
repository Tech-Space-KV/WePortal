<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    $scope_id = $_POST['loc_id'];
    $comment_by = $_SESSION['pt-admin-id'] ?? null;

    if (!$comment || !$scope_id || !$comment_by) {
        echo "Missing required data";
        exit;
    }

    $stmt = $con->prepare("INSERT INTO project_conversation (pconv_scope_id, pconv_comment_by_pt_id, pconv_comment, pconv_comment_date_time, created_at, updated_at) VALUES (?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'))");
    $stmt->bind_param("iis", $scope_id, $comment_by, $comment);

    if ($stmt->execute()) {
        echo "Comment posted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

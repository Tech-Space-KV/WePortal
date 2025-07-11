<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $email = '';

    // Step 1: Get the email of the project owner
    $stmt = $con->prepare("SELECT pown_email FROM project_owners WHERE pown_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    // Step 2: Delete from project_owners
    $stmt = $con->prepare("DELETE FROM project_owners WHERE pown_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {

        // Step 3: Delete from users table using the fetched email
        $stmt->close();
        $stmt = $con->prepare("DELETE FROM users WHERE email = ? AND user_type = 'customer'");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }

    $stmt->close();
}
?>

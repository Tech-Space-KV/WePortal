<?php
require('../../required/db-connection/connection.php'); // Include your DB connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE `notifications` SET `ntfn_readflag` = ? WHERE `ntfn_id` = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $status, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($con)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>

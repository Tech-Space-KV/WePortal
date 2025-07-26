<?php
require('../../required/db-connection/connection.php'); // Include your DB connection

header('Content-Type: application/json');

if (!isset($_GET['username'])) {
    echo json_encode(["status" => "error", "message" => "No details provided"]);
    exit;
}

$username = trim($_GET['username']);

// Prepare a query to check if the username exists
$sql = "SELECT * FROM service_providers WHERE sprov_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$message;

if ($row = $result->fetch_assoc()) {
    $message = $row['sprov_name']." || ".$row['sprov_email']." || ".$row['sprov_contact'];
    echo json_encode(["status" => "exists", "message" => $message]);
} else {
    echo json_encode(["status" => "error", "message" => "no record found"]);
}

// if ($row['count'] > 0) {
//     echo json_encode(["status" => "exists"]);
// } else {
//     echo json_encode(["status" => "available", "message" => ""]);
// }

$stmt->close();
$con->close();
?>
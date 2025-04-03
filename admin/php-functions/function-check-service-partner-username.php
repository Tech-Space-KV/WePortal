<?php
require('../../required/db-connection/connection.php'); // Include your DB connection

header('Content-Type: application/json');

if (!isset($_GET['username'])) {
    echo json_encode(["status" => "error", "message" => "No username provided"]);
    exit;
}

$username = trim($_GET['username']);

// Prepare a query to check if the username exists
$sql = "SELECT COUNT(*) as count FROM service_providers WHERE sprov_username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    echo json_encode(["status" => "exists"]);
} else {
    echo json_encode(["status" => "available"]);
}

$stmt->close();
$con->close();
?>
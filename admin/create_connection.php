<?php
$host = "localhost";
$user = "root"; // Default XAMPP user
$pass = ""; // Default XAMPP password (empty)
$db = "project_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


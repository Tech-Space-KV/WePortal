<?php
$server = "192.168.1.110";  // Change this if your database is hosted elsewhere
$user = "nimisha";         // Your MySQL username
$password = "Root@0000";   // Your MySQL password (leave blank if no password)
$db = "pseudoteam";  // Your database name

// Create connection
$conn = new mysqli($server, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>

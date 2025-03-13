<?php
$server = "localhost";  // Change this if your database is hosted elsewhere
$user = "root";         // Your MySQL username
$password = "";         // Your MySQL password (leave blank if no password)
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

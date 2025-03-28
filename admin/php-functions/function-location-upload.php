<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect form data
        $project_id = $_POST['project_id'];
        $country = $_POST['country'];
        $state = $_POST['state'];
        $city = $_POST['city'];
        $pincode = $_POST['pincode'];
        $address = $_POST['address'];
        $status = $_POST['status'];

        // Prepare SQL query
        $sql = "INSERT INTO project_scope (pscope_project_id, pscope_country, pscope_state, pscope_city, pscope_pincode, pscope_address, pscope_status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'))";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("isssiss", $project_id, $country, $state, $city, $pincode, $address, $status);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Location added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add location."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

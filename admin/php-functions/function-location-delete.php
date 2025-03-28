<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect form data
        $project_id = $_POST['project_id'];
        $pscope_id = $_POST['pscope_id'];
        

        // Prepare SQL query
        // $sql = "INSERT INTO project_scope (pscope_project_id, pscope_country, pscope_state, pscope_city, pscope_pincode, pscope_address, pscope_status, created_at, updated_at) 
        //         VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $sql = "DELETE from project_scope where pscope_id = ? and pscope_project_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $pscope_id, $project_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Location deleted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete location."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

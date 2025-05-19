<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect form data
        
        $raise_invoice = $_POST['raise_invoice'];
        $pptasks_id = $_POST['pptasks_id'];
        

        // Prepare SQL query
                $sql = "UPDATE `project_planner_tasks` 
                SET `pptasks_invoice_raised_flag` = ?, 
                    `updated_at` = DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') 
                WHERE `pptasks_id` = ?";

                $stmt = $con->prepare($sql);
                $stmt->bind_param("ii", $raise_invoice, $pptasks_id);


        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Task added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add task."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

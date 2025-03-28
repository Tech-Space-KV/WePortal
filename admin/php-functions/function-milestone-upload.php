<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect form data
        $pscope_id = $_POST['pscope_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $startDate = date("d-m-Y", strtotime($_POST['startDate']));
        $endDate = date("d-m-Y", strtotime($_POST['endDate']));
        $status = $_POST['status'];

        // Prepare SQL query
        $sql = "INSERT INTO `project_planner`(`pplnr_milestone`, `pplnr_description`, `pplnr_start_date`, `pplnr_end_date`, `pplnr_status`, `pplnr_scope_id`, `created_at`, `updated_at`) 
                VALUES (?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'))";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssi", $name, $description, $startDate, $endDate, $status, $pscope_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Milestone added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add milestone."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

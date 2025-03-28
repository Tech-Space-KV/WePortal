<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if (1) {
    try {
        // Collect form data
        $pplnr_id = 12;
        $name = 'task123';
        $description = 'desc123';
        $startDate = date("d-m-Y", strtotime('2025-01-01'));
        $endDate = date("d-m-Y", strtotime('2025-01-01'));
        $sp_status = 'Not Started';
        $sp_id = 12345;
        $doc = date("d-m-Y", strtotime('2025-01-01'));
        $mngr_status = 'Not Started';
        $payment = 132435;

        // Prepare SQL query
        $sql = " INSERT INTO `project_planner_tasks`(`pptasks_task_title`, `pptasks_description`, `pptasks_start_date`, `pptasks_end_date`, `pptasks_sp_id`, `pptasks_date_of_completion`, `pptasks_sp_status`, `pptasks_pt_status`, `pptasks_payment`, `pptasks_planner_id`,`created_at`,`updated_at`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') )";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssssssdi", $name, $description, $startDate, $endDate, $sp_id, $doc, $sp_status, $mngr_status, $payment, $pplnr_id);

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

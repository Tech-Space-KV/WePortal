<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect form data
        $pplnr_id = $_POST['pplnr_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $startDate = date("d-m-Y", strtotime($_POST['startDate']));
        $endDate = date("d-m-Y", strtotime($_POST['endDate']));
        $sp_status = $_POST['sp_status'];
        $sp_id = $_POST['sp_id'];
        $doc = date("d-m-Y", strtotime($_POST['doc']));
        $mngr_status = $_POST['mngr_status'];
        $payment = $_POST['payment'];
        $pptasks_id = $_POST['pptasks_id'];
        

        // Prepare SQL query
                $sql = "UPDATE `project_planner_tasks` 
                SET `pptasks_task_title` = ?, 
                    `pptasks_description` = ?, 
                    `pptasks_start_date` = ?, 
                    `pptasks_end_date` = ?, 
                    `pptasks_sp_id` = ?, 
                    `pptasks_date_of_completion` = ?, 
                    `pptasks_sp_status` = ?, 
                    `pptasks_pt_status` = ?, 
                    `pptasks_payment` = ?, 
                    `updated_at` = DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s') 
                WHERE `pptasks_id` = ?";

                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssssssssds", $name, $description, $startDate, $endDate, 
                $sp_id, $doc, $sp_status, $mngr_status, $payment, $pptasks_id);


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

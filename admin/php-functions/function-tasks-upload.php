<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../session-management.php');
require('../../required/db-connection/connection.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Sanitize and collect form data
        $pplnr_id = (int)$_POST['pplnr_id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $startDate = date("d-m-Y", strtotime($_POST['startDate']));
        $endDate = date("d-m-Y", strtotime($_POST['endDate']));
        $sp_status = trim($_POST['sp_status']);
        $sp_id = (int)$_POST['sp_id'];
        $doc = date("d-m-Y", strtotime($_POST['doc']));
        $mngr_status = trim($_POST['mngr_status']);
        $payment = (float)$_POST['payment'];
        $created = date("Y-m-d H:i:s");
        $updated = date("Y-m-d H:i:s");

        // SQL insert statement
        $sql = "INSERT INTO `project_planner_tasks` 
                (`pptasks_task_title`, `pptasks_description`, `pptasks_start_date`, `pptasks_end_date`, `pptasks_sp_id`, `pptasks_date_of_completion`, `pptasks_sp_status`, `pptasks_pt_status`, `pptasks_payment`, `pptasks_planner_id`, `created_at`, `updated_at`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $con->prepare($sql);

        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $con->error]);
            exit;
        }

        $stmt->bind_param(
            "ssssisssdiss",
            $name,
            $description,
            $startDate,
            $endDate,
            $sp_id,
            $doc,
            $sp_status,
            $mngr_status,
            $payment,
            $pplnr_id,
            $created,
            $updated
        );

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Task added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add task: " . $stmt->error]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>

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
        $pplnr_id = $_POST['pplnr_id'];
        
        

        // Prepare SQL query
        // $sql = "INSERT INTO project_scope (pscope_project_id, pscope_country, pscope_state, pscope_city, pscope_pincode, pscope_address, pscope_status, created_at, updated_at) 
        //         VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $sql = "UPDATE project_planner set pplnr_milestone =? , pplnr_description = ?, pplnr_start_date = ?, pplnr_end_date = ?, pplnr_status = ? where pplnr_scope_id = ? and pplnr_id = ?";

        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssssii", $name, $description, $startDate, $endDate, $status, $pscope_id, $pplnr_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Milestone saved successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to save milestone."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

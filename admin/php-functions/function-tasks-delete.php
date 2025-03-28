<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Collect form data
        $pplnr_id = $_POST['pplnr_id'];
        $pptasks_id = $_POST['pptasks_id'];

        // Fetch data from project_scope table
        $query = "DELETE FROM project_planner_tasks WHERE pptasks_id = ? AND pptasks_planner_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ii", $pptasks_id, $pplnr_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) {
            echo json_encode($row); // Send data as JSON
        } else {
            echo json_encode(["error" => "No record found"]);
        }
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["error" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request."]);
}
?>

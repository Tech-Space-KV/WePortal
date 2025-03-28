<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_GET['pplnr_id']) {
    try {
        $pplnr_id = $_GET['pplnr_id'];

        // Fetch data from project_scope table
        $query = "SELECT * FROM project_planner WHERE pplnr_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $pplnr_id);
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

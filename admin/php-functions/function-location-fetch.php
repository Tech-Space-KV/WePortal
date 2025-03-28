<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_GET['pscope_id']) {
    try {
        $pscope_id = $_GET['pscope_id'];

        // Fetch data from project_scope table
        $query = "SELECT * FROM project_scope WHERE pscope_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $pscope_id);
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

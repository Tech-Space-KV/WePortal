<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../session-management.php');
require('../../required/db-connection/connection.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $required_fields = ['project_id', 'country', 'state', 'city', 'pincode', 'address', 'status'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                echo json_encode(["status" => "error", "message" => "Missing or empty field: $field"]);
                exit;
            }
        }

        // Sanitize and prepare data
        $project_id = $_POST['project_id'];
        $country = htmlspecialchars(trim($_POST['country']));
        $state = htmlspecialchars(trim($_POST['state']));
        $city = htmlspecialchars(trim($_POST['city']));
        $pincode = $_POST['pincode'];
        $address = htmlspecialchars(trim($_POST['address']));
        $status = htmlspecialchars(trim($_POST['status']));
        $created = date("d-m-Y H:i:s");
        $updated = date("d-m-Y H:i:s");

        // Prepare SQL
        $sql = "INSERT INTO project_scope 
                (pscope_project_id, pscope_country, pscope_state, pscope_city, pscope_pincode, pscope_address, pscope_status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $con->prepare($sql);

        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $con->error]);
            exit;
        }

        if (!$stmt->bind_param("issssssss", $project_id, $country, $state, $city, $pincode, $address, $status, $created, $updated)) {
            echo json_encode(["status" => "error", "message" => "Binding parameters failed: " . $stmt->error]);
            exit;
        }

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Location added successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add location: " . $stmt->error]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Exception: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>

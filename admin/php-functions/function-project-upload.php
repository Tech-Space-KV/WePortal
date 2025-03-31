<?php
require('../session-management.php'); 
require('../../required/db-connection/connection.php'); 

header('Content-Type: application/json');

try {
    // Collect form data and handle null values
    $customer = $_POST['customer'] ?? null;
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $projectIs = $_POST['projectIs'] ?? null;
    $projectType = $_POST['projectType'] ?? null;
    $projectCategory = $_POST['projectCategory'] ?? null;
    $currency = $_POST['currency'] ?? null;
    $budgetAmount = $_POST['budgetAmount'] ?? null;
    $startDate = date("d-m-Y", strtotime($_POST['startDate'])) ?? null;
    $endDate = date("d-m-Y", strtotime($_POST['endDate'])) ?? null;
    $contactName = $_POST['contactName'] ?? null;
    $contactEmail = $_POST['contactEmail'] ?? null;
    $contactNumber = $_POST['contactNumber'] ?? null;
    $notificationEmail = $_POST['notificationEmail'] ?? null;
    $coupon = $_POST['coupon'] ?? null;
    $status = 'No SP Assigned';
    $projectid = "Pseudo-".date("Y")."-".date("mdHis")."";
    $checkrcv = !empty($notificationEmail) ? 'True' : 'False';

    // Validate required fields
    if (!$customer || !$title || !$description) {
        throw new Exception("Missing required fields.");
    }

    // Handle file upload (Scope of Work - SOW)
    $sowData = null;
    if (!empty($_FILES["sow"]["tmp_name"])) {
        $sowData = file_get_contents($_FILES["sow"]["tmp_name"]); // Convert file to binary (BLOB)
    }

    // Prepare SQL Query
    $sql = "INSERT INTO project_list 
        (plist_customer_id, plist_status, plist_checkrcv, plist_projectid, plist_title, plist_description, plist_sow, plist_ongnew, plist_type, plist_category, plist_currency, plist_budget, plist_startdate, plist_enddate, plist_name, plist_email, plist_contact, plist_customeremail, plist_coupon, created_at, updated_at, plist_project_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), 'Live')";

    $stmt = $con->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database query preparation failed: " . $con->error);
    }

    // Bind Parameters
    $stmt->bind_param(
        "issssssssssssssssss", 
        $customer, $status, $checkrcv, $projectid, $title, $description, $sowData, $projectIs, $projectType, 
        $projectCategory, $currency, $budgetAmount, $startDate, $endDate, 
        $contactName, $contactEmail, $contactNumber, $notificationEmail, $coupon
    );

    if (!$stmt->execute()) {
        throw new Exception("Failed to upload project: " . $stmt->error);
    }

    echo json_encode(["status" => "success", "message" => "Project uploaded successfully!"]);
    $stmt->close();

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>

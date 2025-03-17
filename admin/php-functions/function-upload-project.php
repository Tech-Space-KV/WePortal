<?php
require('../session-management.php'); 
require('../../required/db-connection/connection.php'); 

header("Content-Type: application/json"); // Ensure JSON response

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method.");
    }

    // Collect form data
    $customer = $_POST['customer'] ?? null;
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $projectIs = $_POST['projectIs'] ?? null;
    $projectType = $_POST['projectType'] ?? null;
    $projectCategory = $_POST['projectCategory'] ?? null;
    $currency = $_POST['currency'] ?? null;
    $budgetAmount = $_POST['budgetAmount'] ?? null;
    $startDate = $_POST['startDate'] ?? null;
    $endDate = $_POST['endDate'] ?? null;
    $contactName = $_POST['contactName'] ?? null;
    $contactEmail = $_POST['contactEmail'] ?? null;
    $contactNumber = $_POST['contactNumber'] ?? null;
    $notificationEmail = $_POST['notificationEmail'] ?? null;
    $coupon = $_POST['coupon'] ?? null


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
        (plist_customer_id, plist_title, plist_description, plist_sow, plist_ongnew, plist_type, plist_category, plist_currency, plist_budget, plist_startdate, plist_enddate, plist_name, plist_email, plist_contact, plist_customeremail, plist_coupon, created_at, updated_at, plist_projectid) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 'Pseudo-".(new DateTime())->format("Y")."-".(new DateTime())->format("mdHis")."')";

    $stmt = $con->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database query preparation failed.");
    }

    $stmt->bind_param(
        "isssssssdssssssss", 
        $customer, $title, $description, $sowData, $projectIs, $projectType, $projectCategory, 
        $currency, $budgetAmount, $startDate, $endDate, $contactName, 
        $contactEmail, $contactNumber, $notificationEmail, $coupon, 
    );

    if (!$stmt->execute()) {
        throw new Exception("Failed to upload project.");
    }

    echo json_encode(["status" => "success", "message" => "Project uploaded successfully!"]);
    $stmt->close();

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>

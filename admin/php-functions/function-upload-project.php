<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $customer = $_POST['customer'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $projectIs = $_POST['projectIs'] ?? '';
    $projectType = $_POST['projectType'] ?? '';
    $projectCategory = $_POST['projectCategory'] ?? '';
    $currency = $_POST['currency'] ?? '';
    $budgetAmount = $_POST['budgetAmount'] ?? '';
    $startDate = $_POST['startDate'] ?? '';
    $endDate = $_POST['endDate'] ?? '';
    $contactName = $_POST['contactName'] ?? '';
    $contactEmail = $_POST['contactEmail'] ?? '';
    $contactNumber = $_POST['contactNumber'] ?? '';
    $notificationEmail = $_POST['notificationEmail'] ?? '';
    $coupon = $_POST['coupon'] ?? '';

    // Handle file upload (Scope of Work document)
    $sowFileName = "";
    if (!empty($_FILES["sow"]["name"])) {
        $uploadDir = "uploads/"; // Make sure this directory exists and has proper write permissions
        $sowFileName = basename($_FILES["sow"]["name"]);
        $targetFilePath = $uploadDir . $sowFileName;

        if (move_uploaded_file($_FILES["sow"]["tmp_name"], $targetFilePath)) {
            $sowFileName = $targetFilePath; // Store the file path
        } else {
            echo json_encode(["status" => "error", "message" => "File upload failed."]);
            exit;
        }
    }

    // Store data or process further
    // Example: You can store the data in a database here

    // Prepare response
    $response = [
        "status" => "success",
        "message" => "Project uploaded successfully!",
        "data" => [
            "customer" => $customer,
            "title" => $title,
            "description" => $description,
            "sowFile" => $sowFileName,
            "projectIs" => $projectIs,
            "projectType" => $projectType,
            "projectCategory" => $projectCategory,
            "currency" => $currency,
            "budgetAmount" => $budgetAmount,
            "startDate" => $startDate,
            "endDate" => $endDate,
            "contactName" => $contactName,
            "contactEmail" => $contactEmail,
            "contactNumber" => $contactNumber,
            "notificationEmail" => $notificationEmail,
            "coupon" => $coupon
        ]
    ];

    // Send JSON response
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>

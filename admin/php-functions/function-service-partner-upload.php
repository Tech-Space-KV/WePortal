<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

header('Content-Type: application/json');

$response = [];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method!");
    }

    
    $sprov_name = $_POST['sprov_name'] ?? '';
    $sprov_username = $_POST['sprov_username'] ?? '';
    $sprov_user_type = $_POST['sprov_user_type'] ?? '';
    $sprov_country = $_POST['sprov_country'] ?? '';
    $sprov_state = $_POST['sprov_state'] ?? '';
    $sprov_address = $_POST['sprov_address'] ?? '';
    $sprov_pincode = $_POST['sprov_pincode'] ?? '';
    $sprov_contact = $_POST['sprov_contact'] ?? '';
    $sprov_email = $_POST['sprov_email'] ?? '';
    $sprov_about = $_POST['sprov_about'] ?? '';
    $sprov_organisation_name = $_POST['sprov_organisation_name'] ?? '';
    $sprov_cin = $_POST['sprov_cin'] ?? '';
    $sprov_gstpin = $_POST['sprov_gstpin'] ?? '';
    $sprov_adhaar = $_POST['sprov_adhaar'] ?? '';
    $sprov_body = $_POST['sprov_user_type'] ?? '';
    $sprov_verified = intval($_POST['sprov_verified'] ?? 0);
    $sprov_password = sha1($_POST['sprov_password'] ?? '');
    $sprov_login_flag = intval($_POST['sprov_login_flag'] ?? 0);
    $sprov_profile_completion_flag = intval($_POST['sprov_profile_completion_flag'] ?? 0);
    $sprov_refered_by = $_POST['sprov_refered_by'] ?? '';

    
    $sprov_adhaarfileData = null;
    $sprov_dpData = null;

    if (!empty($_FILES["sprov_adhaarfile"]["tmp_name"])) {
        $sprov_adhaarfileData = file_get_contents($_FILES["sprov_adhaarfile"]["tmp_name"]); 
    }
    if (!empty($_FILES["sprov_dp"]["tmp_name"])) {
        $sprov_dpData = file_get_contents($_FILES["sprov_dp"]["tmp_name"]);
    }


    mysqli_query($con,"INSERT INTO `users` (`name`, `email`, `contact`, `user_type`) 
                  VALUES ('$sprov_name', '$sprov_email', '$sprov_contact', '$sprov_user_type')");

    $sql = "INSERT INTO service_providers (
        sprov_username, sprov_name, sprov_user_type, sprov_country, sprov_state, 
        sprov_address, sprov_pincode, sprov_contact, sprov_email, sprov_date_of_registration, 
        sprov_about, sprov_organisation_name, sprov_cin, sprov_gstpin, sprov_adhaar, 
        sprov_body, sprov_password, sprov_login_flag, sprov_adhaarfile, 
        sprov_profile_completion_flag, sprov_dp, sprov_refered_by, created_at, updated_at, 	sprov_verified
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'),
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), ?
    )";

    $stmt = $con->prepare($sql);
    if (!$stmt) {
        throw new Exception("Database query preparation failed: " . $con->error);
    }

    // ✅ Bind Parameters (Same structure as referenced file)
    $stmt->bind_param(
        "ssssssssssssssssisissi",  
        $sprov_username, $sprov_name, $sprov_user_type, $sprov_country, $sprov_state, $sprov_address, $sprov_pincode, $sprov_contact, $sprov_email,
        $sprov_about, $sprov_organisation_name, $sprov_cin, $sprov_gstpin, $sprov_adhaar, $sprov_body, $sprov_password, $sprov_login_flag, $sprov_adhaarfileData, 
        $sprov_profile_completion_flag, $sprov_dpData, $sprov_refered_by, $sprov_verified
    );

    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Service partner added successfully!";
        
    } else {
        throw new Exception("Database Error: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    $response["status"] = "error";
    $response["message"] = $e->getMessage();
}

echo json_encode($response);
?>
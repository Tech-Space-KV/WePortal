<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

header('Content-Type: application/json');

$response = [];

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Invalid request method!");
    }

    
    $pown_name = $_POST['pown_name'] ?? '';
    $pown_username = $_POST['pown_username'] ?? '';
    $pown_user_type = $_POST['pown_user_type'] ?? '';
    $pown_user_type2 = 'customer';
    $pown_country = $_POST['pown_country'] ?? '';
    $pown_state = $_POST['pown_state'] ?? '';
    $pown_address = $_POST['pown_address'] ?? '';
    $pown_pincode = $_POST['pown_pincode'] ?? '';
    $pown_contact = $_POST['pown_contact'] ?? '';
    $pown_email = $_POST['pown_email'] ?? '';
    $pown_about = $_POST['pown_about'] ?? '';
    $pown_organisation_name = $_POST['pown_organisation_name'] ?? '';
    $pown_cin = $_POST['pown_cin'] ?? '';
    $pown_gstpin = $_POST['pown_gstpin'] ?? '';
    $pown_adhaar = $_POST['pown_adhaar'] ?? '';
    $pown_body = $_POST['pown_user_type'] ?? '';
    $pown_verified = intval($_POST['pown_verified'] ?? 0);
    // $pown_password = sha1($_POST['pown_password'] ?? '');
    $pown_password = password_hash($_POST['pown_password'], PASSWORD_BCRYPT);
    $pown_login_flag = intval($_POST['pown_login_flag'] ?? 0);
    $pown_profile_completion_flag = intval($_POST['pown_profile_completion_flag'] ?? 0);
    $pown_refered_by = $_POST['pown_refered_by'] ?? '';

    
    $pown_adhaarfileData = null;
    $pown_dpData = null;

  
    if (!empty($_FILES["pown_adhaarfile"]["tmp_name"])) {
        $pown_adhaarfileData = file_get_contents($_FILES["pown_adhaarfile"]["tmp_name"]); 
    }
    if (!empty($_FILES["pown_dp"]["tmp_name"])) {
        $pown_dpData = file_get_contents($_FILES["pown_dp"]["tmp_name"]);
    }


    // $sql2 = $con->prepare("INSERT INTO `users` (`name`, `email`, `contact`, `user_type`) VALUES (?, ?, ?, ?)");
    // $stmt2 = $con->prepare($sql2);
    // $stmt2->bind_param("ssss", $pown_name, $pown_email, $pown_contact, $pown_user_type);

    // if ($stmt2->execute()) {
       
    // } else {
        
    // }


    mysqli_query($con,"INSERT INTO `users` (`name`, `email`, `contact`, `user_type`) 
                  VALUES ('$pown_name', '$pown_email', '$pown_contact', '$pown_user_type2')");

    
    $sql = "INSERT INTO project_owners (
        pown_username, pown_name, pown_user_type, pown_country, pown_state, 
        pown_address, pown_pincode, pown_contact, pown_email, pown_date_of_registration, 
        pown_about, pown_organisation_name, pown_cin, pown_gstpin, pown_adhaar, 
        pown_body, pown_password, pown_login_flag, pown_adhaarfile, 
        pown_profile_completion_flag, pown_dp, pown_refered_by, created_at, updated_at, pown_verified
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'),
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), DATE_FORMAT(NOW(), '%d-%m-%Y %H:%i:%s'), ?
    )";

    $stmt = $con->prepare($sql);
    // if (!$stmt) {
    //     throw new Exception("Database query preparation failed: " . $con->error);
    // }

    // ✅ Bind Parameters (Same structure as referenced file)
    $stmt->bind_param(
        "ssssssssssssssssisissi",  
        $pown_username, $pown_name, $pown_user_type, $pown_country, $pown_state, $pown_address, $pown_pincode, $pown_contact, $pown_email,
        $pown_about, $pown_organisation_name, $pown_cin, $pown_gstpin, $pown_adhaar, $pown_body, $pown_password, $pown_login_flag, $pown_adhaarfileData, 
        $pown_profile_completion_flag, $pown_dpData, $pown_refered_by, $pown_verified
    );

    if ($stmt->execute()) {

        $response["status"] = "success";
        $response["message"] = "Project owner added successfully!";
        
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
<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
        // Sanitize & Validate Inputs
        $customer = intval($_POST['customer']);
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $projectIs = trim($_POST['projectIs']);
        $projectType = trim($_POST['projectType']);
        $projectCategory = trim($_POST['projectCategory']);
        $currency = trim($_POST['currency']);
        $budgetAmount = floatval($_POST['budgetAmount']);
        $startDate = trim($_POST['startDate']);
        $endDate = trim($_POST['endDate']);
        $contactName = trim($_POST['contactName']);
        $contactEmail = trim($_POST['contactEmail']);
        $contactNumber = trim($_POST['contactNumber']);
        $notificationEmail = trim($_POST['notificationEmail']);
        $coupon = trim($_POST['coupon']);
        $finalPrice = floatval($_POST['finalPrice']);
        $pstatus = trim($_POST['pstatus']);
        $projectStatus = trim($_POST['projectStatus']);
        $statusDescription = trim($_POST['statusDescription']);
        $mngrId = intval($_POST['mngrId']);
        $plistId = intval($_POST['plistId']);

        // Prepare SQL Statement
        $query = "UPDATE project_list SET 
            plist_customer_id=?, plist_title=?, plist_description=?, plist_ongnew=?, plist_type=?, 
            plist_category=?, plist_currency=?, plist_budget=?, plist_startdate=?, plist_enddate=?, 
            plist_name=?, plist_email=?, plist_contact=?, plist_customeremail=?, plist_coupon=?, 
            plist_final_price=?, plist_status=?, plist_project_status=?, plist_project_status_description=?, 
            plist_pt_mngr_id=? WHERE plist_id=?";

        $stmt = mysqli_prepare($con, $query);
        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "issssssssssssssdssssi",
                $customer,
                $title,
                $description,
                $projectIs,
                $projectType,
                $projectCategory,
                $currency,
                $budgetAmount,
                $startDate,
                $endDate,
                $contactName,
                $contactEmail,
                $contactNumber,
                $notificationEmail,
                $coupon,
                $finalPrice,
                $pstatus,
                $projectStatus,
                $statusDescription,
                $mngrId,
                $plistId
            );

            if (mysqli_stmt_execute($stmt)) {
                echo json_encode(["status" => "success", "message" => "Project updated successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Update failed: " . mysqli_stmt_error($stmt)]);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(["status" => "error", "message" => "SQL Error: " . mysqli_error($con)]);
        }
    
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

mysqli_close($con);

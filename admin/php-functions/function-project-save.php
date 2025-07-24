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
        $startDate = date("d-m-Y", strtotime($_POST['startDate'])) ?? null;
        $endDate = date("d-m-Y", strtotime($_POST['endDate'])) ?? null;
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
        $plist_emp_code = trim($_POST['plist_emp_code']);
        $plistId = intval($_POST['plistId']);
        // $delivered_on = intval($_POST['deliveredOn']);
        $delivered_on =  date("d-m-Y", strtotime($_POST['plist_delivered_on'])) ?? null;

        // $delivered_on = ($pstatus === "Delivered") ? date("d-m-Y") : NULL;

        // Prepare SQL Statement
        $query = "UPDATE project_list SET 
            plist_customer_id=?, plist_title=?, plist_description=?, plist_ongnew=?, plist_type=?, 
            plist_category=?, plist_currency=?, plist_budget=?, plist_startdate=?, plist_enddate=?, 
            plist_name=?, plist_email=?, plist_contact=?, plist_customeremail=?, plist_coupon=?, 
            plist_final_price=?, plist_status=?, plist_project_status=?, plist_project_status_description=?, 
            plist_pt_mngr_id=?, plist_emp_code=?, plist_delivered_on=? WHERE plist_id=?";

        $stmt = mysqli_prepare($con, $query);
        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                // "issssssssssssssdssssi",
                "issssssssssssssdsssissi",

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
                $plist_emp_code,
                $delivered_on,
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

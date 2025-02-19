<?php
require('create_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer = $_POST['customer'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $projectIs = $_POST['projectIs'];
    $projectType = $_POST['projectType'];
    $projectCategory = $_POST['projectCategory'];
    $currency = $_POST['currency'];
    $budgetAmount = $_POST['budgetAmount'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $contactName = $_POST['contactName'];
    $contactEmail = $_POST['contactEmail'];
    $contactNumber = $_POST['contactNumber'];
    $notificationEmail = $_POST['notificationEmail'];
    $coupon = $_POST['coupon'];

    // File Upload Handling
    $sow = "";
    // if (!empty($_FILES['sow']['name'])) {
    //     $sow = "uploads/" . basename($_FILES['sow']['name']);
    //     move_uploaded_file($_FILES['sow']['tmp_name'], $sow);
    // }

    $sql = "INSERT INTO projects 
        (customer, title, description, sow, projectIs, projectType, projectCategory, currency, budgetAmount, startDate, endDate, contactName, contactEmail, contactNumber, notificationEmail, coupon) 
        VALUES 
        ('$customer', '$title', '$description', '$sow', '$projectIs', '$projectType', '$projectCategory', '$currency', '$budgetAmount', '$startDate', '$endDate', '$contactName', '$contactEmail', '$contactNumber', '$notificationEmail', '$coupon')";

    if ($conn->query($sql) === TRUE) {
        echo "Project uploaded successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

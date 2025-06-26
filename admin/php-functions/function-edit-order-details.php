<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../session-management.php');
require('../../required/db-connection/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $qty = isset($_POST['ordplcd_final_qty']) ? (int)$_POST['ordplcd_final_qty'] : 0;
    $amount = isset($_POST['ordplcd_final_amount']) ? (int)$_POST['ordplcd_final_amount'] : 0;
    $status = isset($_POST['ordplcd_status']) ? $_POST['ordplcd_status'] : '';

    $stmt = $con->prepare("UPDATE orders_placed SET ordplcd_final_qty = ?, ordplcd_final_amount = ?, ordplcd_status = ? WHERE ordplcd_id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("iisi", $qty, $amount, $status, $order_id);

    if ($stmt->execute()) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Error updating order: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
}
?>

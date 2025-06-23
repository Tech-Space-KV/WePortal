<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

$adminId = $_SESSION['pt-admin-id'] ?? 0;

$response = [];

// Run all the queries
$response['project_owners'] = $con->query("SELECT COUNT(*) as count FROM project_owners")->fetch_assoc()['count'];
$response['service_providers'] = $con->query("SELECT COUNT(*) as count FROM service_providers")->fetch_assoc()['count'];
$response['project_list'] = $con->query("SELECT COUNT(*) as count FROM project_list")->fetch_assoc()['count'];
$response['project_list_by_admin'] = $con->query("SELECT COUNT(*) as count FROM project_list WHERE plist_pt_mngr_id = $adminId")->fetch_assoc()['count'];
$response['hardwares'] = $con->query("SELECT COUNT(*) as count FROM hardwares")->fetch_assoc()['count'];
$response['orders_pending'] = $con->query("SELECT COUNT(*) as count FROM orders_placed WHERE ordplcd_status = 'Pending'")->fetch_assoc()['count'];
$response['orders_placed'] = $con->query("SELECT COUNT(*) as count FROM orders_placed WHERE ordplcd_status = 'Placed'")->fetch_assoc()['count'];
$response['tickets_count'] = $con->query("SELECT COUNT(*) as count FROM tickets")->fetch_assoc()['count'];

// Send response as JSON
echo json_encode($response);
?>

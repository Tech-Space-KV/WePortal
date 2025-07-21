<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('../session-management.php');
require('../../required/db-connection/connection.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

/* ----------------------------------------------------------------
   Sanitize / fetch POST fields
---------------------------------------------------------------- */
$project_id  = $_POST['project_id'] ?? '';
$title       = $_POST['title']      ?? '';
$description = $_POST['description']?? '';
$status      = $_POST['projectIs']  ?? '';
$ticket_id   = (int)($_POST['ticket_id'] ?? 0);
$tckt_asgnd_to_pt_id = ($_POST['mngrId'] === 'None' || empty($_POST['mngrId'])) ? NULL : $_POST['mngrId'];
$tckt_asgnd_to_sp_id = ($_POST['spId'] === 'None' || empty($_POST['spId'])) ? NULL : $_POST['spId'];

/* Basic validation */
if (!$ticket_id || $title === '' || $description === '' || $status === '') {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

/* ----------------------------------------------------------------
   Update query (prepared)
---------------------------------------------------------------- */
$stmt = $con->prepare(
    "UPDATE tickets
     SET tckt_project_id = ?,
         tckt_title       = ?,
         tckt_description = ?,
         tckt_asgnd_to_pt_id = ?,
         tckt_asgnd_to_sp_id = ?,
         tckt_status      = ?
     WHERE tckt_id = ?"
);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => $con->error]);
    exit;
}

$stmt->bind_param('ssssssi', $project_id, $title, $description, $tckt_asgnd_to_pt_id, $tckt_asgnd_to_sp_id, $status, $ticket_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
?>

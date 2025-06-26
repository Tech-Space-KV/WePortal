<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM service_providers WHERE sprov_id = $id";
    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
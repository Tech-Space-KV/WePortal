<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');


if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $query = "DELETE FROM project_owners WHERE pown_id = $id";
    if (mysqli_query($con, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}

?>
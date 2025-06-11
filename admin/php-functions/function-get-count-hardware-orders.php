<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

$query = "SELECT COUNT(*) AS total FROM orders_placed where ordplcd_status = 'Pending'";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);

echo $data['total'];

?>

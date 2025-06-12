<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

$query = "SELECT COUNT(*) AS total FROM notifications where ntfn_type = 'pt' and ntfn_readflag = 0 ";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);

echo $data['total'];

?>

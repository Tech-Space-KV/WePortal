<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $email = '';

    // Step 1: Get the email of the project owner
    $stmt = $con->prepare("SELECT sprov_email FROM service_providers WHERE sprov_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    // Step 2: Delete from sp table
    $stmt = $con->prepare("DELETE FROM service_providers WHERE sprov_id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {

        // Step 3: Delete from users table using the fetched email
        $stmt->close();
        $stmt = $con->prepare("DELETE FROM users WHERE email = ? AND user_type = 'SP'");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }

    $stmt->close();
}
?>


<?php
// require('../session-management.php');
// require('../../required/db-connection/connection.php');

// if (isset($_POST['id'])) {
//     $id = intval($_POST['id']);
//     $query = "DELETE FROM service_providers WHERE sprov_id = $id";
//     if (mysqli_query($con, $query)) {
//         echo "success";
//     } else {
//         echo "error";
//     }
// }
?>

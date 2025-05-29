<?php
require_once('../required/db-connection/connection.php');

function generatePassword($length = 12) {
    return bin2hex(random_bytes($length / 2));
}
$generatedPassword = generatePassword();
$hashedPassword = sha1($generatedPassword);

function handleServiceProviderUpdate($sprov_id) {
    global $con; 

    $providerData = [];
    $updateSuccess = false;

    if ($sprov_id) {
        $stmt = $con->prepare("SELECT * FROM service_providers WHERE sprov_id = ?");
        $stmt->bind_param("i", $sprov_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $providerData = $result->fetch_assoc();
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $sprov_id) {
        $generatedPassword = $_POST['sprv_password'] ?? generatePassword();
        $hashedPassword = sha1($generatedPassword);

        $fieldsToUpdate = [
            'sprov_username', 'sprov_name', 'sprov_user_type', 'sprov_country', 'sprov_state', 'sprov_address',
            'sprov_pincode', 'sprov_contact', 'sprov_email', 'sprov_about', 'sprov_organisation_name', 'sprov_cin',
            'sprov_gstpin', 'sprov_adhaar', 'sprov_body', 'sprov_login_flag', 'sprov_profile_completion_flag',
            'sprov_verified_flag', 'sprov_skill1', 'sprov_skill2', 'sprov_skill3', 'sprov_total_experience',
            'sprov_year_of_establishment', 'sprov_refered_by'
        ];

        $updates = [];
        $params = [];
        $types = '';

        foreach ($fieldsToUpdate as $field) {
            if (isset($_POST[$field]) && $_POST[$field] !== '') {
                $updates[] = "$field = ?";
                $params[] = $_POST[$field];
                $types .= 's';
            } else {
                $updates[] = "$field = ?";
                $params[] = $providerData[$field]; 
                $types .= 's';
            }
        }

        // Handle file uploads
        if (!empty($_FILES['sprv_adhaarfile']['name'])) {
            $aadhaarFile = 'uploads/' . basename($_FILES['sprv_adhaarfile']['name']);
            move_uploaded_file($_FILES['sprv_adhaarfile']['tmp_name'], $aadhaarFile);
            $updates[] = "sprov_adhaarfile = ?";
            $params[] = $aadhaarFile;
            $types .= 's';
        }

        if (!empty($_FILES['sprv_dp']['name'])) {
            $profilePic = 'uploads/' . basename($_FILES['sprv_dp']['name']);
            move_uploaded_file($_FILES['sprv_dp']['tmp_name'], $profilePic);
            $updates[] = "sprov_dp = ?";
            $params[] = $profilePic;
            $types .= 's';
        }

        // Always update password
        $updates[] = "sprov_password = ?";
        $params[] = $hashedPassword;
        $types .= 's';

        // Updated timestamp
        $updates[] = "updated_at = NOW()";

        // WHERE clause
        $params[] = $sprov_id;
        $types .= 'i';

        $sql = "UPDATE service_providers SET " . implode(", ", $updates) . " WHERE sprov_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $updateSuccess = $stmt->execute();

        if ($updateSuccess) {
            echo "<div class='alert alert-success'>Service Provider updated successfully!</div>";
            // Reload updated data
            $stmt = $con->prepare("SELECT * FROM service_providers WHERE sprov_id = ?");
            $stmt->bind_param("i", $sprov_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $providerData = $result->fetch_assoc();
            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error updating Service Provider: " . htmlspecialchars($stmt->error) . "</div>";
        }
    }

    return $providerData;
}
?>

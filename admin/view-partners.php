<?php
require('header.php');
require_once('php-functions/function-view-partner-update.php');

$sprov_id = $_GET['id'] ?? null;
$providerData = handleServiceProviderUpdate($sprov_id);

function getFieldValue($data, $field) {
    return isset($data[$field]) && $data[$field] !== null ? htmlspecialchars($data[$field]) : '';
}
?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Edit Service Provider</h2>
    <form method="POST" enctype="multipart/form-data">
        <?php
        $fields = [
            'sprov_username' => 'Username', 'sprov_name' => 'Name', 'sprov_user_type' => 'User Type',
            'sprov_country' => 'Country', 'sprov_state' => 'State', 'sprov_address' => 'Address',
            'sprov_pincode' => 'Pincode', 'sprov_contact' => 'Contact', 'sprov_email' => 'Email',
            'sprov_about' => 'About', 'sprov_organisation_name' => 'Organisation Name', 'sprov_cin' => 'CIN',
            'sprov_gstpin' => 'GSTPIN', 'sprov_adhaar' => 'Aadhaar', 'sprov_body' => 'Body',
            'sprov_skill1' => 'Skill 1', 'sprov_skill2' => 'Skill 2', 'sprov_skill3' => 'Skill 3',
            'sprov_total_experience' => 'Total Experience', 'sprov_year_of_establishment' => 'Year of Establishment',
            'sprov_refered_by' => 'Referred By'
        ];

        foreach ($fields as $field => $label) {
            $value = getFieldValue($providerData, $field);
            echo "<div class='mb-3'>";
            echo "<label for='{$field}' class='form-label'>{$label}</label>";
            echo "<input type='text' class='form-control' id='{$field}' name='{$field}' placeholder='{$label} Not Available' " .
                 ($value !== '' ? "value='{$value}'" : '') . ">";
            echo "</div>";
        }
        ?>

        <div class="mb-3">
            <label for="sprv_adhaarfile" class="form-label">Aadhaar File</label>
            <input type="file" class="form-control" id="sprv_adhaarfile" name="sprv_adhaarfile">
        </div>

        <div class="mb-3">
            <label for="sprv_dp" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="sprv_dp" name="sprv_dp">
        </div>

        <div class="mb-3">
            <label for="sprv_verified_flag" class="form-label">Verified</label>
            <select class="form-select" id="sprv_verified_flag" name="sprov_verified_flag">
                <option value="1" <?= ($providerData['sprov_verified_flag'] ?? '') == '1' ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= ($providerData['sprov_verified_flag'] ?? '') == '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="sprv_login_flag" class="form-label">Login Flag</label>
            <select class="form-select" id="sprv_login_flag" name="sprov_login_flag">
                <option value="1" <?= ($providerData['sprov_login_flag'] ?? '') == '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= ($providerData['sprov_login_flag'] ?? '') == '0' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="sprv_profile_completion_flag" class="form-label">Profile Completion</label>
            <select class="form-select" id="sprv_profile_completion_flag" name="sprov_profile_completion_flag">
                <option value="1" <?= ($providerData['sprov_profile_completion_flag'] ?? '') == '1' ? 'selected' : '' ?>>Completed</option>
                <option value="0" <?= ($providerData['sprov_profile_completion_flag'] ?? '') == '0' ? 'selected' : '' ?>>Not Completed</option>
            </select>
        </div>

        <!-- <div class="mb-3">
            <label for="sprv_password" class="form-label">Password</label>
            <input type="text" class="form-control" id="sprv_password" name="sprv_password" value="<?= htmlspecialchars($providerData['sprov_password'] ?? generatePassword()) ?>" readonly>
        </div> -->

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</main>
<?php require('footer.php'); ?>

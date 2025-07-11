<?php
require('header.php');
require_once('../required/db-connection/connection.php');
require_once('php-functions/function-view-customer-update.php');

function generatePassword($length = 12) {
    return bin2hex(random_bytes($length / 2)); 
}

$generatedPassword = generatePassword();
$hashedPassword = sha1($generatedPassword);

$pown_id = $_GET['id'] ?? null;
$customerData = [];
$updateSuccess = false;

if (!$con) {
    die("Database connection is not established.");
}

// Call external update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pown_id) {
    $updateSuccess = handleCustomerUpdate($con, $pown_id);
}

if ($pown_id) {
    $stmt = $con->prepare("SELECT * FROM project_owners WHERE pown_id = ?");
    $stmt->bind_param("i", $pown_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customerData = $result->fetch_assoc();
}

function getPlaceholder($data, $field) {
    return isset($data[$field]) && trim($data[$field]) !== '' ? htmlspecialchars($data[$field]) : 'Not available';
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Update Customer</h1>
  </div>

  <?php if ($updateSuccess): ?>
    <div class="alert alert-success">Customer updated successfully!</div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <?php
    $fields = [
        'pown_name' => 'Customer Name',
        'pown_username' => 'User Name',
        'pown_user_type' => 'User Type',
        'pown_country' => 'Country',
        'pown_state' => 'State',
        'pown_address' => 'Address',
        'pown_pincode' => 'Pincode',
        'pown_contact' => 'Contact Number',
        'pown_email' => 'Email',
        'pown_about' => 'About',
        'pown_organisation_name' => 'Organisation Name',
        'pown_cin' => 'Company CIN',
        'pown_gstpin' => 'GST Number',
        'pown_adhaar' => 'Aadhaar Number',
        'pown_refered_by' => 'Referred By'
    ];

    foreach ($fields as $id => $label) {
    $placeholder = getPlaceholder($customerData, $id);
    $value = isset($customerData[$id]) && trim($customerData[$id]) !== '' ? htmlspecialchars($customerData[$id]) : null;

    echo "<div class='mb-3'>";
    echo "<label for='{$id}' class='form-label'>{$label}</label>";

    if ($id === 'pown_about') {
        echo "<textarea class='form-control' id='{$id}' name='{$id}' rows='4' placeholder='{$placeholder}'>" . ($value ?? '') . "</textarea>";
    } else {
        echo "<input type='text' class='form-control' id='{$id}' name='{$id}' placeholder='{$placeholder}'" . ($value !== null ? " value='{$value}'" : '') . ">";
    }

    echo "</div>";
}

    ?>

    <div class="mb-3">
      <label for="pown_adhaarfile" class="form-label">Aadhaar File (Upload)</label>
      <input type="file" class="form-control" id="pown_adhaarfile" name="pown_adhaarfile">
    </div>

    <div class="mb-3">
      <label for="pown_dp" class="form-label">Profile Picture</label>
      <input type="file" class="form-control" id="pown_dp" name="pown_dp">
    </div>

    <div class="mb-3">
      <label for="pown_verified" class="form-label">Verified</label>
      <select class="form-select" id="pown_verified" name="pown_verified" required>
        <option value="1" <?= $customerData['pown_verified'] == '1' ? 'selected' : '' ?>>True</option>
        <option value="0" <?= $customerData['pown_verified'] == '0' ? 'selected' : '' ?>>False</option>
      </select>
    </div>

    <!-- <div class="mb-3">
      <label for="pown_password" class="form-label">Password</label>
      <input type="text" class="form-control" id="pown_password" name="pown_password" value="<?= htmlspecialchars($customerData['pown_password'] ?? $generatedPassword); ?>">
    </div> -->

    <div class="mb-3">
      <label for="pown_login_flag" class="form-label">Login Flag</label>
      <select class="form-select" id="pown_login_flag" name="pown_login_flag" required>
        <option value="1" <?= $customerData['pown_login_flag'] == '1' ? 'selected' : '' ?>>Active</option>
        <option value="0" <?= $customerData['pown_login_flag'] == '0' ? 'selected' : '' ?>>Inactive</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="pown_profile_completion_flag" class="form-label">Profile Completion</label>
      <select class="form-select" id="pown_profile_completion_flag" name="pown_profile_completion_flag" required>
        <option value="1" <?= $customerData['pown_profile_completion_flag'] == '1' ? 'selected' : '' ?>>Completed</option>
        <option value="0" <?= $customerData['pown_profile_completion_flag'] == '0' ? 'selected' : '' ?>>Not Completed</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary" id="insert_operation">Update</button> 
  </form>
</main>

<?php require('footer.php'); ?>

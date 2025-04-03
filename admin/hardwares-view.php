<?php require('header.php'); ?>

<?php 
// Secure the GET parameter
if (isset($_GET['hw-id']) && is_numeric($_GET['hw-id'])) {
    $hrdws_id = mysqli_real_escape_string($con, $_GET['hw-id']);
} else {
    die("Invalid Hardware ID.");
}

// Corrected SQL Query
$query = "SELECT 
    `hardwares`.`hrdws_serial_number`, 
    `hardwares`.`hrdws_hw_identifier`, 
    `hardwares`.`hrdws_model_number`,
    `hardwares`.`hrdws_model_description`, 
    `hardwares`.`hrdws_qty`, 
    `hardwares`.`hrdws_family`,
    `hardwares`.`hrdws_city`, 
    `hardwares`.`hrdws_state`, 
    `hardwares`.`hrdws_price`, 
    `hardwares`.`hrdws_sp_id`,
    `service_providers`.`sprov_username`, 
    `service_providers`.`sprov_name`, 
    `service_providers`.`sprov_user_type`,
    `service_providers`.`sprov_country`, 
    `service_providers`.`sprov_state`, 
    `service_providers`.`sprov_address`,
    `service_providers`.`sprov_pincode`, 
    `service_providers`.`sprov_contact`, 
    `service_providers`.`sprov_email`,
    `service_providers`.`sprov_organisation_name`
FROM `hardwares`
LEFT JOIN `service_providers` ON `service_providers`.`sprov_id` = `hardwares`.`hrdws_sp_id`
WHERE `hardwares`.`hrdws_id` = '$hrdws_id'";

$result = mysqli_query($con, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($con));  // Debugging SQL errors
}

$row = mysqli_fetch_assoc($result);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">View Hardware</h1>
    </div>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Serial Number</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_serial_number']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Hardware Identifier</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_hw_identifier']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Model Number</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_model_number']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Model Description</label>
            <textarea class="form-control" readonly><?php echo htmlspecialchars($row['hrdws_model_description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_qty']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Family</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_family']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">City</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_city']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">State</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_state']); ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_price']); ?>" readonly>
        </div>

        <?php if (!empty($row['sprov_username'])) { ?>
        <div class="mb-3">
            <label class="form-label">Service Provider Username</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_username']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Service Provider Name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_name']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_email']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_contact']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" readonly><?php echo htmlspecialchars($row['sprov_address']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Pincode</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_pincode']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Country</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_country']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">State</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_state']); ?>" readonly>
        </div>
        <?php } if (!empty($row['sprov_organisation_name'])) { ?>
        <div class="mb-3">
            <label class="form-label">Organisation Name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sprov_organisation_name']); ?>" readonly>
        </div>
        <?php } ?>
    </form>
</main>

<?php require('footer.php'); ?>

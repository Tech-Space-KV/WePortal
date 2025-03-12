<?php  require('header.php'); ?>

<?php
// Include database connection
require('connection.php'); 

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from project_owners
    $sql = "SELECT pown_id as user_id, pown_name, pown_country, pown_state, 
                   pown_address, pown_pincode, pown_contact, pown_email, 
                   pown_date_of_registration, pown_about, pown_organisation_name, 
                   pown_cin, pown_gstpin, pown_adhaar,pown_user_type
            FROM project_owners 
            WHERE pown_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found'); window.location.href='users.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='users.php';</script>";
    exit;
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden ">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      </div>
      <div class="mb-3">
        <h2>User Details</h2>
        <form action="update_user.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">

            <div class="mb-3">
    <label for="pown_name" class="form-label">Name</label>
    <input type="text" class="form-control" id="pown_name" name="pown_name" 
           value="<?= !empty($user['pown_name']) ? $user['pown_name'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="pown_country" class="form-label">Country</label>
    <input type="text" class="form-control" id="pown_country" name="pown_country" 
           value="<?= !empty($user['pown_country']) ? $user['pown_country'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="pown_state" class="form-label">State</label>
    <input type="text" class="form-control" id="pown_state" name="pown_state" 
           value="<?= !empty($user['pown_state']) ? $user['pown_state'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="pown_address" class="form-label">Address</label>
    <input type="text" class="form-control" id="pown_address" name="pown_address" 
           value="<?= !empty($user['pown_address']) ? $user['pown_address'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="pown_pincode" class="form-label">Pincode</label>
    <input type="text" class="form-control" id="pown_pincode" name="pown_pincode" 
           value="<?= !empty($user['pown_pincode']) ? $user['pown_pincode'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="pown_contact" class="form-label">Contact</label>
    <input type="text" class="form-control" id="pown_contact" name="pown_contact" 
           value="<?= !empty($user['pown_contact']) ? $user['pown_contact'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="pown_email" class="form-label">Email</label>
    <input type="email" class="form-control" id="pown_email" name="pown_email" 
           value="<?= !empty($user['pown_email']) ? $user['pown_email'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="pown_date_of_registration" class="form-label">Date Of Registration</label>
    <input type="date" class="form-control" id="pown_date_of_registration" name="pown_date_of_registration" 
           value="<?= !empty($user['pown_date_of_registration']) ? $user['pown_date_of_registration'] : ''; ?>">
</div>

<div class="mb-3">
    <label for="pown_about" class="form-label">About</label>
    <textarea class="form-control" id="pown_about" name="pown_about" rows="4"><?= !empty($user['pown_about']) ? $user['pown_about'] : 'Not available'; ?></textarea>
</div>

<div class="mb-3">
    <label for="pown_organisation_name" class="form-label">Organisation Name</label>
    <input type="text" class="form-control" id="pown_organisation_name" name="pown_organisation_name" 
           value="<?= !empty($user['pown_organisation_name']) ? $user['pown_organisation_name'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="pown_cin" class="form-label">CIN</label>
    <input type="text" class="form-control" id="pown_cin" name="pown_cin" 
           value="<?= !empty($user['pown_cin']) ? $user['pown_cin'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="pown_gstpin" class="form-label">GST Pin</label>
    <input type="text" class="form-control" id="pown_gstpin" name="pown_gstpin" 
           value="<?= !empty($user['pown_gstpin']) ? $user['pown_gstpin'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="pown_adhaar" class="form-label">Aadhaar</label>
    <input type="text" class="form-control" id="pown_adhaar" name="pown_adhaar" 
           value="<?= !empty($user['pown_adhaar']) ? $user['pown_adhaar'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="pown_user_type" class="form-label">Body</label>
                <!-- Comment 
                <select class="form-select" id="pown_body" name="pown_body" required>
                    <option value="Organisation" <?= $user['body'] == 'Organisation' ? 'selected' : ''; ?>>Organisation</option>
                    <option value="Individual" <?= $user['body'] == 'Inidividual' ? 'selected' : ''; ?>>Individual</option>
                </select> -->
                <input type="text" class="form-control" id="pown_user_type" name="pown_user_type" 
           value="<?= !empty($user['pown_user_type']) ? $user['pown_user_type'] : 'Not available'; ?>">
</div>



            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-danger" onclick="disableUser(<?= $user['user_id']; ?>)">Disable</button>
        </form>
    </div>

    <br><br>
    </main>

    <script>
        function disableUser(userId) {
            if (confirm("Are you sure you want to disable this user?")) {
                window.location.href = "disable_user.php?id=" + userId;
            }
        }
    </script>


<?php  require('footer.php'); ?>

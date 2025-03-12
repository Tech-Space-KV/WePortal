<?php  require('header.php'); ?>

<?php
// Include database connection
require('connection.php'); 

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user details from project_owners
    $sql = "SELECT sprov_id as user_id, sprov_name, sprov_country, sprov_state, 
                   sprov_address, sprov_pincode, sprov_contact, sprov_email, 
                   sprov_date_of_registration, sprov_about,
                   sprov_cin, sprov_gstpin, sprov_adhaar,sprov_user_type
            FROM service_providers 
            WHERE sprov_id = ?";
    
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
        <h2>Service Provider Details</h2>
        <form action="update_users.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">

            <div class="mb-3">
    <label for="sprov_name" class="form-label">Name</label>
    <input type="text" class="form-control" id="sprov_name" name="sprov_name" 
           value="<?= !empty($user['sprov_name']) ? $user['sprov_name'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="sprov_country" class="form-label">Country</label>
    <input type="text" class="form-control" id="sprov_country" name="sprov_country" 
           value="<?= !empty($user['sprov_country']) ? $user['sprov_country'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="sprov_state" class="form-label">State</label>
    <input type="text" class="form-control" id="sprov_state" name="sprov_state" 
           value="<?= !empty($user['sprov_state']) ? $user['sprov_state'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="sprov_address" class="form-label">Address</label>
    <input type="text" class="form-control" id="sprov_address" name="sprov_address" 
           value="<?= !empty($user['sprov_address']) ? $user['sprov_address'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="sprov_pincode" class="form-label">Pincode</label>
    <input type="text" class="form-control" id="sprov_pincode" name="sprov_pincode" 
           value="<?= !empty($user['sprov_pincode']) ? $user['sprov_pincode'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="sprov_contact" class="form-label">Contact</label>
    <input type="text" class="form-control" id="sprov_contact" name="sprov_contact" 
           value="<?= !empty($user['sprov_contact']) ? $user['sprov_contact'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="sprov_email" class="form-label">Email</label>
    <input type="email" class="form-control" id="sprov_email" name="sprov_email" 
           value="<?= !empty($user['sprov_email']) ? $user['sprov_email'] : 'Not available'; ?>" required>
</div>

<div class="mb-3">
    <label for="sprov_date_of_registration" class="form-label">Date Of Registration</label>
    <input type="date" class="form-control" id="sprov_date_of_registration" name="sprov_date_of_registration" 
           value="<?= !empty($user['sprov_date_of_registration']) ? $user['sprov_date_of_registration'] : ''; ?>">
</div>

<div class="mb-3">
    <label for="sprov_about" class="form-label">About</label>
    <textarea class="form-control" id="sprov_about" name="sprov_about" rows="4"><?= !empty($user['sprov_about']) ? $user['sprov_about'] : 'Not available'; ?></textarea>
</div>


<div class="mb-3">
    <label for="sprov_cin" class="form-label">CIN</label>
    <input type="text" class="form-control" id="sprov_cin" name="sprov_cin" 
           value="<?= !empty($user['sprov_cin']) ? $user['sprov_cin'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="sprov_gstpin" class="form-label">GST Pin</label>
    <input type="text" class="form-control" id="sprov_gstpin" name="sprov_gstpin" 
           value="<?= !empty($user['sprov_gstpin']) ? $user['sprov_gstpin'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="sprov_adhaar" class="form-label">Aadhaar</label>
    <input type="text" class="form-control" id="sprov_adhaar" name="sprov_adhaar" 
           value="<?= !empty($user['sprov_adhaar']) ? $user['sprov_adhaar'] : 'Not available'; ?>">
</div>

<div class="mb-3">
    <label for="sprov_user_type" class="form-label">Body</label>
                <!-- Comment 
                <select class="form-select" id="sprov_body" name="sprov_body" required>
                    <option value="Organisation" <?= $user['body'] == 'Organisation' ? 'selected' : ''; ?>>Organisation</option>
                    <option value="Individual" <?= $user['body'] == 'Inidividual' ? 'selected' : ''; ?>>Individual</option>
                </select> -->
                <input type="text" class="form-control" id="sprov_user_type" name="sprov_user_type" 
           value="<?= !empty($user['sprov_user_type']) ? $user['sprov_user_type'] : 'Not available'; ?>">
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
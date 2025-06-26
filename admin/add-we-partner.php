<?php
require_once('../required/db-connection/connection.php'); // should connect to `weusers` DB

function generatePassword($length = 12)
{
  return bin2hex(random_bytes($length / 2)); 
}

$generatedPassword = generatePassword();
$hashedPassword = sha1($generatedPassword);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    // Check if username or ID already exists
    $checkStmt = $con->prepare("SELECT id FROM weusers WHERE id = ? OR username = ?");
    $checkStmt->bind_param("is", $id, $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $errors[] = "User ID or Username already exists.";
    } else {
        $stmt = $con->prepare("INSERT INTO weusers ( `username`, `password`, `email`, `role`) VALUES ( ?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashedPassword, $email, $role);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'> Registration successful!<br>Password: <b>$generatedPassword</b><br><a href='login.php'>Login here</a></div>";
            exit;
        } else {
            $errors[] = "Something went wrong during registration.";
        }
    }
}
?>

<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Register User</h1>
  </div>

  <?php foreach ($errors as $error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endforeach; ?>

  <form method="POST">

    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Generated Password</label>
      <input type="text" class="form-control" id="password" name="password" value="<?= htmlspecialchars($generatedPassword); ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <select class="form-select" id="role" name="role" required>
        <option value="Manager">Manager</option>
        <option value="Viewer">Viewer</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</main>

<?php require('footer.php'); ?>

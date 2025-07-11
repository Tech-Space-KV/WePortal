<?php
require('header.php');
require('../required/db-connection/connection.php');   // make sure $con exists
?>

<!-- jQuery (needed for Select2 and any future AJAX helpers) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 (optional – remove if you’re not using it) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">View Ticket</h1>
  </div>

  <?php
  /* --------------------------------------------------------------------------
     Fetch the ticket we’re viewing
     -------------------------------------------------------------------------- */
  $id = (int) ($_GET['tckt-id'] ?? 0);

  $stmt = $con->prepare("SELECT * FROM tickets WHERE tckt_id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    die('<div class="alert alert-danger">Ticket not found.</div>');
  }
  $row = $result->fetch_assoc();
  $stmt->close();
  ?>

  <form id="ticketForm" enctype="multipart/form-data">

    <!-- Hidden ticket ID so the save script knows which record to update -->
    <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($row['tckt_id']) ?>">

    <div class="mb-3">
      <label for="project_id" class="form-label">Project ID</label>
      <input type="text" class="form-control" id="project_id" name="project_id"
        value="<?= htmlspecialchars($row['tckt_project_id']) ?>">
    </div>

    <div class="mb-3">
      <label for="title" class="form-label">Ticket Title</label>
      <input type="text" class="form-control" id="title" name="title" required
        value="<?= htmlspecialchars($row['tckt_title']) ?>">
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Ticket Description</label>
      <textarea id="description" name="description" class="form-control" rows="5"
        required><?= htmlspecialchars($row['tckt_description']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label d-block">Attachment</label>
      <a class="btn btn-sm btn-outline-primary" onclick="downloadFile(<?= (int) $row['tckt_id'] ?>)">View file</a>
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="mngrId" class="form-label">Assign to manager</label>
        <select class="form-select border border-2 border-primary" id="2mySelect" name="mngrId">


          <option selected value="<?php echo $row['mgr_user_id']; ?>">
            <?php echo $row['mgr_username'] . " (" . $row['mgr_email'] . ")" . " (" . $row['mgr_user_id'] . ")"; ?>
          </option>

          <option>None</option>
          <?php
          $query1 = "SELECT `id` as user_id, `username` as username, `email` as email FROM `weusers`";
          $result1 = mysqli_query($con, $query1);
          while ($row1 = mysqli_fetch_assoc($result1)) {
            ?>
            <option value="<?php echo $row1['user_id']; ?>">
              <?php echo $row1['username'] . " (" . $row1['email'] . ")" . " (" . $row1['user_id'] . ")"; ?>
            </option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="assignedTo" class="form-label">Assigned to SP</label>
        <select class="form-select border border-2 border-primary" id="1mySelect" name="mngrId">


          <option selected value="<?php echo $row['mgr_user_id']; ?>">
            <?php echo $row['mgr_username'] . " (" . $row['mgr_email'] . ")" . " (" . $row['mgr_user_id'] . ")"; ?>
          </option>

          <option>None</option>
          <?php
          $query1 = "SELECT `sprov_id` as user_id, `sprov_name` as username, `sprov_email` as email FROM `service_providers`";
          $result1 = mysqli_query($con, $query1);
          while ($row1 = mysqli_fetch_assoc($result1)) {
            ?>
            <option value="<?php echo $row1['user_id']; ?>">
              <?php echo $row1['username'] . " (" . $row1['email'] . ")" . " (" . $row1['user_id'] . ")"; ?>
            </option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="projectIs" class="form-label">Ticket Status</label>
        <select class="form-select" id="projectIs" name="projectIs" required>
          <?php
          $statuses = ['Open', 'In Progress', 'Close'];
          foreach ($statuses as $s) {
            $sel = $s === $row['tckt_status'] ? 'selected' : '';
            echo "<option value=\"$s\" $sel>$s</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Created on: <?= htmlspecialchars($row['created_at']) ?></label>
      </div>
    </div>

    <!-- NOTE: type="button" prevents default HTML submit -->
    <button type="button" class="btn btn-primary" onclick="update_data()">Save</button>
  </form>

  <br><br>
</main>

<script>
  /* --------------------------------------------------------------
     OPTIONAL Select2 init (remove block if not needed)
  -------------------------------------------------------------- */
  $(function () {
    $('#2mySelect').select2({
      tags: true,
      placeholder: 'Select or type your own option',
      allowClear: true
    }).on('change', sendInputValue);
  });

    $(function () {
    $('#1mySelect').select2({
      tags: true,
      placeholder: 'Select or type your own option',
      allowClear: true
    }).on('change', sendInputValue);
  });

  /* --------------------------------------------------------------
     Save / update ticket via fetch API
  -------------------------------------------------------------- */
  function update_data() {
    const form = document.getElementById('ticketForm');
    const data = new FormData(form);

    fetch('php-functions/function-tickets-save.php', {
      method: 'POST',
      body: data
    })
      .then(r => r.json())
      .then(res => {
        if (res.status === 'success') {
          alert('Ticket updated successfully.');
          // Optionally reload or update UI here
        } else {
          alert('Update failed: ' + res.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert('Something went wrong.');
      });
  }

  /* --------------------------------------------------------------
     File download helper
  -------------------------------------------------------------- */
  function downloadFile(id) {
    window.location.href = `php-functions/function-download-ticket-file.php?id=${id}`;
  }
</script>

<?php require('footer.php'); ?>
<?php
require('header.php');
require('../required/db-connection/connection.php');

// Get ticket ID
$id = (int)($_GET['tckt-id'] ?? 0);

// Fetch ticket + manager email + service provider email
$stmt = $con->prepare("
  SELECT t.*,
         wu.email AS mgr_email,
         sp.sprov_email AS sprov_email
  FROM tickets t
  LEFT JOIN weusers wu ON t.tckt_asgnd_to_pt_id = wu.id
  LEFT JOIN service_providers sp ON t.tckt_asgnd_to_sp_id = sp.sprov_id
  WHERE t.tckt_id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die('<div class="alert alert-danger">Ticket not found.</div>');
}
$row = $result->fetch_assoc();
$stmt->close();
?>

<!-- Include jQuery and Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">View Ticket</h1>
  </div>

  <form id="ticketForm" enctype="multipart/form-data">
    <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($row['tckt_id']) ?>">

    <!-- Project ID --> 
    <!-- <div class="mb-3">
      <label for="project_id" class="form-label">Project ID</label>
      <input type="text" class="form-control" id="project_id" name="project_id"
             value="<?= htmlspecialchars($row['tckt_project_id']) ?>">
    </div> -->

    <!-- Ticket Title -->
    <div class="mb-3">
      <label for="title" class="form-label">Ticket Title</label>
      <input type="text" class="form-control" id="title" name="title" required
             value="<?= htmlspecialchars($row['tckt_title']) ?>">
    </div>

    <!-- Description -->
    <div class="mb-3">
      <label for="description" class="form-label">Ticket Description</label>
      <textarea id="description" name="description" class="form-control" rows="5" required><?= htmlspecialchars($row['tckt_description']) ?></textarea>
    </div>

    <!-- Attachment -->
    <div class="mb-3">
      <label class="form-label">Attachment</label><br>
      <button type="button" class="btn btn-outline-secondary"
              onclick="downloadFile(<?= (int)$row['tckt_id'] ?>)">View file</button>
    </div>

    <!-- Manager Dropdown -->
    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="2mySelect" class="form-label">Assign to manager</label>
        <select id="2mySelect" name="mngrId" class="form-select border border-2 border-primary">
          <option value="None" <?= empty($row['tckt_asgnd_to_pt_id']) ? 'selected' : '' ?>>None</option>
          <?php
          $resM = mysqli_query($con, "SELECT id, email FROM weusers");
          while ($u = mysqli_fetch_assoc($resM)) {
              $sel = ($u['id'] == $row['tckt_asgnd_to_pt_id']) ? 'selected' : '';
              echo "<option value='{$u['id']}' $sel>" . htmlspecialchars($u['email']) . "</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Service Provider Dropdown -->
    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="1mySelect" class="form-label">Assigned to SP</label>
        <select id="1mySelect" name="spId" class="form-select border border-2 border-primary">
          <option value="None" <?= empty($row['tckt_asgnd_to_sp_id']) ? 'selected' : '' ?>>None</option>
          <?php
          $resS = mysqli_query($con, "SELECT sprov_id, sprov_email FROM service_providers");
          while ($sp = mysqli_fetch_assoc($resS)) {
              $sel = ($sp['sprov_id'] == $row['tckt_asgnd_to_sp_id']) ? 'selected' : '';
              echo "<option value='{$sp['sprov_id']}' $sel>" . htmlspecialchars($sp['sprov_email']) . "</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Ticket Status -->
    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="projectIs" class="form-label">Ticket Status</label>
        <select id="projectIs" name="projectIs" class="form-select" required>
          <?php
          foreach (['Open', 'In Progress', 'Close'] as $s) {
            $sel = ($s === $row['tckt_status']) ? 'selected' : '';
            echo "<option value=\"$s\" $sel>$s</option>";
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Created On -->
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Created on: <?= htmlspecialchars($row['created_at']) ?></label>
      </div>
    </div>

    <button type="button" class="btn btn-primary" onclick="update_data()">Save</button>
  </form>
</main>

<script>
  $(function() {
    $('#2mySelect, #1mySelect').select2({ placeholder: 'Select email...', allowClear: true });
  });

  function update_data() {

    //  var mailtoemail = document.getElementById("pplnr_id").value;
    var mailtosp = document.getElementById("1mySelect").value;
    // var tasktitle = document.getElementById("name").value;


    const form = new FormData(document.getElementById('ticketForm'));
    fetch('php-functions/function-tickets-save.php', { method: 'POST', body: form })
      .then(r => r.json())
      .then(res => {

        if(res.status === 'success'){
           let mailData = new FormData();
                    mailData.append("messagefor","ticketupdated");
                    // mailData.append("mailto", mailtoemail);
                    mailData.append("mailtosp", mailtosp);
                    // mailData.append("tasktitle", tasktitle);
                    
                    fetch("php-functions/function-sendmail.php", {
                            method: "POST",
                            body: mailData
                        })
                        .then(response => response.text()) // Assuming it returns plain text
                        .then(mailResponse => {
                            console.log("Mail Response:", mailResponse);
                            //alert(mailResponse);
                            // You may show a success message or do further actions here
                        })
                        .catch(mailError => {
                            console.error("Mail Sending Failed:", mailError);
                           // alert(mailError);
                        });
          // alert("Task added successfully!", "success");       
          // location.reload();
          showNotification("Success","Task added successfully!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        }
        alert(res.status === 'success' ? 'Ticket updated successfully.' : 'Update failed: ' + res.message);
      }).catch(() => alert('Something went wrong.'));
  }

  function downloadFile(id) {
    window.location.href = `php-functions/function-download-ticket-file.php?id=${id}`;
  }
</script>

<?php require('footer.php'); ?>

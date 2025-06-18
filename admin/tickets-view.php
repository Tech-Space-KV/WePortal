<?php require('header.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">View Ticket</h1>
  </div>

  <!-- <div class="alert alert-primary mt-2" role="alert" id="successbox">
            Perfect! Project uploaded successfully.
        </div>
        <div class="alert alert-danger mt-2" role="alert" id="failbox">
            Error: Project upload failed.
        </div> -->


  <?php
  $id = $_GET['tckt-id'];

  // Fetch data
  $sql = "SELECT * FROM tickets WHERE tckt_id = $id";
  $result = $con->query($sql);

  if ($result->num_rows === 0) {
    die("Data not found.");
  }

  $row = $result->fetch_assoc();
  ?>
  <form method="POST" enctype="multipart/form-data">


    <div class="mb-3">
      <label for="title" class="form-label">Any Project ID</label>
      <input type="text" class="form-control" id="title" placeholder="Project id" name="project id"  value="<?php echo $row['tckt_project_id']; ?>">
    </div>

    <div class="mb-3">
      <label for="title" class="form-label">Ticket Title</label>
      <input type="text" class="form-control" id="title" placeholder="Project title" name="title" required value="<?php echo $row['tckt_title']; ?>">
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Ticket Description</label>
      <!-- <input type="textarea" class="form-control" id="description" placeholder="About project"> -->
      <textarea id="description" name="description" class="form-control" required
        placeholder="Enter your description here"><?php echo $row['tckt_description']; ?></textarea>
    </div>

    <div class="mb-3">
      <label for="sow" class="form-label">Any attachment</label>
      <a class="btn btn-sm btn-outline-primary" onclick="downloadFile(<?php echo $row['tckt_id']; ?>)">View here</a>
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="projectIs" class="form-label">Ticket Status</label>
        <select class="form-select" id="projectIs" name="projectIs" required>
          <option selected value="<?php echo $row['tckt_status']; ?>"><?php echo $row['tckt_status']; ?></option>
          <option value="Open">Open</option>
          <option value="In Progress">In Progress</option>
          <option value="Close">Close</option>
        </select>
      </div>

    </div>


    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="startDate" class="form-label" required>Created on date: <?php echo $row['created_at']; ?></label>
      </div>
    </div>


    <button type="submit" name="upload_btn" class="btn btn-primary" onClick="update_data()">Save</button>

  </form>

  <br><br>
</main>




<script>
  $(document).ready(function() {
    // Initialize Select2 with tagging enabled
    $('#mySelect').select2({
      tags: true, // Allows typing new values
      placeholder: "Select or type your own option",
      allowClear: true
    });

    // Ensure AJAX runs when selecting or typing a new value
    $("#mySelect").on("change", function() {
      sendInputValue();
    });
  });
</script>


<script>
  function update_data() {
    const form = document.querySelector('form');
    const formData = new FormData(form);

    fetch('function-tickets-save.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        alert("Ticket updated successfully.");
      } else {
        alert("Update failed: " + data.message);
      }
    })
    .catch(err => {
      console.error("Error:", err);
      alert("Something went wrong.");
    });
  }
</script>



<script>
  function downloadFile(fileId) {
    window.location.href = `php-functions/function-download-ticket-file.php?id=${fileId}`;
  }
</script>


<?php require('footer.php'); ?>
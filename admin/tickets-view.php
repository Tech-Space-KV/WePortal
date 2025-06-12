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
      <input type="text" class="form-control" id="title" placeholder="Project id" name="project id" required value="<?php echo $row['tckt_project_id']; ?>">
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
      <input type="file" class="form-control" id="sow" placeholder="Scope of work" name="sow">
    </div>

    <div class="row">
      <div class="col-md-4 mb-3">
        <label for="projectIs" class="form-label">Ticket Status</label>
        <select class="form-select" id="projectIs" name="projectIs" required>
          <option selected value="<?php echo $row['tckt_status']; ?>"><?php echo $row['tckt_status']; ?></option>
          <option value="New">New</option>
          <option value="On Going">On Going</option>
        </select>
      </div>

    </div>


    <div class="row">
      <div class="col-md-6 mb-3">
        <label for="startDate" class="form-label" required>Created on date</label>
        <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start date" value="<?php echo $row['created_at']; ?>">
      </div>
    </div>


    <button type="submit" name="upload_btn" class="btn btn-primary" onClick="insert_data()">Upload</button>

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
  function insert_data() {
    let form = document.querySelector("form");

    // Store each form field value in variables
    let customer = document.getElementById("mySelect").value;
    let title = document.getElementById("title").value;
    let description = document.getElementById("description").value;
    let sow = document.getElementById("sow").files[0]; // File input
    let projectIs = document.getElementById("projectIs").value;
    let projectType = document.getElementById("projectType").value;
    let projectCategory = document.getElementById("projectCategory").value;
    let currency = document.getElementById("budget").value;
    let budgetAmount = document.getElementById("budgetAmount").value;
    let startDate = document.getElementById("startDate").value;
    let endDate = document.getElementById("endDate").value;
    let contactName = document.getElementsByName("contactName")[0].value;
    let contactEmail = document.getElementsByName("contactEmail")[0].value;
    let contactNumber = document.getElementsByName("contactNumber")[0].value;
    let notificationEmail = document.getElementsByName("notificationEmail")[0].value;
    let coupon = document.getElementsByName("coupon")[0].value;

    // Validate required fields
    if (!customer || !title || !description) {
      alert("Customer, Title, and Description are required!");
      return;
    }

    // Create FormData object
    let formData = new FormData();
    formData.append("customer", customer);
    formData.append("title", title);
    formData.append("description", description);
    if (sow) {
      formData.append("sow", sow);
    }
    formData.append("projectIs", projectIs);
    formData.append("projectType", projectType);
    formData.append("projectCategory", projectCategory);
    formData.append("currency", currency);
    formData.append("budgetAmount", budgetAmount);
    formData.append("startDate", startDate);
    formData.append("endDate", endDate);
    formData.append("contactName", contactName);
    formData.append("contactEmail", contactEmail);
    formData.append("contactNumber", contactNumber);
    formData.append("notificationEmail", notificationEmail);
    formData.append("coupon", coupon);

    // Send data using fetch()
    fetch("php-functions/function-project-upload.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json()) // Expect JSON response
      .then(data => {
        if (data.status === "success") {
          alert(data.message); // Display success message
          // location.reload(); // Refresh page after successful submission
          // document.getElementById("successbox").style.display = "block";
          // document.getElementById("failbox").style.display = "none";
          // document.getElementById("successbox").textContent = "Project uploaded.";
        } else {
          alert("Error: " + data.message); // Display error message
          // document.getElementById("successbox").style.display = "none";
          // document.getElementById("failbox").style.display = "block";
          // document.getElementById("failbox").textContent = "Error: Project upload failed.";
        }
        console.log(data); // Log full response
      })
      .catch(error => {
        alert("Error uploading project. Please try again.");
        console.error("Error:", error);
      });
  }
</script>



<?php require('footer.php'); ?>
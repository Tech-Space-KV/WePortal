<?php  require('header.php'); ?>
<?php $project_id= $_GET['proj-id']; ?>
<?php 
if (isset($_GET['search'])) {
  $search = $_GET['search']; // Get the value
} else {
  $search='';
}
?>

<?php 
  $stdate;
if (isset($_GET['startdate'])) {
  $stdate = $_GET['startdate']; // Get the value
} else {
  $stdate='';
}
?>

<?php 
  $eddate;
if (isset($_GET['enddate'])) {
  $eddate = $_GET['enddate']; // Get the value
} else {
   $eddate='';
}
?>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Project Scope/Locations</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2"><button type="button" class="btn btn-sm btn-outline-secondary" onclick="openviewmodal('nodata')" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Locations</button>
            
			<button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>
          </div>
        </div>
      </div>

      <center>
        <input type="text" class="w-50 mx-auto mb-4" id="tableSearch" placeholder="Search..." onkeyup="searchTable()" />
      </center>

      <div class="table-responsive small">
        <table class="table table-striped table-sm" id="dataTable">
          <thead>
    <tr>
        <th scope="col">Country</th>
        <th scope="col">State</th>
        <th scope="col">City</th>
        <th scope="col">Created on</th>
        <th scope="col">Status</th>
		<th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          <?php
              $query="SELECT * FROM `project_scope` WHERE pscope_project_id = $project_id AND pscope_id like '%$search%'" ;
							$result=mysqli_query($con,$query);
							while( $row=mysqli_fetch_assoc($result))
							{
							    ?>
							    <tr id="">
							       
                  <td class="limited-td">
							            <?php echo $row['pscope_country'] ; ?>
							        </td>
							        <td class="limited-td">
							            <?php echo $row['pscope_state'] ; ?>
							        </td>
							        <td class="limited-td">
							            <?php echo $row['pscope_city'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['created_at'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['pscope_status'] ; ?>
							        </td>
							        <td>
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openviewmodal('<?php echo $row['pscope_id'] ;?>')">view</button>
                      <a class="btn btn-sm btn-primary ms-2" href="milestones?loc-id=<?php echo $row['pscope_id'] ;?>&startdate=<?php echo $stdate ; ?>&enddate=<?php echo $eddate ; ?>">expand</a>
							        </td>
							    </tr>
							    <?php
							    
							}
        
        ?>
	 </tbody>
        </table>
        <div class="pagination" style="float:right;" hidden>
    <button id="prevBtn" class="btn btn-sm btn-outline-primary" onclick="changePage(-1)" disabled>Prev</button>
    <button id="nextBtn" class="btn btn-sm btn-outline-primary" onclick="changePage(1)">Next</button>
  </div>
      
	  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center" id="pagination">
      <!-- Page numbers will go here -->
    </ul>
  </nav>
	  
	  </div>
    </main>
	
	
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Scope/Locations</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="modalForm">

          <!-- Country Field -->
          <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" required>
          </div>

          <!-- State Field -->
          <div class="mb-3">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" required>
          </div>

          <!-- City Field -->
          <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" required>
          </div>

          <!-- Pincode Field -->
          <div class="mb-3">
            <label for="pincode" class="form-label">Pincode</label>
            <input type="text" class="form-control" id="pincode" name="pincode" required>
          </div>

          <div class="mb-3">
            <label for="pincode" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>

          <div class="mb-3">
            <label for="pincode" class="form-label">Status</label>
            <!-- <input type="text" class="form-control" id="status" name="status" required> -->
            <input type="text" class="form-control" id="status" name="status" list="statusOptions" required>
            <datalist id="statusOptions">
                <option value="Not Started">
                <option value="Ongoing">
                <option value="Fullfilled">
                <option value="Scrapped">
            </datalist>

          </div>

          <!-- Scope of Work (SOW) Field -->
          <!-- <div class="mb-3">
            <label for="sow" class="form-label">Scope of Work (SOW)</label>
            <input type="text" class="form-control" id="sow" name="sow" required>
          </div> -->

          <!-- ID Field (Hidden) -->
           
          <input type="hidden" id="pscope_id" name="pscope_id" value="">
          <input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id; ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="insert_operation">Submit</button>
        <button type="submit" class="btn btn-success" id="save_operation">Save</button>
        <button type="submit" class="btn btn-danger" id="delete_operation">Delete</button>
        <button type="button" class="btn btn-secondary" onclick="location.reload()" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<script>
  // Focus on input when modal is opened
  var myModal = document.getElementById('exampleModal');
  var myInput = document.getElementById('country');


  function openviewmodal(stringdata){
    myModal.addEventListener('shown.bs.modal', function () {
      myInput.focus();
    });
    
    // alert(stringdata);
    if(stringdata!='nodata')
      {

               document.getElementById("insert_operation").style.display='none';
              document.getElementById("save_operation").style.display='block';
              document.getElementById("delete_operation").style.display='block';

              fetch(`php-functions/function-location-fetch.php?pscope_id=${stringdata}`)
              .then(response => response.json())
              .then(data => {
                  if (!data.error) {
                      document.getElementById("project_id").value = data.pscope_project_id;
                      document.getElementById("country").value = data.pscope_country;
                      document.getElementById("state").value = data.pscope_state;
                      document.getElementById("city").value = data.pscope_city;
                      document.getElementById("pincode").value = data.pscope_pincode;
                      document.getElementById("address").value = data.pscope_address;
                      document.getElementById("status").value = data.pscope_status;
                      document.getElementById("pscope_id").value = stringdata;
                      // Show modal
                      var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                      modal.show();
                  } else {
                      alert("No data found!");
                  }
              })
              .catch(error => console.error("Error fetching data:", error));
      }
      else
      {
              document.getElementById("insert_operation").style.display='block';
              document.getElementById("save_operation").style.display='none';
              document.getElementById("delete_operation").style.display='none';
      }
  }

  // Handle form submission
  document.getElementById("insert_operation").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData();
    formData.append("project_id", document.getElementById("project_id").value);
    formData.append("country", document.getElementById("country").value);
    formData.append("state", document.getElementById("state").value);
    formData.append("city", document.getElementById("city").value);
    formData.append("pincode", document.getElementById("pincode").value);
    formData.append("address", document.getElementById("address").value);
    formData.append("status", document.getElementById("status").value);

    fetch("php-functions/function-location-upload.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
        if (data.status === "success") {
          alert("Location added successfully!", "success");
          location.reload();
        } else {
            alert("Failed to add location!", "error");
            location.reload();
        }
    })
    .catch(error => {
      alert("Error in request!", "error");
        console.error("Error:", error);
        location.reload();
    });

       // Close modal after submission
       var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
       modalElement.hide();
   
       // Reset form after submission
       document.getElementById("modalForm").reset();
       
});



document.getElementById("save_operation").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData();
    formData.append("project_id", document.getElementById("project_id").value);
    formData.append("country", document.getElementById("country").value);
    formData.append("state", document.getElementById("state").value);
    formData.append("city", document.getElementById("city").value);
    formData.append("pincode", document.getElementById("pincode").value);
    formData.append("address", document.getElementById("address").value);
    formData.append("status", document.getElementById("status").value);
    formData.append("pscope_id", document.getElementById("pscope_id").value);

    fetch("php-functions/function-location-save.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
        if (data.status === "success") {
          alert("Location saved successfully!", "success");
          location.reload();
        } else {
            alert("Failed to save location!", "error");
            location.reload();
        }
    })
    .catch(error => {
      alert("Error in request!", "error");
        console.error("Error:", error);
        location.reload();
    });

       // Close modal after submission
       var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
       modalElement.hide();
   
       // Reset form after submission
       document.getElementById("modalForm").reset();
       
});





document.getElementById("delete_operation").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData();
    formData.append("project_id", document.getElementById("project_id").value);
    formData.append("pscope_id", document.getElementById("pscope_id").value);

    fetch("php-functions/function-location-delete.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
        if (data.status === "success") {
          alert("Location deleted successfully!", "success");
          location.reload();
        } else {
            alert("Failed to delete location!", "error");
            location.reload();
        }
    })
    .catch(error => {
      alert("Error in request!", "error");
        console.error("Error:", error);
        location.reload();
    });

       // Close modal after submission
       var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
       modalElement.hide();
   
       // Reset form after submission
       document.getElementById("modalForm").reset();
       
});





</script>

	
	<?php  require('footer.php'); ?>
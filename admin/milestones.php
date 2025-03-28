<?php  require('header.php'); ?>
<?php $location_id= $_GET['loc-id']; ?>
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Project Milestones</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2"><button type="button" class="btn btn-sm btn-outline-secondary" onclick="openviewmodal('nodata')" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Milestone</button>
            
			<button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>
          </div>
        </div>
      </div>

      <div class="table-responsive small">
        <table class="table table-striped table-sm" id="dataTable">
          <thead>
            <tr>
                <th scope="col">Milestones</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Created On</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          <?php
              $query="SELECT * FROM `project_planner` WHERE pplnr_scope_id = $location_id" ;
							$result=mysqli_query($con,$query);
							while( $row=mysqli_fetch_assoc($result))
							{
							    ?>
							    <tr id="">
							       
                  <td>
							            <?php echo $row['pplnr_milestone'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['pplnr_start_date'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['pplnr_end_date'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['created_at'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['pplnr_status'] ; ?>
							        </td>
							        <td>
                      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openviewmodal('<?php echo $row['pplnr_id'] ;?>')">view</button>
                      <a class="btn btn-sm btn-primary ms-2" href="tasks?mil-id=<?php echo $row['pplnr_id'] ;?>">expand</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Milestone</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="modalForm">
          <!-- Name Field -->
          <div class="mb-3">
            <label for="name" class="form-label"> Milestone Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <!--Description Field -->
          <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
          </div>

          <!-- Start Date Field -->
          <div class="mb-3">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startDate" name="startDate" required>
          </div>

          <!-- End Date Field -->
          <div class="mb-3">
            <label for="endDate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate" required>
          </div>

          <!-- Status Field -->
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" class="form-control" id="status" name="status" list="statusOptions" required>
            <datalist id="statusOptions">
                <option value="Not Started">
                <option value="Ongoing">
                <option value="Fullfilled">
                <option value="Scrapped">
            </datalist>
          </div>

          <!-- Hidden ID Field -->
          <input type="hidden" id="pplnr_id" name="pplnr_id" value="">
          <input type="hidden" id="pscope_id" name="pscope_id" value="<?php echo $location_id; ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="location.reload()" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="insert_operation">Submit</button>
        <button type="submit" class="btn btn-success" id="save_operation">Save</button>
        <button type="submit" class="btn btn-danger" id="delete_operation">Delete</button>
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
    
    alert(stringdata);
    if(stringdata!='nodata')
      {
              fetch(`php-functions/function-milestone-fetch.php?pplnr_id=${stringdata}`)
              .then(response => response.json())
              .then(data => {
                  if (!data.error) {
                      document.getElementById("pscope_id").value = data.pplnr_scope_id;
                      document.getElementById("name").value = data.pplnr_milestone;
                      document.getElementById("description").value = data.pplnr_description;
                      document.getElementById("startDate").value = convertToDate(data.pplnr_start_date);
                      document.getElementById("endDate").value = convertToDate(data.pplnr_end_date);
                      document.getElementById("status").value = data.pplnr_status;
                      document.getElementById("pplnr_id").value = stringdata;
                      // Show modal
                      var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                      modal.show();
                  } else {
                      alert("No data found!");
                  }
              })
              .catch(error => console.error("Error fetching data:", error));
      }
  }

  // Handle form submission
  document.getElementById("insert_operation").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData();
    formData.append("pscope_id", document.getElementById("pscope_id").value);
    formData.append("name", document.getElementById("name").value);
    formData.append("description", document.getElementById("description").value);
    formData.append("startDate", document.getElementById("startDate").value);
    formData.append("endDate", document.getElementById("endDate").value);
    formData.append("status", document.getElementById("status").value);

    fetch("php-functions/function-milestone-upload.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
        if (data.status === "success") {
          alert("Milestone added successfully!", "success");
          location.reload();
        } else {
            alert("Failed to add milestone!", "error");
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
    formData.append("pscope_id", document.getElementById("pscope_id").value);
    formData.append("name", document.getElementById("name").value);
    formData.append("description", document.getElementById("description").value);
    formData.append("startDate", document.getElementById("startDate").value);
    formData.append("endDate", document.getElementById("endDate").value);
    formData.append("status", document.getElementById("status").value);
    formData.append("pplnr_id", document.getElementById("pplnr_id").value);

    fetch("php-functions/function-milestone-save.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
        if (data.status === "success") {
          alert("Milestone saved successfully!", "success");
          location.reload();
        } else {
            alert("Failed to save milestone!", "error");
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
    formData.append("pscope_id", document.getElementById("pscope_id").value);
    formData.append("pplnr_id", document.getElementById("pplnr_id").value);

    fetch("php-functions/function-milestone-delete.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
        if (data.status === "success") {
          alert("Milestone deleted successfully!", "success");
          location.reload();
        } else {
            alert("Failed to delete milestone!", "error");
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




function convertToDate(dateString) {
    if (!dateString) return ""; // Handle empty or invalid date

    let dateParts = dateString.split(/[-\/]/); // Split by "-" or "/"
    
    if (dateParts.length === 3) {
        let year, month, day;

        if (dateParts[0].length === 4) {
            // Format: YYYY-MM-DD or YYYY/MM/DD
            year = dateParts[0];
            month = dateParts[1];
            day = dateParts[2];
        } else {
            // Format: DD-MM-YYYY or MM-DD-YYYY
            year = dateParts[2];
            month = dateParts[1];
            day = dateParts[0];
        }

        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }

    return "";
}


</script>

	
	<?php  require('footer.php'); ?>
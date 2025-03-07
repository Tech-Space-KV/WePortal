<?php  require('header.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Project Locations</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Locations</button>
			<button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>
          </div>
        </div>
      </div>

      <div class="table-responsive small">
        <table class="table table-striped table-sm" id="dataTable">
          <thead>
            <tr>
               <th scope="col">Proj. ID.</th>
        <th scope="col">Title</th>
        <th scope="col">Start Date</th>
        <th scope="col">End Date</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
		<th scope="col"></th>
            </tr>
          </thead>
          <tbody>
		  <tr>
              <td>1,001</td>
              <td>random</td>
              <td>data</td>
              <td>placeholder</td>
              <td>text</td>
			  <td></td>
			  <td>
				<a class="btn btn-sm btn-primary ms-2" href="milestones">expand</a>
			  </td>
            </tr>
	 </tbody>
        </table>
      
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
        <h5 class="modal-title" id="exampleModalLabel">Form Modal</h5>
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
            <input type="number" class="form-control" id="pincode" name="pincode" required>
          </div>

          <!-- Scope of Work (SOW) Field -->
          <div class="mb-3">
            <label for="sow" class="form-label">Scope of Work (SOW)</label>
            <input type="text" class="form-control" id="sow" name="sow" required>
          </div>

          <!-- ID Field (Hidden) -->
          <input type="hidden" id="ProjectId" name="ProjectId" value="12345">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Focus on input when modal is opened
  var myModal = document.getElementById('exampleModal');
  var myInput = document.getElementById('country');

  myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus();
  });

  // Handle form submission
  document.getElementById("submitBtn").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default form submission

    // Get form values

    let country = document.getElementById("country").value;
    let state = document.getElementById("state").value;
    let city = document.getElementById("city").value;
    let pincode = document.getElementById("pincode").value;
    let sow = document.getElementById("sow").value;
    let Id = document.getElementById("ProjectId").value;

    // Show alert with form details
    alert(
      "Form Details:\n" +
      "Country: " + country + "\n" +
      "State: " + state + "\n" +
      "City: " + city + "\n" +
      "Pincode: " + pincode + "\n" +
      "Scope of Work (SOW): " + sow + "\n" +
      "Project ID (Hidden): " + Id 
    );

    // Close modal after submission
    var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalElement.hide();

    // Reset form after submission
    document.getElementById("modalForm").reset();
  });
</script>

	
	<?php  require('footer.php'); ?>
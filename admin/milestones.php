<?php  require('header.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Project Milestones</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
		  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Milestones</button>
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
				<a class="btn btn-sm btn-primary ms-2" href="tasks">expand</a>
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
          <!-- Name Field -->
          <div class="mb-3">
            <label for="name" class="form-label"> Milestone Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <!--Description Field -->
          <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <input type="text" class="form-control" id="Description" name="Description" required>
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
            <input type="text" class="form-control" id="status" name="status" required>
          </div>

          <!-- Hidden ID Field -->
          <input type="hidden" id="ScopeId" name="ScopeId" value="12345">
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
  var myInput = document.getElementById('name');

  myModal.addEventListener('shown.bs.modal', function () {
    myInput.focus();
  });

  // Handle form submission
  document.getElementById("submitBtn").addEventListener("click", function () {
    // Get form values
    let name = document.getElementById("name").value;
    let description = document.getElementById("Description").value;
    let startDate = document.getElementById("startDate").value;
    let endDate = document.getElementById("endDate").value;
    let status = document.getElementById("status").value;
    let scopeId = document.getElementById("ScopeId").value;

    // Show alert with form details
    alert(
      "Form Details:\n" +
      "Milestone Name: " + name + "\n" +
      "Description: " + description +"\n"+
      "Start Date: " + startDate + "\n" +
      "End Date: " + endDate + "\n" +
      "Status: " + status + "\n" +
      "Scope ID (Hidden): " + scopeId
    );
  });
</script>

	
	
	
	<?php  require('footer.php'); ?>
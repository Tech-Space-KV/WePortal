<?php  require('header.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="add_customer">Add Customer</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="add_service_partner ">Add Service Partner</a>
			<button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>
			
          </div>
        </div>
      </div>

      <div class="table-responsive small">
        <table class="table table-striped table-sm" id="dataTable">
          <thead>
            <tr>
               <th scope="col">User ID</th>
        <th scope="col">Category</th>
        <th scope="col">Name</th>
        <th scope="col">Contact</th>
        <th scope="col">Email</th>
        <th scope="col">Type</th>
        <th scope="col">Verified</th>
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
	
	
	
	<?php  require('footer.php'); ?>
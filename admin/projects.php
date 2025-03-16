<?php  require('header.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Projects</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="upload-project">Upload Project</a>
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
              <th scope="col">Customer ID</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
          <?php
              $query="SELECT `plist_id`, `plist_customer_id`, `plist_projectid`, `plist_title`, `plist_description`, `plist_startdate`, `plist_enddate`, `plist_status` FROM `project_list`" ;
							$result=mysqli_query($con,$query);
							while( $row=mysqli_fetch_assoc($result))
							{
							    ?>
							    <tr id="row-<?php echo $row['plist_id']; ?>">
							       
                  <td>
							            <?php echo $row['plist_projectid'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['plist_title'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['plist_startdate'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['plist_enddate'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['plist_status'] ; ?>
							        </td>
							        <td>
							            <?php echo $row['plist_customer_id'] ; ?>
							        </td>
							        <td>
                      <a class="btn btn-sm btn-primary" href="view-project">view</a>
                      <a class="btn btn-sm btn-primary ms-2" href="locations">expand</a>
							        </td>
							    </tr>
							    <?php
							    
							}
        
        ?>
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
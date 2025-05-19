<?php  require('header.php');
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0 d-flex flex-wrap justify-content-end">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <svg class="bi"><use xlink:href="#calendar3"/></svg>
            This week
          </button>
        </div>
      </div>


      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

      <h2>Recent Projects</h2>
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
            </tr>
          </thead>
          <tbody>
          <?php
              $query="SELECT `plist_id`, `plist_customer_id`, `plist_projectid`, `plist_title`, `plist_description`, `plist_startdate`, `plist_enddate`, `plist_status` FROM `project_list` WHERE plist_status = 'NO SP Assigned'  order by 1 desc " ;
							$result=mysqli_query($con,$query);
							while( $row=mysqli_fetch_assoc($result))
							{
							    ?>
							    <tr id="row-<?php echo $row['plist_id']; ?>">
							       
                  <td>
							            <?php echo $row['plist_projectid'] ; ?>
							        </td>
							        <td class="limited-td">
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
                        <a class="btn btn-sm btn-outline-primary" href="purchase-form-view.php?pid=<?php echo $row['pur_id'] ; ?>">View</a>
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
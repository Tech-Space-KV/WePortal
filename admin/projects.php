<?php  require('header.php'); ?>
<?php 
if (isset($_GET['search'])) {
  $search = $_GET['search']; // Get the value
} else {
  $search='';
}
if (isset($_GET['status'])) {
  $status = $_GET['status']; // Get the value
} else {
  $status='';
}

?>

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

      <center>
        <input type="text" class="w-50 mx-auto mb-4" id="tableSearch" placeholder="Search..." onkeyup="searchTable()" />
      </center>

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
              $query="SELECT `project_owners`.`pown_name`, `project_owners`.`pown_id`, `project_owners`.`pown_username`, `project_owners`.`pown_user_type`,  `project_owners`.`pown_organisation_name`,
              `weusers`.`id`, `weusers`.`username`, `weusers`.`email`,  
              `plist_id`, `plist_customer_id`, `plist_projectid`, `plist_title`, `plist_description`, `plist_startdate`, `plist_enddate`, `plist_status` FROM `project_list`
              JOIN `project_owners` ON `pown_id` = `plist_customer_id`
              LEFT JOIN `weusers` ON `id` = `plist_pt_mngr_id`
              WHERE `plist_id` like '%$search%' AND `plist_status` like '%$status%' ";
							$result=mysqli_query($con,$query);
							while( $row=mysqli_fetch_assoc($result))
							{
							    ?>
							    <tr id="<?php echo $row['plist_id'] ;?>" 
                      title="<?php echo $row['pown_id'].'\n'.$row['pown_username'].'<br>'.$row['pown_name'].'<br>'.$row['pown_user_type'].'<br>'.$row['pown_organisation_name'] ;?>">
							       
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
							        <td title="email">
							            <?php echo $row['username'] ; ?>
							        </td>
							        <td>
                      <a class="btn btn-sm btn-primary" href="project-view?project_key=<?php echo $row['plist_id'] ;?>">view</a>
                      <a class="btn btn-sm btn-primary" href="project-tree?project_key=<?php echo $row['plist_id'] ;?>">timeline</a>
                      <a class="btn btn-sm btn-primary" href="locations?proj-id=<?php echo $row['plist_id'] ;?>">expand</a>
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
	


	
	
	<?php  require('footer.php'); ?>
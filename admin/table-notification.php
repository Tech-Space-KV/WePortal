<?php  require('header.php'); ?>

<?php
// Include database connection
include 'connection.php';

// SQL Query to fetch data from both tables 
// Not taken username as the column is not present in both the tables
 $sql = "SELECT ntfn_id,ntfn_notification,ntfn_date_time,ntfn_readflag
        FROM 	notifications";


$result = $conn->query($sql);

?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Notification</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
			<button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>
			
          </div>
        </div>
      </div>

      <div class="table-responsive small">
        <table class="table table-striped table-sm" id="dataTable">
          <thead>
            <tr>
               <th scope="col">Notification</th>
        <th scope="col">Date/Time</th>
        <th scope="col">Read/Unread</th>
        <th scope="col">Action</th>
		<th scope="col"></th>
            </tr>
          </thead>
          <tbody>
                <?php
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
      $btnClass = ($row['ntfn_readflag'] == 1) ? 'btn-outline-warning' : 'btn-outline-success';
      $btnText = ($row['ntfn_readflag'] == 1) ? 'Unread' : 'Read';

      echo "<tr>
              <td>{$row['ntfn_notification']}</td>
              <td>{$row['ntfn_date_time']}</td>
              <td class='status' data-id='{$row['ntfn_id']}'>" . (($row['ntfn_readflag'] == 1) ? 'Read' : 'Unread') . "</td>
              <td>
                  <button class='btn btn-sm $btnClass toggle-read' data-id='{$row['ntfn_id']}'>{$btnText}</button>
                  <button class='btn btn-sm btn-outline-primary delete-btn' data-id='{$row['ntfn_id']}'>Delete</button>
              </td>
            </tr>";
  }
} else {
  echo "<tr><td colspan='4'>No notifications found</td></tr>";
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
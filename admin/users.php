<?php  require('header.php'); ?>

<?php
// Include database connection
include 'connection.php';

// SQL Query to fetch data from both tables 
// Not taken username as the column is not present in both the tables
 $sql = "SELECT pown_id as user_id,'Partner' as title,pown_name as name,pown_user_type as user_type,pown_contact as contact,pown_email as email
        FROM 	project_owners 
         UNION
         SELECT sprov_id as user_id,'Partner' as title,sprov_name as name,sprov_user_type as user_type,sprov_contact as contact,sprov_email as email
         FROM service_providers";


$result = $conn->query($sql);

?>



    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="d-flex flex-wrap gap-2">
            <a type="button" class="btn btn-sm btn-outline-secondary" href="add_customer">Add Customer</a>
            <a type="button" class="btn btn-sm btn-outline-secondary" href="service-partner ">Add Service Partner</a>
			<button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>
			
          </div>
        </div>
      </div>

      <div class="table-responsive small">
        <table class="table table-striped table-sm" id="dataTable">
          <thead>
            <tr>
               <th scope="col">User ID</th> 
  <!-- Category,title,username and verified has been removed,I have also changed the linking from milestones to view-customers-->   
        <th scope="col">Name</th>
        <th scope="col">Contact</th>
        <th scope="col">Email</th>
        <th scope="col">Type</th>
		<th scope="col"></th>
            </tr>
          </thead>
          <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Correcting the typo "Inidividual" -> "Individual"
            $formPage = ($row['user_type'] === 'Inidividual') ? 'user-details.php' : 'service-provider-details.php';

            echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['contact']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['user_type']}</td>
                    <td>
                        <a href='{$formPage}?id={$row['user_id']}' class='btn btn-sm btn-primary ms-2'>Expand</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No records found</td></tr>";
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
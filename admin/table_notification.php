<?php  require('header.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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
        <th scope="col">Read</th>
        <th scope="col">Action</th>
		<th scope="col"></th>
            </tr>
          </thead>
          <form action="#" method="post">
            <tr>
                <td>Ordered</td>
                <td>Unread</td>
                <td><button type="Delete" class="btn btn-sm btn-outline-primary">Delete</button></td>
            </tr>
        </form>
        <form action="#" method="post">
            <tr>
                <td>Received</td>
                <td>Unread</td>
                <td><button type="Delete" class="btn btn-sm btn-outline-primary">Delete</button></td>
            </tr>
        </form>
        <form action="#" method="post">
            <tr>
                <td>Delivered</td>
                <td>Unread</td>
                <td><button type="Delete" class="btn btn-sm btn-outline-primary">Delete</button></td>
            </tr>
        </form>
        </table>
      
	  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center" id="pagination">
      <!-- Page numbers will go here -->
    </ul>
  </nav>
	  
	  </div>
	  
    </main>
	
	
	
	<?php  require('footer.php'); ?>
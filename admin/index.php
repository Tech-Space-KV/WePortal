<?php require('header.php');
?>
<style>
  /* Chart Styling */
  .chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    max-width: 500px;
    height: 300px;
    /* Fixed height to ensure visibility */
    margin: 0 auto;
    overflow: hidden;
    position: relative;
    /* Ensure chart remains positioned */

  }

  canvas {
    width: 100% !important;
    height: 100% !important;
    max-width: 400px;
  }

  /* Card Layout - Keeping Your Design */
  .card-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 30px;
    margin-left: 70px;
  }

  .card {
    width: 200px;
    height: 130px;
    text-align: center;
    transition: 0.3s;
  }

  .card:hover {
    transform: scale(1.05);
  }

  /* Mobile Adjustments */
  @media (max-width: 768px) {
    .chart-container {
      max-width: 100%;
      height: 250px;
    }

    .card-container {
      margin-left: 0;
      justify-content: center;
    }
  }

  @media (max-width: 576px) {
    .chart-container {
      height: 220px;
    }

    .card-container {
      margin-left: 0;
      justify-content: center;
    }

    .card {
      width: 180px;
      margin-bottom: 10px;
    }
  }
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
  </div>


  <div class="card-container">
    <a href="users?filter=Customer" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-address-card-o fs-2"></i></h5>
          <h5 class="card-title">CUSTOMERS</h5>
          <p class="card-title" id="projectOwnersCount">0</p>
        </div>
      </div>
    </a>

    <a href="users?filter=Partner" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-briefcase fs-3"></i></h5>
          <h5 class="card-title">ASPs</h5>
          <p class="card-title" id="serviceProvidersCount">0</p>
        </div>
      </div>
    </a>

    <a href="projects" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-file-archive-o fs-3"></i></h5>
          <h5 class="card-title">PROJECTS</h5>
          <p class="card-title" id="projectListCount">0</p>
        </div>
      </div>
    </a>

    <a href="my-projects" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-file-o fs-3"></i></h5>
          <h5 class="card-title">MY PROJECTS</h5>
          <p class="card-title" id="adminProjectListCount">0</p>
        </div>
      </div>
    </a>
  </div>


  <div class="card-container">
    <a href="hardwares" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-address-card-o fs-2"></i></h5>
          <h5 class="card-title">HARDWARES</h5>
          <p class="card-title" id="hardwareCount">0</p>
        </div>
      </div>
    </a>

    <a href="hardware-orders" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-briefcase fs-3"></i></h5>
          <h5 class="card-title">ORDERS PEND</h5>
          <p class="card-title" id="ordersPendingCount">0</p>
        </div>
      </div>
    </a>

    <a href="placed-orders" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-address-card-o fs-3"></i></h5>
          <h5 class="card-title">ORDERS PLCD</h5>
          <p class="card-title" id="ordersPlacedCount">0</p>
        </div>
      </div>
    </a>

    <a href="tickets" class="text-decoration-none">
      <div class="card text-primary border-primary">
        <div class="card-body">
          <h5 class="card-title"><i class="fa fa-bookmark-o fs-3"></i></h5>
          <h5 class="card-title">TICKETS</h5>
          <p class="card-title" id="ticketsCount">0</p>
        </div>
      </div>
    </a>
    
  </div>

  <br>

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
        $query = "SELECT `plist_id`, `plist_customer_id`, `plist_projectid`, `plist_title`, `plist_description`, `plist_startdate`, `plist_enddate`, `plist_status` FROM `project_list` WHERE plist_status = 'NO SP Assigned'  order by 1 desc ";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr id="row-<?php echo $row['plist_id']; ?>">

            <td>
              <?php echo $row['plist_projectid']; ?>
            </td>
            <td class="limited-td">
              <?php echo $row['plist_title']; ?>
            </td>
            <td>
              <?php echo $row['plist_startdate']; ?>
            </td>
            <td>
              <?php echo $row['plist_enddate']; ?>
            </td>
            <td>
              <?php echo $row['plist_status']; ?>
            </td>

            <td>
              <a class="btn btn-sm btn-outline-primary" href="project-view?project_key=<?php echo $row['plist_id'] ;?>">View</a>
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

<script>
function loadDashboardCounts() {
  fetch('php-functions/function-get-dashboard-counts.php')
    .then(response => response.json())
    .then(data => {
      document.getElementById('projectOwnersCount').textContent = data.project_owners;
      document.getElementById('serviceProvidersCount').textContent = data.service_providers;
      document.getElementById('projectListCount').textContent = data.project_list;
      document.getElementById('adminProjectListCount').textContent = data.project_list_by_admin;
      document.getElementById('hardwareCount').textContent = data.hardwares;
      document.getElementById('ordersPendingCount').textContent = data.orders_pending;
      document.getElementById('ordersPlacedCount').textContent = data.orders_placed;
      document.getElementById('ticketsCount').textContent = data.tickets_count;
    })
    .catch(err => console.error('Error loading counts:', err));
}

// Call it once immediately
loadDashboardCounts();

// Then every 5 seconds
setInterval(loadDashboardCounts, 5000);
</script>


<?php require('footer.php'); ?>
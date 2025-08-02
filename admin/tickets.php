<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tickets</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
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
          <th scope="col">Id</th>
          <th scope="col">Project_Id</th>
          <th scope="col">Tittle</th>
          <th scope="col">Status</th>
          <th scope="col">Customer_Id</th>
          <th scope="col">Created_At</th>
        </tr>
      </thead>
      <tbody>
        <?php
      $query = "SELECT * FROM `tickets`";
      $result = mysqli_query($con, $query);
      while ($row = mysqli_fetch_assoc($result)) {
      ?>

          <tr id="">

            <td class="limited-td">
              <?php echo $row['tckt_id']; ?>
            </td>
            <td class="limited-td">
              <?php echo $row['tckt_project_id']; ?>
            </td>
            <td class="limited-td">
              <?php echo $row['tckt_title']; ?>
            </td>
            <td>
              <?php echo $row['tckt_status']; ?>
            </td>
            <td class="limited-td">
              <?php echo $row['tckt_customer_id']; ?>
            </td>
            <td class="limited-td">
              <?php echo $row['created_at']; ?>
            </td>
            <td>
              <!-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openviewmodal('<?php echo $row['pscope_id']; ?>')">view</button> -->
              <a class="btn btn-sm btn-primary ms-2" href="tickets-view?tckt-id=<?php echo $row['tckt_id']; ?>">View</a>
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



<?php require('footer.php'); ?>
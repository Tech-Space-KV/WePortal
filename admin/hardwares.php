<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Hardware Inventory</h1>
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
          <th scope="col">S No.</th>
          <th scope="col">Identifier</th>
          <th scope="col">Model No.</th>
          <th scope="col">Uploaded Qty.</th>
          <th scope="col">Family</th>
          <th scope="col">Service Partner</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM `hardwares` ";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr id="">

            <td>
              <?php echo $row['hrdws_serial_number']; ?>
            </td>
            <td>
              <?php echo $row['hrdws_hw_identifier']; ?>
            </td>
            <td>
              <?php echo $row['hrdws_model_number']; ?>
            </td>
            <td>
              <?php echo $row['hrdws_qty']; ?>
            </td>
            <td>
              <?php echo $row['hrdws_family']; ?>
            </td>
            <td>
              <?php echo $row['hrdws_sp_id']; ?>
            </td>
            <td>
              <!-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openviewmodal('<?php echo $row['pscope_id']; ?>')">view</button> -->
              <a class="btn btn-sm btn-primary ms-2" href="hardwares-view?hw-id=<?php echo $row['hrdws_id']; ?>">View</a>
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



<?php require('footer.php'); ?>
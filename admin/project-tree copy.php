<?php require('header.php');
?>

<link rel="icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .tree ul {
    padding-left: 20px;
    list-style: none;
    position: relative;
  }

  .tree ul::before {
    content: "";
    position: absolute;
    top: 0;
    left: 20px;
    border-left: 2px solid #007bff;
    height: 100%;
  }

  .tree li {
    position: relative;
    padding: 20px 20px;
    margin-left: 20px;
  }

  .tree li::before {
    content: "";
    position: absolute;
    top: 50%;
    left: -20px;
    width: 60px;
    border-top: 2px solid #007bff;
  }

  .node {
    display: inline-block;
    padding: 10px 15px;
    /* background-color:rgb(187, 213, 240);
color: #000000; */
    border-radius: 5px;
    font-weight: bold;
  }
</style>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Track Project</h1>
  </div>


  <div class="tree">
    <ul>
      <!-- <span class="node"><img src="plogo2.png" class="w-50" /></span> -->
      <br><br>
      <?php

      $projid = $_GET['project_key'];
      $sqlqry = "select * from `project_list` where `plist_id` = '" . $projid . "' limit 1";
      $result = mysqli_query($con, $sqlqry);
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <li>
          <a href="projects?search=<?php echo $row['plist_id']; ?>" class="node btn btn-sm btn-danger">Project: <?php echo $row['plist_title']; ?></a>

          <ul>

            <?php
            $sqlqry1 = "select * from `project_scope` where `pscope_project_id` = '" . $row['plist_id'] . "' ";
            $result1 = mysqli_query($con, $sqlqry1);
            while ($row1 = mysqli_fetch_assoc($result1)) {
            ?>
              <li>
                <a href="locations?search=<?php echo $row1['pscope_id']; ?>&proj-id=<?php echo $row['plist_id']; ?>" class="node btn btn-sm btn-dark"><?php echo $row1['pscope_state']; ?>
                  <?php if ($row1['status'] == 'Delivered') { ?>
                    <i class="fa fa-check-square-o text-light" alt="completed"></i>
                  <?php
                  } else {
                  ?>
                    <i class="fa fa-spinner text-light" alt="in progress"></i>
                  <?php } ?>
                </a>

                <ul>

                  <?php
                  $sqlqry2 = "select * from `project_planner` where pplnr_scope_id  = " . $row1['pscope_id'] . " ";
                  $result2 = mysqli_query($con, $sqlqry2);
                  while ($row2 = mysqli_fetch_assoc($result2)) {
                  ?>
                    <li>
                      <a href="milestones?search=<?php echo $row2['pplnr_id']; ?>&loc-id=<?php echo $row1['pscope_id']; ?>" class="node btn btn-sm btn-primary ms-1"><?php echo $row2['pplnr_milestone']; ?>
                        <?php if ($row2['pt_status'] == 'Completed') { ?>
                          <i class="fa fa-check-square-o text-light" alt="completed"></i>
                        <?php
                        } else {
                        ?>
                          <i class="fa fa-spinner text-light" alt="in progress"></i>
                        <?php } ?>
                      </a>


                      <ul>

                        <?php
                        $sqlqry3 = "select * from `project_planner_tasks` where pptasks_planner_id  = " . $row2['pplnr_id'] . " ";
                        $result3 = mysqli_query($con, $sqlqry3);
                        while ($row3 = mysqli_fetch_assoc($result3)) {
                        ?>
                          <li>
                            <a href="tasks?search=<?php echo $row3['pptasks_id']; ?>&mil-id=<?php echo $row2['pplnr_id']; ?>" class="node btn btn-sm btn-info ms-3"><?php echo $row3['pptasks_task_title']; ?>
                              <?php if ($row3['pt_status'] == 'Completed') { ?>
                                <i class="fa fa-check-square-o text-light" alt="completed"></i>
                              <?php
                              } else {
                              ?>
                                <i class="fa fa-spinner text-light" alt="in progress"></i>
                              <?php } ?>
                            </a>

                          </li>
                        <?php } ?>
                      </ul>
                    <?php } ?>


                    </li>

                </ul>



              </li>
            <?php } ?>

          </ul>
        </li>
      <?php } ?>
    </ul>
  </div>


</main>


<?php require('footer.php'); ?>
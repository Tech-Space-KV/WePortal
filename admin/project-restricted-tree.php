<?php require('header.php'); ?>
<link rel="icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
.box {
  border: 1px solid #ccc;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 5px;
  background-color: #f8f9fa;
}
.expand-btn {
  float: right;
}
ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}
</style>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Track Project</h1>
  </div>

<?php
$projid = $_GET['project_key'];
$sqlqry = "SELECT * FROM `project_list`
JOIN `project_owners` ON pown_id = plist_customer_id
WHERE `plist_id` = '" . $projid . "' LIMIT 1";
$result = mysqli_query($con, $sqlqry);

while ($row = mysqli_fetch_assoc($result)) {
    $collapse1_id = "collapse_proj_" . $row['plist_id'];
?>
  <!-- Project Box -->
  <div class="box p-3" style="background-color:#e6f5ff;">
    <ul>
      <li><strong>Database ID</strong> - <?php echo $row['plist_id']; ?></li>
      <li><strong>Project ID</strong> - <?php echo $row['plist_projectid']; ?></li>
      <li><strong>Project Title</strong> - <?php echo $row['plist_title']; ?></li>
      <li><strong>Project Status</strong> - <?php echo $row['plist_status']; ?></li>
      <li><strong>Customer ID</strong> - <?php echo $row['pown_id']; ?></li>
      <li><strong>Customer Name</strong> - <?php echo $row['pown_name']; ?></li>
      <li><strong>Customer Email</strong> - <?php echo $row['pown_email']; ?></li>
      <li><strong>Customer Contact</strong> - <?php echo $row['pown_contact']; ?></li>
      <li>
        <button class="btn btn-sm btn-primary expand-btn" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapse1_id; ?>">+</button>
      </li>
    </ul>
    <br>
  </div>

  <!-- Collapse: Project Scope -->
  <div id="<?php echo $collapse1_id; ?>" class="collapse ms-3">
    <?php
    $sqlqry1 = "SELECT * FROM `project_scope` WHERE `pscope_project_id` = '" . $row['plist_id'] . "'";
    $result1 = mysqli_query($con, $sqlqry1);

    while ($row1 = mysqli_fetch_assoc($result1)) {
        $collapse2_id = "collapse_scope_" . $row1['pscope_id'];
    ?>
      <div class="box" style="background-color:#ffe6e6;">
        <ul>
          <li><strong>Location ID</strong> - <?php echo $row1['pscope_id']; ?></li>
          <li><strong>Country</strong> - <?php echo $row1['pscope_country']; ?></li>
          <li><strong>State</strong> - <?php echo $row1['pscope_state']; ?></li>
          <li><strong>City</strong> - <?php echo $row1['pscope_city']; ?></li>
          <li><strong>Pincode</strong> - <?php echo $row1['pscope_pincode']; ?></li>
          <li><strong>Status</strong> - <?php echo $row1['pscope_status']; ?></li>
          <li>
            <button class="btn btn-sm btn-primary expand-btn" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapse2_id; ?>">+</button>
          </li>
        </ul>
        <br>
      </div>

      <!-- Collapse: Project Planner -->
      <div id="<?php echo $collapse2_id; ?>" class="collapse ms-4">
        <?php
        $sqlqry2 = "SELECT * FROM `project_planner` WHERE pplnr_scope_id = " . $row1['pscope_id'];
        $result2 = mysqli_query($con, $sqlqry2);

        while ($row2 = mysqli_fetch_assoc($result2)) {
            $collapse3_id = "collapse_planner_" . $row2['pplnr_id'];
        ?>
          <div class="box" style="background-color:#d1e0e0;">
             <ul>
              <li><strong>Milestone ID:</strong> <?php echo $row2['pplnr_id']; ?></li>
              <li><strong>Milestone Title</strong> - <?php echo $row2['pplnr_milestone']; ?></li>
              <li><strong>Milestone Status</strong> - <?php echo $row2['pplnr_status']; ?></li>
              <li>
                <button class="btn btn-sm btn-primary expand-btn" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapse3_id; ?>">+</button>
              </li>
            </ul>
          <br>
          </div>

          <!-- Collapse: Planner Tasks -->
          <div id="<?php echo $collapse3_id; ?>" class="collapse ms-5">
            <?php
            $sqlqry3 = "SELECT * FROM `project_planner_tasks`
            left join service_providers on sprov_id = pptasks_sp_id
            WHERE pptasks_planner_id = " . $row2['pplnr_id'];
            $result3 = mysqli_query($con, $sqlqry3);

            while ($row3 = mysqli_fetch_assoc($result3)) {
            ?>
              <div class="box">
                <ul>
                  <li><strong>Task ID:</strong> <?php echo $row3['pptasks_id']; ?></li>
                  <li><strong>Task Title</strong> - <?php echo $row3['pptasks_task_title']; ?></li>
                  <li><strong>Manager Status</strong> - <?php echo $row3['pptasks_pt_status']; ?></li>
                  <li><strong>ASP Status</strong> - <?php echo $row3['pptasks_sp_status']; ?></li>
                  <li><strong>ASP ID</strong> - <?php echo $row3['sprov_id']; ?></li>
                  <li><strong>ASP Name</strong> - <?php echo $row3['sprov_name']; ?></li>
                  <li><strong>ASP Email</strong> - <?php echo $row3['sprov_email']; ?></li>
                  <li><strong>ASP Contact</strong> - <?php echo $row3['sprov_contact']; ?></li>
                 
                </ul>
                <br>
                
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
<?php } ?>
</main>

<script>
document.querySelectorAll('.expand-btn').forEach(btn => {
  btn.addEventListener('click', function () {
    const target = document.querySelector(this.getAttribute('data-bs-target'));
    const isOpen = target.classList.contains('show');
    this.textContent = isOpen ? '+' : '-';
  });
});
</script>

<?php require('footer.php'); ?>

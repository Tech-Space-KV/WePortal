<?php  require('header.php');

// Sample costs array for each year (replace this with dynamic values)
$costs = [10500, 13400, 9800, 15600, 17800, 14200, 19000]; 
$years = count($costs);
$customerLTV = array_sum($costs) / $years; // Calculate average cost


?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">

    <!-- Display Customer LTV Above Chart -->
    <div class="alert alert-info text-center mt-2">
        <strong>Customer LTV:</strong> $<?php echo number_format($customerLTV, 2); ?>
    </div>


      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

      </main>

<script src="dashboard.js?v=<?php echo time(); ?>"></script>


<?php  require('footer.php'); ?>
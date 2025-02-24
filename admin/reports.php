<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        canvas {
            margin-top:50px;
            width: 400px; 
            height: 400px;
        }
        .chart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .card-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
            margin-left:70px;
        }
        .card {
            width: 200px;
            height:100px !important;
            text-align: center;
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        body {
            padding-top: 0px; /* Push content down if header is fixed */
        }

    </style>
</head>
<body>

        <!-- Ensure header styling remains unchanged -->
        <header class="no-bootstrap-header">
        <?php include 'header.php'; ?>
    </header>

    <h2 style="text-align:center"><b>REPORTS</b></h2>

    <div class="chart-container">
        <canvas id="myPieChart"></canvas>
    </div>

    <div class="card-container">
        <a href="no_sp_assigned.html" class="text-decoration-none">
        <div class="card text-white" style="background-color: grey;">
                <div class="card-body">
                    <h5 class="card-title">No SP Assigned</h5>
                </div>
            </div>
        </a>
        <a href="in_progress.html" class="text-decoration-none">
        <div class="card text-white" style="background-color: blue;">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                </div>
            </div>
        </a>
        <a href="delivered.html" class="text-decoration-none">
        <div class="card text-white" style="background-color: green;">
                <div class="card-body">
                    <h5 class="card-title">Delivered</h5>
                </div>
            </div>
        </a>
        <a href="overdue.html" class="text-decoration-none">
        <div class="card text-white" style="background-color:rgb(235, 205, 9);">
                <div class="card-body">
                    <h5 class="card-title">Overdue</h5>
                </div>
            </div>
        </a>
        <a href="cancelled.html" class="text-decoration-none">
        <div class="card text-white" style="background-color: red;">
                <div class="card-body">
                    <h5 class="card-title">Cancelled</h5>
                </div>
            </div>
        </a>
    </div>

    <script>
        const ctx = document.getElementById('myPieChart').getContext('2d');
        const myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['No_sp_assigned', 'In_progress', 'Delivered', 'Overdue', 'Cancelled'],
                datasets: [{
                    data: [12, 19, 7, 15, 10], // Dummy data
                    backgroundColor: ['grey', 'blue', 'green', 'rgb(235, 205, 9)', 'red']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

</body>
</html>




	<?php  require('footer.php'); ?>
<?php require('header.php'); ?>

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
        height: 100px;
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
        <h1 class="h2">Project Reports</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        </div>
    </div>

    <!-- Chart Container -->
    <div class="chart-container">
        <canvas id="myPieChart"></canvas>
    </div>

    <!-- Cards Section -->
    <div class="card-container">
        <a href="projects?status=No SP Assigned" class="text-decoration-none">
            <div class="card text-white" style="background-color: grey;">
                <div class="card-body">
                    <h5 class="card-title">No SP Assigned</h5>
                </div>
            </div>
        </a>

        <a href="projects?status=In Progress" class="text-decoration-none">
            <div class="card text-white" style="background-color: blue;">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                </div>
            </div>
        </a>

        <a href="projects?status=Delivered" class="text-decoration-none">
            <div class="card text-white" style="background-color: green;">
                <div class="card-body">
                    <h5 class="card-title">Delivered</h5>
                </div>
            </div>
        </a>

        <a href="projects?status=Overdue" class="text-decoration-none">
            <div class="card text-white" style="background-color: rgb(235, 205, 9);">
                <div class="card-body">
                    <h5 class="card-title">Overdue</h5>
                </div>
            </div>
        </a>

        <a href="projects?status=Cancelled" class="text-decoration-none">
            <div class="card text-white" style="background-color: red;">
                <div class="card-body">
                    <h5 class="card-title">Cancelled</h5>
                </div>
            </div>
        </a>
    </div>

    <br><br>
    <br><br>

</main>

<script>
    let myPieChart;

    function createChart() {
        const canvas = document.getElementById('myPieChart');

        // Ensure the canvas exists and is visible
        if (!canvas) {
            console.error("Canvas element not found!");
            return;
        }

        const ctx = canvas.getContext('2d');
        if (!ctx) {
            console.error("Canvas context not available.");
            return;
        }

        // Destroy previous chart instance if exists
        if (myPieChart) {
            myPieChart.destroy();
        }

        // Create new chart
        myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['No SP Assigned', 'In Progress', 'Delivered', 'Overdue', 'Cancelled'],
                datasets: [{
                    data: [12, 19, 7, 15, 10], // Dummy data
                    backgroundColor: ['grey', 'blue', 'green', 'rgb(235, 205, 9)', 'red']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Run chart creation after the page loads
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(createChart, 500); // Delay execution to allow canvas rendering
    });

    // Handle screen resizing (destroy & recreate chart)
    window.addEventListener("resize", function() {
        setTimeout(createChart, 500);
    });
</script>


<?php require('footer.php'); ?>
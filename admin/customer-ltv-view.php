<?php require('header.php'); ?>
<?php

// Fetch all transactions
$query = "SELECT plist_final_price, plist_delivered_on FROM project_list";
$result = mysqli_query($con, $query);

$yearlyData = [];
$totalThisYear = 0;
$totalPrice = 0;
$rowCount = 0;

$currentYear = date("Y");

// Loop through data
while ($row = mysqli_fetch_assoc($result)) {
    $price = $row['plist_final_price'];
    $date = $row['plist_delivered_on'];
    
    // Skip if date is empty or NULL
    if (!$date) continue;

    $year = date("Y", strtotime($date));
    $month = date("n", strtotime($date));
    $fy = ($month < 4) ? $year - 1 : $year; // Financial year: April to March
    $financialYear = $fy . "-" . ($fy + 1);

    if ($year == $currentYear) {
        $totalThisYear += $price;
    }

    if (!isset($yearlyData[$financialYear])) {
        $yearlyData[$financialYear] = 0;
    }
    $yearlyData[$financialYear] += $price;

    $totalPrice += $price;
    $rowCount++;
}


$ltv = $rowCount ? round($totalPrice / $rowCount, 2) : 0;
?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Customer LTV</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
      </div>
    </div>
  </div>

    <meta charset="UTF-8">
    <title>Customer LTV</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .tile {
            padding: 20px;
            background: #f2f2f2;
            margin: 10px 0;
            font-size: 1.5em;
            border-radius: 8px;
        }
        canvas {
            max-width: 100%;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<div class="tile">📈 Business This Year: ₹<?php echo number_format($totalThisYear, 2); ?></div>
<div class="tile">💰 Customer LTV: ₹<?php echo number_format($ltv, 2); ?></div>

<div style="height: 400px;"><canvas id="barChart"></canvas></div>

<div style="height: 250px; width: 250px;"><canvas id="pieChart"></canvas></div>

<script>
const yearlyLabels = <?php echo json_encode(array_keys($yearlyData)); ?>;
const yearlyValues = <?php echo json_encode(array_values($yearlyData)); ?>;

// Reverse both labels and values
const reversedLabels = [...yearlyLabels].reverse();
const reversedValues = [...yearlyValues].reverse();
// Bar Chart
new Chart(document.getElementById("barChart"), {
    type: 'bar',
    data: {
        labels: reversedLabels,
        datasets: [{
            label: 'Business per Financial Year',
            data: reversedValues,
            backgroundColor: 'rgba(75, 192, 192, 0.7)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Amount (₹)'
                }
            }
        }
    }
});

// Pie Chart (now uses reversed order)
new Chart(document.getElementById("pieChart"), {
    type: 'pie',
    data: {
        labels: reversedLabels,
        datasets: [{
            label: 'Business Share',
            data: reversedValues,
            backgroundColor: reversedLabels.map(() => `hsl(${Math.random() * 360}, 70%, 70%)`),
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 10
                    }
                }
            }
        }
    }
});

   </script>

</body>
</html>

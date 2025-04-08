<?php require('header.php'); ?>
<?php
// Fetch all transactions
$query = "SELECT plist_final_price, plist_delivered_on FROM project_list";
$result = mysqli_query($con, $query);

$yearlyData = [];
$totalThisYear = 0;
$totalPrice = 0;
$rowCount = 0;
$monthlyRevenueByYear = [];

$currentYear = date("Y");

// Loop through data
while ($row = mysqli_fetch_assoc($result)) {
    $price = $row['plist_final_price'];
    $date = $row['plist_delivered_on'];

    if (!$date) continue;

    $year = date("Y", strtotime($date));
    $month = (int)date("n", strtotime($date));
    $fy = ($month < 4) ? $year - 1 : $year;
    $financialYear = $fy . "-" . ($fy + 1);

    if (!isset($monthlyRevenueByYear[$year])) {
        $monthlyRevenueByYear[$year] = array_fill(1, 12, 0);
    }
    $monthlyRevenueByYear[$year][$month] += $price;

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

// Top 5 customers
$topCustomers = [];
$topQuery = "SELECT pown_name AS name, SUM(plist_final_price) AS total 
             FROM project_list 
             JOIN project_owners ON plist_customer_id = pown_id 
             GROUP BY pown_name 
             ORDER BY total DESC 
             LIMIT 5";
$topResult = mysqli_query($con, $topQuery);
while ($row = mysqli_fetch_assoc($topResult)) {
    $topCustomers[$row['name']] = $row['total'];
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4 border-bottom">
        <h1 class="h2">Customer Lifetime Value</h1>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title">Business This Year</h5>
                    <p class="card-text display-6 text-success">₹<?php echo number_format($totalThisYear, 2); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title">Average Customer LTV</h5>
                    <p class="card-text display-6 text-primary">₹<?php echo number_format($ltv, 2); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Financial Year-wise Business</h5>
                    <div style="height: 400px;"><canvas id="barChart"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Share by FY</h5>
                    <div style="height: 250px;"><canvas id="pieChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">Monthly Revenue Trend</h5>
                        <select id="yearSelect" class="form-select w-auto">
                            <?php
                            $years = array_keys($monthlyRevenueByYear);
                            rsort($years);
                            foreach ($years as $y) {
                                echo "<option value='$y'" . ($y == $currentYear ? " selected" : "") . ">$y</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div style="height: 300px;"><canvas id="monthlyTrendChart"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Top 5 Customers by Revenue</h5>
                    <div style="height: 300px;"><canvas id="topCustomersChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const yearlyLabels = <?php echo json_encode(array_keys($yearlyData)); ?>;
const yearlyValues = <?php echo json_encode(array_values($yearlyData)); ?>;
const reversedLabels = [...yearlyLabels].reverse();
const reversedValues = [...yearlyValues].reverse();

new Chart(document.getElementById("barChart"), {
    type: 'bar',
    data: {
        labels: reversedLabels,
        datasets: [{
            label: 'Business per Financial Year',
            data: reversedValues,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1.5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '₹' + value.toLocaleString();
                    }
                },
                title: {
                    display: true,
                    text: 'Amount (₹)'
                }
            }
        }
    }
});

new Chart(document.getElementById("pieChart"), {
    type: 'pie',
    data: {
        labels: reversedLabels,
        datasets: [{
            label: 'Business Share',
            data: reversedValues,
            backgroundColor: [
                '#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f',
                '#edc949', '#af7aa1', '#ff9da7', '#9c755f', '#bab0ac'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
const monthlyRevenueByYear = <?php echo json_encode($monthlyRevenueByYear); ?>;
const ctx = document.getElementById("monthlyTrendChart").getContext("2d");

let monthlyTrendChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [{
            label: 'Monthly Revenue',
            data: monthlyRevenueByYear[<?php echo $currentYear; ?>],
            borderColor: 'rgba(255, 99, 132, 1)',
            tension: 0.3,
            fill: false
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
                    text: 'Revenue (₹)'
                }
            }
        }
    }
});

document.getElementById("yearSelect").addEventListener("change", function () {
    const selectedYear = this.value;
    const newData = monthlyRevenueByYear[selectedYear];
    monthlyTrendChart.data.datasets[0].data = Object.values(newData);
    monthlyTrendChart.update();
});

const topCustomerLabels = <?php echo json_encode(array_keys($topCustomers)); ?>;
const topCustomerValues = <?php echo json_encode(array_values($topCustomers)); ?>;

new Chart(document.getElementById("topCustomersChart"), {
    type: 'doughnut',
    data: {
        labels: topCustomerLabels,
        datasets: [{
            label: 'Top Customers',
            data: topCustomerValues,
            backgroundColor: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php require('footer.php'); ?>

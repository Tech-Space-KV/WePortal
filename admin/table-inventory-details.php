<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">H/W Order Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i>
                </button>
            </div>
        </div>
    </div>

    <center>
        <input type="text" class="w-50 mx-auto mb-4" id="tableSearch" placeholder="Search..." onkeyup="searchTable()" />
    </center>

    <?php
    $order_no = isset($_GET['order_no']) ? $_GET['order_no'] : '';

    if (empty($order_no)) {
        echo "<div class='alert alert-danger'>Order number is missing!</div>";
        exit;
    }

    // Fetch order + hardware details using JOIN
    $query = "
        SELECT 
            o.ordplcd_id AS hardware_id,
            o.ordplcd_qty_placed,
            o.ordplcd_amt,
            o.ordplcd_status,
            o.ordplcd_order_date,
            o.ordplcd_hw_id,
            h.hrdws_model_number
        FROM orders_placed o
        INNER JOIN hardwares h ON o.ordplcd_hw_id = h.hrdws_id
        WHERE o.ordplcd_order_no = ?
    ";

    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $order_no);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <h2 class="h4">Order Details - <?php echo htmlspecialchars($order_no); ?></h2>
        <a href="table-inventory.php" class="btn btn-sm btn-outline-secondary">← Back to Orders</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive small">
            <table class="table table-striped table-sm" id="inventoryDetailsTable">
                <thead>
                    <tr>
                        <th>Model Number</th>
                        <th>Price (₹)</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['hrdws_model_number']); ?></td>
                            <td><?php echo number_format($row['ordplcd_amt'], 2); ?></td>
                            <td><?php echo $row['ordplcd_qty_placed']; ?></td>
                            <td><?php echo htmlspecialchars($row['ordplcd_status']); ?></td>
                            <td><?php echo htmlspecialchars($row['ordplcd_order_date']); ?></td>
                            <td>
                            <a class="btn btn-sm btn-primary ms-2" href="hardwares-orders-view.php?hw-id=<?php echo $row['ordplcd_hw_id']; ?>&order_no=<?php echo urlencode($order_no); ?>">View</a>
                            </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hardware items found for this order.</div>
    <?php endif; ?>
</main>

<script>
function searchTable() {
    const input = document.getElementById("tableSearch").value.toUpperCase();
    const table = document.getElementById("inventoryDetailsTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
        let found = false;
        const cells = rows[i].getElementsByTagName("td");
        for (let j = 0; j < cells.length; j++) {
            const cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toUpperCase().indexOf(input) > -1) {
                found = true;
                break;
            }
        }
        rows[i].style.display = found ? "" : "none";
    }
}
</script>

<?php require('footer.php'); ?>

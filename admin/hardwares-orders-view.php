<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hardware</h1>
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

    $hw_id = isset($_GET['hw-id']) ? $_GET['hw-id'] : null;
    $order_no = isset($_GET['order_no']) ? $_GET['order_no'] : null;

    $hw_id = intval($hw_id);
    $order_no = htmlspecialchars($order_no);

    if ($hw_id && $order_no) {
        //     $stmt = mysqli_prepare($con, "
        //     SELECT h.*, sp.*
        //     FROM hardwares h
        //     INNER JOIN service_providers sp ON h.hrdws_sp_id = sp.sprov_id
        //     WHERE h.hrdws_id = ?
        // ");
    
        $stmt = mysqli_prepare($con, "
        SELECT op.*, h.*, sp.*, po.*
        FROM orders_placed op
        INNER JOIN hardwares h ON op.ordplcd_hw_id = h.hrdws_id
        INNER JOIN service_providers sp ON h.hrdws_sp_id = sp.sprov_id
        INNER JOIN project_owners po ON op.ordplcd_customer_id = po.pown_id
        WHERE op.ordplcd_hw_id = ? And op.ordplcd_order_no = ?
    ");

        mysqli_stmt_bind_param($stmt, "is", $hw_id, $order_no);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "No hardware ID provided.";
    }
    ?>

    <div class="container-fluid">
        <div class="row g-3" id="dataTable">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4">
                        <div class="border p-3 rounded bg-light">
                            <div class="mb-2">
                                <label class="form-label">Hardware Serial No.</label>
                                <input type="text" class="form-control" value="<?php echo $row['hrdws_serial_number']; ?>"
                                    readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Hardware Identifier</label>
                                <input type="text" class="form-control" value="<?php echo $row['hrdws_hw_identifier']; ?>"
                                    readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Hardware Model Number</label>
                                <input type="text" class="form-control" value="<?php echo $row['hrdws_model_number']; ?>"
                                    readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Hardware Status</label>
                                <input type="text" class="form-control" value="<?php echo $row['hrdws_hw_status']; ?>" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Order Date</label>
                                <input type="text" class="form-control" value="<?php echo $row['order_date']; ?>" readonly>
                            </div>
                            <!-- <div class="text-end">
                                <a class="btn btn-sm btn-primary"
                                    href="table-inventory-details.php?order_no=<?php echo urlencode($row['order_no']); ?>">View</a>
                                <a class="btn btn-sm btn-secondary ms-2"
                                    href="hardwares-orders-view.php?hw-id=<?php echo urlencode($row['hardware_id']); ?>&order_no=<?php echo urlencode($row['order_no']); ?>">Back</a>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border p-3 rounded bg-light">
                            <div class="mb-2">
                                <label class="form-label">Supplier ID</label>
                                <input type="text" class="form-control" value="<?php echo $row['sprov_id']; ?>" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" value="<?php echo $row['sprov_name']; ?>" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Supplier Email</label>
                                <input type="text" class="form-control" value="<?php echo $row['sprov_email']; ?>" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Supplier Contact</label>
                                <input type="text" class="form-control" value="<?php echo $row['sprov_contact']; ?>" readonly>
                            </div>
                            <!-- <div class="text-end">
                                <a class="btn btn-sm btn-primary"
                                    href="table-inventory-details.php?order_no=<?php echo urlencode($row['order_no']); ?>">View</a>
                                <a class="btn btn-sm btn-secondary ms-2"
                                    href="hardwares-orders-view.php?hw-id=<?php echo urlencode($row['hardware_id']); ?>&order_no=<?php echo urlencode($row['order_no']); ?>">Back</a>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="border p-3 rounded bg-light">
                            <div class="mb-2">
                                <label class="form-label">Buyer ID</label>
                                <input type="text" class="form-control" value="<?php echo $row['pown_id']; ?>" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Buyer Name</label>
                                <input type="text" class="form-control" value="<?php echo $row['pown_name']; ?>" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Buyer Email</label>
                                <input type="text" class="form-control" value="<?php echo $row['pown_email']; ?>" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Buyer Contact</label>
                                <input type="text" class="form-control" value="<?php echo $row['pown_contact']; ?>" readonly>
                            </div>
                            <!-- <div class="text-end">
                                <a class="btn btn-sm btn-primary"
                                    href="table-inventory-details.php?order_no=<?php echo urlencode($row['order_no']); ?>">View</a>
                                <a class="btn btn-sm btn-secondary ms-2"
                                    href="hardwares-orders-view.php?hw-id=<?php echo urlencode($row['hardware_id']); ?>&order_no=<?php echo urlencode($row['order_no']); ?>">Back</a>
                            </div> -->
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<p class='text-center text-muted'>No hardware found for the given ID and Order Number.</p>";
            }
            ?>
        </div>
    </div>

    <div class="pagination" style="float:right;" hidden>
        <button id="prevBtn" class="btn btn-sm btn-outline-primary" onclick="changePage(-1)" disabled>Prev</button>
        <button id="nextBtn" class="btn btn-sm btn-outline-primary" onclick="changePage(1)">Next</button>
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center" id="pagination">
            <!-- Page numbers will go here -->
        </ul>
    </nav>
</main>

<script>
    function searchTable() {
        const input = document.getElementById("tableSearch").value.toLowerCase();
        const table = document.getElementById("dataTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false;
            for (let j = 0; j < cells.length - 1; j++) {
                if (cells[j].textContent.toLowerCase().includes(input)) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? "" : "none";
        }
    }
</script>

<?php require('footer.php'); ?>
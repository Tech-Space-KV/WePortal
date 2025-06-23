<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">H/W Orders</h1>
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

    <div class="table-responsive small" id="customer-table">
        <table class="table table-striped table-sm" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">Order No</th>
                    <th scope="col">Number of items</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Order date</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_cust = "
                    SELECT 
                    ordplcd_order_no AS order_no, 
                    COUNT(*) AS number_of_items,  -- Counts number of rows (each item placed)
                    GROUP_CONCAT(DISTINCT ordplcd_status) AS status, 
                    MIN(ordplcd_order_date) AS order_date 
                    FROM orders_placed 
                    GROUP BY ordplcd_order_no
                    HAVING 
                    SUM(CASE WHEN LOWER(ordplcd_status) = 'pending' THEN 1 ELSE 0 END) > 0
                    ORDER BY ordplcd_order_date DESC;
                ";
 

                $result_cust = mysqli_query($con, $query_cust);
                while ($row_cust = mysqli_fetch_assoc($result_cust)) {
                ?>
                    <tr>
                        <td><?php echo $row_cust['order_no']; ?></td>
                        <td><?php echo $row_cust['number_of_items']; ?></td>
                        <td><?php echo $row_cust['status']; ?></td>
                        <td><?php echo $row_cust['order_date']; ?></td>
                        <td>
                            <a href="table-inventory-details.php?order_no=<?php echo $row_cust['order_no']; ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
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
<?php require('header.php'); ?>


<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Customer LTV</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="d-flex flex-wrap gap-2">
                <a type="button" class="btn btn-sm btn-outline-secondary" href="add-customer">Add Customer</a>
                <a type="button" class="btn btn-sm btn-outline-secondary" href="add-service-partner ">Add Service Partner</a>
                <button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>

            </div>
        </div>
    </div>


<!-- 
    <nav class="nav nav-pills flex-column flex-sm-row mb-3 bg-light">
        <a class="flex-sm-fill text-sm-center nav-link active" href="#" id="customer-tab">Customers</a>
        <a class="flex-sm-fill text-sm-center nav-link" href="#" id="service-tab">Service Partner</a>
    </nav> -->


    <center>
        <input type="text" class="w-50 mx-auto mb-4" id="tableSearch" placeholder="Search..." onkeyup="searchTable()" />
    </center>

    <div class="table-responsive small" id="customer-table">
        <table class="table table-striped table-sm" id="dataTable">
            <thead>
                <tr>

                    <!-- Category,title,username and verified has been removed,I have also changed the linking from milestones to view-customers-->
                    <th scope="col">Category</th>
                    <th scope="col">Username</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query_cust = "SELECT `pown_id` as user_id, 'Customer' as title , `pown_username` as username, `pown_name` as name, `pown_user_type` as type, `pown_contact` as contact, `pown_email` as email FROM `project_owners` ";
                $result_cust = mysqli_query($con, $query_cust);
                while ($row_cust = mysqli_fetch_assoc($result_cust)) {
                ?>
                    <tr id="row-<?php echo $row_cust['user_id']; ?>">

                        <td>
                            <?php echo $row_cust['title']; ?>
                        </td>
                        <td>
                            <?php echo $row_cust['username']; ?>
                        </td>
                        <td>
                            <?php echo $row_cust['name']; ?>
                        </td>
                        <td>
                            <?php echo $row_cust['type']; ?>
                        </td>
                        <td>
                            <?php echo $row_cust['contact']; ?>
                        </td>
                        <td>
                            <?php echo $row_cust['email']; ?>
                        </td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="customer-ltv-view.php?cust-id=<?php echo $row['pown_id']; ?>">View</a>
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
//     document.addEventListener("DOMContentLoaded", function() {
//         // Ensure the correct table is shown on page load
//         document.getElementById("customer-table").style.display = "block";
//         document.getElementById("service-table").style.display = "none";

//         // Handle click on Customers tab
//         document.getElementById("customer-tab").addEventListener("click", function() {
//             document.getElementById("customer-table").style.display = "block";
//             document.getElementById("service-table").style.display = "none";

//             this.classList.add("active");
//             document.getElementById("service-tab").classList.remove("active");
//         });

//         // Handle click on Service Partner tab
//         document.getElementById("service-tab").addEventListener("click", function() {
//             document.getElementById("service-table").style.display = "block";
//             document.getElementById("customer-table").style.display = "none";

//             this.classList.add("active");
//             document.getElementById("customer-tab").classList.remove("active");
//         });
//     });
</script>


<?php require('footer.php'); ?>
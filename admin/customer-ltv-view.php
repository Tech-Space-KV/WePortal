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
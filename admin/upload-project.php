<?php  require('header.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload Project</h1>
      </div>

      <form action="save_data.php" method="POST" enctype="multipart/form-data">


        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> First details of the project
        </h5>

		 <div class="mb-3">
            <label for="title" class="form-label">Select Customer</label>

            <select class="form-control" id="mySelect" name="customer">
                <option value="">None</option>
            </select>

        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Project title" name="title">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <!-- <input type="textarea" class="form-control" id="description" placeholder="About project"> -->
            <textarea id="description" name="description" class="form-control"
                placeholder="Enter your description here"></textarea>
        </div>

        <div class="mb-3">
            <label for="sow" class="form-label">Scope of work</label>
            <input type="file" class="form-control" id="sow" placeholder="Scope of work" name="sow">
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="projectIs" class="form-label">Project is</label>
                <select class="form-select" id="projectIs" name="projectIs">
                    <option selected value="">--Select type--</option>
                    <option value="New">New</option>
                    <option value="On Going">On Going</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="projectType" class="form-label">Project type</label>
                <select class="form-select" id="projectType" name="projectType">
                    <option selected value="">--Select type--</option>
                    <option value="On Remote">On Remote</option>
                    <option value="On Site">On Site</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="projectCategory" class="form-label">Project Category</label>
                <select class="form-select" id="projectCategory" name="projectCategory" required>
                    <option selected value="">--Select category--</option>
                    <option value="Pre Sales Support">Pre Sales Support</option>
                    <option value="Implementation">Implementation</option>
                    <option value="Post Sales Support">Post Sales Support</option>
                    <option value="Software/Web evelopment">Software/Web Development</option>
                    <option value="Resource">Resource</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="budget" class="form-label">Budget</label>

            <div class="d-flex">
                <div class="me-2" style="flex: 0.3;">
                <select class="form-select" id="budget" name="currency" >
                        <option selected value=""> -- Currency --</option>
                        <option value="INR">INR</option>
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                        <option value="SGD">SGD</option>
                    </select>
                </div>

                <div style="width: 465px;">
                    <input type="number" class="form-control" id="budgetAmount" name="budgetAmount" placeholder="Enter amount">
                </div>
            </div>
        </div>

        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Define interval
        </h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="startDate" class="form-label">Start date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start date">
            </div>

            <div class="col-md-6 mb-3">
                <label for="endDate" class="form-label">End date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" placeholder="End date">
            </div>
        </div>


        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Details of the person to be contacted by PseudoTeam
        </h5>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="title" name="contactName" placeholder="Name of the authorised person">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="title" name="contactEmail" placeholder="Email of the authorised person">
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="title" name="contactNumber" placeholder="Contact no. of authorised person">
        </div>

        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Updates on additional/customer email id <sup>(Optional)</sup>
        </h5>

		
		 <div class="mb-3">
            <label for="email" class="form-label">Notification Email <sup>(optional)</sup></label>
            <input type="ntfnemail" class="form-control" id="title" name="notificationEmail" placeholder="Email">
        </div>

        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Apply coupons/promo code <sup>(Optional)</sup>
        </h5>

        <div class="mb-3">
            <label for="coupon" class="form-label">Coupon/Promo Code <sup>(optional)</sup></label>
            <input type="text" class="form-control" id="title"name="coupon" placeholder="Add your coupon or promocode here">
        </div>

        <button type="submit" name="upload_btn" class="btn btn-primary" onClick="insert_data()" >Upload</button>
        <button type="submit" name="save_btn" class="btn btn-success" onClick="save_data()">Save</button>

    </form>

<br><br>
    </main>
	



    <script>
document.addEventListener("DOMContentLoaded", function () {
    // Get the current URL
    const urlParams = new URLSearchParams(window.location.search);
    
    // Check if projectid exists in the URL
    if (urlParams.has("projectid")) {

        document.querySelector("button[name='upload_btn']").style.display = "none";
        document.querySelector("button[name='save_btn']").style.display = "block";

        const projectId = urlParams.get("projectid");

        // Fetch project details from the PHP script
        fetch(`php-functions/get_project_details.php?projectid=${projectId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector("select[name='customer']").value = data.customer;
                    document.querySelector("input[name='title']").value = data.title;
                    document.querySelector("textarea[name='description']").value = data.description;
                    document.querySelector("select[name='projectIs']").value = data.projectIs;
                    document.querySelector("select[name='projectType']").value = data.projectType;
                    document.querySelector("select[name='projectCategory']").value = data.projectCategory;
                    document.querySelector("select[name='currency']").value = data.currency;
                    document.querySelector("input[name='budgetAmount']").value = data.budgetAmount;
                    document.querySelector("input[name='startDate']").value = data.startDate;
                    document.querySelector("input[name='endDate']").value = data.endDate;
                    document.querySelector("input[name='contactName']").value = data.contactName;
                    document.querySelector("input[name='contactEmail']").value = data.contactEmail;
                    document.querySelector("input[name='contactNumber']").value = data.contactNumber;
                    document.querySelector("input[name='notificationEmail']").value = data.notificationEmail;
                    document.querySelector("input[name='coupon']").value = data.coupon;
                }
            })
            .catch(error => console.error("Error fetching project details:", error));
    }
    else{
        
        document.querySelector("button[name='upload_btn']").style.display = "block";
        document.querySelector("button[name='save_btn']").style.display = "none";
    }
});
</script>

<script>
 $(document).ready(function () {
    // Initialize Select2 with tagging enabled
    $('#mySelect').select2({
        tags: true,   // Allows typing new values
        placeholder: "Select or type your own option",
        allowClear: true
    });

    // Ensure AJAX runs when selecting or typing a new value
    $("#mySelect").on("change", function () {
        sendInputValue();
    });
});
</script>


<script>
    function insert_data() {
        let form = document.querySelector("form");

        // Store each form field value in a separate variable
        let customer = document.getElementById("mySelect").value;
        let title = document.getElementById("title").value;
        let description = document.getElementById("description").value;
        let sow = document.getElementById("sow").files[0]; // File input
        let projectIs = document.getElementById("projectIs").value;
        let projectType = document.getElementById("projectType").value;
        let projectCategory = document.getElementById("projectCategory").value;
        let currency = document.getElementById("budget").value;
        let budgetAmount = document.getElementById("budgetAmount").value;
        let startDate = document.getElementById("startDate").value;
        let endDate = document.getElementById("endDate").value;
        let contactName = document.getElementsByName("contactName")[0].value;
        let contactEmail = document.getElementsByName("contactEmail")[0].value;
        let contactNumber = document.getElementsByName("contactNumber")[0].value;
        let notificationEmail = document.getElementsByName("notificationEmail")[0].value;
        let coupon = document.getElementsByName("coupon")[0].value;

        // Create FormData object to send via POST
        let formData = new FormData();
        formData.append("customer", customer);
        formData.append("title", title);
        formData.append("description", description);
        formData.append("sow", sow);
        formData.append("projectIs", projectIs);
        formData.append("projectType", projectType);
        formData.append("projectCategory", projectCategory);
        formData.append("currency", currency);
        formData.append("budgetAmount", budgetAmount);
        formData.append("startDate", startDate);
        formData.append("endDate", endDate);
        formData.append("contactName", contactName);
        formData.append("contactEmail", contactEmail);
        formData.append("contactNumber", contactNumber);
        formData.append("notificationEmail", notificationEmail);
        formData.append("coupon", coupon);

        // Send data using fetch()
        fetch("php-functions/function_upload_project.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert("Project uploaded successfully!"); // Success message
            console.log(data); // Log server response
        })
        .catch(error => {
            alert("Error uploading project.");
            console.error("Error:", error);
        });
    }

   
</script>






	<?php  require('footer.php'); ?>
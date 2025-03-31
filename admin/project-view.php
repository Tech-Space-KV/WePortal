<?php  require('header.php'); ?>
<?php $project_key = $_GET['project_key']; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">View Project</h1>
      </div>
        
        <!-- <div class="alert alert-primary mt-2" role="alert" id="successbox">
            Perfect! Project uploaded successfully.
        </div>
        <div class="alert alert-danger mt-2" role="alert" id="failbox">
            Error: Project upload failed.
        </div> -->

        <?php
              $query="SELECT `project_owners`.`pown_name`, `project_owners`.`pown_id`, `project_owners`.`pown_username`,  
              `project_list`.* FROM `project_list`
              JOIN `project_owners` ON `pown_id` = `plist_customer_id` WHERE plist_id = $project_key " ;
							$result=mysqli_query($con,$query);
							while( $row=mysqli_fetch_assoc($result))
							{

							    ?>

      <form method="POST" enctype="multipart/form-data">


        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> First details of the project
        </h5>

		 <div class="mb-3">
            <label for="customer" class="form-label">Select Customer</label>

            <select class="form-control" id="mySelect" name="customer" required>
                
                <option selected disabled value="<?php echo $row['pown_id'] ; ?>"><?php echo $row['pown_username']." (".$row['pown_name'].")"." (".$row['pown_id'].")" ; ?></option>
                
                <?php
                $query1="SELECT `pown_id` as user_id, `pown_username` as username, `pown_name` as name, `pown_user_type` as type, `pown_contact` as contact, `pown_email` as email FROM `project_owners`";
				$result1=mysqli_query($con,$query1);
				while( $row1=mysqli_fetch_assoc($result1))
				    {
				?>
                    <option value="<?php echo $row1['user_id'] ; ?>"><?php echo $row1['username']." (".$row1['name'].")"." (".$row1['user_id'].")" ; ?></option>
                <?php 
                    } 
                ?>
            
            </select>

        </div>

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Project title" name="title" value="<?php echo $row['plist_title'] ; ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <!-- <input type="textarea" class="form-control" id="description" placeholder="About project"> -->
            <textarea id="description" name="description" class="form-control" required
                placeholder="Enter your description here"><?php echo $row['plist_description'] ; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="sow" class="form-label">Scope of work</label>
            <a class="btn btn-sm btn-outline-primary" onclick="downloadFile(<?php echo $row['plist_id'] ; ?>)">View here</a>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="projectIs" class="form-label">Project is</label>
                <select class="form-select" id="projectIs" name="projectIs" required>
                    <option selected disabled value="<?php echo $row['plist_ongnew'] ; ?>"><?php echo $row['plist_ongnew'] ; ?></option>
                    <option value="New">New</option>
                    <option value="On Going">On Going</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="projectType" class="form-label">Project type</label>
                <select class="form-select" id="projectType" name="projectType" required>
                    <option selected disabled value="<?php echo $row['plist_type'] ; ?>" ><?php echo $row['plist_type'] ; ?></option>
                    <option value="On Remote">On Remote</option>
                    <option value="On Site">On Site</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="projectCategory" class="form-label">Project Category</label>
                <select class="form-select" id="projectCategory" name="projectCategory" required>
                <option selected disabled value="<?php echo $row['plist_category'] ; ?>" ><?php echo $row['plist_category'] ; ?></option>
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
                        <option selected disabled value="<?php echo $row['plist_currency'] ; ?>" ><?php echo $row['plist_currency'] ; ?></option>
                        <option value="INR">INR</option>
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                        <option value="SGD">SGD</option>
                    </select>
                </div>

                <div style="width: 465px;">
                    <input type="text" class="form-control" id="budgetAmount" name="budgetAmount" placeholder="Enter amount"   value="<?php echo $row['plist_budget'] ; ?>" >
                </div>
            </div>
        </div>


        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Define interval
        </h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="startDate" class="form-label" required>Start date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start date"  value="<?php echo date("Y-m-d", strtotime($row['plist_startdate'])) ; ?>" >
            </div>

            <div class="col-md-6 mb-3">
                <label for="endDate" class="form-label" required>End date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" placeholder="End date"  value="<?php echo date("Y-m-d", strtotime($row['plist_enddate'])) ; ?>" >
            </div>
        </div>


        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Details of the person to be contacted by PseudoTeam
        </h5>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="title" name="contactName" placeholder="Name of the authorised person"  value="<?php echo $row['plist_name'] ; ?>"  required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="title" name="contactEmail" placeholder="Email of the authorised person"  value="<?php echo $row['plist_email'] ; ?>"  required>
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="title" name="contactNumber" placeholder="Contact no. of authorised person"  value="<?php echo $row['plist_contact'] ; ?>" required>
        </div>

        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Updates on additional/customer email id <sup>(Optional)</sup>
        </h5>

		
		 <div class="mb-3">
            <label for="email" class="form-label">Notification Email <sup>(optional)</sup></label>
            <input type="ntfnemail" class="form-control" id="title" name="notificationEmail" placeholder="Email"   value="<?php echo $row['plist_customeremail'] ; ?>" >
        </div>

        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> Apply coupons/promo code <sup>(Optional)</sup>
        </h5>

        <div class="mb-3">
            <label for="coupon" class="form-label">Coupon/Promo Code <sup>(optional)</sup></label>
            <input type="text" class="form-control" id="title"name="coupon" placeholder="Add your coupon or promocode here"   value="<?php echo $row['plist_coupon'] ; ?>" >
        </div>



        
        <div class="px-3 py-3 mb-3 border border-2 border-primary rounded bg-light">
            <h5 class="mt-4 mb-4 text-pseudo fw-bold text-danger">
                For Pseudo-Managers only
            </h5>
                   
        <div class="mb-3">
            <label for="budget" class="form-label fw-bold">Final Price</label>

            <div class="d-flex">
                <div style="width: 465px;">
                    <input type="text" class="form-control border border-2 border-primary" id="finalPrice" name="finalPrice" placeholder="Enter amount"   value="<?php echo $row['plist_final_price'] ; ?>" >
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
                <label for="pstatus" class="form-label fw-bold">Status</label>
                <select class="form-select border border-2 border-primary" id="pstatus" name="pstatus">
                <option selected disabled value="<?php echo $row['plist_status'] ; ?>" ><?php echo $row['plist_status'] ; ?></option>
                    <option value="No SP Assigned">No SP Assigned</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
        </div>

        <div class="col-md-4 mb-3">
                <label for="projectStatus" class="form-label fw-bold">Project Status</label>
                <select class="form-select border border-2 border-primary" id="projectStatus" name="projectStatus">
                <option selected disabled value="<?php echo $row['plist_project_status'] ; ?>" ><?php echo $row['plist_project_status'] ; ?></option>
                    <option value="Live">Live</option>
                    <option value="Hold">Hold</option>
                </select>
        </div>

        <div class="mb-3">
            <label for="statusDescription" class="form-label fw-bold">Description for project status</label>
            <!-- <input type="textarea" class="form-control" id="description" placeholder="About project"> -->
            <textarea id="statusDescription" name="statusDescription" class="form-control border border-2 border-primary "
                placeholder="Enter your description here"><?php echo $row['plist_project_status_description'] ; ?></textarea>
        </div>


        <div class="col-md-4 mb-3">
                <label for="mngrId" class="form-label fw-bold">Assign to</label>
                <select class="form-select border border-2 border-primary" id="2mySelect" name="mngrId">
                <option selected disabled value="<?php echo $row['plist_pt_mngr_id'] ; ?>" ><?php echo $row['plist_pt_mngr_id'] ; ?></option>
                    <option>None</option>
                        <?php
                        $query1="SELECT `id` as user_id, `username` as username, `email` as email FROM `weusers`";
                        $result1=mysqli_query($con,$query1);
                        while( $row1=mysqli_fetch_assoc($result1))
                            {
                        ?>
                            <option value="<?php echo $row1['user_id'] ; ?>"><?php echo $row1['username']." (".$row1['email'].")"." (".$row1['user_id'].")" ; ?></option>
                        <?php 
                            } 
                        ?>
                </select>
        </div>




        </div>

        <button type="submit" name="upload_btn" class="btn btn-primary" onClick="insert_data()" >Upload</button>

    </form>

    <?php } ?>

<br><br>
    </main>

	



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
 $(document).ready(function () {
    // Initialize Select2 with tagging enabled
    $('#2mySelect').select2({
        tags: true,   // Allows typing new values
        placeholder: "Select or type your own option",
        allowClear: true
    });

    // Ensure AJAX runs when selecting or typing a new value
    $("#2mySelect").on("change", function () {
        sendInputValue();
    });
});
</script>

<script>
        function downloadFile(fileId) {
            window.location.href = `php-functions/function-download-file.php?id=${fileId}`;
        }
    </script>

<script>
    function insert_data() {
    let form = document.querySelector("form");

    // Store each form field value in variables
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
    let finalPrice = document.getElementsByName("finalPrice")[0].value;
    let pstatus = document.getElementsByName("pstatus")[0].value;
    let projectStatus = document.getElementsByName("projectStatus")[0].value;
    let statusDescription = document.getElementsByName("statusDescription")[0].value;
    let mngrId = document.getElementsByName("2mySelect")[0].value;
    

    // Validate required fields
    if (!customer || !title || !description) {
        alert("Customer, Title, and Description are required!");
        return;
    }

    // Create FormData object
    let formData = new FormData();
    formData.append("customer", customer);
    formData.append("title", title);
    formData.append("description", description);
    if (sow) {
        formData.append("sow", sow);
    }
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
    formData.append("finalPrice", finalPrice);
    formData.append("pstatus", pstatus);
    formData.append("projectStatus", projectStatus);
    formData.append("statusDescription", statusDescription);
    formData.append("mngrId", mngrId);

    // Send data using fetch()
    fetch("php-functions/function-project-save.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expect JSON response
    .then(data => {
        if (data.status === "success") {
            alert(data.message); // Display success message
            // location.reload(); // Refresh page after successful submission
            // document.getElementById("successbox").style.display = "block";
            // document.getElementById("failbox").style.display = "none";
            // document.getElementById("successbox").textContent = "Project uploaded.";
        } else {
            alert("Error: " + data.message); // Display error message
            // document.getElementById("successbox").style.display = "none";
            // document.getElementById("failbox").style.display = "block";
            // document.getElementById("failbox").textContent = "Error: Project upload failed.";
        }
        console.log(data); // Log full response
    })
    .catch(error => {
        alert("Error uploading project. Please try again.");
        console.error("Error:", error);
    });
}

</script>



	<?php  require('footer.php'); ?>
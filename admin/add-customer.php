<?php  require('header.php'); ?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Customer</h1>
      </div>
      
  <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="pown_name" class="form-label">User Name</label>
        <input type="text" class="form-control" id="pown_name" name="pown_name" required>
      </div>

      <div class="mb-3">
        <label for="pown_user_type" class="form-label">User Type</label>
        <select class="form-control" id="pown_user_type" name="pown_user_type" required onchange="toggleFields()">
			<option selected disabled value="">-- Select --</option>
			<option value="Organisation">Organisation</option>
			<option value="Individual">Individual</option>
		</select>
      </div>

      <div class="mb-3">
        <label for="pown_country" class="form-label">Country</label>
        <input type="text" class="form-control" id="pown_country" name="pown_country" >
      </div>

      <div class="mb-3">
        <label for="pown_state" class="form-label">State</label>
        <input type="text" class="form-control" id="pown_state" name="pown_state" >
      </div>

      <div class="mb-3">
        <label for="pown_address" class="form-label">Address</label>
        <input type="text" class="form-control" id="pown_address" name="pown_address" required>
      </div>

      <div class="mb-3">
        <label for="pown_pincode" class="form-label">Pincode</label>
        <input type="text" class="form-control" id="pown_pincode" name="pown_pincode" >
      </div>

      <div class="mb-3">
        <label for="pown_contact" class="form-label">Contact Number</label>
        <input type="text" class="form-control" id="pown_contact" name="pown_contact" required>
      </div>

      <div class="mb-3">
        <label for="pown_email" class="form-label">Email</label>
        <input type="email" class="form-control" id="pown_email" name="pown_email" required>
      </div>

      <div class="mb-3">
        <label for="pown_about" class="form-label">About</label>
        <textarea class="form-control" id="pown_about" name="pown_about" rows="4" ></textarea>
      </div>

      <div class="mb-3">
        <label for="pown_organisation_name" class="form-label">Organisation Name</label>
        <input type="text" class="form-control" id="pown_organisation_name" name="pown_organisation_name">
      </div>

      <div class="mb-3">
        <label for="pown_cin" class="form-label">Company CIN</label>
        <input type="text" class="form-control" id="pown_cin" name="pown_cin">
      </div>

      <div class="mb-3">
        <label for="pown_gstpin" class="form-label">GST Number</label>
        <input type="text" class="form-control" id="pown_gstpin" name="pown_gstpin">
      </div>

      <div class="mb-3">
        <label for="pown_adhaar" class="form-label">Aadhaar Number</label>
        <input type="text" class="form-control" id="pown_adhaar" name="pown_adhaar">
      </div>

      <div class="mb-3">
        <label for="pown_adhaarfile" class="form-label">Aadhaar File (Upload)</label>
        <input type="file" class="form-control" id="pown_adhaarfile" name="pown_adhaarfile">
      </div>

      <div class="mb-3">
        <label for="pown_dp" class="form-label">Profile Picture</label>
        <input type="file" class="form-control" id="pown_dp" name="pown_dp">
      </div>

      <div class="mb-3">
        <label for="pown_verified" class="form-label">Verified</label>
        <select class="form-select" id="pown_verified" name="pown_verified" required>
          <option value="True">True</option>
          <option value="False">False</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="pown_password" class="form-label">Password</label>
        <input type="password" class="form-control" id="pown_password" name="pown_password" required>
      </div>

      <div class="mb-3">
        <label for="pown_login_flag" class="form-label">Login Flag</label>
        <select class="form-select" id="pown_login_flag" name="pown_login_flag" required>
          <option value="Active">Active</option>
          <option value="Inactive">Inactive</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="pown_profile_completion_flag" class="form-label">Profile Completion</label>
        <select class="form-select" id="pown_profile_completion_flag" name="pown_profile_completion_flag" required>
          <option value="Completed">Completed</option>
          <option value="Not Completed">Not Completed</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="pown_date_of_registration" class="form-label">Registration Date</label>
        <input type="date" class="form-control w-100" id="pown_date_of_registration" name="pown_date_of_registration" >
      </div>

      <div class="mb-3">
        <label for="created_at" class="form-label">Created At</label>
        <input type="datetime-local" class="form-control" id="created_at" name="created_at" >
      </div>

      <div class="mb-3">
        <label for="updated_at" class="form-label">Updated At</label>
        <input type="datetime-local" class="form-control" id="updated_at" name="updated_at">
      </div>

      <button type="submit" class="btn btn-primary">Register</button>
    </form>


    <script>
  function toggleFields() {
    const userType = document.getElementById("pown_user_type").value;
    
    // Organisation fields
    const organisationFields = ["pown_organisation_name", "pown_cin", "pown_gstpin"];
    const organisationHints = ["org_name_hint", "cin_hint", "gst_hint"];

    // Individual fields
    const individualFields = ["pown_adhaar", "pown_adhaarfile"];
    const individualHints = ["aadhaar_hint", "aadhaar_file_hint"];
    
    if (userType === "Individual") {
      // Disable Organisation fields, Enable Individual fields
      organisationFields.forEach(id => setReadOnly(id, true));
      individualFields.forEach(id => setReadOnly(id, false));

      // Show only relevant hints
      organisationHints.forEach(id => document.getElementById(id).style.display = "inline");
      individualHints.forEach(id => document.getElementById(id).style.display = "none");
      
    } else if (userType === "Organisation") {
      // Disable Individual fields, Enable Organisation fields
      individualFields.forEach(id => setReadOnly(id, true));
      organisationFields.forEach(id => setReadOnly(id, false));

      // Show only relevant hints
      individualHints.forEach(id => document.getElementById(id).style.display = "inline");
      organisationHints.forEach(id => document.getElementById(id).style.display = "none");
      
    } else {
      // If no selection, enable all fields
      organisationFields.concat(individualFields).forEach(id => setReadOnly(id, false));
      organisationHints.concat(individualHints).forEach(id => document.getElementById(id).style.display = "none");
    }
  }

  function setReadOnly(id, isReadOnly) {
    let field = document.getElementById(id);
    if (isReadOnly) {
      field.setAttribute("readonly", true);
      field.classList.add("readonly-style");
    } else {
      field.removeAttribute("readonly");
      field.classList.remove("readonly-style");
    }
  }
</script>

<!-- CSS to Style Read-Only Fields -->
<style>
  .readonly-style {
    background-color: #e9ecef !important;
    cursor: not-allowed;
  }
  .text-muted {
    display: none;
  }
</style>


    <script>
      // Handle form submission
      document.querySelector("form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission 
    // Get form values
    let name = document.getElementById("pown_name").value;
    let userType = document.getElementById("pown_user_type").value;
    let country = document.getElementById("pown_country").value;
    let state = document.getElementById("pown_state").value;
    let address = document.getElementById("pown_address").value;
    let pincode = document.getElementById("pown_pincode").value;
    let contact = document.getElementById("pown_contact").value;
    let email = document.getElementById("pown_email").value;
    let about = document.getElementById("pown_about").value;
    let organisation = document.getElementById("pown_organisation_name").value;
    let cin = document.getElementById("pown_cin").value;
    let gst = document.getElementById("pown_gstpin").value;
    let aadhaar = document.getElementById("pown_adhaar").value;
    let verified = document.getElementById("pown_verified").value;
    let password = document.getElementById("pown_password").value;
    let loginFlag = document.getElementById("pown_login_flag").value;
    let registrationDate = document.getElementById("pown_date_of_registration").value;


    
    // Get file names
    let aadhaarFile = document.getElementById("pown_adhaarfile").files[0]?.name || "No file selected";
    let profilePicture = document.getElementById("pown_dp").files[0]?.name || "No file selected";


    // Show alert with form details
    alert(
      "Form Details:\n" +
      "User Name: " + name + "\n" +
      "User Type: " + userType + "\n" +
      "Country: " + country + "\n" +
      "State: " + state + "\n" +
      "Address: " + address + "\n" +
      "Pincode: " + pincode + "\n" +
      "Contact: " + contact + "\n" +
      "Email: " + email + "\n" +
      "About: " + about + "\n" +
      "Organisation Name: " + organisation + "\n" +
      "CIN: " + cin + "\n" +
      "GST Number: " + gst + "\n" +
      "Aadhaar: " + aadhaar + "\n" +
      "Aadhaar File: " + aadhaarFile + "\n" +
      "Profile Picture: " + profilePicture+"\n"+
      "Verified: " + verified + "\n" +
      "Password: " + password + "\n" +
      "Login Flag: " + loginFlag + "\n" +
      "Registration Date: " + registrationDate
    );

    // Submit the form after the alert
    event.target.submit();
});

    </script>


 
<br><br>
    </main>
 
	
	
	
	<?php  require('footer.php'); ?>

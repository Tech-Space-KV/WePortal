<?php require('header.php');
function generatePassword($length = 12)
{
  return bin2hex(random_bytes($length / 2));
}

$generatedPassword = generatePassword();
$hashedPassword = sha1($generatedPassword);



?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Customer</h1>
  </div>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="pown_name" class="form-label">Customer Name</label>
      <input type="text" class="form-control" id="pown_name" name="pown_name" required>
    </div>

    <div class="mb-3">
      <label for="pown_username" class="form-label">User Name</label>
      <!-- <input type="text" class="form-control" id="pown_username" name="pown_username" required oninput="checkUsername()"> -->
      <input type="text" class="form-control" id="pown_username" name="pown_username" readonly>
      <span id="username_status"></span>
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
      <input type="text" class="form-control" id="pown_country" name="pown_country">
    </div>

    <div class="mb-3">
      <label for="pown_state" class="form-label">State</label>
      <input type="text" class="form-control" id="pown_state" name="pown_state">
    </div>

    <div class="mb-3">
      <label for="pown_address" class="form-label">Address</label>
      <input type="text" class="form-control" id="pown_address" name="pown_address" required>
    </div>

    <div class="mb-3">
      <label for="pown_pincode" class="form-label">Pincode</label>
      <input type="text" class="form-control" id="pown_pincode" name="pown_pincode">
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
      <textarea class="form-control" id="pown_about" name="pown_about" rows="4"></textarea>
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
      <select class="form-select" id="pown_verified" name="pown_verified">
        <option value="1">True</option>
        <option value="0">False</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="pown_password" class="form-label">Password</label>
      <input type="text" class="form-control" id="pown_password" name="pown_password" value="<?= htmlspecialchars($generatedPassword); ?>" readonly>
    </div>


    <div class="mb-3">
      <label for="pown_login_flag" class="form-label">Login Flag</label>
      <select class="form-select" id="pown_login_flag" name="pown_login_flag" required>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="pown_profile_completion_flag" class="form-label">Profile Completion</label>
      <select class="form-select" id="pown_profile_completion_flag" name="pown_profile_completion_flag" required>
        <option value="1">Completed</option>
        <option value="0">Not Completed</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="pown_cin" class="form-label">Referred By</label>
      <input type="text" class="form-control" id="pown_refered_by" name="pown_refered_by">
    </div>


    <button type="submit" class="btn btn-primary" id="insert_operation">Register</button>
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
        organisationFields.forEach(id => setReadOnly(id, true));
        individualFields.forEach(id => setReadOnly(id, false));

        organisationHints.forEach(id => document.getElementById(id).style.display = "none");
        individualHints.forEach(id => document.getElementById(id).style.display = "inline");
      } else if (userType === "Organisation") {
        individualFields.forEach(id => setReadOnly(id, true));
        organisationFields.forEach(id => setReadOnly(id, false));

        individualHints.forEach(id => document.getElementById(id).style.display = "none");
        organisationHints.forEach(id => document.getElementById(id).style.display = "inline");
      } else {
        organisationFields.concat(individualFields).forEach(id => setReadOnly(id, false));
        organisationHints.concat(individualHints).forEach(id => document.getElementById(id).style.display = "none");
      }
    }

    function setReadOnly(id, isReadOnly) {
      let field = document.getElementById(id);
      if (field) {
        field.readOnly = isReadOnly;
        field.classList.toggle("readonly-style", isReadOnly);
      }
    }
  </script>

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
    document.getElementById("insert_operation").addEventListener("click", function(event) {
      event.preventDefault();
      var mailtoemail = document.getElementById("pown_email").value;
      let formData = new FormData(document.querySelector("form"));

      showLoader();

      fetch("php-functions/function-customer-upload.php", {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            //alert(data.message);

            
            let mailData = new FormData();
            mailData.append("messagefor","customerregistration");
            mailData.append("mailto", mailtoemail);

            fetch("php-functions/function-sendmail.php", {
                method: "POST",
                body: mailData
              })
              .then(response => response.text()) // Assuming it returns plain text
              .then(mailResponse => {
                console.log("Mail Response:", mailResponse);
                //alert(mailResponse);
                // You may show a success message or do further actions here
              })
              .catch(mailError => {
                console.error("Mail Sending Failed:", mailError);
                //alert(mailError);
              });

               showNotification("✅Success","Customer added successfully!");
          // location.reload();
           setTimeout(function () {
             location.reload();
        }, 2000);

            // window.location.href = "add-customer.php?success=1";
          } else {
            // alert("Error: " + data.message);
            showNotification("❌Failed","Customer not added!");
            setTimeout(function () {
             location.reload();
        }, 2000);
          // location.reload();
           
          }

        })
        .catch(error => {
          console.error("Error:", error);
          // alert("Error uploading. Please try again.");
          showNotification("⚠️Error","Error in request!");
          // location.reload();
           setTimeout(function () {
             location.reload();
        }, 2000);
        });
    });
  </script>

  <script>
    function checkUsername() {
      let username = document.getElementById("pown_username").value;
      let statusIndicator = document.getElementById("username_status");

      if (username.length < 3) {
        statusIndicator.innerHTML = "Too short";
        statusIndicator.style.color = "red";
        return;
      }

      fetch("php-functions/function-check-customer-username.php?username=" + encodeURIComponent(username))
        .then(response => response.json())
        .then(data => {
          if (data.status === "exists") {
            statusIndicator.innerHTML = "Username already taken";
            statusIndicator.style.color = "red";
          } else {
            statusIndicator.innerHTML = "Username available";
            statusIndicator.style.color = "green";
          }
        })
        .catch(error => {
          console.error("Error checking username:", error);
        });
    }

    document.getElementById("pown_username").addEventListener("input", checkUsername);
  </script>

  <br><br>
</main>

<?php require('footer.php'); ?>
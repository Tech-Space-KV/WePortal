
<?php require('header.php');
function generatePassword($length = 12)
{
  return bin2hex(random_bytes($length / 2));
}

$generatedPassword = generatePassword();
$hashedPassword = sha1($generatedPassword);


$mail_message="We`re excited to have you as part of the PseudoTeam.

Here`s what you can do next:
Explore your dashboard
Upload your first project/task
Track your progress in real-time
Reach out for any support, we`re here to help!

Your account is all set up, and you`re ready to go";


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Service Partner</h1>
  </div>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="sprov_name" class="form-label">Service Partner Name</label>
      <input type="text" class="form-control" id="sprov_name" name="sprov_name" required>
    </div>

    <div class="mb-3">
      <label for="sprov_username" class="form-label">User Name</label>
      <input type="text" class="form-control" id="sprov_username" name="sprov_username" readonly oninput="checkUsername()">
      <span id="username_status"></span>
    </div>

    <div class="mb-3">
      <label for="sprov_user_type" class="form-label">User Type</label>
      <select class="form-control" id="sprov_user_type" name="sprov_user_type" required onchange="toggleFields()">
        <option selected disabled value="">-- Select --</option>
        <option value="Organisation">Organisation</option>
        <option value="Individual">Individual</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="sprov_country" class="form-label">Country</label>
      <input type="text" class="form-control" id="sprov_country" name="sprov_country">
    </div>

    <div class="mb-3">
      <label for="sprov_state" class="form-label">State</label>
      <input type="text" class="form-control" id="sprov_state" name="sprov_state">
    </div>

    <div class="mb-3">
      <label for="sprov_address" class="form-label">Address</label>
      <input type="text" class="form-control" id="sprov_address" name="sprov_address" required>
    </div>

    <div class="mb-3">
      <label for="sprov_pincode" class="form-label">Pincode</label>
      <input type="text" class="form-control" id="sprov_pincode" name="sprov_pincode">
    </div>

    <div class="mb-3">
      <label for="sprov_contact" class="form-label">Contact Number</label>
      <input type="text" class="form-control" id="sprov_contact" name="sprov_contact" required>
    </div>

    <div class="mb-3">
      <label for="sprov_email" class="form-label">Email</label>
      <input type="email" class="form-control" id="sprov_email" name="sprov_email" required>
    </div>

    <div class="mb-3">
      <label for="sprov_about" class="form-label">About</label>
      <textarea class="form-control" id="sprov_about" name="sprov_about" rows="4"></textarea>
    </div>

    <div class="mb-3">
      <label for="sprov_organisation_name" class="form-label">Organisation Name</label>
      <input type="text" class="form-control" id="sprov_organisation_name" name="sprov_organisation_name">
    </div>

    <div class="mb-3">
      <label for="sprov_cin" class="form-label">Company CIN</label>
      <input type="text" class="form-control" id="sprov_cin" name="sprov_cin">
    </div>

    <div class="mb-3">
      <label for="sprov_gstpin" class="form-label">GST Number</label>
      <input type="text" class="form-control" id="sprov_gstpin" name="sprov_gstpin">
    </div>

    <div class="mb-3">
      <label for="sprov_adhaar" class="form-label">Aadhaar Number</label>
      <input type="text" class="form-control" id="sprov_adhaar" name="sprov_adhaar">
    </div>

    <div class="mb-3">
      <label for="sprov_adhaarfile" class="form-label">Aadhaar File (Upload)</label>
      <input type="file" class="form-control" id="sprov_adhaarfile" name="sprov_adhaarfile">
    </div>

    <div class="mb-3">
      <label for="sprov_dp" class="form-label">Profile Picture</label>
      <input type="file" class="form-control" id="sprov_dp" name="sprov_dp">
    </div>

    <div class="mb-3">
      <label for="sprov_verified_flag" class="form-label">Verified</label>
      <select class="form-select" id="sprov_verified_flag" name="sprov_verified_flag" required>
        <option value="1">True</option>
        <option value="0">False</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="sprov_password" class="form-label">Password</label>
      <input type="text" class="form-control" id="sprov_password" name="sprov_password" value="<?= htmlspecialchars($generatedPassword); ?>" readonly>
    </div>


    <div class="mb-3">
      <label for="sprov_login_flag" class="form-label">Login Flag</label>
      <select class="form-select" id="sprov_login_flag" name="sprov_login_flag" required>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="sprov_profile_completion_flag" class="form-label">Profile Completion</label>
      <select class="form-select" id="sprov_profile_completion_flag" name="sprov_profile_completion_flag" required>
        <option value="1">Completed</option>
        <option value="0">Not Completed</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="sprov_refered_by" class="form-label">Referred By</label>
      <input type="text" class="form-control" id="sprov_refered_by" name="sprov_refered_by">
    </div>


    <button type="submit" class="btn btn-primary" id="insert_operation">Register</button>
  </form>


  <script>
    function toggleFields() {
      const userType = document.getElementById("sprov_user_type").value;

      // Organisation fields
      const organisationFields = ["sprov_organisation_name", "sprov_cin", "sprov_gstpin"];
      const organisationHints = ["org_name_hint", "cin_hint", "gst_hint"];

      // Individual fields
      const individualFields = ["sprov_adhaar", "sprov_adhaarfile"];
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
      var mailtoemail = document.getElementById("sprov_email").value;
      let formData = new FormData(document.querySelector("form"));

      fetch("php-functions/function-service-partner-upload.php", {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === "success") {
            alert(data.message);

           let mailData = new FormData();
            mailData.append("heading", "You have been registered on PseudoTeam.");
            mailData.append("message",<?php echo $mail_message; ?>);
            mailData.append("mailto", mailtoemail);
            mailData.append("subject", "Registration on PseudoTeam");
            // mailData.append("mailtocust","");
            // mailData.append("mailtosp","");
            mailData.append("link", "www.pseudoteam.com/partner");


            fetch("php-functions/function-sendmail.php", {
                method: "POST",
                body: mailData
              })
              .then(response => response.text()) // Assuming it returns plain text
              .then(mailResponse => {
                console.log("Mail Response:", mailResponse);
                alert(mailResponse);
                // You may show a success message or do further actions here
              })
              .catch(mailError => {
                console.error("Mail Sending Failed:", mailError);
                alert(mailError);
              });

            window.location.href = "add-service-partner.php?success=1";
          } else {
            alert("Error: " + data.message);
          }

        })
        .catch(error => {
          console.error("Error:", error);
          alert("Error uploading. Please try again.");
        });
    });
  </script>

  <!-- <script>
      function checkUsername() {
          let username = document.getElementById("sprov_username").value;
          let statusIndicator = document.getElementById("username_status");

          if (username.length < 3) {
              statusIndicator.innerHTML = "Too short";
              statusIndicator.style.color = "red";
              return;
          }

          fetch("php-functions/function-check-service-partner-username.php?username=" + encodeURIComponent(username))
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

      document.getElementById("sprov_username").addEventListener("input", checkUsername);
    
  </script> -->

  <br><br>
</main>

<?php require('footer.php'); ?>
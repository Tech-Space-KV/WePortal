<?php require('header.php'); ?><?php
                                if (isset($_GET['search'])) {
                                  $search = $_GET['search']; // Get the value
                                } else {
                                  $search = '';
                                }
                                ?>
<?php $milestone_id = $_GET['mil-id']; ?>


<?php 
  $stdate;
if (isset($_GET['startdate'])) {
  $stdate = $_GET['startdate']; // Get the value
} else {
  $stdate='';
}
?>

<?php 
  $eddate;
if (isset($_GET['enddate'])) {
  $eddate = $_GET['enddate']; // Get the value
} else {
   $eddate='';
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Project Tasks</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2"><button type="button" class="btn btn-sm btn-outline-secondary" onclick="openviewmodal('nodata')" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Task</button>

        <button type="button" class="btn btn-sm btn-outline-secondary"> &nbsp;&nbsp; <i class="fa fa-refresh"> &nbsp;&nbsp; </i></button>
      </div>
    </div>
  </div>


  <center>
    <input type="text" class="w-50 mx-auto mb-4" id="tableSearch" placeholder="Search..." onkeyup="searchTable()" />
  </center>


  <div class="table-responsive small">
    <table class="table table-striped table-sm" id="dataTable">
      <thead>
        <tr>
          <th scope="col">Task</th>
          <th scope="col">Start Date</th>
          <th scope="col">End Date</th>
          <th scope="col">Created On</th>
          <th scope="col">Service Partner Status</th>
          <th scope="col">Pseudo-Manager Status</th>
          <td></td>
          <td></td>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM `project_planner_tasks` WHERE pptasks_planner_id = $milestone_id AND `pptasks_id` like '%$search%'";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr id="">

            <td>
              <?php echo $row['pptasks_task_title']; ?>
            </td>
            <td>
              <?php echo $row['pptasks_start_date']; ?>
            </td>
            <td>
              <?php echo $row['pptasks_end_date']; ?>
            </td>
            <td>
              <?php echo $row['created_at']; ?>
            </td>
            <td>
              <?php echo $row['pptasks_sp_status']; ?>
            </td>
            <td>
              <?php echo $row['pptasks_pt_status']; ?>
            </td>
            <td>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="openviewmodal('<?php echo $row['pptasks_id']; ?>')">view</button>
            </td>
            <td>
              <a class="btn btn-sm btn-primary" href="task-comment?task-id=<?php echo $row['pptasks_id']; ?>">comments</a>
            </td>
          </tr>
        <?php

        }

        ?>
      </tbody>
    </table>
    <div class="pagination" style="float:right;" hidden>
      <button id="prevBtn" class="btn btn-sm btn-outline-primary" onclick="changePage(-1)" disabled>Prev</button>
      <button id="nextBtn" class="btn btn-sm btn-outline-primary" onclick="changePage(1)">Next</button>
    </div>

    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center" id="pagination">
        <!-- Page numbers will go here -->
      </ul>
    </nav>

  </div>

</main>


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="modalForm">
          <!-- Name Field -->
          <div class="mb-3">
            <label for="name" class="form-label"> Task Title</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <!--Description Field -->
          <div class="mb-3">
            <label for="Description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description">
          </div>

          <!-- Start Date Field -->
          <div class="mb-3">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startDate" name="startDate"  min="<?php echo $stdate; ?>" max="<?php echo $eddate; ?>" required>
          </div>

          <!-- End Date Field -->
          <div class="mb-3">
            <label for="endDate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate"  min="<?php echo $stdate; ?>" max="<?php echo $eddate; ?>" required>
          </div>


          <!-- SP ID Field -->
          <div class="mb-3">
            <label for="sp_id" class="form-label">Service Partner ID</label>
            <input type="text" class="form-control" id="sp_id" name="sp_id" oninput="checkUsername()">
            <span id="sp_id_indicator" class="sp_id_indicator"></span>
          </div>

          <div class="mb-3">
            <label for="" class="form-label">View Asp's</label>
            <a href="list-of-asp.php" target="_blank">View</a>
          </div>


          <!-- Date of Completion Field -->
          <div class="mb-3">
            <label for="doc" class="form-label">Date of Completion</label>
            <input type="date" class="form-control" id="doc" name="doc">
          </div>

          <!-- Proof of Completion -->
          <div class="mb-3">
            <label for="endDate" class="form-label">Proof of Completion</label>
            <a href="#" onclick="downloadFile()">View</a>
          </div>

          <!-- End Date Field -->
          <div class="mb-3">
            <label for="sp_status" class="form-label">Service Partner Status</label>
            <input type="text" class="form-control bg-light" id="sp_status" name="sp_status" placeholder="Not Started" readonly>
          </div>


          <!-- Status Field -->
          <div class="mb-3">
            <label for="mngr_status" class="form-label">Manager Status</label>
            <input type="text" class="form-control" id="mngr_status" name="mngr_status" list="statusOptions" required>
            <datalist id="statusOptions">
              <option value="Not Started">
              <option value="Ongoing">
              <option value="Fullfilled">
              <option value="Scrapped">
            </datalist>
          </div>


          <div class="mb-3">
            <label for="payment" class="form-label">Payment to Srv.Prtnr (Rs)</label>
            <input type="text" class="form-control" id="payment" name="payment">
          </div>

          <br>
          <div class="bg-light">
            <p class="text-primary" id="pmt-done" style="display:none;"><i>Payment request has already been raised</i></p>
            <p class="text-danger" id="pmt-not-done" style="display:none;"><i>Payment request not raised yet</i></p>
          </div>


          <div class="mb-3">
            <label for="endDate" class="form-label">Raise Payment Request</label>
            <button class="btn btn-sm btn-outline-primary" id="request_payment">Request Payment</button>
            <button class="btn btn-sm btn-outline-danger" id="request_cancel">Cancel Request</button>
          </div>


          <!-- Hidden ID Field -->
          <input type="hidden" id="pplnr_id" name="pplnr_id" value="<?php echo $milestone_id; ?>">
          <input type="hidden" id="pptasks_id" name="pptasks_id" value="">
          <hr>
         


        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="insert_operation">Submit</button>
            <button type="submit" class="btn btn-success" id="save_operation">Save</button>
            <button type="submit" class="btn btn-danger" id="delete_operation">Delete</button>
        <button type="button" class="btn btn-secondary" onclick="location.reload()" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<script>
  // Focus on input when modal is opened
  var myModal = document.getElementById('exampleModal');
  var myInput = document.getElementById('country');
  var alertnm;
  var oldsp;

  function openviewmodal(stringdata) {
    myModal.addEventListener('shown.bs.modal', function() {
      myInput.focus();
    });

    // alert(stringdata);
    if (stringdata != 'nodata') {
              
      document.getElementById("insert_operation").style.display='none';
              document.getElementById("save_operation").style.display='block';
              document.getElementById("delete_operation").style.display='block';

      fetch(`php-functions/function-tasks-fetch.php?pptasks_id=${stringdata}`)
        .then(response => response.json())
        .then(data => {
          if (!data.error) {
          // alert(data);
            document.getElementById("pplnr_id").value = data.pptasks_planner_id;
            document.getElementById("name").value = data.pptasks_task_title;
            document.getElementById("description").value = data.pptasks_description;
            document.getElementById("startDate").value = convertToDate(data.pptasks_start_date);
            document.getElementById("endDate").value = convertToDate(data.pptasks_end_date);
            document.getElementById("sp_id").value = data.pptasks_sp_id;
            document.getElementById("doc").value = data.pptasks_date_of_completion;
            document.getElementById("sp_status").value = data.pptasks_sp_status;
            document.getElementById("mngr_status").value = data.pptasks_pt_status;
            document.getElementById("payment").value = data.pptasks_payment;
            document.getElementById("pptasks_id").value = stringdata;

            oldsp = data.pptasks_sp_id;

            console.log(data.pptasks_pt_status);
            checkUsername();

            var pptasks_invoice_raised_flag = data.pptasks_invoice_raised_flag;

            if (pptasks_invoice_raised_flag == 0) {
              document.getElementById("pmt-done").style.display = 'none';
              document.getElementById("pmt-not-done").style.display = 'block';
            } else if (pptasks_invoice_raised_flag == 1) {
              document.getElementById("pmt-done").style.display = 'block';
              document.getElementById("pmt-not-done").style.display = 'none';
            } else {
              document.getElementById("pmt-done").style.display = 'none';
              document.getElementById("pmt-not-done").style.display = 'block';
            }



            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            modal.show();
          } else {
            alert("No data found!");
          }
        })
        .catch(error => console.error("Error fetching data:", error));

    }
    else
      {
              document.getElementById("insert_operation").style.display='block';
              document.getElementById("save_operation").style.display='none';
              document.getElementById("delete_operation").style.display='none';
      }


  }

  // Handle form submission
  document.getElementById("insert_operation").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default form submission
    
    var mailtoemail = document.getElementById("pplnr_id").value;
    var mailtosp = document.getElementById("sp_id").value;
    var tasktitle = document.getElementById("name").value;

    let formData = new FormData();
    formData.append("pplnr_id", document.getElementById("pplnr_id").value);
    formData.append("name", document.getElementById("name").value);
    formData.append("description", document.getElementById("description").value);
    formData.append("startDate", document.getElementById("startDate").value);
    formData.append("endDate", document.getElementById("endDate").value);
    formData.append("sp_id", document.getElementById("sp_id").value);
    formData.append("doc", document.getElementById("doc").value); // Assuming this is a date
    formData.append("sp_status", document.getElementById("sp_status").value);
    formData.append("mngr_status", document.getElementById("mngr_status").value);
    formData.append("payment", document.getElementById("payment").value);

    showLoader();

    fetch("php-functions/function-tasks-upload.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json()) // Expecting JSON response
      .then(data => {
        if (data.status === "success") {
            let mailData = new FormData();
                    mailData.append("messagefor","newtask");
                    mailData.append("mailto", mailtoemail);
                    mailData.append("mailtosp", mailtosp);
                    mailData.append("tasktitle", tasktitle);


                    fetch("php-functions/sendmail-add-task.php", {
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
                           // alert(mailError);
                        });
          // alert("Task added successfully!", "success");       
          // location.reload();
          showNotification("Success","Task added successfully!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        } else {
          // alert("Failed to add task!", "error");
          // location.reload();
          showNotification("❌Failed","Task not added!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        }
      })
      .catch(error => {
        // alert("Error in request!", "error");
        console.error("Error:", error);
        // location.reload();
        showNotification("⚠️Error","Error in request!");
            setTimeout(function () {
             location.reload();
        }, 2000);
      });

    // Close modal after submission
    var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalElement.hide();

    // Reset form after submission
    document.getElementById("modalForm").reset();

  });



  document.getElementById("save_operation").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default form submission
     var mailtoemail = document.getElementById("pplnr_id").value;
    var mailtosp = document.getElementById("sp_id").value;
    var tasktitle = document.getElementById("name").value;

    let formData = new FormData();
    formData.append("pplnr_id", document.getElementById("pplnr_id").value);
    formData.append("name", document.getElementById("name").value);
    formData.append("description", document.getElementById("description").value);
    formData.append("startDate", document.getElementById("startDate").value);
    formData.append("endDate", document.getElementById("endDate").value);
    formData.append("sp_id", document.getElementById("sp_id").value);
    formData.append("doc", document.getElementById("doc").value); // Assuming this is a date
    formData.append("sp_status", document.getElementById("sp_status").value);
    formData.append("mngr_status", document.getElementById("mngr_status").value);
    formData.append("payment", document.getElementById("payment").value);
    formData.append("pptasks_id", document.getElementById("pptasks_id").value);

    showLoader();

    fetch("php-functions/function-tasks-save.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json()) // Expecting JSON response
      .then(data => {
        if (data.status === "success") {
          let mailData = new FormData();
                    mailData.append("messagefor","savetask");
                    mailData.append("mailto", mailtoemail);
                    mailData.append("mailtosp", mailtosp);
                    mailData.append("mailtooldsp", oldsp);
                    mailData.append("tasktitle", tasktitle);


                    fetch("php-functions/sendmail-save-task.php", {
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
                           // alert(mailError);
                        });
          // alert("Task saved successfully!", "success");
          // location.reload();
          showNotification("✅Success","Task saved successfully!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        } else {
          // alert("Failed to save task!", "error");
          // location.reload();
          showNotification("❌Failed","Failed to save task!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        }
      })
      .catch(error => {
        // alert("Error in request!", "error");
        console.error("Error:", error);
        // location.reload();
        showNotification("⚠️Error","Error in request!");
            setTimeout(function () {
             location.reload();
        }, 2000);
      });

    // Close modal after submission
    var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalElement.hide();

    // Reset form after submission
    document.getElementById("modalForm").reset();

  });





  document.getElementById("delete_operation").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData();
    formData.append("pptasks_id", document.getElementById("pptasks_id").value);
    formData.append("pplnr_id", document.getElementById("pplnr_id").value);

    showLoader();
    
    fetch("php-functions/function-tasks-delete.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json()) // Expecting JSON response
      .then(data => {
        if (data.status === "success") {
          // alert("Task deleted successfully!", "success");
          // location.reload();
           showNotification("✅Success","Task deleted successfully!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        } else {
          // alert("Failed to delete task!", "error");
          // location.reload();
           showNotification(";❌Failed","Failed to delete task!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        }
      })
      .catch(error => {
        // alert("Error in request!", "error");
        console.error("Error:", error);
        // location.reload();
         showNotification("⚠️Error","Error in request!");
            setTimeout(function () {
             location.reload();
        }, 2000);
      });

    // Close modal after submission
    var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalElement.hide();

    // Reset form after submission
    document.getElementById("modalForm").reset();

  });



  // Handle payment submission
  document.getElementById("request_payment").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default form submission
    
    var mailtoemail = document.getElementById("pplnr_id").value;
    var mailtosp = document.getElementById("sp_id").value;
    var tasktitle = document.getElementById("name").value;

    let formData = new FormData();
    formData.append("pptasks_id", document.getElementById("pptasks_id").value);
    formData.append("raise_invoice", 1);

    fetch("php-functions/function-tasks-raise-invoice.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json()) // Expecting JSON response
      .then(data => {
        if (data.status === "success") {
          
          let mailData = new FormData();
                    mailData.append("messagefor","raiseinvoice");
                    mailData.append("mailto", mailtoemail);
                    mailData.append("mailtosp", mailtosp);
                    mailData.append("tasktitle", tasktitle);


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
                           // alert(mailError);
                        });

          // alert("Invoice details updated!", "success");
          // location.reload();
          showNotification("✅Success","Invoice details sent to finance department!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        } else {
          // alert("Failed to update!", "error");
          // location.reload();
           showNotification("Failed","Invoice details failed to send to finance department!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        }
      })
      .catch(error => {
        // alert("Error in request!", "error");
        // console.error("Error:", error);
        // location.reload();
         showNotification("⚠️Error","Error in request!");
            setTimeout(function () {
             location.reload();
        }, 2000);
      });

    // Close modal after submission
    var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalElement.hide();

    // Reset form after submission
    document.getElementById("modalForm").reset();

  });



  // Handle payment submission
  document.getElementById("request_cancel").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default form submission

     var mailtoemail = document.getElementById("pplnr_id").value;
    var mailtosp = document.getElementById("sp_id").value;
    var tasktitle = document.getElementById("name").value;

    let formData = new FormData();
    formData.append("pptasks_id", document.getElementById("pptasks_id").value);
    formData.append("raise_invoice", 0);

    fetch("php-functions/function-tasks-raise-invoice.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.json()) // Expecting JSON response
      .then(data => {
        if (data.status === "success") {

          let mailData = new FormData();
                    mailData.append("messagefor","cancellinvoice");
                    mailData.append("mailto", mailtoemail);
                    mailData.append("mailtosp", mailtosp);
                    mailData.append("tasktitle", tasktitle);


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
                           // alert(mailError);
                        });

          // alert("Invoice details updated!", "success");
          // location.reload();
           showNotification("✅Success","Invoice cancellation details sent to finance department!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        } else {
          // alert("Failed to update!", "error");
          // location.reload();
           showNotification("❌Failed","Invoice cancellation details were not sent to finance department!");
            setTimeout(function () {
             location.reload();
        }, 2000);
        }
      })
      .catch(error => {
        // alert("Error in request!", "error");
        // console.error("Error:", error);
        // location.reload();
         showNotification("⚠️Error","Error in request!");
            setTimeout(function () {
             location.reload();
        }, 2000);
      });

    // Close modal after submission
    var modalElement = new bootstrap.Modal(document.getElementById('exampleModal'));
    modalElement.hide();

    // Reset form after submission
    document.getElementById("modalForm").reset();

  });





  function convertToDate(dateString) {
    if (!dateString) return ""; // Handle empty or invalid date

    let dateParts = dateString.split(/[-\/]/); // Split by "-" or "/"

    if (dateParts.length === 3) {
      let year, month, day;

      if (dateParts[0].length === 4) {
        // Format: YYYY-MM-DD or YYYY/MM/DD
        year = dateParts[0];
        month = dateParts[1];
        day = dateParts[2];
      } else {
        // Format: DD-MM-YYYY or MM-DD-YYYY
        year = dateParts[2];
        month = dateParts[1];
        day = dateParts[0];
      }

      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }

    return "";
  }
</script>


 <script>
    function checkUsername() {
      let username = document.getElementById("sp_id").value;
      let statusIndicator = document.getElementById("sp_id_indicator");


      fetch("php-functions/function-check-sp-details.php?username=" + encodeURIComponent(username))
        .then(response => response.json())
        .then(data => {
          if (data.status === "exists") {
            statusIndicator.innerHTML = data.message;
            statusIndicator.style.color = "green";
          } else {
            statusIndicator.innerHTML = data.message;
            statusIndicator.style.color = "red";
          }
        })
        .catch(error => {
          console.error("Error checking username:", error);
        });
    }

    document.getElementById("sp_id").addEventListener("input", checkUsername);

  </script>

<script>
    function downloadFile() {
      var doc = document.getElementById("pptasks_id").value
        window.location.href = `php-functions/function-download-file-tasks.php?id=`+doc;
    }
</script>

<?php require('footer.php'); ?>
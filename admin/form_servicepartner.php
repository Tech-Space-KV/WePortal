<?php  require('header.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add Service Partner</h1>
      </div>

  <form action="submit_form.php" method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="pown_name" class="form-label">Name</label>
        <input type="text" class="form-control" id="pown_name" name="pown_name" required>
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
        <label for="pown_contact" class="form-label">Contact</label>
        <input type="text" class="form-control" id="pown_contact" name="pown_contact" required>
      </div>

      <div class="mb-3">
        <label for="pown_email" class="form-label">Email</label>
        <input type="email" class="form-control" id="pown_email" name="pown_email" required>
      </div>
      
      <div class="mb-3">
        <label for="pown_date_of_registration" class="form-label">Date Of Registration</label>
        <input type="date" class="form-control" id="pown_date_of_registration" name="pown_date_of_registration" >
      </div>

      <div class="mb-3">
        <label for="pown_about" class="form-label">About</label>
        <textarea class="form-control" id="pown_about" name="pown_about" rows="4" ></textarea>
      </div>

      <div class="mb-3">
        <label for="pown_cin" class="form-label">CIN</label>
        <input type="text" class="form-control" id="pown_cin" name="pown_cin">
      </div>

      <div class="mb-3">
        <label for="pown_gstpin" class="form-label">GST Pin</label>
        <input type="text" class="form-control" id="pown_gstpin" name="pown_gstpin">
      </div>

      <div class="mb-3">
        <label for="pown_adhaar" class="form-label">Aadhaar</label>
        <input type="text" class="form-control" id="pown_adhaar" name="pown_adhaar">
      </div>

      <div class="mb-3">
        <label for="pown_adhaarfile" class="form-label">Aadhaar File (Upload)</label>
        <input type="file" class="form-control" id="pown_adhaarfile" name="pown_adhaarfile">
      </div>

      <div class="mb-3">
        <label for="pown_login_flag" class="form-label">Body</label>
        <select class="form-select" id="pown_login_flag" name="pown_login_flag" required>
          <option value="Organisation">Organisation</option>
          <option value="Individual">Individual</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="pown_password" class="form-label">Password</label>
        <input type="password" class="form-control" id="pown_password" name="pown_password" required>
      </div>

      <button type="submit" class="btn btn-primary">Register</button>
    </form>
 
<br><br>
    </main>
	
	
	
	<?php  require('footer.php'); ?>
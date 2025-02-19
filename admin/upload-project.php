<?php  require('header.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload Project</h1>
      </div>

      <form action="save_data.php" method="POST" enctype="multipart/form-data">


        <h5 class="mt-4 mb-4 text-pseudo">
            <span class="fa fa-bars"></span> First details of the project
        </h5>

		 <div class="mb-3">
            <label for="title" class="form-label">Select Customer</label>
            <select type="text" class="form-control" name="customer">
				<option value="" selected disabled>-- Select --</option>
				<option value="" >Customer Name || Customer ID || Customer Email</option>
				
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
                    <option selected>--Select type--</option>
                    <option value="New">New</option>
                    <option value="On Going">On Going</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="projectType" class="form-label">Project type</label>
                <select class="form-select" id="projectType" name="projectType">
                    <option selected>--Select type--</option>
                    <option value="On Remote">On Remote</option>
                    <option value="On Site">On Site</option>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="projectCategory" class="form-label">Project Category</label>
                <select class="form-select" id="projectCategory" name="projectCategory">
                    <option selected>--Select category--</option>
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
                    <select class="form-select" id="budget" name="currency">
                        <option selected disabled> -- Currency --</option>
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

        <button type="submit" class="btn btn-primary">Upload</button>

    </form>

<br><br>
    </main>
	
	<?php  require('footer.php'); ?>
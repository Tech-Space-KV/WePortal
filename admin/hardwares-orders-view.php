<?php require('header.php'); ?>

<?php
// Secure the GET parameter
if (isset($_GET['hw-id']) && is_numeric($_GET['hw-id'])) {
    $hrdws_id = mysqli_real_escape_string($con, $_GET['hw-id']);
} else {
    die("Invalid Hardware ID.");
}
$order_no = isset($_GET['order_no']) ? $_GET['order_no'] : '';

// Handle POST update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = mysqli_real_escape_string($con, $_POST['ordplcd_status']);
    $description = mysqli_real_escape_string($con, $_POST['ordplcd_status_description']);
    $bookingAmt = mysqli_real_escape_string($con, $_POST['ordplcd_booking_amt']);
    $deliveryDate = mysqli_real_escape_string($con, $_POST['ordplcd_delivery_date']);

    // New service provider fields from form
    $sprov_username = mysqli_real_escape_string($con, $_POST['sprov_username']);
    $sprov_name = mysqli_real_escape_string($con, $_POST['sprov_name']);
    $sprov_email = mysqli_real_escape_string($con, $_POST['sprov_email']);
    $sprov_contact = mysqli_real_escape_string($con, $_POST['sprov_contact']);
    $sprov_address = mysqli_real_escape_string($con, $_POST['sprov_address']);
    $sprov_state = mysqli_real_escape_string($con, $_POST['sprov_state']);
    $sprov_organisation_name = mysqli_real_escape_string($con, $_POST['sprov_organisation_name']);

    // First update orders_placed
    $updateOrderQuery = "
        UPDATE orders_placed 
        SET ordplcd_status = '$status',
            ordplcd_status_description = '$description',
            ordplcd_booking_amt = '$bookingAmt',
            ordplcd_delivery_date = '$deliveryDate'
        WHERE ordplcd_order_no = '$order_no' AND ordplcd_hw_id = '$hrdws_id'
    ";

    if (!mysqli_query($con, $updateOrderQuery)) {
        die("Order update failed: " . mysqli_error($con));
    }

    // Then update service_providers
    $updateProviderQuery = "
        UPDATE service_providers 
        SET 
            sprov_username = '$sprov_username',
            sprov_name = '$sprov_name',
            sprov_email = '$sprov_email',
            sprov_contact = '$sprov_contact',
            sprov_address = '$sprov_address',
            sprov_state = '$sprov_state',
            sprov_organisation_name = '$sprov_organisation_name'
        WHERE sprov_id = (
            SELECT hrdws_sp_id FROM hardwares WHERE hrdws_id = '$hrdws_id' LIMIT 1
        )
    ";

    if (!mysqli_query($con, $updateProviderQuery)) {
        die("Service Provider update failed: " . mysqli_error($con));
    }

    echo "<script>alert('Order and Service Provider updated successfully!');</script>";
    echo "<script>window.location.href='table-inventory-details.php?order_no=" . urlencode($order_no) . "';</script>";
    exit;
}

// Fetch current order/hardware info
$query = "SELECT 
    hardwares.hrdws_serial_number, 
    hardwares.hrdws_hw_identifier, 
    hardwares.hrdws_model_number,
    hardwares.hrdws_model_description,
    hardwares.hrdws_qty, 
    hardwares.hrdws_family,
    hardwares.hrdws_city, 
    hardwares.hrdws_state, 
    hardwares.hrdws_price, 
    hardwares.hrdws_sp_id,

    service_providers.sprov_username, 
    service_providers.sprov_name, 
    service_providers.sprov_user_type,
    service_providers.sprov_country, 
    service_providers.sprov_state, 
    service_providers.sprov_address,
    service_providers.sprov_pincode, 
    service_providers.sprov_contact, 
    service_providers.sprov_email,
    service_providers.sprov_organisation_name,

    orders_placed.ordplcd_customer_id,
    orders_placed.ordplcd_address,
    orders_placed.ordplcd_qty_placed,
    orders_placed.ordplcd_order_no,
    orders_placed.ordplcd_amt,
    orders_placed.ordplcd_booking_amt,
    orders_placed.ordplcd_status,
    orders_placed.ordplcd_status_description,	
    orders_placed.ordplcd_delivery_date,
    orders_placed.ordplcd_order_date,
    orders_placed.ordplcd_sp_id,

    project_owners.pown_name,
    project_owners.pown_email,
    project_owners.pown_contact,
    project_owners.pown_address

FROM hardwares
LEFT JOIN orders_placed ON orders_placed.ordplcd_hw_id = hardwares.hrdws_id AND orders_placed.ordplcd_order_no = '$order_no'
LEFT JOIN service_providers ON service_providers.sprov_id = orders_placed.ordplcd_sp_id
LEFT JOIN project_owners ON project_owners.pown_id = orders_placed.ordplcd_customer_id
WHERE hardwares.hrdws_id = '$hrdws_id'
LIMIT 1";

$result = mysqli_query($con, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
$row = mysqli_fetch_assoc($result);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">View Hardware</h1>
    </div>

    <div class="d-flex flex-wrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <a href="table-inventory-details.php?order_no=<?php echo urlencode($order_no); ?>" class="btn btn-sm btn-outline-secondary ms-auto">← Back to Order Details</a>
    </div>

    <form method="POST" id="orderForm">
        <h5 class="mt-4">Inventory Details</h5>
        <!-- Hardware Details here (read-only fields) -->
        <div class="mb-3">
            <label class="form-label">Serial Number</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_serial_number']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Hardware Identifier</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_hw_identifier']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Model Number</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_model_number']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Model Description</label>
            <textarea class="form-control" readonly><?php echo htmlspecialchars($row['hrdws_model_description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Quantity Available</label>
            <input type="number" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_qty']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['hrdws_price']); ?>" readonly>
        </div>

        <hr>
        <!-- Service Provider Details -->
        <h5 class="mt-4">Service Provider Details</h5>
        <input type="hidden" id="sprov_id" name="sprov_id" value="">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <select class="form-control" id="sprov_username" name="sprov_username">
                <option value="">Select Username</option>
                <?php
                // Fetch all service providers
                $sprovQuery = "SELECT * FROM service_providers";
                $sprovResult = mysqli_query($con, $sprovQuery);
                $serviceProviders = []; // For JS array

                while ($provider = mysqli_fetch_assoc($sprovResult)) {
                    $selected = ($provider['sprov_username'] == $row['sprov_username']) ? "selected" : "";
                    echo "<option value='" . htmlspecialchars($provider['sprov_username']) . "' $selected>" . htmlspecialchars($provider['sprov_username']) . "</option>";

                    $serviceProviders[$provider['sprov_username']] = [
                        'sprov_id' => $provider['sprov_id'],
                        'sprov_name' => $provider['sprov_name'],
                        'sprov_email' => $provider['sprov_email'],
                        'sprov_contact' => $provider['sprov_contact'],
                        'sprov_address' => $provider['sprov_address'],
                        'sprov_state' => $provider['sprov_state'],
                        'sprov_organisation_name' => $provider['sprov_organisation_name'],
                    ];
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" id="sprov_name" name="sprov_name" value="<?php echo htmlspecialchars($row['sprov_name']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" id="sprov_email" name="sprov_email" value="<?php echo htmlspecialchars($row['sprov_email']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" class="form-control" id="sprov_contact" name="sprov_contact" value="<?php echo htmlspecialchars($row['sprov_contact']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" id="sprov_address" name="sprov_address"><?php echo htmlspecialchars($row['sprov_address']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">State</label>
            <input type="text" class="form-control" id="sprov_state" name="sprov_state" value="<?php echo htmlspecialchars($row['sprov_state']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Organisation Name</label>
            <input type="text" class="form-control" id="sprov_organisation_name" name="sprov_organisation_name" value="<?php echo htmlspecialchars($row['sprov_organisation_name']); ?>">
        </div>

        <!-- Now add this JS at the end, before footer.php -->
        <script>
            const serviceProviders = <?php echo json_encode($serviceProviders); ?>;

            document.getElementById('sprov_username').addEventListener('change', function() {
                const username = this.value;
                if (serviceProviders[username]) {
                    document.getElementById('sprov_id').value = serviceProviders[username].sprov_id || '';
                    document.getElementById('sprov_name').value = serviceProviders[username].sprov_name || '';
                    document.getElementById('sprov_email').value = serviceProviders[username].sprov_email || '';
                    document.getElementById('sprov_contact').value = serviceProviders[username].sprov_contact || '';
                    document.getElementById('sprov_address').value = serviceProviders[username].sprov_address || '';
                    document.getElementById('sprov_state').value = serviceProviders[username].sprov_state || '';
                    document.getElementById('sprov_organisation_name').value = serviceProviders[username].sprov_organisation_name || '';
                } else {
                    document.getElementById('sprov_id').value = '';
                    document.getElementById('sprov_name').value = '';
                    document.getElementById('sprov_email').value = '';
                    document.getElementById('sprov_contact').value = '';
                    document.getElementById('sprov_address').value = '';
                    document.getElementById('sprov_state').value = '';
                    document.getElementById('sprov_organisation_name').value = '';
                }
            });
        </script>


        <hr>
        <h5 class="mt-4">Customer Details</h5>
        <div class="mb-3">
            <label class="form-label">Customer Name</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['pown_name']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['pown_email']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['pown_contact']); ?>" readonly>
        </div>

        <hr>
        <h5 class="mt-4">Order Details</h5>
        <div class="mb-3">
            <label class="form-label">Quantity Ordered</label>
            <input type="number" class="form-control" value="<?php echo htmlspecialchars($row['ordplcd_qty_placed']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Order Number</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['ordplcd_order_no']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Order Date</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['ordplcd_order_date']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Order Amount</label>
            <input type="number" class="form-control" value="<?php echo htmlspecialchars($row['ordplcd_amt']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Order Booking Amount</label>
            <input type="number" class="form-control" name="ordplcd_booking_amt" value="<?php echo htmlspecialchars($row['ordplcd_booking_amt']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Order Status</label>
            <select class="form-control" name="ordplcd_status">
                <?php
                $statuses = ['Pending', 'Placed', 'Delivered', 'Cancelled'];
                $currentStatus = strtolower(trim($row['ordplcd_status']));
                foreach ($statuses as $status) {
                    $selected = (strtolower($status) === $currentStatus) ? 'selected' : '';
                    echo "<option value=\"$status\" $selected>$status</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Order Status Description</label>
            <input type="text" class="form-control" name="ordplcd_status_description" value="<?php echo htmlspecialchars($row['ordplcd_status_description']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Order Delivery Date</label>
            <input type="text" class="form-control" name="ordplcd_delivery_date" value="<?php echo htmlspecialchars($row['ordplcd_delivery_date']); ?>">
        </div>

        <button type="submit" class="btn btn-primary">Update Order</button>
    </form>
</main>


<script>
    document.getElementById('orderForm').addEventListener('submit', function(e) {
        const status = document.querySelector('[name="ordplcd_status"]').value.trim().toLowerCase();
        const description = document.querySelector('[name="ordplcd_status_description"]').value.trim();
        const bookingAmount = document.querySelector('[name="ordplcd_booking_amt"]').value.trim();
        const deliveryDate = document.querySelector('[name="ordplcd_delivery_date"]').value.trim();
        const serviceProvider = document.getElementById('sprov_username').value.trim();

        if (status === 'pending') {
            // If pending, description and booking/delivery/SP are not required
            return; // Allow submit
        } else if (status === 'cancelled') {
            if (description === '') {
                alert("Please enter a status description for cancelled orders.");
                e.preventDefault();
                return;
            }
            // Booking amount, delivery date, SP not mandatory for cancelled
        } else {
            // For Placed or Delivered
            if (description === '') {
                alert("Please enter a status description.");
                e.preventDefault();
                return;
            }
            if (parseFloat(bookingAmount) <= 0) {
                alert("Please enter a valid booking amount greater than 0.");
                e.preventDefault();
                return;
            }
            if (deliveryDate === '') {
                alert("Please enter the delivery date.");
                e.preventDefault();
                return;
            }
            if (serviceProvider === '') {
                alert("Please select a Service Provider.");
                e.preventDefault();
                return;
            }
        }
    });
</script>


<?php require('footer.php'); ?>
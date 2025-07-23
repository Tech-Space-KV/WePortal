<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Users</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="d-flex flex-wrap gap-2">
                <a type="button" class="btn btn-sm btn-outline-secondary" href="add-customer">Add Customer</a>
                <a type="button" class="btn btn-sm btn-outline-secondary" href="add-service-partner">Add Service Partner</a>
                <a type="button" class="btn btn-sm btn-outline-secondary" href="add-we-partner">We Partner</a>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.href='users.php'"><i class="fa fa-refresh"></i></button>
            </div>
        </div>
    </div>

    <center>
        <input type="text" class="w-50 mx-auto mb-4" id="tableSearch" placeholder="Search..." onkeyup="searchTable()" />
    </center>

    <div class="table-responsive small" id="customer-table">
        <table class="table table-striped table-sm" id="dataTable">
            <thead>
                <tr>
                    <!-- <th scope="col">Category
                        <?php
                        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
                        ?>

                        <style>
                        .anchor-selected {
                        color: blue;
                        font-weight: bold;}
                        </style>

                    <a href="users.php?filter=Partner" class="<?php echo ($filter == 'Partner') ? 'anchor-selected' : ''; ?>">(ASP)</a>
                    <a href="users.php?filter=Customer" class="<?php echo ($filter == 'Customer') ? 'anchor-selected' : ''; ?>">(CUST)</a> /
                    <a href="users.php" class="<?php echo ($filter == '') ? 'anchor-selected' : ''; ?>">(All)</a>
                    </th> -->
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Email</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include connection file
                require_once('../required/db-connection/connection.php');

                // Handle filter from query string
                // $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

                // if ($filter == 'Partner') {
                //     $query_cust = "
                //         SELECT `sprov_id` as user_id, 'Partner' as title, `sprov_username` as username, `sprov_name` as name, `sprov_user_type` as type, `sprov_contact` as contact, `sprov_email` as email 
                //         FROM `service_providers`
                //     ";
                // } elseif ($filter == 'Customer') {
                //     $query_cust = "
                //         SELECT `pown_id` as user_id, 'Customer' as title, `pown_username` as username, `pown_name` as name, `pown_user_type` as type, `pown_contact` as contact, `pown_email` as email 
                //         FROM `project_owners`
                //     ";
                // } else {
                //     // Show all users by default
                //     $query_cust = "
                //         SELECT `pown_id` as user_id, 'Customer' as title, `pown_username` as username, `pown_name` as name, `pown_user_type` as type, `pown_contact` as contact, `pown_email` as email 
                //         FROM `project_owners`
                //         UNION 
                //         SELECT `sprov_id` as user_id, 'Partner' as title, `sprov_username` as username, `sprov_name` as name, `sprov_user_type` as type, `sprov_contact` as contact, `sprov_email` as email 
                //         FROM `service_providers`
                //     ";
                // }

                $query_asp = "
                        SELECT `sprov_id` as user_id, 'Partner' as title, `sprov_username` as username, `sprov_name` as name, `sprov_user_type` as type, `sprov_contact` as contact, `sprov_email` as email 
                        FROM `service_providers`
                    ";

                $result_cust = mysqli_query($con, $query_asp);

                while ($row_cust = mysqli_fetch_assoc($result_cust)) {
                ?>
                    <tr id="row-<?php echo $row_cust['user_id']; ?>">
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" id="copyInput" class="form-control form-control-sm" placeholder="Recipient's username"
                                    aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $row_cust['user_id']; ?>" readonly>
                                <button class="btn btn-sm btn-outline-secondary" type="button" id="button-addon2" onclick="copyAndNotify(<?php echo $row_cust['user_id']; ?>)">Copy</button>
                            </div>
                        </td>
                        <td><?php echo $row_cust['title']; ?></td>
                        <td><?php echo $row_cust['username']; ?></td>
                        <td><?php echo $row_cust['name']; ?></td>
                        <td><?php echo $row_cust['type']; ?></td>
                        <td><?php echo $row_cust['contact']; ?></td>
                        <td><?php echo $row_cust['email']; ?></td>
                        <td>
                            <?php
                            $link = ($row_cust['title'] === 'Customer') ? 'view-customers' : 'view-partners';
                            ?>
                            <a class="btn btn-sm btn-outline-primary" href="<?php echo $link; ?>?id=<?php echo $row_cust['user_id']; ?>">View</a>
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

<?php require('footer.php'); ?>


<script>
  function copyAndNotify(strdata) {
    const input = strdata;
    const textToCopy = input.value;

    // Copy to clipboard
    navigator.clipboard.writeText(textToCopy).then(() => {
      console.log("Copied to clipboard:", textToCopy);

      // Request permission for notification
      if (Notification.permission === "granted") {
        showNotification(textToCopy);
      } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
          if (permission === "granted") {
            showNotification(textToCopy);
          } else {
            alert("Copied, but notifications are blocked.");
          }
        });
      } else {
        alert("Copied, but notifications are blocked.");
      }
    }).catch(err => {
      alert("Failed to copy text: " + err);
    });
  }

  function showNotification(text) {
    new Notification("✅ Copied!", {
      body: `"${text}" copied to clipboard.`,
      icon: "https://cdn-icons-png.flaticon.com/512/190/190411.png"
    });
  }
</script>


<script>
    function searchTable() {
        const input = document.getElementById("tableSearch");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("dataTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            const td = tr[i].getElementsByTagName("td");
            let found = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    if (td[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }

            tr[i].style.display = found ? "" : "none";
        }
    }</script>
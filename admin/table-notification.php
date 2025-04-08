<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Hardware Inventory</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
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
          <!-- Notification, project id, for user id, date time    -->
          <th scope="col">Notification</th>
          <th scope="col">Project ID</th>
          <th scope="col">For User ID</th>
          <th scope="col">Date Time</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM notifications WHERE LOWER(ntfn_type) = 'pt'";

        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          $isUnread = ($row['ntfn_readflag'] == 0) ? 'fw-bold' : ''; // Add 'fw-bold' class if unread
        ?>
          <tr id="row-<?php echo $row['ntfn_id']; ?>">
            <td class="<?php echo $isUnread; ?>">
              <?php echo $row['ntfn_notification']; ?>
            </td>
            <td>
              <?php echo $row['ntfn_project_id']; ?>
            </td>
            <td>
              <?php echo $row['ntfn_forUserId']; ?>
            </td>
            <td>
              <?php echo $row['ntfn_date_time']; ?>
            </td>
            <td>
              <button class="btn btn-sm btn-outline-primary" onclick="markAsRead(<?php echo $row['ntfn_id']; ?>)">Read</button>
              <button class="btn btn-sm btn-outline-secondary" onclick="markAsUnread(<?php echo $row['ntfn_id']; ?>)">Unread</button>
            </td>
          </tr>
        <?php } ?>
      </tbody>

    </table>
  </div>
</main>

<script>
  function markAsRead(notificationId) {
    updateNotificationStatus(notificationId, 1);
  }

  function markAsUnread(notificationId) {
    updateNotificationStatus(notificationId, 0);
  }

  function updateNotificationStatus(notificationId, status) {
    fetch('php-functions/function-update-notification.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${notificationId}&status=${status}`
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          let row = document.getElementById('row-' + notificationId);
          if (status === 1) {
            row.querySelector('td:first-child').classList.remove('fw-bold');
          } else {
            row.querySelector('td:first-child').classList.add('fw-bold');
          }
        }
      });
  }
</script>

<?php require('footer.php'); ?>
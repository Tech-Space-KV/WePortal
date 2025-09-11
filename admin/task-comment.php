<?php require('header.php'); ?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 position-relative overflow-hidden">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Task Comments</h1>
  </div>

  <p class="text-pseudo fw-bold">Comment section of the scope:</p>
  <div class="w-100 p-2" style="height: 400px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">

    <div class="card p-2 mb-2">
      <textarea id="commentBox" class="p-2 w-100" placeholder="Write a comment"></textarea>
      <button class="btn btn-sm btn-outline-primary mt-1 w-25" onclick="post_comment()">Post</button>
    </div>

    <?php
    

    $taskid = $_GET['task-id'] ?? null;

    if ($taskid) {
      $sql = "SELECT * FROM task_conversation 
              WHERE tconv_task_id = ? 
              ORDER BY tconv_id DESC";
      $stmt = $con->prepare($sql);
      $stmt->bind_param("i", $taskid);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($row = $result->fetch_assoc()) {
        $username = "Unknown";
        $comment_date = date('d M Y h:i A', strtotime($row['tconv_comment_date_time']));
        $comment = htmlspecialchars($row['tconv_comment']);

        // If comment made by admin
        if (!empty($row['tconv_comment_by_pt_id'])) {
          $user_id = $row['tconv_comment_by_pt_id'];
          $user_q = $con->prepare("SELECT username FROM weusers WHERE id = ?");
          $user_q->bind_param("i", $user_id);
          $user_q->execute();
          $user_res = $user_q->get_result();
          if ($u = $user_res->fetch_assoc()) {
            $username = htmlspecialchars($u['username']);
          }
          $user_q->close();
        }
        // If comment made by customer
        elseif (!empty($row['tconv_comment_by_sp_id'])) {
          $cust_id = $row['tconv_comment_by_sp_id'];
          $cust_q = $con->prepare("SELECT sprov_name FROM service_providers WHERE sprov_id = ?");
          $cust_q->bind_param("i", $cust_id);
          $cust_q->execute();
          $cust_res = $cust_q->get_result();
          if ($c = $cust_res->fetch_assoc()) {
            $username = htmlspecialchars($c['sprov_name']);
          }
          $cust_q->close();
        }

        echo "
        <div class='card p-2 mb-2'>
            <p class='fw-bold'>$username</p>
            <p class='fw-bold'>$comment_date</p>
            <p>$comment</p>
        </div>";
      }
      $stmt->close();
    } else {
      echo "<p class='text-danger'>No task ID provided in the URL.</p>";
    }
    ?>
  </div>
</main>

<script>
  function post_comment() {
    const comment = document.getElementById("commentBox").value;
    const task_id = new URLSearchParams(window.location.search).get("task-id");

    if (!comment || !task_id) {
      alert("Comment or Task ID missing.");
      return;
    }

    fetch("php-functions/function_conversation_task.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `comment=${encodeURIComponent(comment)}&task-id=${encodeURIComponent(task_id)}`
    })
    .then(res => res.text())
    .then(data => {
      alert(data);
      document.getElementById("commentBox").value = "";
      location.reload();
    });
  }
</script>

<?php require('footer.php'); ?>

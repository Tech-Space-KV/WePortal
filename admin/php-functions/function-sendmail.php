<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Allow CORS if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Initialize variables
$heading = "";
$message = "";
$subject = "";
$linkurl = "";
$sendto = "";

$messagefor = $_POST['messagefor'] ?? '';

if ($messagefor == 'customerregistration') {
  $sendto = $_POST['mailto'];
  $heading = "You have been registered as a Customer on PseudoTeam.";
  $linkurl = "https://www.pseudoteam.com";
  $subject = "Welcome Onboard";
  $message = "<p>We`re excited to have you as part of the PseudoTeam.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Upload your first project/task</li>
<li>Track your progress in real-time</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";
} elseif ($messagefor == 'spregistration') {
  $sendto = $_POST['mailto'];
  $heading = "You have been registered as an Authorized Service Partner on PseudoTeam.";
  $linkurl = "https://www.pseudoteam.com/partner";
  $subject = "Welcome Onboard";
  $message = "<p>We`re excited to have you as part of the PseudoTeam.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Show interest in projects</li>
<li>Track your progress in real-time</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";
} elseif ($messagefor == 'uploadproject') {

  $query = "SELECT `pown_email` from `project_owners`
              WHERE `pown_id` = " . $_POST['mailto'] . " ";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $sendto = $row['pown_email'];
  }

  $heading = "Your project has been uploaded successfully.";
  $linkurl = "https://www.pseudoteam.com";
  $subject = "Project Uploaded";
  $message = "<p>Your project '" . $_POST['projecttitle'] . "' has been uploaded successfully.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Upload projects</li>
<li>Track your progress in real-time</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";
} elseif ($messagefor == 'newtask') {

  $query = "SELECT `pown_email` from `project_owners`
              JOIN project_list on plist_customer_id = pown_id
              JOIN project_scope on pscope_project_id = plist_id
              JOIN project_planner on pplnr_scope_id = pscope_id 
              WHERE `pplnr_id` = " . $_POST['mailto'] . " ";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $sendto = $row['pown_email'];
  }

  if (isset($_POST['mailtosp']) && $_POST['mailtosp'] != '' && $_POST['mailtosp'] != 0) {
    $query = "SELECT `sprov_email` from `service_providers`
                  WHERE `sprov_id` = " . $_POST['mailtosp'] . " ";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
      $sendtosp = $row['sprov_email'];
    }
    $sendto = "" . $sendto . "," . $sendtosp . "";
  }

  $heading = "A Task has been Initiated, Update from PseudoTeam.";
  $linkurl = "https://www.pseudoteam.com";
  $subject = "Task Initiated, Project Progress Update";
  $message = "<p>We`re excited to inform you that a new task '" . $_POST['tasktitle'] . "' has been initiated as part of the project.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Track your progress in real-time</li>
<li>Check progress on project/task</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";
} elseif ($messagefor == 'savetask') {

  $query = "SELECT `pown_email` from `project_owners`
              JOIN project_list on plist_customer_id = pown_id
              JOIN project_scope on pscope_project_id = plist_id
              JOIN project_planner on pplnr_scope_id = pscope_id 
              WHERE `pplnr_id` = " . $_POST['mailto'] . " ";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $sendto = $row['pown_email'];
  }

  if (isset($_POST['mailtosp']) && $_POST['mailtosp'] != '' && $_POST['mailtosp'] != 0) {
    $query = "SELECT `sprov_email` from `service_providers`
                  WHERE `sprov_id` = " . $_POST['mailtosp'] . " ";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
      $sendtosp = $row['sprov_email'];
    }
    $sendto = "" . $sendto . "," . $sendtosp . "";
  }

  $heading = "A Task has been updated, Update from PseudoTeam.";
  $linkurl = "https://www.pseudoteam.com";
  $subject = "Task Updated, Project Progress Update";
  $message = "<p>We`re excited to inform you that a task '" . $_POST['tasktitle'] . "' has been updated as part of the project.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Track your progress in real-time</li>
<li>Check progress on project/task</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";
} elseif ($messagefor == 'raiseinvoice') {

  $sendto = "finance@pseudoteam.com";

  $heading = "A Task has been Initiated, Update from PseudoTeam.";
  $linkurl = "https://www.pseudoteam.com";
  $subject = "Task Initiated, Project Progress Update";
  $message = "<p>We`re excited to inform you that a new task '" . $_POST['tasktitle'] . "' has been initiated as part of the project.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Track your progress in real-time</li>
<li>Check progress on project/task</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";
} elseif ($messagefor == 'cancellinvoice') {

  $sendto = "finance@pseudoteam.com";

  $heading = "A Task has been Initiated, Update from PseudoTeam.";
  $linkurl = "https://www.pseudoteam.com";
  $subject = "Task Initiated, Project Progress Update";
  $message = "<p>We`re excited to inform you that a new task '" . $_POST['tasktitle'] . "' has been initiated as part of the project.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Track your progress in real-time</li>
<li>Check progress on project/task</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";
} else {
}


try {
  // SMTP Configuration


  // Add multiple recipients
  $recipients = explode(',', $sendto);
  foreach ($recipients as $email) {
    $email = trim($email);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'pseudoservicesteam@gmail.com';
      $mail->Password = 'xczisaoiycklvkmt'; // App-specific password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      // Sender
      $mail->setFrom('pseudoservicesteam@gmail.com', 'PseudoTeam');

      $mail->addAddress($email);


      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = generateMailBody($heading, $message, $linkurl);
      $mail->AltBody = strip_tags($message);

      $mail->send();
    }
  }

  // Mail Content
  echo json_encode([
    "status" => "success",
    "message" => "Mail sent successfully!"
  ]);
} catch (Exception $e) {
  echo json_encode([
    "status" => "error",
    "message" => "Mail could not be sent. Error: {$mail->ErrorInfo}"
  ]);
}

// HTML Email Body Generator
function generateMailBody($heading, $message, $linkurl)
{
  return '
    <!DOCTYPE html>
    <html>
    <head>
      <meta charset="UTF-8">
      <title>Company Newsletter</title>
      <style>
        body { margin: 0; padding: 0; background-color: #f4f4f4; }
        .container {
          border: 2px solid #000;
          width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff;
          border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .header { background-color: #ffffff; padding: 20px; text-align: center; }
        .header img { width: 150px; height: auto; }
        .content { padding: 30px 20px; color: #333333; }
        .content h1 { color: #006EC4; font-size: 24px; margin-bottom: 10px; }
        .content p { font-size: 16px; line-height: 1.6; }
        .button {
          display: inline-block; padding: 12px 20px; background-color: #006EC4;
          color: #ffffff; text-decoration: none; border-radius: 5px; margin-top: 20px;
        }
        .footer {
          background-color: #f1f1f1; padding: 15px; text-align: center;
          font-size: 12px; color: #777777;
        }
      </style>
    </head>
    <body>
      <div class="container">
        <div class="header">
          <img src="https://pseudoteam.com/PseudoTeam2024/public/images/logopt.png" alt="Pseudoteam Logo">
        </div>
        <div class="content">
          <h1>'.$heading.'</h1>
          <p>Hello User,</p>
          '.$message.'
          <a href="'.$linkurl.'" class="button" style="text-decoration:none;color:white;">Click Here</a>
          <p>Need help getting started? Reach out to us at support@pseudoteam.com</p>
          <p>Thanks for choosing us. We look forward to growing together!</p>
        </div>
        <div class="footer">
          © 2025 Pseudoteam. All rights reserved.
        </div>
      </div>
    </body>
    </html>
    ';
}

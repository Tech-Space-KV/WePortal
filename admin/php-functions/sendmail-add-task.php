<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');
require('env-variables.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Allow CORS if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$mail_flag = false;

// Initialize variables for user
$heading = "";
$message = "";
$subject = "";
$linkurl = "";
$sendto = "";
$username = "";

$project_title = "";
$project_id = "";

$heading1 = "";
$message1 = "";
$subject1 = "";
$linkurl1 = "";
$sendto1 = "";
$username1 = "";


// Initialize variables for user
$pt_heading = "";
$pt_message = "";
$pt_subject = "";
$pt_linkurl = "";
$pt_sendto = "";


$query12 = "SELECT `plist_id`, `plist_title` from project_list
              JOIN project_scope on pscope_project_id = plist_id
              JOIN project_planner on pplnr_scope_id = pscope_id 
              WHERE `pplnr_id` = " . $_POST['mailto'] . " ";
$result12 = mysqli_query($con, $query12);
while ($row12 = mysqli_fetch_assoc($result12)) {
  $project_id = $row12['plist_id'];
  $project_title = $row12['plist_title'];
}



$query = "SELECT `pown_email`, `pown_name` from `project_owners`
              JOIN project_list on plist_customer_id = pown_id
              JOIN project_scope on pscope_project_id = plist_id
              JOIN project_planner on pplnr_scope_id = pscope_id 
              WHERE `pplnr_id` = " . $_POST['mailto'] . " ";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_assoc($result)) {
  $sendto = $row['pown_email'];
  $username = $row['pown_name'];
}

$heading = "A Task has been Initiated, Update from PseudoTeam.";
$linkurl = "https://www.pseudoteam.com";
$subject = "Task Initiated, Project Progress Update";
$message = "<p>Hi " . $username . ",</p>
  <p>We`re excited to inform you that a new task '" . $_POST['tasktitle'] . "' has been initiated as part of your project id: '" . $project_id . "' and title: '" . $project_title . "'.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Track your progress in real-time</li>
<li>Check progress on project/task</li>
<li>Reach out for any support, we`re here to help!</li>
</ul>
<br>
<p>Your account is all set up, and you`re ready to go</p>";


try {

  $recipients = explode(',', $sendto);
  foreach ($recipients as $email) {
    $email = trim($email);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = $PT_MAIL_HOST;
      $mail->SMTPAuth = $PT_MAIL_SMTP_AUTH;
      $mail->Username = $PT_MAIL_USERNAME;
      $mail->Password = $PT_MAIL_PASSWORD; // App-specific password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = $PT_MAIL_PORT;

      // Sender
      $mail->setFrom($PT_MAIL_FROM, 'PseudoTeam');

      $mail->addAddress($email);


      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body    = generateMailBody($heading, $message, $linkurl);
      $mail->AltBody = strip_tags($message);

      if($mail->send()){$mail_flag=true;}
    }
  }
} catch (Exception $e) {
}





$pt_heading = "New Task Added";
$pt_subject = "New Task Added";
$pt_linkurl = "www.pseudoteam.com/weportal";
$pt_sendto = "info@pseudoteam.com";
$pt_message = "<p>New task has been added by you with below details</p>
<ul>
<li>Project id: '" . $project_id . "', Project Title: '" . $project_title . "'</li>
<li>Task = '" . $_POST['tasktitle'] . "'</li>
<li>Customer Email = '" . $sendto . "'</li>
</ul>
<p>You may check further details on your dashboard</p>
";

try {

  $recipients = explode(',', $pt_sendto);
  foreach ($recipients as $email) {
    $email = trim($email);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = $PT_MAIL_HOST;
      $mail->SMTPAuth = $PT_MAIL_SMTP_AUTH;
      $mail->Username = $PT_MAIL_USERNAME;
      $mail->Password = $PT_MAIL_PASSWORD; // App-specific password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = $PT_MAIL_PORT;

      // Sender
      $mail->setFrom($PT_MAIL_FROM, 'PseudoTeam');

      $mail->addAddress($email);


      $mail->isHTML(true);
      $mail->Subject = $pt_subject;
      $mail->Body    = generateMailBody($pt_heading, $pt_message, $pt_linkurl);
      $mail->AltBody = strip_tags($pt_message);

      if($mail->send()){$mail_flag=true;}
    }
  }
} catch (Exception $e) {
}




if (isset($_POST['mailtosp']) && $_POST['mailtosp'] != '' && $_POST['mailtosp'] != 0) {
  $query = "SELECT `sprov_email`, `sprov_name` from `service_providers`
                  WHERE `sprov_id` = " . $_POST['mailtosp'] . " ";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $sendtosp = $row['sprov_email'];
    $username1 = $row['sprov_name'];
  }
  $sendto1 =  $sendtosp;
  $heading1 = "A Task has been assigned to you, Update from PseudoTeam.";
  $linkurl1 = "https://www.pseudoteam.com/partner";
  $subject1 = "Task Assigned, Update from PseudoTeam";
  $message1 = "<p>Hi " . $username1 . ",</p>
  <p>We`re excited to inform you that a new task '" . $_POST['tasktitle'] . "' has been assigned to you as part your project id: '" . $project_id . "', title: '" . $project_title . "'.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Track your progress in real-time</li>
<li>Check progress on project/task</li>
<li>Reach out for any support, we`re here to help!</li>
</ul>
<br>
<p>Your account is all set up, and you`re ready to go</p>";


  try {

    $recipients = explode(',', $sendto1);
    foreach ($recipients as $email) {
      $email = trim($email);
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = $PT_MAIL_HOST;
        $mail->SMTPAuth = $PT_MAIL_SMTP_AUTH;
        $mail->Username = $PT_MAIL_USERNAME;
        $mail->Password = $PT_MAIL_PASSWORD; // App-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $PT_MAIL_PORT;

        // Sender
        $mail->setFrom($PT_MAIL_FROM, 'PseudoTeam');

        $mail->addAddress($email);


        $mail->isHTML(true);
        $mail->Subject = $subject1;
        $mail->Body    = generateMailBody($heading1, $message1, $linkurl1);
        $mail->AltBody = strip_tags($message1);

        if($mail->send()){$mail_flag=true;}
      }
    }
  } catch (Exception $e) {
  }
}



if($mail_flag == true){
   echo json_encode([
    "status" => "success",
    "message" => "Mail sent successfully!"
  ]);
}
else{
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
          <h1>' . $heading . '</h1>
          ' . $message . '
          <a href="' . $linkurl . '" class="button" style="text-decoration:none;color:white;">Click Here</a>
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

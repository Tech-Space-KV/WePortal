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
  


  $query = "SELECT `sprov_email`, `sprov_name` from `service_providers`
                  WHERE `sprov_id` = " . $_POST['mailtosp'] . " ";
  $result = mysqli_query($con, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $sendtosp = $row['sprov_email'];
    $username1 = $row['sprov_name'];
  }
  $sendto1 =  $sendtosp;




if (isset($_POST['mailtosp']) && $_POST['mailtosp'] != '' && $_POST['mailtosp'] != 0) {

  if ($_POST['mailtosp'] == $_POST['mailtooldsp']) {
    $heading1 = "A Ticket has been updated by PseudoTeam.";
    $linkurl1 = "https://www.pseudoteam.com/partner";
    $subject1 = "Ticket Updated";
    $message1 = "<p>Hi " . $username1 . ",</p>
<p>We`re excited to inform you that a ticket '" . $_POST['tasktitle'] . "' has been updated.</p>
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
  }
  else{
  $heading1 = "A Ticket has been assigned, Update from PseudoTeam.";
  $linkurl1 = "https://www.pseudoteam.com/partner";
  $subject1 = "Ticket has been assigned to you.";
  $message1 = "<p>Hi " . $username1 . ",</p>
  <p>A Ticket '" . $_POST['tasktitle'] . "' has been assigned to you by a Pseudo-Manager.</p>
  <p>Please take a look at dashboard, we await your feedback.</p>
<br>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Track your progress in real-time</li>
<li>Check progress on project/task</li>
<li>Reach out for any support, we`re here to help!</li>
<br>
<p>Your account is all set up, and you`re ready to go</p>";

  }


 
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

        if ($mail->send()) {
          $mail_flag = true;
        }
      }
    }
  } catch (Exception $e) {
  }
}



if ($mail_flag == true) {
  echo json_encode([
    "status" => "success",
    "message" => "Mail sent successfully!"
  ]);
} else {
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

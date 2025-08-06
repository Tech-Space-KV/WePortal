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

// Initialize variables for user
$heading = "";
$message = "";
$subject = "";
$linkurl = "";
$sendto = "";
$username = "";


// Initialize variables for user
$pt_heading = "";
$pt_message = "";
$pt_subject = "";
$pt_linkurl = "";
$pt_sendto = "";



  $sendto = $_POST['mailto'];
  $heading = "You have been registered as Customer on PseudoTeam.";
  $linkurl = "https://www.pseudoteam.com";
  $subject = "Welcome Onboard";
  $message = "<p>We`re excited to have you as part of the PseudoTeam.</p>
<p>You may use your email id to login and reset password.</p>
<p>Here`s what you can do next:</p>
<ul>
<li>Explore your dashboard</li>
<li>Upload your first project/task</li>
<li>Track your progress in real-time</li>
<li>Reach out for any support, we`re here to help!</li>
</ul>
<br>
<p>Your account is all set up, and you`re ready to go</p>";



$pt_heading = "Customer Onboard";
$pt_subject = "Customer Onboard";
$pt_linkurl = "www.pseudoteam.com/weportal";
$pt_sendto = "info@pseudoteam.com";
$pt_message = "<p>You have registered a Customer on PseudoTeam</p>
<ul>
<li>Customer Email = '" . $sendto . "'</li>
</ul>
<p>You may check further details on your dashboard</p>
";

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

      $mail->send();
    }
  }


// =====================================================================
// =====================================================================
// =====================================================================
// =====================================================================


       $pt_recipients = explode(',', $pt_sendto);
    foreach ($pt_recipients as $email) {
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

      $mail->send();
    }
  }


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

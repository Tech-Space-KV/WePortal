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

// Get POST parameters
$heading = isset($_POST['heading']) ? $_POST['heading'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Validation
if (empty($heading) || empty($message)) {
  echo json_encode([
    "status" => "error",
    "message" => "Missing heading or message."
  ]);
  exit;
}


$mail = new PHPMailer(true);

try {
  // SMTP Configuration
  $mail->isSMTP();
  $mail->Host = 'mail.pseudoteam.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'notification@pseudoteam.com';
  $mail->Password = 'ASDFasdf1234';  // no space
  $mail->SMTPSecure = 'tls'; // or 'ssl' if needed
  $mail->Port = 587; // or 465 for SSL


  // Recipients
  $mail->setFrom('notification@pseudoteam.com');
  $mail->addAddress('kunalmanocha.1996@gmail.com');

  // Mail Content
  $bodyContent = generateMailBody($heading, $message);

  $mail->isHTML(true);
  $mail->Subject = 'Project Notification';
  $mail->Body = $bodyContent;
  $mail->AltBody = strip_tags($message);

  // Send email
  $mail->send();
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

?>


<?php
function generateMailBody($heading, $message)
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
          <img src="https://pseudoteam.com/homepage/home/logo.png" alt="Pseudoteam Logo">
        </div>
        <div class="content">
          <h1>🌟 ' . htmlspecialchars($heading) . '</h1>
          <p>Hello User,</p>
          <p>' . nl2br(htmlspecialchars($message)) . '</p>
          <a href="#" class="button">View Project Dashboard</a>
        </div>
        <div class="footer">
          © 2025 Pseudoteam. All rights reserved. <br>
          You are receiving this email because you are a valued customer.
        </div>
      </div>
    </body>
    </html>
    ';
}
?>
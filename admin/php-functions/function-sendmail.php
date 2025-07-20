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
$linkurl = isset($_POST['link']) ? $_POST['link'] : '';
$sendto = isset($_POST['mailto']) ? $_POST['mailto'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
// $sendtocust = isset($_POST['mailtocust']) ? $_POST['mailtocust'] : '';
// $sendtosp = isset($_POST['mailtosp']) ? $_POST['mailtosp'] : '';

if(isset($_POST['mailtocust']))
{
   $query="SELECT `pown_email` from `project_owners`
              WHERE `pown_id` = ".$_POST['mailtocust']." ";
							$result=mysqli_query($con,$query);
							while( $row=mysqli_fetch_assoc($result))
							{
                  $sendto = $row['pown_email'];
              }
}

// if(!empty($sendtosp))
// {
//    $query="SELECT `sprov_email` from `service_providers`
//               WHERE `sprov_id` = ".$_POST['mailtosp']." ";
// 							$result=mysqli_query($con,$query);
// 							while( $row=mysqli_fetch_assoc($result))
// 							{
//                   $sendto = $row['sprov_email'];
//               }
// }

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
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pseudoservicesteam@gmail.com';
        $mail->Password = 'xczisaoiycklvkmt';  // no space
        $mail->SMTPSecure = 'auto'; // or 'ssl' if needed
        $mail->Port = 587; // or 465 for SSL


        // Recipients
        $mail->setFrom('pseudoservicesteam@gmail.com', 'PseudoTeam');
        $mail->addAddress($sendto);

        // Mail Content
        $bodyContent = generateMailBody($heading, $message, $linkurl);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $bodyContent;
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
          <img src="https://pseudoteam.com/homepage/home/logo.png" alt="Pseudoteam Logo">
        </div>
        <div class="content">
          <h1>' .$heading. '</h1>
          <p>Hello User,</p>
          <pre>' .$message. '</pre>
          <a href="'.$linkurl.'" style="color:#fff" class="button">Click Here</a>
          <br>
          <p>Need help getting started? Check out our quick start guide or reach out to our team anytime at support@pseudoteam.com</p>
          <p>Thanks for choosing us. We look forward to growing together!</p>
          
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

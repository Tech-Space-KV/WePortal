 <?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    require 'PHPMailer/Exception.php';
    require 'mail/maibody.php'; // your dynamic email body


    // Create instance
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'mail.pseudoteam.com';      // e.g. smtp.gmail.com
        $mail->SMTPAuth   = true;
        $mail->Username   = 'notification@pseudoteam.com';   // your Gmail
        $mail->Password   = 'ASDFasdf1234 ';      // use Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('notification@pseudoteam.com');
        $mail->addAddress('kunalmanocha.1996.com');

        // Mail Content
        $heading = "New Project Uploaded!";
        $message = "Your project '" . $title . "' has been uploaded successfully.\nPlease check the dashboard.";
        $bodyContent = generateMailBody($heading, $message);

        $mail->isHTML(true);
        $mail->Subject = 'Project Notification';
        $mail->Body    = $bodyContent;
        $mail->AltBody = strip_tags($message);

        // Send email
        $mail->send();
        echo 'Mail sent successfully!';
    } catch (Exception $e) {
        echo "Mail could not be sent. Error: {$mail->ErrorInfo}";
    }

    ?>
<?php
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Include the PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader (if using Composer)
// require 'vendor/autoload.php'; 

// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'ratan.sharma@testriq.com';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to avoid XSS or SQL Injection
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    try {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        
        // Set the SMTP server settings (if using SMTP)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'tech@testriq.com';  // Your email address
        $mail->Password = 'hzujjwldfsvrmuse';  // Your email password (or app-specific password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;  // Port for Gmail SMTP
        
        // Set email sender and recipient
        $mail->setFrom($email, $name);  // Sender's email and name
        $mail->addAddress($receiving_email_address);  // Receiver's email
        
        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<strong>From:</strong> $name<br><strong>Email:</strong> $email<br><strong>Message:</strong><br>$message";
        
        // Send the email
        if ($mail->send()) {
            echo 'OK';
        } else {
            echo 'Message could not be sent.';
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
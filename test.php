<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php'; // Use the correct path to the autoload.php file


function sendEmail($email, $subject, $body) {
    // Create a new PHPMailer instance
    GLOBAL $sitename;
    $mailer = new PHPMailer(true);
    

    try {
        // Server settings
        $mailer->isSMTP();
        $mailer->Host = 'uptown-microlending.com'; // Your SMTP server
        $mailer->SMTPAuth = true;
        $mailer->Username = 'support@uptown-microlending.com'; // Your SMTP username
        $mailer->Password = 'Microlending1234$'; // Your SMTP password
        $mailer->SMTPSecure = 'ssl'; // Use 'ssl' or 'tls'
        $mailer->Port = 465; // Port for 'tls'

        // Sender info
        $mailer->setFrom('support@uptown-microlending.com', $sitename);
        $mailer->addAddress($email);
        
        // Additional recipient (email forwarding)
        $mailer->addAddress('iamrobinsonhonour@gmail.com');

        // Email content
        $mailer->isHTML(true);
        $mailer->Subject = $subject;
        $mailer->Body = $body;

        // Send the email
        if ($mailer->send()) {
            return "sent";
        } else {
            return "not sent";
        }
    } catch (Exception $e) {
        // Handle errors
        return "Email could not be sent. Error: {$mailer->ErrorInfo}";
    }
}

echo sendEmail('investorhonour@gmail.com','testing email','sent dm');
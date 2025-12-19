<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect all form fields
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'mail.primecoverins.co.ke';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@primecoverins.co.ke';
        $mail->Password   = 'infopassword123'; // Replace with actual password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Email headers
        $mail->setFrom('info@primecoverins.co.ke', 'Prime Cover Insurance');
        $mail->addAddress('info@primecoverins.co.ke'); // Send to yourself
        $mail->addReplyTo($email, $applicant_name);

        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Submitted';

        // Construct HTML email body
        $mail->Body = "
        <h2>Contact Form Submission</h2>
        <b>Name:</b> $name<br>
        <b>Email:</b> $email<br>
        <b>Phone:</b> $phone<br>
        <b>Subject:</b> $subject<br>
        <b>Message:</b> $message
        
        ";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Proposal submitted successfully!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
}
?>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect all form fields
    $city = $_POST['city'] ?? '';
    $applicant_name = $_POST['applicant_name'] ?? '';
    $next_of_kin = $_POST['next_of_kin'] ?? '';
    $id_number = $_POST['id_number'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact_no = $_POST['contact_no'] ?? '';
    $email = $_POST['email'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $monthly_income = $_POST['monthly_income'] ?? '';
    $plan = $_POST['plan'] ?? '';
    $terms = $_POST['terms'] ?? '';
    $physical_impairment = $_POST['physical_impairment'] ?? '';
    $medical_history = $_POST['medical_history'] ?? '';
    $current_health = $_POST['current_health'] ?? '';

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'mail.primecoverins.co.ke';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@primecoverins.co.ke';
        $mail->Password   = 'infopassword123'; // Replace with actual password
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Email headers
        $mail->setFrom('info@primecoverins.co.ke', 'Prime Cover Insurance');
        $mail->addAddress('info@primecoverins.co.ke'); // Send to yourself

        $mail->isHTML(true);
        $mail->Subject = 'New Policy Proposal Submitted';

        // Construct HTML email body
        $mail->Body = "
        <h2>New Policy Proposal Submission</h2>
        <b>City:</b> $city<br>
        <b>Applicant Name:</b> $applicant_name<br>
        <b>Next of Kin:</b> $next_of_kin<br>
        <b>ID Number:</b> $id_number<br>
        <b>Date of Birth:</b> $dob<br>
        <b>Address:</b> $address<br>
        <b>Contact No:</b> $contact_no<br>
        <b>Email:</b> $email<br>
        <b>Occupation:</b> $occupation<br>
        <b>Monthly Income:</b> $monthly_income<br>
        <b>Plan:</b> $plan<br>
        <b>Terms:</b> $terms<br>
        <b>Physical Impairment:</b> $physical_impairment<br>
        <b>Medical History:</b> $medical_history<br>
        <b>Current Health:</b> $current_health
        ";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Proposal submitted successfully!']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
}
?>

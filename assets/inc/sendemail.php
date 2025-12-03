<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Collect POST data
$applicant_name = $_POST['applicant_name'] ?? '';
$email = $_POST['email'] ?? '';

if(empty($applicant_name) || empty($email)){
    echo json_encode(["status"=>"error","message"=>"Full name and email are required."]);
    exit;
}

// Other fields
$city = $_POST['city'] ?? '';
$next_of_kin = $_POST['next_of_kin'] ?? '';
$id_number = $_POST['id_number'] ?? '';
$dob = $_POST['dob'] ?? '';
$address = $_POST['address'] ?? '';
$contact_no = $_POST['contact_no'] ?? '';
$occupation = $_POST['occupation'] ?? '';
$monthly_income = $_POST['monthly_income'] ?? '';
$plan = $_POST['plan'] ?? '';
$terms = $_POST['terms'] ?? '';
$physical_impairment = $_POST['physical_impairment'] ?? '';
$medical_history = $_POST['medical_history'] ?? '';
$current_health = $_POST['current_health'] ?? '';

// PHPMailer setup
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'mail.primecoverins.co.ke';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@primecoverins.co.ke';
    $mail->Password   = 'infopassword123';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('info@primecoverins.co.ke', 'Prime Cover Insurance');
    $mail->addAddress('info@primecoverins.co.ke'); // receiver

    $mail->isHTML(true);
    $mail->Subject = 'New Policy Proposal';
    $mail->Body    = "
        <h2>Policy Proposal Submission</h2>
        <p><strong>Name:</strong> $applicant_name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>City:</strong> $city</p>
        <p><strong>Next of Kin:</strong> $next_of_kin</p>
        <p><strong>ID No:</strong> $id_number</p>
        <p><strong>DOB:</strong> $dob</p>
        <p><strong>Address:</strong> $address</p>
        <p><strong>Contact:</strong> $contact_no</p>
        <p><strong>Occupation:</strong> $occupation</p>
        <p><strong>Monthly Income:</strong> $monthly_income</p>
        <p><strong>Plan:</strong> $plan</p>
        <p><strong>Terms:</strong> $terms</p>
        <p><strong>Physical Impairment:</strong> $physical_impairment</p>
        <p><strong>Medical History:</strong> $medical_history</p>
        <p><strong>Current Health:</strong> $current_health</p>
    ";

    $mail->send();
    echo json_encode(["status"=>"success","message"=>"Proposal submitted successfully!"]);
} catch (Exception $e) {
    echo json_encode(["status"=>"error","message"=>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}

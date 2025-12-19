<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

/* =========================
   SANITIZE INPUT
========================= */
function clean($value) {
    return htmlspecialchars(trim($value ?? ''));
}

$name   = clean($_POST['name'] ?? '');
$email  = clean($_POST['email'] ?? '');

/* Optional fields (based on tab) */
$property_type = clean($_POST['property_type'] ?? '');
$vehicle_type  = clean($_POST['vehicle_type'] ?? '');
$medical_plan  = clean($_POST['medical_plan'] ?? '');
$life_term     = clean($_POST['life_term'] ?? '');

/* Slider value (hidden input recommended) */
$amount = clean($_POST['amount'] ?? '');

/* =========================
   DETERMINE FORM TYPE
========================= */
$formType = 'General Quote Request';

if ($property_type) $formType = 'Property Insurance Quote';
if ($vehicle_type)  $formType = 'Motor Insurance Quote';
if ($medical_plan)  $formType = 'Medical Insurance Quote';
if ($life_term)     $formType = 'Life Insurance Quote';

/* =========================
   EMAIL BODY
========================= */
$message = "
<h2>{$formType}</h2>
<b>Full Name:</b> {$name}<br>
<b>Email:</b> {$email}<br>
";

if ($property_type) {
    $message .= "<b>Property Type:</b> {$property_type}<br>";
}

if ($vehicle_type) {
    $message .= "<b>Vehicle Type:</b> {$vehicle_type}<br>";
}

if ($medical_plan) {
    $message .= "<b>Medical Plan:</b> {$medical_plan}<br>";
}

if ($life_term) {
    $message .= "<b>Life Cover Term:</b> {$life_term} years<br>";
}

if ($amount) {
    $message .= "<b>Estimated Amount:</b> {$amount}<br>";
}

/* =========================
   SEND EMAIL
========================= */
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'mail.primecoverins.co.ke';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@primecoverins.co.ke';
    $mail->Password   = 'infopassword123';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    $mail->CharSet = 'UTF-8';

    $mail->setFrom('info@primecoverins.co.ke', 'Prime Cover Insurance');
    $mail->addAddress('info@primecoverins.co.ke');
    $mail->addReplyTo($email, $name);

    $mail->isHTML(true);
    $mail->Subject = $formType;
    $mail->Body    = $message;

    $mail->send();

    echo json_encode([
        'status'  => 'success',
        'message' => 'Quote request sent successfully. We will contact you shortly.'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Mailer Error: ' . $mail->ErrorInfo
    ]);
}

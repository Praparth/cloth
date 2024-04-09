<?php
session_start();


// Example email sending logic using PHPMailer
require 'smtp/PHPMailerAutoload.php';

// Get the email from the POST request
$email = isset($_POST['email']) ? $_POST['email'] : '';

// Store the email in a session variable
$_SESSION['email'] = $email;

// Generate a random six-digit OTP
$password = generate_otp();

// Store the OTP in a session variable
$_SESSION['otp'] = $password;

// Your email sending logic
$result = smtp_mailer($email, 'Your OTP for Password Reset', $password); 

// Function to generate a random six-digit OTP
function generate_otp() {
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Function to send email using PHPMailer
function smtp_mailer($to, $subject, $msg){
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'tls';  
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587; 
    $mail->IsHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Username = "notme123177@gmail.com";
    $mail->Password = "usly ajfu wfmf cmjm"; // Replace with your Gmail password
    $mail->SetFrom("email"); // Replace with your email address
    $mail->Subject = $subject;
    $mail->Body = $msg;
    $mail->AddAddress($to);

    // Configure SSL settings
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => false
        )
    );

    // Send email
    if ($mail->Send()) {
        // Email sent successfully
        echo 'Sent';
    } else {
        // Email sending failed
        echo 'Error: ' . $mail->ErrorInfo;
    }
}
?>

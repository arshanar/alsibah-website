
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json');



if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $name    = $_POST["name"];
    $email   = $_POST["email"];
    $message = nl2br($_POST["message"]);
    $phone   = $_POST["phone"];
    $company = $_POST["company"];

    $mail = new PHPMailer(true);

    try {
        // ---------------- SMTP SETTINGS ----------------
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alsibahtechnical@gmail.com'; 
        $mail->Password   = 'awmj gecu dgtw veak';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // ---------------- MAIN EMAIL TO YOU ----------------
        $mail->setFrom('alsibahtechnical@gmail.com', 'New Query');
        $mail->addAddress('alsibahtechnical@gmail.com'); 

        $mail->isHTML(true);
        $mail->Subject = "New Quote Query";

        $mail->Body = "
            <h2>New Quote Query</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Company</strong> $company</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        $mail->send();

        // ---------------- AUTO REPLY TO USER ----------------
        $reply = new PHPMailer(true);
        $reply->isSMTP();
        $reply->Host       = 'smtp.gmail.com';
        $reply->SMTPAuth   = true;
        $reply->Username   = 'alsibahtechnical@gmail.com';
        $reply->Password   = 'awmj gecu dgtw veak';
        $reply->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $reply->Port       = 587;

        $reply->setFrom('alsibahtechnical@gmail.com', 'AlSibah Technical Services');
        $reply->addAddress($email);

        $reply->isHTML(true);
        $reply->Subject = "Thank you for contacting us!";
        $reply->Body = "
            <h3>Hello $name,</h3>
            <p>Thank you for getting in touch with <strong>AlSibah Technical Services</strong>.</p>
            <p>We have received your message and will respond shortly.</p>
            <br>
            <p>Regards,<br><strong>AlSibah Technical Services</strong></p>
        ";

        $reply->send();

        echo json_encode(["success" => true, "message" => "Message sent successfully"]);
        exit();


        } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Failed to send email"]);
        exit();
        }


}
?>




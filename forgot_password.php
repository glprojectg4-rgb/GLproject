<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];


    $stmt = $conn->prepare("SELECT id_users FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+2 hours"));


        $update = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE id_users = ?");
        $update->bind_param("ssi", $token, $expires, $user['id_users']);
        $update->execute();


        $resetLink = "http://localhost/GLProject/reset_password.php?token=$token";


        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'glprojectg4@gmail.com';
            $mail->Password = 'pidk oqgf tmyx miba';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;


            $mail->setFrom('your_email@gmail.com', 'Blood Bank System');
            $mail->addAddress($email);


            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "
                <h3>Hello,</h3>
                <p>You requested a password reset. Click the link below to reset your password:</p>
                <a href='$resetLink'>$resetLink</a>
                <p>This link will expire in 2 hours.</p>
            ";

            $mail->send();
            echo "<script>alert('Reset link sent to your email.'); window.location.href='login.html';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Email not found.'); window.history.back();</script>";
    }
}
?>
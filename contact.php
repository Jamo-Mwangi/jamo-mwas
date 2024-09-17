<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);
    
    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Validate message
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    if (empty($errors)) {
        $to = "mwangi.jamo@outlook.com";
        $subject = "New Contact Form Submission";
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Message:\n$message\n";

        $headers = "From: $name <$email>";

        if (mail($to, $subject, $email_content, $headers, "-f{$email}")) {
            echo "Message sent successfully!";
        } else {
            $mail_config = [
                'SMTP' => 'localhost',
                'smtp_port' => 25,
                'Authenticatio' => 'login',
                'Username' => $email,
                'Password' => 'your_password',
                'From' => $email,
                'FromName' => $name
            ];
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = $mail_config['SMTP'];
            $mail->Port = $mail_config['smtp_port'];
            $mail->SMTPAuth = true;
            $mail->Username = $mail_config['Username'];
            $mail->Password = $mail_config['Password'];
            $mail->setFrom($mail_config['From'], $mail_config['FromName']);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $email_content;
            if (!$mail->send()) {
                echo "Failed to send message!";
            } else {
                echo "Message sent successfully!";
            }
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>
<!--
; For Win32 only.
SMTP = localhost
smtp_port = 25

; For Win32 only.
sendmail_from = you@yourdomain
-->

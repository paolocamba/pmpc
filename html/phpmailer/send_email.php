<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

// Database connection
$host = 'localhost'; // Your MySQL host
$db = 'pmpc'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["send"])) {
    $email = $_POST["email"];

    // Check if the email exists in the credentials database
    $stmt = $conn->prepare("SELECT * FROM member_credentials WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email found, proceed with sending the email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'manusoncristina05@gmail.com';
            $mail->Password = 'nwcmcoskfabppavv'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('manusoncristina05@gmail.com', 'PMPC');
            $mail->addAddress($email); // Use the email variable directly

            $mail->isHTML(true);
            $mail->Subject = $_POST["subject"] ?? 'Password Reset Request';

            // Generate a unique token
            $token = bin2hex(random_bytes(16)); // Generate a random token

            // Set timezone to Manila
            date_default_timezone_set('Asia/Manila');
            
            // Calculate expiration time in Manila and convert to UTC
            $expirationManila = new DateTime('+1 hour');
            $expirationUTC = $expirationManila->setTimezone(new DateTimeZone("Asia/Manila"))-> format("Y-m-d H:i:s");

            // Update database with token and UTC expiration time
            $stmt = $conn->prepare("UPDATE member_credentials SET reset_token = ?, token_expiry = ? WHERE email = ?");
            $stmt->bind_param("sss", $token, $expirationUTC, $email);
            $stmt->execute();

            $local_ip = '192.168.100.9:8080';
            // Include the token in the email body link
            $mail->Body = $_POST["message"] ?? '
            <p>Good day!</p>
            <p>We have received a request to reset your password. You can reset it by clicking this <a href="http://' . $local_ip . '/pmpcv6/pmpc/html/forgot-password.php?token=' . $token . '&email=' . urlencode($email) .'">link</a>.</p>
            <p>Thank you,</p>
                <p>Paschal Multi-Purpose Cooperative</p>
            ';

            // Attempt to send the email
            if ($mail->send()) {
                // If email is sent successfully, show alert
                echo "<script>alert('Password reset link sent to $email'); window.location.href='memblogin.html';</script>";
            } else {
                // Handle the case where the mail is not sent
                echo "<script>alert('Failed to send password reset link. Please try again later.'); window.location.href='memblogin.html';</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href='memblogin.html';</script>";
        }
    } else {
        // Email not found
        echo "<script>alert('The email address you entered is not registered with PMPC. Please use the email you used during registration.'); window.location.href='memblogin.html';</script>";
    }
    $stmt->close();
}

$conn->close();
?>

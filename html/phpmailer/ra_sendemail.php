<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

function generateTemporaryPassword($length = 8) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    // Capture input data
    $lastName = $_POST['last_name'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $birthday = $_POST['birthday'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'pmpc'); // Update with your database credentials

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the query based on whether the middle name is provided or not
    if (!empty($middleName)) {
        // If middle name is provided, use it in the query
        $stmt = $conn->prepare("SELECT MemberID FROM old_members WHERE LastName = ? AND FirstName = ? AND MiddleName = ? AND Birthday = ?");
        $stmt->bind_param("ssss", $lastName, $firstName, $middleName, $birthday);
    } else {
        // If middle name is not provided, exclude it from the query
        $stmt = $conn->prepare("SELECT MemberID FROM old_members WHERE LastName = ? AND FirstName = ? AND Birthday = ?");
        $stmt->bind_param("sss", $lastName, $firstName, $birthday);
    }

    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Member exists, fetch the MemberID
        $stmt->bind_result($memberId);
        $stmt->fetch();

        // Generate the temporary password
        $temporaryPassword = generateTemporaryPassword();
        
        // Hash the generated password
        $hashedPassword = password_hash($temporaryPassword, PASSWORD_DEFAULT);

        // Set password expiration time to ten minutes from now
        $expirationTime = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Insert into account_request table, set IsPasswordUsed to 0
        $insertStmt = $conn->prepare("INSERT INTO account_request (MemberID, Email, Username, GeneratedPassword, RequestDate, PasswordExpiration, IsPasswordUsed) VALUES (?, ?, ?, ?, NOW(), ?, 0)");
        $insertStmt->bind_param("sssss", $memberId, $email, $username, $hashedPassword, $expirationTime);
        
        if ($insertStmt->execute()) {
            // Send email with temporary password
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'manusoncristina05@gmail.com';
            $mail->Password = 'nwcmcoskfabppavv'; // Use App Password here for Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('manusoncristina05@gmail.com', 'PMPC');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Request Account';
            $mail->Body = '
                <p>Good day!</p>
                <p>Your password is: <strong>' . $temporaryPassword . '</strong>. You can update this password in your Account Settings. Please note that it will expire in <strong> 1 hour.</strong></p>
                <p>Thank you,</p>
                <p>Paschal Multi-Purpose Cooperative</p>
            ';

            $mail->send();

            echo "
            <script>
            alert('Email sent successfully with a temporary password.');
            document.location.href = '../memblogin.html';
            </script>";
        } else {
            echo "Error inserting into account_request: " . $conn->error;
        }

        // Close insert statement
        $insertStmt->close();
    } else {
        echo "
        <script>
        alert('No matching records found. Please check your information.');
        document.location.href = '../html/request-account.html';
        </script>";
    }

    // Close statements and connection
    $stmt->close();
    $conn->close();
}


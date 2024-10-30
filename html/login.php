<?php
session_start();

// Database connection setup
$servername = "localhost";
$dbUsername = "root";
$dbPassword = ""; // Update if you have a password
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
        exit();
    }

    // Prepare statement to select the member's hashed password and membership status from member_credentials and member tables
    $stmt = $conn->prepare("
        SELECT 
            mc.MemberID, 
            mc.Password, 
            m.MembershipStatus 
        FROM 
            member_credentials mc 
        JOIN 
            member m ON mc.MemberID = m.MemberID 
        WHERE 
            mc.Email = ?
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists in member_credentials table
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($memberId, $hashedPassword, $membershipStatus);
        $stmt->fetch();

        // Check if membership status is "Active"
        if ($membershipStatus !== "Active") {
            echo "<script>alert('Your membership status is not active. Please contact support.');</script>";
        } else {
            // Verify password
            if (password_verify($password, $hashedPassword)) {
                // Set session variables
                $_SESSION['email'] = $email;
                $_SESSION['MemberID'] = $memberId;

                // Redirect to the member landing page
                header("Location: ../html/member/member-landing.php");
                exit();
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
        }
    } else {
        // Close the statement and check in the account_request table if not found in member_credentials
        $stmt->close();

        $stmt = $conn->prepare("SELECT MemberID, GeneratedPassword, IsPasswordUsed, PasswordExpiration FROM account_request WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if the email exists in account_request table
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($memberId, $hashedGeneratedPassword, $isPasswordUsed, $passwordExpiration);
            $stmt->fetch();

            // Check if the password token has expired
            if (new DateTime() > new DateTime($passwordExpiration)) {
                echo "<script>alert('The password has already expired. Please request a new password.'); document.location.href = '../memblogin.html';</script>";
            } else {
                // Verify password for account_request table
                if (password_verify($password, $hashedGeneratedPassword)) {
                    // Mark password as used
                    $updateStmt = $conn->prepare("UPDATE account_request SET IsPasswordUsed = 1 WHERE MemberID = ?");
                    $updateStmt->bind_param("i", $memberId);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // Sign-in succeeded
                    $_SESSION['email'] = $email;
                    $_SESSION['MemberID'] = $memberId;

                    // Redirect to the member landing page
                    header("Location: ../html/member/member-landing.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid email or password.'); document.location.href = '../memblogin.html';</script>";
                }
            }
        } else {
            echo "<script>alert('Invalid email or password. Email not found in both databases.');</script>";
        }
    }
    $stmt->close();
}

$conn->close();

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
        $stmt->close();

        // Check in account_request table
        $stmt = $conn->prepare("SELECT MemberID, GeneratedPassword, IsPasswordUsed, PasswordExpiration FROM account_request WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($memberId, $hashedGeneratedPassword, $isPasswordUsed, $passwordExpiration);
            $stmt->fetch();

            if (new DateTime() > new DateTime($passwordExpiration)) {
                echo "<script>alert('The password has expired. Please request a new password.'); document.location.href = '../memblogin.html';</script>";
            } else {
                if (password_verify($password, $hashedGeneratedPassword)) {
                    $updateStmt = $conn->prepare("UPDATE account_request SET IsPasswordUsed = 1 WHERE MemberID = ?");
                    $updateStmt->bind_param("i", $memberId);
                    $updateStmt->execute();
                    $updateStmt->close();

                    $_SESSION['email'] = $email;
                    $_SESSION['MemberID'] = $memberId;
                    header("Location: ../html/member/member-landing.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid email or password.');</script>";
                }
            }
        } else {
            $stmt->close();

            // Check in old_members table
            $stmt = $conn->prepare("SELECT MemberID, Password FROM old_members WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($memberId, $oldHashedPassword);
                $stmt->fetch();

                // Verify password for old_members table
                if (password_verify($password, $oldHashedPassword)) {
                    $_SESSION['email'] = $email;
                    $_SESSION['MemberID'] = $memberId;
                    header("Location: ../html/member/member-landing.php");
                    exit();
                } else {
                    echo "<script>alert('Invalid email or password.');</script>";
                }
            } else {
                echo "<script>alert('Invalid email or password. Email not found in any records.');</script>";
            }
        }
    }
    $stmt->close();
}

$conn->close();

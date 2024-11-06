<?php
session_start();

// Database connection setup
$servername = "localhost";
$dbUsername = "root";
$dbPassword = ""; 
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Reset failed attempts after 5 minutes
if (isset($_SESSION['lockout_time']) && time() - $_SESSION['lockout_time'] > 300) {
    unset($_SESSION['failed_attempts']);
    unset($_SESSION['lockout_time']);
}

// Check if the user is locked out
if (isset($_SESSION['lockout_time']) && time() - $_SESSION['lockout_time'] < 300) {
    echo "<script>
            alert('You have been locked out. Please try again after 5 minutes.');
            window.location.href = 'memblogin.html';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Invalid email format.');
                window.location.href = 'memblogin.html';
              </script>";
        exit();
    }

    // First, check in the member_credentials table
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

    // Check if the email exists in member_credentials
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($memberId, $hashedPassword, $membershipStatus);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            // Check if membership status is "Active"
            if ($membershipStatus !== "Active") {
                echo "<script>
                        alert('Your membership status is not active. Please contact support.');
                        window.location.href = 'memblogin.html';
                      </script>";
            } else {
                // Successful login
                $_SESSION['email'] = $email;
                $_SESSION['memberID'] = $memberId;

                // Redirect to the member landing page
                header("Location: ../html/member/member-landing.php");
                exit();
            }
        } else {
            handle_failed_attempt();
        }
    } else {
        // If not found in member_credentials, check in account_request
        $stmt = $conn->prepare("
            SELECT 
                MemberID, 
                GeneratedPassword, 
                IsPasswordUsed, 
                PasswordExpiration 
            FROM 
                account_request 
            WHERE 
                Email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($memberId, $hashedGeneratedPassword, $isPasswordUsed, $passwordExpiration);
            $stmt->fetch();

            // Check if the password has expired
            if (new DateTime() > new DateTime($passwordExpiration)) {
                echo "<script>alert('The password has expired. Please request a new password.'); window.location.href = 'memblogin.html';</script>"; 
            } else {
                // Verify generated password
                if (password_verify($password, $hashedGeneratedPassword)) {
                    // Mark the password as used
                    $updateStmt = $conn->prepare("UPDATE account_request SET IsPasswordUsed = 1 WHERE MemberID = ?");
                    $updateStmt->bind_param("i", $memberId);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // Successful login
                    $_SESSION['email'] = $email;
                    $_SESSION['memberID'] = $memberId;

                    // Redirect to the member landing page
                    header("Location: ../html/member/member-landing.php");
                    exit();
                } else {
                    handle_failed_attempt();
                }
            }
        } else {
            // If not found in either table, handle failed attempt
            handle_failed_attempt();
        }
    }

    $stmt->close();
}

$conn->close();

function handle_failed_attempt() {
    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = 0;
    }
    $_SESSION['failed_attempts']++;

    $remaining_attempts = 3 - $_SESSION['failed_attempts'];

    if ($_SESSION['failed_attempts'] >= 3) {
        $_SESSION['lockout_time'] = time();
        echo "<script>
                alert('Too many failed attempts. You have been locked out for 5 minutes.');
                window.location.href = 'memblogin.html';
              </script>";
    } else {
        echo "<script>
                alert('Invalid email or password. You have $remaining_attempts attempt(s) remaining.');
                window.location.href = 'memblogin.html';
              </script>";
    }
}
?>

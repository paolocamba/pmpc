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

    // Prepare statement to select the member's hashed password and membership status
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

    // Check if the email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($memberId, $hashedPassword, $membershipStatus);
        $stmt->fetch();

        // Debugging output for fetched data
        echo "<script>console.log('Fetched Hashed Password: " . addslashes($hashedPassword) . "');</script>";
        echo "<script>console.log('Entered Password: " . addslashes($password) . "');</script>";

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            echo "<script>console.log('Password verification succeeded.');</script>";

            // Check if membership status is "Active"
            if ($membershipStatus !== "Active") {
                echo "<script>
                        alert('Your membership status is not active. Please contact support.');
                        window.location.href = 'memblogin.html';
                      </script>";
            } else {
                // Set session variables
                $_SESSION['email'] = $email;
                $_SESSION['memberID'] = $memberId;  // Ensure 'memberID' matches other scripts

                // Redirect to the member landing page
                header("Location: ../html/member/member-landing.php");
                exit();
            }
        } else {
            handle_failed_attempt();
        }
    } else {
        handle_failed_attempt();
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

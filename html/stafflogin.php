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
            window.location.href = 'stafflogin.php';
          </script>";
    exit();
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Invalid email format.');
                window.location.href = 'stafflogin.php';
              </script>";
        exit();
    }

    // Prepare statement to select user credentials
    $stmt = $conn->prepare("SELECT staffID, Password, Role FROM staff_credentials WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($staffId, $hashedPassword, $role);
        $stmt->fetch();

        // Verify the password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Successful login
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            $_SESSION['staffID'] = $staffId; // Store staffID in session
            unset($_SESSION['failed_attempts']);
            unset($_SESSION['lockout_time']);

            // Redirect based on role
            switch ($role) {
                case 'Admin':
                    header("Location: ../html/admin/admin.php");
                    break;
                case 'Loan Officer':
                    header("Location: ../html/loan/loanofficer.php");
                    break;
                case 'Membership Officer':
                    header("Location: ../html/membership/membership.php");
                    break;
                case 'Medical Officer':
                    header("Location: ../html/medical/medicalofficer.php");
                    break;
                case 'Liaison Officer':
                    header("Location: ../html/liaison/liaison.php");
                    break;
                default:
                    echo "<script>alert('Unauthorized role.');</script>";
            }
            exit();
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
                window.location.href = 'stafflogin.php';
              </script>";
    } else {
        echo "<script>
                alert('Invalid email or password. You have $remaining_attempts attempt(s) remaining.');
                window.location.href = 'stafflogin.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - PASCHAL COOPERATIVE</title>
    <link rel="stylesheet" href="../css/stafflogin.css">
</head>
<body>
    <div class="login-container">
        <img src="../assets/pmpc-logo.png" alt="PMPC Logo" class="login-logo">
        <h1>PASCHAL COOPERATIVE</h1>
        <p class="welcome-text">Welcome Staff!</p>

        <form method="post" action="stafflogin.php">
            <div class="input-group">
                <input type="text" id="email" name="email" placeholder="Enter email address" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="login-button">Sign-In</button>

            <div class="checkbox-options">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
        </form>

        <div class="additional-links">
            <p>Not a Staff Member? <a href="memblogin.html">Log in as a member</a> instead.</p>
        </div>
    </div>
</body>
</html>

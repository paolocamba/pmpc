<?php
// Start the session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = ""; // Update if you have a password
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user credentials from the database
    $stmt = $conn->prepare("SELECT Password, Role FROM staff_credentials WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashedPassword, $role);
        $stmt->fetch();

        // Verify the password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Successful login
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            // Redirect based on role
            switch ($role) {
                case 'Admin':
                    header("Location: ../html/admin/admin.php");
                    break;
                case 'Loan Officer':
                    header("Location: ../html/loan/loanofficer.html");
                    break;
                case 'Membership Officer':
                    header("Location: ../html/membership/membership.php");
                    break;
                case 'Medical Officer':
                    header("Location: ../html/medical/medicalofficer.html");
                    break;
                case 'Liaison Officer':
                    header("Location: ../html/liaison/liaison.html");
                    break;
                default:
                    echo "<script>alert('Unauthorized role.');</script>";
            }
            exit();
        } else {
            echo "<script>alert('Invalid email or password.');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email.');</script>";
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - PASCHAL COOPERATIVE</title>
    <link rel="stylesheet" href="../css/stafflogin.css"> <!-- Linking the updated staff login CSS -->

</head>
<body>
    <!-- Login Container -->
    <div class="login-container">
        <img src="../assets/pmpc-logo.png" alt="PMPC Logo" class="login-logo"> <!-- Logo -->
        <h1>PASCHAL COOPERATIVE</h1>
        <p class="welcome-text">Welcome Staff!</p>

        <!-- Login Form -->
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

        <!-- Additional Links -->
        <div class="additional-links">
            <p>Not a Staff Member? <a href="signup.html">Create Account</a> instead.</p>
            <p>If already a staff member, <a="#">Request Account Credentials</a>.</p>
        </div>
    </div>
</body>
</html>
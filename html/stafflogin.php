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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username']; // Use 'username' for email
    $password = $_POST['password'];

    // Debugging output
    error_log("Email: $email, Password: $password"); // Log received values

    // Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format. Please try again.');</script>";
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT Role, Password FROM staff_credentials WHERE Email = ?");
    if ($stmt === false) {
        error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        die("Database error, please try again later.");
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($role, $hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables based on role
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role; // Save role to determine redirection

            // Redirect based on role
            switch ($role) {
                case 'Admin':
                    header("Location: ../html/admin/admin.php");
                    break;
                case 'Loan Officer':
                    header("Location: ../html/loan/loanofficer.html");
                    break;
                case 'Membership Officer':
                    header("Location: ../html/membership/membership.html");
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
            echo "<script>alert('Invalid email or password');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

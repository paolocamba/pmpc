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

    // Prepare statement to select the member's hashed password from the database
    $stmt = $conn->prepare("SELECT MemberID, Password FROM member_credentials WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($memberId, $hashedPassword);
        $stmt->fetch();

        // Debugging output for fetched data
        echo "<script>console.log('Fetched Hashed Password: " . addslashes($hashedPassword) . "');</script>";
        echo "<script>console.log('Entered Password: " . addslashes($password) . "');</script>";
        echo "<script>console.log('password_verify Result: " . (password_verify($password, $hashedPassword) ? "True" : "False") . "');</script>";

        // Verify password
        if (password_verify($password, $hashedPassword)) {
            echo "<script>console.log('Password verification succeeded.');</script>";
            
            // Set session variables
            $_SESSION['email'] = $email;
            $_SESSION['member_id'] = $memberId;

            // Redirect to the member landing page
            header("Location: ../html/member/member-landing.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password. Password verification failed.');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password. Email not found in database.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

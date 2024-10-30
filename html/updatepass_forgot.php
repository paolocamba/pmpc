<?php
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

if (isset($_POST['email'], $_POST['token'], $_POST['newPassword'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT); // Hash the new password

    // Check if the token and email match
    $stmt = $conn->prepare("SELECT * FROM member_credentials WHERE email = ? AND reset_token = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, update the password
        $updateStmt = $conn->prepare("UPDATE member_credentials SET password = ?, reset_token = NULL WHERE email = ?");
        $updateStmt->bind_param("ss", $newPassword, $email);
        if ($updateStmt->execute()) {
            echo 'success: Password has been updated.';
        } else {
            echo 'error: Could not update password. Please try again.';
        }
        $updateStmt->close();
    } else {
        echo 'Sorry, you can no longer use this link to change your password because it has already expired."';
    }
    $stmt->close();
} else {
    echo 'error: Required parameters are missing.';
}

$conn->close();


<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "pmpc";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare test data
$newMemberID = 112; // Replace with a valid MemberID that exists in your member table
$username = "testuser";
$email = "test@example.com";
$password = password_hash("testpassword", PASSWORD_DEFAULT);

// Prepare and execute the insert statement
$stmt3 = $conn->prepare('INSERT INTO member_credentials (MemberID, Username, Email, Password) VALUES (?, ?, ?, ?)');
$stmt3->bind_param('isss', $newMemberID, $username, $email, $password);

if ($stmt3->execute()) {
    echo "Insert successful!";
} else {
    echo "Error: " . $stmt3->error;
}

// Close the statement and connection
$stmt3->close();
$conn->close();
?>

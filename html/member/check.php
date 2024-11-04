<?php
// Database connection
$servername = "localhost";
$dbUsername = "root"; // Update if you have a different username
$dbPassword = ""; // Update if you have a password
$dbname = "pmpc"; // Your database name

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare password
$password = '12345678';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Fetch Emails from member table for MemberID 68 to 115
$sql = "SELECT MemberID, Email FROM member WHERE MemberID BETWEEN 68 AND 115";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Prepare insert statement for member_credentials
    $stmt = $conn->prepare("INSERT INTO member_credentials (MemberID, Username, Email, Password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $memberID, $username, $email, $hashedPassword);

    while ($row = $result->fetch_assoc()) {
        $memberID = $row['MemberID'];
        $email = $row['Email'];
        // Use email prefix as username, adjust as necessary
        $username = explode('@', $email)[0];

        // Execute insert statement
        if ($stmt->execute()) {
            echo "New record created successfully for MemberID: $memberID\n";
        } else {
            echo "Error: " . $stmt->error . "\n";
        }
    }

    // Close statement
    $stmt->close();
} else {
    echo "No records found in the member table.\n";
}

// Close connection
$conn->close();
?>

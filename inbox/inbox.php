<?php
// Start the session
session_start();

// Include database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the logged-in user's ID
$recipientID = $_SESSION['user_id']; // Assuming you store the logged-in user ID in the session

// Fetch messages from the inbox
$query = "SELECT * FROM inbox WHERE RecipientID = ? ORDER BY DateSent DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $recipientID);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any messages
if ($result->num_rows > 0) {
    echo "<h1>Inbox</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='message'>";
        echo "<h3>" . htmlspecialchars($row['Subject']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['Message']) . "</p>";
        echo "<p><small>From: User ID " . htmlspecialchars($row['SenderID']) . " | Sent: " . htmlspecialchars($row['DateSent']) . "</small></p>";
        echo "</div><hr>";
    }
} else {
    echo "<h1>Inbox</h1><p>No messages in your inbox.</p>";
}

$stmt->close();
$conn->close();
?>

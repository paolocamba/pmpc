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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipientID = $_POST['recipient'] ?? 0;
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $senderID = $_SESSION['user_id']; // Assuming you store the logged-in user ID in the session

    // Insert the message into the database
    $stmt = $conn->prepare("INSERT INTO inbox (SenderID, RecipientID, Subject, Message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $senderID, $recipientID, $subject, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending message: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

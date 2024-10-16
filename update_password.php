<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pmpc";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select all members' credentials
$sql = "SELECT MemberID, Password FROM member_credentials";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Iterate through each record
    while ($row = $result->fetch_assoc()) {
        $memberId = $row['MemberID'];
        $plainPassword = $row['Password'];

        // Hash the password
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateSql = "UPDATE member_credentials SET Password = ? WHERE MemberID = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $hashedPassword, $memberId);

        // Execute the update statement
        if ($stmt->execute()) {
            echo "Password for Member ID $memberId has been updated successfully.<br>";
        } else {
            echo "Error updating password for Member ID $memberId: " . $stmt->error . "<br>";
        }
    }
} else {
    echo "No records found.";
}

// Select all staffs' credentials
$sql = "SELECT StaffID, Password FROM staff_credentials";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Iterate through each record
    while ($row = $result->fetch_assoc()) {
        $staffId = $row['StaffID'];
        $plainPassword = $row['Password'];

        // Hash the password
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateSql = "UPDATE staff_credentials SET Password = ? WHERE StaffID = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $hashedPassword, $staffId);

        // Execute the update statement
        if ($stmt->execute()) {
            echo "Password for Member ID $staffId has been updated successfully.<br>";
        } else {
            echo "Error updating password for Member ID $staffId: " . $stmt->error . "<br>";
        }
    }
} else {
    echo "No records found.";
}

// Close the connection
$conn->close();
?>

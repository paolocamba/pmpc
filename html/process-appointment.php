<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "pmpc";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $memberID = $_POST['member-id'];  // Pass the member ID from the previous step
    $appointmentDate = $_POST['appointment-date'];

    // Insert appointment data into the appointment table
    $sqlAppointment = "INSERT INTO appointment (member_id, appointment_date) VALUES ('$memberID', '$appointmentDate')";
    if ($conn->query($sqlAppointment) !== TRUE) {
        echo "Error: " . $sqlAppointment . "<br>" . $conn->error;
        exit();
    }

    // Update membershipapplication table (if required, you can modify this section)
    $sqlMembership = "UPDATE membershipapplication SET appointment_date = '$appointmentDate' WHERE member_id = '$memberID'";
    if ($conn->query($sqlMembership) === TRUE) {
        header("Location: sign-up-submit.html"); // Redirect to the next step
        exit();
    } else {
        echo "Error: " . $sqlMembership . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<?php
// Start the session
session_start();

// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

// Check if the user is logged in
if (!isset($_SESSION['staffID'])) {
    header("Location: ../stafflogin.php");
    exit();
}

// Retrieve staffID from session
$staffId = $_SESSION['staffID'];

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

// Get the AppointmentID from the URL
if (isset($_GET['AppointmentID'])) {
    $appointmentID = $_GET['AppointmentID'];

    // Fetch appointment details
    $appointmentQuery = "
        SELECT 
            AppointmentID, 
            LastName, 
            FirstName, 
            AppointmentDate, 
            Description, 
            Email 
        FROM 
            appointments 
        WHERE 
            AppointmentID = ?
    ";
    
    $stmt = $conn->prepare($appointmentQuery);
    $stmt->bind_param("i", $appointmentID);
    $stmt->execute();
    $appointmentResult = $stmt->get_result();
    $appointment = $appointmentResult->fetch_assoc();
} else {
    die("No AppointmentID provided.");
}

// Handle the confirmation or disapproval action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        // Determine the new status based on the action
        $newStatus = ($action === 'confirm') ? 'Approved' : 'Disapproved';

        // Update the appointment status in the database
        $updateQuery = "
            UPDATE appointments 
            SET Status = ? 
            WHERE AppointmentID = ?
        ";
        
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("si", $newStatus, $appointmentID);
        
        if ($stmt->execute()) {
            // Redirect back to the appointments list with a success message
            header("Location: admin-appointments.php?message=Appointment status updated successfully");
            exit();
        } else {
            die("Error updating appointment status: " . $stmt->error);
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Appointment</title>
    <link rel="stylesheet" href="../../css/admin-content.css">
    <link rel="stylesheet" href="../../css/admin-general.css">
    <link rel="stylesheet" href="../../css/admin-view-appointment.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
                </div>
                <h2 class="pmpc-text">PASCHAL</h2>
            </div>

            <ul class="sidebar-menu">
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="admin-members.php">Members</a></li>
                <li><a href="admin-loans.php">Loans</a></li>
                <li><a href="admin-transactions.php">Transactions</a></li>
                <li><a href="admin-appointments.php">Appointments</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>View Appointment</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Appointment Details -->
            <section class="appointment-details">
                <h3>Appointment Information</h3>
                <?php if ($appointment): ?>
                    <p><strong>Appointment ID:</strong> <?php echo htmlspecialchars($appointment['AppointmentID']); ?></p>
                    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($appointment['LastName']); ?></p>
                    <p><strong>First Name:</strong> <?php echo htmlspecialchars($appointment['FirstName']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($appointment['AppointmentDate']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($appointment['Description']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($appointment['Email']); ?></p>
                <?php else: ?>
                    <p>No appointment details found.</p>
                <?php endif; ?>
            </section>

            <!-- Confirmation Actions -->
            <section class="confirmation-actions">
                <h3>Actions</h3>
                <form action="" method="POST">
                    <input type="hidden" name="AppointmentID" value="<?php echo htmlspecialchars($appointmentID); ?>">
                    <button type="submit" name="action" value="confirm">Confirm Appointment</button>
                    <button type="submit" name="action" value="disapprove">Disapprove Appointment</button>
                </form>
            </section>
        </div>
    </div>

</body>
</html>

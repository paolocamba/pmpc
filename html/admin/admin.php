<?php
// Start the session
session_start();

// Include database connection
$servername = "localhost";
$dbUsername = "root"; // Update if you have a different username
$dbPassword = ""; // Update if you have a password
$dbname = "pmpc"; // Your database name

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total members
$totalMembersQuery = "SELECT COUNT(*) as total FROM member";
$totalMembersResult = $conn->query($totalMembersQuery);
$totalMembers = $totalMembersResult->fetch_assoc()['total'];

// Fetch active member applications
$activeMemberApplicationsQuery = "SELECT COUNT(*) as total FROM membership_application WHERE Status = 'Active'";
$activeMemberApplicationsResult = $conn->query($activeMemberApplicationsQuery);
$activeMemberApplications = $activeMemberApplicationsResult->fetch_assoc()['total'];

// Fetch loan applications
$loanApplicationsQuery = "SELECT COUNT(*) as total FROM loanapplication";
$loanApplicationsResult = $conn->query($loanApplicationsQuery);
$loanApplications = $loanApplicationsResult->fetch_assoc()['total'];

// Fetch medical records
$medicalRecordsQuery = "SELECT COUNT(*) as total FROM medical";
$medicalRecordsResult = $conn->query($medicalRecordsQuery);
$medicalRecords = $medicalRecordsResult->fetch_assoc()['total'];

// Fetch account requests
$accountRequestsQuery = "SELECT COUNT(*) as total FROM Account_request";
$accountRequestsResult = $conn->query($accountRequestsQuery);
$accountRequests = $accountRequestsResult->fetch_assoc()['total'];

// Fetch appointments
$appointmentsQuery = "SELECT COUNT(*) as total FROM appointments";
$appointmentsResult = $conn->query($appointmentsQuery);
$appointments = $appointmentsResult->fetch_assoc()['total'];

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin.css"> <!-- Linking CSS -->
    <link rel="stylesheet" href="../../css/admin-general.css">
</head>
<body>
    <!-- Container for the sidebar and main content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
                </div>
                <h2 class="pmpc-text">PASCHAL</h2> <!-- Text beside the logo -->
            </div>

            <ul class="sidebar-menu">
                <li><a href="admin.html" class="active">Dashboard</a></li>
                <li><a href="admin-members.html">Members</a></li>
                <li><a href="admin-loans.html">Loans</a></li>
                <li><a href="admin-transactions.html">Transactions</a></li>
                <li><a href="admin-appointments.html">Appointments</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Admin Panel</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <section class="dashboard-metrics">
                <div class="metric-box">
                    <h3><?php echo $totalMembers; ?></h3>
                    <p>Members</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $activeMemberApplications; ?></h3>
                    <p>Member Application</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $loanApplications; ?></h3>
                    <p>Loan Application</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $medicalRecords; ?></h3>
                    <p>Medical Records</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $accountRequests; ?></h3>
                    <p>Account Request</p>
                </div>
                <div class="metric-box">
                    <h3><?php echo $appointments; ?></h3>
                    <p>Appointments</p>
                </div>
            </section>
        </div>
    </div>

    <script>
        function redirectToIndex() {
            window.location.href = "../../html/index.html";
        }
    </script>
</body>
</html>

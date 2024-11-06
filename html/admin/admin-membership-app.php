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

include('../db_connect.php');

// Fetch total members
$totalMembersQuery = "SELECT COUNT(*) as total FROM member WHERE MembershipStatus = 'Active'";
$totalMembersResult = $conn->query($totalMembersQuery);
if (!$totalMembersResult) {
    die("Query failed: " . $conn->error);
}
$totalMembers = $totalMembersResult->fetch_assoc()['total'];

// Fetch active member applications
$activeMemberApplicationsQuery = "SELECT COUNT(*) as total FROM membership_application WHERE Status = 'In Progress'";
$activeMemberApplicationsResult = $conn->query($activeMemberApplicationsQuery);
if (!$activeMemberApplicationsResult) {
    die("Query failed: " . $conn->error);
}
$activeMemberApplications = $activeMemberApplicationsResult->fetch_assoc()['total'];


// Fetch members list
$membersQuery = "
    SELECT 
        mc.MemberID, 
        sf.LastName, 
        sf.FirstName, 
        sf.MiddleName, 
        sf.ContactNo, 
        mc.Email
    FROM 
        member_credentials mc
    JOIN 
        signupform sf 
    ON 
        mc.MemberID = sf.MemberID
    LIMIT 5
";

$membersResult = $conn->query($membersQuery);


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Members</title>
    <link rel="stylesheet" href="../../css/admin-members.css">
    <link rel="stylesheet" href="../../css/admin-general.css">
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
                <li><a href="admin-members.php" class="active">Members</a></li>
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
                <h1>Membership Application</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Summary Cards -->
            <section class="summary-cards">
                <div class="card" onclick="window.location.href='admin-membership-app.php'">
                    <h2><?php echo $activeMemberApplications; ?></h2>
                    <p>Member Application</p>
                </div>
                <div class="card" onclick="window.location.href='admin-members.php'">
                    <h2><?php echo $totalMembers; ?></h2>
                    <p>Members</p>
                </div>
            </section>

            <!-- Application List Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Member Application</h3>
                    <a href="admin-manage-membership.php" class="manage-link">Manage / View All</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($membersResult->num_rows > 0) {
                            while ($row = $membersResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['MemberID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MiddleName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ContactNo']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No application found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</body>
</html>

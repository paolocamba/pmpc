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
$dbUsername = "root"; // Update if you have a different username
$dbPassword = ""; // Update if you have a password
$dbname = "pmpc"; // Your database name

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
$membersQuery = "SELECT MemberID, LastName, FirstName, MiddleName, ContactNo, Email FROM member LIMIT 5";
$membersResult = $conn->query($membersQuery);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Officer Dashboard</title>
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
                <li><a href="membership.php" class="active">Members</a></li>
                <li><a href="membership-inbox.php" >Inbox</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Members Overview</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Summary Cards -->
            <section class="summary-cards">
            <div class="card" onclick="window.location.href='membership.php'">
            <h2><?php echo $totalMembers; ?></h2>
            <p>Members</p>
        </div>
        <a href="membership-app.php" class="card-link">
            <div class="card">
                <h2><?php echo $activeMemberApplications; ?></h2>
                <p>Member Application</p>
            </div>
        </a>
            </section>


            <!-- Member List Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Member</h3>
                    <a href="manage-members.php" class="manage-link">Manage / View All</a>
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
                            echo "<tr><td colspan='6'>No members found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </div>

    <script>
        function redirectToIndex() {
            window.location.href = "../../html/index.php";
        }
    </script>
</body>
</html>

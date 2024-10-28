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

// Fetch all member applications along with their status
$allMembersQuery = "
    SELECT 
        mc.MemberID, 
        sf.LastName, 
        sf.FirstName, 
        sf.MiddleName, 
        sf.ContactNo, 
        mc.Email,
        ma.Status
    FROM 
        member_credentials mc
    JOIN 
        signupform sf ON mc.MemberID = sf.MemberID
    JOIN 
        membership_application ma ON mc.MemberID = ma.MemberID
";

$allMembersResult = $conn->query($allMembersQuery);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Membership Applications</title>
    <link rel="stylesheet" href="../../css/admin-manage-members.css">
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
                <h1>Manage Membership Applications</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Member List Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Members</h3>
                    <a href="membership.php" class="manage-link">Manage / View All</a>
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
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($allMembersResult->num_rows > 0) {
                            while ($row = $allMembersResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['MemberID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MiddleName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ContactNo']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status']) . "</td>"; // Display the status
                                echo "<td><a href='edit-membership.php?id=" . htmlspecialchars($row['MemberID']) . "'>Edit</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No members found.</td></tr>";
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

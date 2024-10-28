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

// Pagination setup
$limit = 12; // Number of members per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Check if a search query exists
$searchQuery = isset($_GET['search']) ? $_GET['search'] : "";

// Modify the query to handle search
if (!empty($searchQuery)) {
    // If search is performed
    $allMembersQuery = "
        SELECT 
            MemberID, 
            LastName, 
            FirstName, 
            ContactNo, 
            Email, 
            Savings
        FROM 
            member
        WHERE 
            LastName LIKE ? OR
            FirstName LIKE ? OR
            Email LIKE ?
        LIMIT ?, ?
    ";
    $searchTerm = "%" . $searchQuery . "%";
    $stmt = $conn->prepare($allMembersQuery);
    $stmt->bind_param("sssii", $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
} else {
    // If no search is performed
    $allMembersQuery = "
        SELECT 
            MemberID, 
            LastName, 
            FirstName, 
            ContactNo, 
            Email, 
            Savings
        FROM 
            member
        LIMIT ?, ?
    ";
    $stmt = $conn->prepare($allMembersQuery);
    $stmt->bind_param("ii", $offset, $limit);
}

$stmt->execute();
$allMembersResult = $stmt->get_result();

// Count total members for pagination (considering search)
$countQuery = "SELECT COUNT(*) as total FROM member";
if (!empty($searchQuery)) {
    $countQuery .= " WHERE LastName LIKE '%$searchQuery%' OR FirstName LIKE '%$searchQuery%' OR Email LIKE '%$searchQuery%'";
}
$countResult = $conn->query($countQuery);
$totalMembers = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalMembers / $limit);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Members</title>
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
                <h1>Manage Members Information</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Member List Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Members</h3>
                    <!-- Search Form -->
                    <form action="admin-manage-members.php" method="GET">
                        <input type="text" name="search" placeholder="Search by name or email" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Savings</th>
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
                                echo "<td>" . htmlspecialchars($row['ContactNo']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Savings']) . "</td>";
                                echo "<td><a href='admin-edit-member.php?id=" . htmlspecialchars($row['MemberID']) . "'>Edit</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No members found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Pagination Buttons -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>">Previous</a>
                    <?php endif; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($searchQuery); ?>">Next</a>
                    <?php endif; ?>
                </div>
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

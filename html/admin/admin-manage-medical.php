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

// Pagination setup
$limit = 12; // Number of transactions per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Check if a search query exists
$searchQuery = isset($_GET['search']) ? $_GET['search'] : "";

// Modify the query to handle search for medical records
if (!empty($searchQuery)) {
    $transactionsQuery = "
    SELECT 
        m.TransactID, 
        m.MemberID, 
        mem.ContactNo,
        m.Date, 
        s.ServiceName, 
        m.Status,
        mem.LastName, 
        mem.FirstName
    FROM 
        medical m
    JOIN 
        member mem ON m.MemberID = mem.MemberID
    JOIN 
        service s ON m.ServiceID = s.ServiceID
    WHERE 
        mem.LastName LIKE ? OR
        mem.FirstName LIKE ? OR
        m.Status LIKE ?
    LIMIT ?, ?";

    $searchTerm = "%" . $searchQuery . "%";
    $stmt = $conn->prepare($transactionsQuery);
    $stmt->bind_param("ssiii", $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
} else {
    // If no search is performed
    $transactionsQuery = "
    SELECT 
        m.TransactID, 
        m.MemberID, 
        mem.ContactNo,
        m.Date, 
        s.ServiceName, 
        m.Status,
        mem.LastName, 
        mem.FirstName
    FROM 
        medical m
    JOIN 
        member mem ON m.MemberID = mem.MemberID
    JOIN 
        service s ON m.ServiceID = s.ServiceID
    LIMIT ?, ?";

    $stmt = $conn->prepare($transactionsQuery);
    $stmt->bind_param("ii", $offset, $limit);
}

$stmt->execute();
$transactionsResult = $stmt->get_result();

// Count total transactions for pagination (considering search)
$countQuery = "SELECT COUNT(*) as total FROM medical m JOIN member mem ON m.MemberID = mem.MemberID";
if (!empty($searchQuery)) {
    $countQuery .= " WHERE mem.LastName LIKE ? OR mem.FirstName LIKE ? OR m.Status LIKE ?";
}
$countStmt = $conn->prepare($countQuery);
if (!empty($searchQuery)) {
    $countTerm = "%" . $searchQuery . "%";
    $countStmt->bind_param("sss", $countTerm, $countTerm, $countTerm);
}
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalTransactions = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalTransactions / $limit);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Medical Records</title>
    <link rel="stylesheet" href="../../css/admin-manage-trans.css">
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
                <li><a href="admin-members.php">Members</a></li>
                <li><a href="admin-loans.php">Loans</a></li>
                <li><a href="admin-transactions.php" class="active">Transactions</a></li>
                <li><a href="admin-appointments.php">Appointments</a></li>

            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Manage Medical Records</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Medical Records List Table -->
            <section class="transaction-list">
                <div class="table-header">
                    <h3>Medical Records</h3>
                    <!-- Search Form -->
                    <form action="admin-manage-medical.php" method="GET">
                        <input type="text" name="search" placeholder="Search by name or status" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Member ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Phone Number</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($transactionsResult->num_rows > 0) {
                            while ($row = $transactionsResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['TransactID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MemberID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ContactNo']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ServiceName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                echo "<td><a href='admin-edit-medical.php?TransactID=" . htmlspecialchars($row['TransactID']) . "'>Edit</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9'>No medical records found.</td></tr>";
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


</body>
</html>

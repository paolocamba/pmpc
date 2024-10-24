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

// Fetch completed transactions
$completedTransactionsQuery = "SELECT COUNT(*) as total FROM transaction WHERE Status = 'Completed'";
$completedTransactionsResult = $conn->query($completedTransactionsQuery);
if (!$completedTransactionsResult) {
    die("Query failed: " . $conn->error);
}
$completedTransactions = $completedTransactionsResult->fetch_assoc()['total'];

// Fetch in-progress transactions
$inProgressTransactionsQuery = "SELECT COUNT(*) as total FROM transaction WHERE Status = 'In Progress'";
$inProgressTransactionsResult = $conn->query($inProgressTransactionsQuery);
if (!$inProgressTransactionsResult) {
    die("Query failed: " . $conn->error);
}
$inProgressTransactions = $inProgressTransactionsResult->fetch_assoc()['total'];

// Fetch transaction list with member and service details
$transactionsQuery = "
SELECT 
    t.TransactID, 
    t.MemberID, 
    m.LastName, 
    DATE(t.Date) as Date,  -- Extract only the date 
    s.ServiceName, 
    t.Status 
FROM 
    transaction t
JOIN 
    member m 
ON 
    t.MemberID = m.MemberID
JOIN 
    service s
ON 
    t.ServiceID = s.ServiceID
LIMIT 5
";
$transactionsResult = $conn->query($transactionsQuery);

// Fetch medical records from the medical table
$medicalRecordsQuery = "
SELECT 
    m.TransactID AS ID,         -- Use the transaction's ID as the medical record ID
    m.MemberID, 
    mem.LastName, 
    DATE(m.Date) as Date,  -- Extract only the date
    s.ServiceName, 
    m.Status
FROM 
    medical m
JOIN 
    member mem 
ON 
    m.MemberID = mem.MemberID
JOIN 
    service s
ON 
    m.ServiceID = s.ServiceID
LIMIT 5
";
$medicalRecordsResult = $conn->query($medicalRecordsQuery);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Transactions</title>
    <link rel="stylesheet" href="../../css/admin-content.css">
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
                <h1>Transactions</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Summary Cards -->
            <section class="summary-cards">
                <div class="card">
                    <h2><?php echo $completedTransactions; ?></h2>
                    <p>Completed</p>
                </div>
                <div class="card">
                    <h2><?php echo $inProgressTransactions; ?></h2>
                    <p>In Progress</p>
                </div>
            </section>

            <!-- Transaction List Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Transaction</h3>
                    <a href="admin-manage-trans.php" class="manage-link">Manage / View All</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>MemberID</th>
                            <th>Last Name</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Status</th>
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
                                echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ServiceName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No transactions found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <!-- Medical Records Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Medical Records</h3>
                    <a href="admin-manage-medical.php" class="manage-link">Manage / View All</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>MemberID</th>
                            <th>Last Name</th>
                            <th>Date</th>
                            <th>Service</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($medicalRecordsResult->num_rows > 0) {
                            while ($row = $medicalRecordsResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MemberID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ServiceName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No medical records found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
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

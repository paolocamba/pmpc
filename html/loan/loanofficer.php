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

// Fetch completed transactions
$completedTransactionsQuery = "SELECT COUNT(*) as total FROM transaction WHERE Status = 'Completed'";
$completedTransactionsResult = $conn->query($completedTransactionsQuery);
if (!$completedTransactionsResult) {
    die("Query failed: " . $conn->error);
}
$completedTransactions = $completedTransactionsResult->fetch_assoc()['total'];

// Fetch active Loans
$activeLoansQuery = "SELECT COUNT(*) as total FROM loan_admin";
$activeLoansResult = $conn->query($activeLoansQuery); // Fixed line
if (!$activeLoansResult) {
    die("Query failed: " . $conn->error);
}
$activeLoans = $activeLoansResult->fetch_assoc()['total'];

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

// Fetch loan details from loan_admin and member tables
$activeLoansQuery = "
SELECT 
    la.MemberID, 
    m.LastName, 
    m.FirstName, 
    la.TypeOfLoan, 
    la.AmountOfLoan, 
    DATE(la.MaturityDate) as MaturityDate,  -- Extract only the date
    la.AmountPayable
FROM 
    loan_admin la
JOIN 
    member m 
ON 
    la.MemberID = m.MemberID
LIMIT 5
";
$activeLoansResult = $conn->query($activeLoansQuery);


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Officer Dashboard</title>
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
                <li><a href="loanofficer.php" class="active">Loans</a></li>
                <li><a href="loan-inbox.php" >Inbox</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Loans Overview</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Summary Cards -->
            <section class="summary-cards">
                <div class="card">
                    <h2><?php echo $completedTransactions; ?></h2>
                    <p>Loan Application</p>
                </div>
                <div class="card">
                    <h2><?php echo $activeLoans; ?></h2>
                    <p>Active Loans</p>
                </div>
            </section>

            <!-- Transaction List Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Loan Application</h3>
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

            <!-- Active Loans Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Active Loans</h3>
                    <a href="admin-manage-medical.php" class="manage-link">Manage / View All</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Type Of Loan</th>
                            <th>Amount Of Loan</th>
                            <th>Maturity Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($activeLoansResult->num_rows > 0) {
                            while ($row = $activeLoansResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['MemberID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['TypeOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['AmountOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MaturityDate']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No active loans found.</td></tr>";
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

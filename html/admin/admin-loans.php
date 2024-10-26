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

// Pagination variables for Loan Applications
$limit = 7; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
$offset = ($page - 1) * $limit; // Calculate offset

// Fetch total number of pending statuses in loanapplication_status table
$pendingStatusQuery = "SELECT COUNT(*) as total FROM loanapplication_status WHERE Status = 'Pending'";
$pendingStatusResult = $conn->query($pendingStatusQuery);
if (!$pendingStatusResult) {
    die("Query failed: " . $conn->error);
}
$totalPendingStatus = $pendingStatusResult->fetch_assoc()['total'];

// Fetch active loans count for pagination
$activeLoansCountQuery = "SELECT COUNT(*) as total FROM loan_admin";
$activeLoansCountResult = $conn->query($activeLoansCountQuery);
if (!$activeLoansCountResult) {
    die("Query failed: " . $conn->error);
}
$activeLoansCount = $activeLoansCountResult->fetch_assoc()['total'];

// Fetch total loan applications
$totalLoanApplicationsQuery = "SELECT COUNT(*) as total FROM loanapplication";
$totalLoanApplicationsResult = $conn->query($totalLoanApplicationsQuery);
if (!$totalLoanApplicationsResult) {
    die("Query failed: " . $conn->error);
}
$totalLoanApplications = $totalLoanApplicationsResult->fetch_assoc()['total'];

// Fetch loan application records from loanapplication table
$searchLoanAppQuery = isset($_GET['search_loan_app']) ? $_GET['search_loan_app'] : "";

// SQL query for loan applications
$loanApplicationsQuery = "
SELECT 
    la.LoanID, 
    la.MemberID, 
    m.LastName, 
    DATE(la.DateOfLoan) AS DateOfLoan, 
    la.AmountRequested AS AmountOfLoan, 
    la.LoanType AS TypeOfLoan,
    las.Status AS LoanStatus  
FROM 
    loanapplication la
JOIN 
    member m ON la.MemberID = m.MemberID
JOIN 
    loanapplication_status las ON la.LoanID = las.LoanID  
WHERE 
    m.LastName LIKE ? OR
    la.MemberID LIKE ?
LIMIT ?, ?";

$stmtLoanApplications = $conn->prepare($loanApplicationsQuery);
$searchTermLoanApp = "%{$searchLoanAppQuery}%";
$stmtLoanApplications->bind_param("ssii", $searchTermLoanApp, $searchTermLoanApp, $offset, $limit);
$stmtLoanApplications->execute();
$loanApplicationsResult = $stmtLoanApplications->get_result();

// Fetch active loans with pagination
$searchActiveLoansQuery = isset($_GET['search_active_loans']) ? $_GET['search_active_loans'] : "";
$activeLoansQuery = "
SELECT 
    la.MemberID, 
    m.LastName, 
    m.FirstName, 
    la.TypeOfLoan, 
    la.AmountOfLoan, 
    DATE(la.MaturityDate) as MaturityDate 
FROM 
    loan_admin la
JOIN 
    member m ON la.MemberID = m.MemberID
WHERE 
    m.LastName LIKE ? OR
    la.MemberID LIKE ?
LIMIT ?, ?";

$stmtActiveLoans = $conn->prepare($activeLoansQuery);
$searchTermActiveLoans = "%{$searchActiveLoansQuery}%";
$stmtActiveLoans->bind_param("ssii", $searchTermActiveLoans, $searchTermActiveLoans, $offset, $limit);
$stmtActiveLoans->execute();
$activeLoansResult = $stmtActiveLoans->get_result();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Loans</title>
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
                <li><a href="admin-loans.php" class="active">Loans</a></li>
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
                <h1>Loans Overview</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Summary Cards -->
            <section class="summary-cards">
                <div class="card">
                    <h2><?php echo $totalLoanApplications; ?></h2>
                    <p>Total Loan Applications</p>
                </div>
                <div class="card">
                    <h2><?php echo $activeLoansCount; ?></h2>
                    <p>Active Loans</p>
                </div>
                <div class="card">
                    <h2><?php echo $totalPendingStatus; ?></h2>
                    <p>Pending Loan Applications</p>
                </div>
            </section>

            <!-- Loan Applications Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Loan Applications</h3>
                    <form action="admin-loans.php" method="GET">
                        <input type="text" name="search_loan_app" placeholder="Search by Member ID or Last Name" value="<?php echo htmlspecialchars($searchLoanAppQuery); ?>">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>Last Name</th>
                            <th>Date Of Loan</th>
                            <th>Type Of Loan</th>
                            <th>Amount Of Loan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($loanApplicationsResult->num_rows > 0) {
                            while ($row = $loanApplicationsResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['MemberID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['DateOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['TypeOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['AmountOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LoanStatus']) . "</td>";
                                echo "<td><a href='view_loan_application.php?id=" . htmlspecialchars($row['LoanID']) . "' class='view-button'>View</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No loan applications found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Pagination for Loan Applications -->
                <div class="pagination">
                    <?php
                    $totalPages = ceil($totalLoanApplications / $limit);
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<a href="admin-loans.php?page=' . $i . '&search_loan_app=' . urlencode($searchLoanAppQuery) . '">' . $i . '</a> ';
                    }
                    ?>
                </div>
            </section>

            <!-- Active Loans Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Active Loans</h3>
                    <form action="admin-loans.php" method="GET">
                        <input type="text" name="search_active_loans" placeholder="Search by Member ID or Last Name" value="<?php echo htmlspecialchars($searchActiveLoansQuery); ?>">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
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
                                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['TypeOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['AmountOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MaturityDate']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No active loans found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Pagination for Active Loans -->
                <div class="pagination">
                    <?php
                    $totalPagesActiveLoans = ceil($activeLoansCount / $limit);
                    for ($i = 1; $i <= $totalPagesActiveLoans; $i++) {
                        echo '<a href="admin-loans.php?page=' . $i . '&search_active_loans=' . urlencode($searchActiveLoansQuery) . '">' . $i . '</a> ';
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>

    <script>
        function redirectToIndex() {
            window.location.href = '../index.php';
        }
    </script>
</body>
</html>

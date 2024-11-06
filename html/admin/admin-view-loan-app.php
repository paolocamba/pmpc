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
                <h1>View Loan Application</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>


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
                                echo "<td><a href='admin-view-loan-app.php?id=" . htmlspecialchars($row['LoanID']) . "' class='view-button'>View</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No loan applications found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>



        </div>
    </div>


</body>
</html>

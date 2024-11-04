<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard Page</title>
    <link rel="stylesheet" href="../../css/member-dashboard.css">
    <link rel="stylesheet" href="../../css/member-general.css">
    

   
</head>
<body>

<?php
// Start the session and regenerate ID for security
session_start();
session_regenerate_id(true);

// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

// Check if the user is logged in
if (!isset($_SESSION['memberID'])) {
    header("Location: ../memblogin.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pmpc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve MemberID from session
$member_id = $_SESSION['memberID'];

// Fetch savings balance
$savings_balance = 0;
$savings_query = "SELECT Savings FROM member WHERE MemberID = ?";
$stmt = $conn->prepare($savings_query);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$stmt->bind_result($savings_balance);
$stmt->fetch();
$stmt->close();

// Fetch loan application status and eligibility
$loan_application_status = "N/A";
$loan_eligibility = "N/A";
$loan_app_query = "
    SELECT las.Eligibility, las.Status 
    FROM loanapplication_status las 
    JOIN loan_admin la ON las.LoanID = la.LoanID 
    WHERE la.MemberID = ?";
$stmt = $conn->prepare($loan_app_query);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$stmt->bind_result($loan_eligibility, $loan_application_status);
$stmt->fetch();
$stmt->close();

// Fetch active services
$active_services = [];
$services_query = "
    SELECT s.ServiceName 
    FROM service s 
    JOIN transaction t ON s.ServiceID = t.ServiceID 
    WHERE t.MemberID = ? AND t.Status = 'In Progress'";
$stmt = $conn->prepare($services_query);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $active_services[] = htmlspecialchars($row['ServiceName'], ENT_QUOTES, 'UTF-8');
}
$stmt->close();

// Fetch transaction history (merged with medical)
$transaction_history = [];
$transactions_query = "
    SELECT t.TransactID, s.ServiceName, t.Date, t.Amount, t.Status 
    FROM transaction t 
    JOIN service s ON t.ServiceID = s.ServiceID 
    WHERE t.MemberID = ?
    UNION
    SELECT m.TransactID, s.ServiceName, m.Date, m.Amount, m.Status 
    FROM medical m 
    JOIN service s ON m.ServiceID = s.ServiceID 
    WHERE m.MemberID = ?";
$stmt = $conn->prepare($transactions_query);
$stmt->bind_param("ii", $member_id, $member_id);
$stmt->execute();
$transactions_result = $stmt->get_result();
while ($row = $transactions_result->fetch_assoc()) {
    $transaction_history[] = $row;
}
$stmt->close();

// Fetch loan status from loan_admin
$loan_status_list = [];
$loan_status_query = "
    SELECT LoanID, AmountOfLoan, TypeOfLoan, Term, MaturityDate, AmountPayable, LoanStatus 
    FROM loan_admin 
    WHERE MemberID = ?";
$stmt = $conn->prepare($loan_status_query);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$loan_status_result = $stmt->get_result();
while ($row = $loan_status_result->fetch_assoc()) {
    $loan_status_list[] = $row;
}
$stmt->close();

// Close connection
$conn->close();
?>

<div class="container">
    <div class="sidebar">
        <div class="logo-container">
            <div class="logo">
                <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
            </div>
            <h2 class="pmpc-text">PASCHAL</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="member-landing.php">Home</a></li>
            <li><a href="member-dashboard.php" class="active">Dashboard</a></li>
            <li><a href="member-services.php">Services</a></li>
            <li><a href="member-inbox.php">Inbox</a></li>
            <li><a href="member-about.html">About</a></li>
        </ul>
        <ul class="sidebar-settings">
            <li><a href="member-settings.php">Settings</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Dashboard</h1>
            <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
        </header>

        <!-- Summary Cards Section -->
        <section class="summary-cards">
            <div class="summary-card">
                <h3>Savings Balance</h3>
                <p><?php echo number_format($savings_balance, 2); ?> PHP</p>
            </div>
            <div class="summary-card">
                <h3>Active Services</h3>
                <ul>
                    <?php if (!empty($active_services)): ?>
                        <?php foreach ($active_services as $service): ?>
                            <li><?php echo $service; ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No active services.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="summary-card">
                <h3>Loan Application Status</h3>
                <p>Eligibility: <?php echo htmlspecialchars($loan_eligibility); ?></p>
                <p>Status: <?php echo htmlspecialchars($loan_application_status); ?></p>
            </div>
        </section>

        <!-- Transaction History Table -->
        <section class="full-width-table">
            <h3>Transaction History</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transaction_history)): ?>
                        <?php foreach ($transaction_history as $transaction): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($transaction['TransactID']); ?></td>
                                <td><?php echo htmlspecialchars($transaction['ServiceName']); ?></td>
                                <td><?php echo date('m/d/Y', strtotime($transaction['Date'])); ?></td>
                                <td><?php echo number_format($transaction['Amount'], 2); ?> PHP</td>
                                <td><?php echo htmlspecialchars($transaction['Status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <!-- Loan Status Table -->
        <section class="full-width-table">
            <h3>Loan Status</h3>
            <table>
                <thead>
                    <tr>
                        <th>Loan ID</th>
                        <th>Amount of Loan</th>
                        <th>Type of Loan</th>
                        <th>Term</th>
                        <th>Maturity Date</th>
                        <th>Amount Payable</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($loan_status_list)): ?>
                        <?php foreach ($loan_status_list as $loan): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($loan['LoanID']); ?></td>
                                <td><?php echo number_format($loan['AmountOfLoan'], 2); ?> PHP</td>
                                <td><?php echo htmlspecialchars($loan['TypeOfLoan']); ?></td>
                                <td><?php echo htmlspecialchars($loan['Term']); ?></td>
                                <td><?php echo date('m/d/Y', strtotime($loan['MaturityDate'])); ?></td>
                                <td><?php echo number_format($loan['AmountPayable'], 2); ?> PHP</td>
                                <td><?php echo htmlspecialchars($loan['LoanStatus']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No loan records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</div>

</body>
</html>

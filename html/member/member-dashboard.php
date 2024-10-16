<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard Page</title>
    <link rel="stylesheet" href="../../css/member-dashboard.css"> <!-- Linking CSS -->
    <link rel="stylesheet" href="../../css/member-general.css">
</head>
<body>

    <?php
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['member_id'])) {
        header("Location: ../../html/index.html"); // Redirect to login if not logged in
        exit();
    }

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pmpc";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve MemberID from session
    $member_id = $_SESSION['member_id'];

    // Fetch savings balance
    $savings_query = "SELECT Savings FROM member WHERE MemberID = ?";
    $stmt = $conn->prepare($savings_query);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->bind_result($savings_balance);
    $stmt->fetch();
    $stmt->close();

    // Fetch loan status
    $loan_query = "SELECT LoanStatus FROM loan_admin WHERE MemberID = ?";
    $stmt = $conn->prepare($loan_query);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->bind_result($loan_status);
    $stmt->fetch();
    $stmt->close();

    // Fetch active services (In Progress)
    $services_query = "
    SELECT s.ServiceName 
    FROM service s 
    JOIN transaction t ON s.ServiceID = t.ServiceID 
    WHERE t.MemberID = ? AND t.Status = 'In Progress'";
    $stmt = $conn->prepare($services_query);

    // Check if the statement was prepared correctly
    if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
    }

    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $active_services = [];
    while ($row = $result->fetch_assoc()) {
    // Sanitize output to prevent XSS
    $active_services[] = htmlspecialchars($row['ServiceName'], ENT_QUOTES, 'UTF-8');
    }

    $stmt->close();



    // Fetch transaction history
    $transactions_query = "
        SELECT t.TransactID, s.ServiceName, t.Date, t.Amount, t.Status 
        FROM transaction t 
        JOIN service s ON t.ServiceID = s.ServiceID 
        WHERE t.MemberID = ?";
    $stmt = $conn->prepare($transactions_query);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $transactions_result = $stmt->get_result();
    $transaction_history = [];
    while ($row = $transactions_result->fetch_assoc()) {
        $transaction_history[] = $row;
    }
    $stmt->close();

    // Close connection
    $conn->close();
    ?>

    <!-- Container for the sidebar and main content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
                </div>
                <h2 class="pmpc-text">PASCHAL</h2> <!-- PMPC text beside the logo -->
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="member-landing.php">Home</a></li>
                <li><a href="member-dashboard.php" class="active">Dashboard</a></li>
                <li><a href="member-services.html">Services</a></li>
                <li><a href="member-inbox.html">Inbox</a></li>
                <li><a href="member-about.html">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="#settings">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Dashboard</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Dashboard Information -->
            <section class="dashboard-info">
                <div class="dashboard-card">
                    <h3>Savings Balance</h3>
                    <p><?php echo number_format($savings_balance, 2); ?> PHP</p>
                </div>
                <div class="dashboard-card">
                    <h3>Loan Status</h3>
                    <p class="status <?php echo strtolower(str_replace(' ', '-', $loan_status)); ?>">Status: <?php echo htmlspecialchars($loan_status); ?></p>
                </div>
            </section>

            <section class="dashboard-services">
                <div class="active-services">
                    <h3>Active Services</h3>
                    <ul>
                        <?php if (!empty($active_services)): ?>
                            <?php foreach ($active_services as $service): ?>
                                <li><?php echo htmlspecialchars($service); ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No active services.</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="health-records">
                    <h3>Health Records</h3>
                    <p>No records available</p>
                </div>
            </section>

            <section class="transaction-history">
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
                <button onclick="viewMoreTransactions()">View More</button>
            </section>
        </div>
    </div>

    <script>
        function redirectToIndex() {
            window.location.href = "../../html/index.html"; // Redirect to login page
        }

        function viewMoreTransactions() {
            alert("Feature not implemented yet!"); // Placeholder for future feature
        }
    </script>

</body>
</html>

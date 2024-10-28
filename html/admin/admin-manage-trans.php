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
    $limit = 12; // Number of transactions per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Check if a search query exists
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : "";

    // Modify the query to handle search
    if (!empty($searchQuery)) {
        $transactionsQuery = "
        SELECT 
            t.TransactID, 
            t.MemberID, 
            m.LastName, 
            m.FirstName,
            m.ContactNo,
            DATE(t.Date) as Date,  -- Extract only the date 
            s.ServiceName, 
            t.Status 
        FROM 
            transaction t
        JOIN 
            member m ON t.MemberID = m.MemberID
        JOIN 
            service s ON t.ServiceID = s.ServiceID
        WHERE 
            m.LastName LIKE ? OR
            m.FirstName LIKE ? OR
            t.Status LIKE ?
        LIMIT ?, ?";

        $searchTerm = "%" . $searchQuery . "%";
        $stmt = $conn->prepare($transactionsQuery);
        $stmt->bind_param("ssiii", $searchTerm, $searchTerm, $searchTerm, $offset, $limit);
    } else {
        // If no search is performed
        $transactionsQuery = "
        SELECT 
            t.TransactID, 
            t.MemberID, 
            m.LastName, 
            m.FirstName,
            m.ContactNo,
            DATE(t.Date) as Date,  -- Extract only the date
            s.ServiceName, 
            t.Status 
        FROM 
            transaction t
        JOIN 
            member m ON t.MemberID = m.MemberID
        JOIN 
            service s ON t.ServiceID = s.ServiceID
        LIMIT ?, ?";

        $stmt = $conn->prepare($transactionsQuery);
        $stmt->bind_param("ii", $offset, $limit);
    }

    $stmt->execute();
    $transactionsResult = $stmt->get_result();

    // Count total transactions for pagination (considering search)
    $countQuery = "SELECT COUNT(*) as total FROM transaction t JOIN member m ON t.MemberID = m.MemberID";
    if (!empty($searchQuery)) {
        $countQuery .= " WHERE m.LastName LIKE ? OR m.FirstName LIKE ? OR t.Status LIKE ?";
    }
    $countStmt = $conn->prepare($countQuery);
    if (!empty($searchQuery)) {
        $countTerm = "%" . $searchQuery . "%";
        $countStmt->bind_param("sss", $countTerm, $countTerm, $countTerm);
    } else {
        // No need to bind parameters if there is no search filter for count query
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
        <title>Admin Dashboard - Transactions</title>
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
                    <h1>Manage Transactions</h1>
                    <button class="logout-button" onclick="redirectToIndex()">Log out</button>
                </header>

                <!-- Transaction List Table -->
                <section class="transaction-list">
                    <div class="table-header">
                        <h3>Transactions</h3>
                        <!-- Search Form -->
                        <form action="admin-manage-trans.php" method="GET">
                            <input type="text" name="search" placeholder="Search by name or status" value="<?php echo htmlspecialchars($searchQuery); ?>">
                            <button type="submit">Search</button>
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Member ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Phone Number</th>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Actions</th>
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
                                            echo "<td><a href='admin-edit-transaction.php?TransactID=" . htmlspecialchars($row['TransactID']) . "'>Edit</a></td>"; // Edit link

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9'>No transactions found.</td></tr>";
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

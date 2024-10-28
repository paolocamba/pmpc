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

// Get the TransactID from URL
$transactID = $_GET['TransactID'] ?? null;

if ($transactID) {
    // Fetch transaction and member data from the medical table
    $query = "
    SELECT 
        m.TransactID,
        m.MemberID,
        mem.LastName,
        mem.FirstName,
        mem.ContactNo,
        mc.Email,
        m.ServiceID,
        s.ServiceName,
        m.Date,
        t.Amount,
        m.Status
    FROM 
        medical m
    JOIN 
        member mem ON m.MemberID = mem.MemberID
    JOIN 
        member_credentials mc ON mc.MemberID = mem.MemberID
    JOIN 
        service s ON m.ServiceID = s.ServiceID
    LEFT JOIN 
        transaction t ON t.TransactID = m.TransactID  -- Use LEFT JOIN to avoid missing records
    WHERE 
        m.TransactID = ?";

    // Log the TransactID being searched
    error_log("Searching for TransactID: " . $transactID);

    $stmt = $conn->prepare($query);
    
    // Check for preparation error
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        echo "Error preparing statement.";
        exit();
    }

    $stmt->bind_param("i", $transactID);
    
    // Execute the statement
    if (!$stmt->execute()) {
        error_log("Execution failed: " . $stmt->error);
        echo "Execution error.";
        exit();
    }

    $result = $stmt->get_result();
    $transactionData = $result->fetch_assoc();

    // Check if any data was fetched
    if (!$transactionData) {
        echo "No transaction found with the given TransactID.";
        error_log("No transaction data found for TransactID: " . $transactID);
    }
}

// Update the transaction details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serviceID = $_POST['serviceID'] ?? 0; // Selected service ID
    $date = $_POST['date'] ?? ''; // Transaction date
    $amount = $_POST['amount'] ?? 0; // Transaction amount
    $status = $_POST['status'] ?? 'In Progress'; // Default status is 'In Progress'

    // Update transaction in the medical table
    $updateQuery = "
        UPDATE medical 
        SET ServiceID = ?, Date = ?, Amount = ?, Status = ?
        WHERE TransactID = ?";
    
    $updateStmt = $conn->prepare($updateQuery);
    
    // Check for preparation error
    if (!$updateStmt) {
        error_log("Prepare failed: " . $conn->error);
        echo "Error preparing update statement.";
        exit();
    }

    $updateStmt->bind_param("isssi", $serviceID, $date, $amount, $status, $transactID);
    
    if ($updateStmt->execute()) {
        echo "Transaction updated successfully!";
    } else {
        echo "Error updating transaction: " . $updateStmt->error;
    }
}

// Handle delete request
if (isset($_POST['delete'])) {
    $deleteQuery = "DELETE FROM medical WHERE TransactID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    
    // Check for preparation error
    if (!$deleteStmt) {
        error_log("Prepare failed: " . $conn->error);
        echo "Error preparing delete statement.";
        exit();
    }

    $deleteStmt->bind_param("i", $transactID);
    
    if ($deleteStmt->execute()) {
        echo "Transaction deleted successfully!";
        header("Location: admin-transactions.php");
        exit();
    } else {
        echo "Error deleting transaction: " . $deleteStmt->error;
    }
}

// Fetch services for dropdown, limiting to IDs 4, 5, 6, 7, and 8
$servicesQuery = "SELECT ServiceID, ServiceName FROM service WHERE ServiceID IN (4, 5, 6, 7, 8)";
$servicesResult = $conn->query($servicesQuery);

// Close the database connection
$conn->close();

// Format the date for the date input
$dateValue = new DateTime($transactionData['Date']);
$formattedDate = $dateValue->format('Y-m-d');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="../../css/admin-edit-membership.css">
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
        </div>

        <div class="main-content">
            <header>
                <h1>Edit Record</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Transaction Form -->
            <form method="POST" action="">
                <div class="member-details">
                    <h3>Transaction ID: <?php echo htmlspecialchars($transactionData['TransactID']); ?></h3>
                    <p>Member ID: <?php echo htmlspecialchars($transactionData['MemberID']); ?></p>
                    <p>Member: <?php echo htmlspecialchars($transactionData['FirstName'] . ' ' . $transactionData['LastName']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($transactionData['Email']); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($transactionData['ContactNo']); ?></p>
                </div>

                <div class="application-details">
                    <h4>Medical Transaction Details</h4>
                    <label>
                        Service: 
                        <select name="serviceID" required>
                            <?php while ($service = $servicesResult->fetch_assoc()): ?>
                                <option value="<?php echo $service['ServiceID']; ?>" <?php echo $service['ServiceID'] == $transactionData['ServiceID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($service['ServiceName']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </label>
                    <br>
                    <label>
                        Date: 
                        <input type="date" name="date" value="<?php echo htmlspecialchars($formattedDate); ?>" required>
                    </label>
                    <br>
                    <label>
                        Amount: 
                        <input type="number" name="amount" value="<?php echo htmlspecialchars($transactionData['Amount']); ?>" required>
                    </label>
                    <br>
                    <label>
                        Status: 
                        <select name="status" required>
                            <option value="In Progress" <?php echo $transactionData['Status'] === 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                            <option value="Completed" <?php echo $transactionData['Status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </label>
                </div>

                <div class="button-container">
                    <button type="submit" class="action-button">Update Transaction</button>
                    <button type="button" class="action-button delete-button" onclick="confirmDelete()">Delete Transaction</button>
                </div>
            </form>

            <!-- Hidden delete form to be submitted on confirmation -->
            <form method="POST" id="deleteForm" style="display: none;">
                <input type="hidden" name="delete" value="1">
            </form>
        </div>
    </div>

    <script>
        function confirmDelete() {
            const confirmDelete = window.confirm("Are you sure you want to delete this transaction?");
            if (confirmDelete) {
                document.getElementById('deleteForm').submit();
            }
        }

        function redirectToIndex() {
            window.location.href = "../../html/index.php";
        }
    </script>
</body>
</html>

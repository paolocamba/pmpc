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
    // Fetch transaction and member data
    $query = "
        SELECT 
            t.TransactID,
            t.MemberID,
            m.LastName,
            m.FirstName,
            m.ContactNo,
            mc.Email,
            t.ServiceID,
            s.ServiceName,
            t.Date,
            t.Amount,
            t.Status
        FROM 
            transaction t
        JOIN 
            member m ON t.MemberID = m.MemberID
        JOIN 
            member_credentials mc ON mc.MemberID = m.MemberID
        JOIN 
            service s ON t.ServiceID = s.ServiceID
        WHERE 
            t.TransactID = ?
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $transactID);
    $stmt->execute();
    $result = $stmt->get_result();
    $transactionData = $result->fetch_assoc();
}

// Update the transaction details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serviceID = $_POST['serviceID'] ?? 0; // Selected service ID
    $date = $_POST['date'] ?? ''; // Transaction date
    $amount = $_POST['amount'] ?? 0; // Transaction amount
    $status = $_POST['status'] ?? 'InProgress'; // Default status is 'InProgress'

    // Update transaction in the database
    $updateQuery = "
        UPDATE transaction 
        SET ServiceID = ?, Date = ?, Amount = ?, Status = ?
        WHERE TransactID = ?
    ";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("isssi", $serviceID, $date, $amount, $status, $transactID);
    
    if ($updateStmt->execute()) {
        echo "Transaction updated successfully!";
    } else {
        echo "Error updating transaction: " . $conn->error;
    }
}

// Handle delete request
if (isset($_POST['delete'])) {
    $deleteQuery = "DELETE FROM transaction WHERE TransactID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $transactID);
    
    if ($deleteStmt->execute()) {
        echo "Transaction deleted successfully!";
        header("Location: admin-transactions.php");
        exit();
    } else {
        echo "Error deleting transaction: " . $conn->error;
    }
}

// Fetch services for dropdown, excluding IDs 4, 5, 6, 7, and 8
$servicesQuery = "SELECT ServiceID, ServiceName FROM service WHERE ServiceID NOT IN (4, 5, 6, 7, 8)";
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
    <title>Edit Transaction</title>
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
                <h1>Edit Transaction</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
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
                    <h4>Transaction Details</h4>
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

    </script>
</body>
</html>

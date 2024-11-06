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

// Fetch total number of collaterals
$totalCollateralQuery = "SELECT COUNT(*) as total FROM collateral_info";
$totalCollateralResult = $conn->query($totalCollateralQuery);
$totalCollateral = $totalCollateralResult->fetch_assoc()['total'];

// Set pagination variables
$limit = 10; // Number of rows per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch collateral data with JOINs
$query = "SELECT ci.LoanID, la.MemberID, la.DateOfLoan, 
                 m.LastName, m.FirstName, 
                 ci.square_meters 
          FROM collateral_info ci
          JOIN loanapplication la ON ci.LoanID = la.LoanID
          JOIN member m ON la.MemberID = m.MemberID
          LIMIT ?, ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$collateralResult = $stmt->get_result();

// Get the total number of pages
$totalPages = ceil($totalCollateral / $limit);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liaison Dashboard</title>
    <link rel="stylesheet" href="../../css/admin-general.css">
    <link rel="stylesheet" href="../../css/admin-content.css">
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
                <li><a class="active">Dashboard</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>View Collateral</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <section class="summary-cards">
                <a href="liaison.php" class="card-link">
                    <div class="card">
                        <h2><?php echo $totalCollateral; ?></h2>
                        <p>Collateral</p>
                    </div>
                </a>
            </section>

            <section class="member-list">
                <div class="table-header">
                    <h3>Collateral List</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>LoanID</th>
                            <th>MemberID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Date of Loan</th>
                            <th>Square Meters</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($collateralResult->num_rows > 0) {
                            while ($row = $collateralResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['LoanID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['MemberID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['DateOfLoan']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['square_meters']) . "</td>";
                                echo "<td><a href='collateral-assessment.php?LoanID=" . htmlspecialchars($row['LoanID']) . "'>View</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No collateral found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </section>
        </div>
    </div>
</body>
</html>

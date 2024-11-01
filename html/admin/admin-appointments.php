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

// Fetch total number of appointments
$completedAppointmentsQuery = "SELECT COUNT(*) as total FROM appointments";
$completedAppointmentsResult = $conn->query($completedAppointmentsQuery);
if (!$completedAppointmentsResult) {
    die("Query failed: " . $conn->error);
}
$completedAppointments = $completedAppointmentsResult->fetch_assoc()['total'];

// Pagination setup
$limit = 5; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Calculate total pages
$totalPages = ceil($completedAppointments / $limit);

// Fetch appointment list with member details
$searchQuery = isset($_GET['search']) ? $_GET['search'] : "";

// Modify the query to handle search, including Status, with pagination
$appointmentsQuery = "
    SELECT 
        AppointmentID, 
        LastName, 
        FirstName, 
        AppointmentDate, 
        Description, 
        Email,
        Status
    FROM 
        appointments
    WHERE 
        LastName LIKE ? OR
        FirstName LIKE ? OR
        AppointmentDate LIKE ? OR
        Description LIKE ? OR
        Email LIKE ?
    LIMIT ?, ?
";
$stmt = $conn->prepare($appointmentsQuery);
$searchTerm = "%{$searchQuery}%";
$stmt->bind_param("sssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $start, $limit);
$stmt->execute();
$appointmentsResult = $stmt->get_result();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Appointments</title>
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
                <li><a href="admin-transactions.php">Transactions</a></li>
                <li><a href="admin-appointments.php" class="active">Appointments</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Appointments</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <!-- Summary Cards -->
            <section class="summary-cards">
                <div class="card">
                    <h2><?php echo $completedAppointments; ?></h2>
                    <p>Total Appointments</p>
                </div>
            </section>

            <!-- Appointment List Table -->
            <section class="member-list">
                <div class="table-header">
                    <h3>Appointment List</h3>
                    <!-- Search Form -->
                    <form action="admin-appointments.php" method="GET">
                        <input type="text" name="search" placeholder="Search by name, date, description, or email" value="<?php echo htmlspecialchars($searchQuery); ?>">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($appointmentsResult->num_rows > 0) {
                            while ($row = $appointmentsResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['AppointmentID']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['AppointmentDate']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Description']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                echo "<td><a href='admin-view-appointment.php?AppointmentID=" . htmlspecialchars($row['AppointmentID']) . "'>View</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No appointments found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($searchQuery); ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
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

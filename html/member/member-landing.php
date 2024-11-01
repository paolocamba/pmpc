<?php
session_start();

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

if (isset($_SESSION['member_id'])) {
    $member_id = $_SESSION['member_id'];

    // Fetch first name of the logged-in user
    $first_name_query = "SELECT FirstName FROM member WHERE MemberID = ?";
    $stmt = $conn->prepare($first_name_query);
    $stmt->bind_param("i", $member_id);
    $stmt->execute();
    $stmt->bind_result($first_name);
    $stmt->fetch();
    $stmt->close();
} else {
    $first_name = "Guest";
}

// Pagination setup
$limit = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch events with pagination
$sql = "SELECT title, event_date, event_description, image FROM events ORDER BY event_date DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Landing Page</title>
    <link rel="stylesheet" href="../../css/member-landing.css">
    <link rel="stylesheet" href="../../css/member-general.css">
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
                <li><a href="member-landing.php" class="active">Home</a></li>
                <li><a href="member-dashboard.php">Dashboard</a></li>
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
                <h1>Welcome, <?php echo htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8'); ?>!</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>

            </header>

            <section class="news-bulletin">
                <div class="news">
                    <h2>News and Events</h2>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="event-card">';
                            echo '<img src="../../assets/uploads/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '" class="event-image">';
                            echo '<div class="event-details">';
                            echo '<h4>' . htmlspecialchars($row["title"]) . '</h4>';
                            echo '<p class="event-date">Date: ' . htmlspecialchars($row["event_date"]) . '</p>';
                            echo '<p>' . htmlspecialchars($row["event_description"]) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No events available.</p>';
                    }

                    $totalResult = $conn->query("SELECT COUNT(*) as total FROM events");
                    $totalItems = $totalResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalItems / $limit);

                    echo '<div class="pagination">';
                    if ($page > 1) {
                        echo '<a href="?page=' . ($page - 1) . '">Previous</a>';
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<a href="?page=' . $i . '"' . ($i === $page ? ' class="active"' : '') . '>' . $i . '</a>';
                    }

                    if ($page < $totalPages) {
                        echo '<a href="?page=' . ($page + 1) . '">Next</a>';
                    }
                    echo '</div>';
                    ?>
                </div>

                <div class="announcement">
                    <h2>Bulletin</h2>
                    <?php
                    $sql_announcements = "SELECT Ann_Name, Ann_Date FROM announcement ORDER BY Ann_Date DESC";
                    $result_announcements = $conn->query($sql_announcements);

                    if ($result_announcements->num_rows > 0) {
                        while ($row = $result_announcements->fetch_assoc()) {
                            echo '<div class="announcement-card">';
                            echo '<h3 class="announcement-title">' . htmlspecialchars($row["Ann_Name"]) . '</h3>';
                            echo '<p class="announcement-date"><strong>Date:</strong> ' . htmlspecialchars($row["Ann_Date"]) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No announcements available.</p>';
                    }
                    $conn->close();
                    ?>
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

<?php
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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle announcements
    if (isset($_POST['announcement'])) {
        $event_name = $_POST['event_name'];
        $event_date = $_POST['event_date'];

        $stmt = $conn->prepare("INSERT INTO announcement (Ann_Name, Ann_Date) VALUES (?, ?)");
        $stmt->bind_param("ss", $event_name, $event_date);
        $stmt->execute();
        $stmt->close();
    }

    // Handle events
    if (isset($_POST['event'])) {
        $title = $_POST['title'];
        $date = $_POST['date'];
        $event_description = $_POST['event_description'];
        $image = $_FILES['image']['name'];
        
        // Image upload
        if (!empty($image)) {
            $target_dir = "../../assets/uploads/";
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        }

        $stmt = $conn->prepare("INSERT INTO events (title, event_date, event_description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $date, $event_description, $image);
        $stmt->execute();
        $stmt->close();
    }

    // Handle deletion of announcements and events
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $table = $_POST['table'];

        $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Settings</title>
    <link rel="stylesheet" href="../../css/admin-settings.css">
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
                <li><a href="admin.html">Dashboard</a></li>
                <li><a href="admin-members.html">Members</a></li>
                <li><a href="admin-loans.html">Loans</a></li>
                <li><a href="admin-transactions.php">Transactions</a></li>
                <li><a href="admin-appointments.html">Appointments</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="#settings" class="active">Settings</a></li>
            </ul>
        </div>

        <main class="main-content">
            <header>
                <h1>Settings</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <section class="dashboard-metrics">
                <!-- Announcement Form -->
                <div class="metric-box">
                    <h3>Post Announcement</h3>
                    <form id="announcement-form" method="POST" action="index.php">
                        <input type="hidden" name="announcement" value="1">
                        <label for="event_name">Event Name</label>
                        <input type="text" id="event_name" name="event_name" placeholder="Enter event name" required>

                        <label for="event_date">Event Date</label>
                        <input type="date" id="event_date" name="event_date" required>

                        <button type="submit">Post Announcement</button>
                    </form>
                </div>

                <!-- Event Form -->
                <div class="metric-box">
                    <h3>Post Event</h3>
                    <form id="event-form" method="POST" action="index.php" enctype="multipart/form-data">
                        <input type="hidden" name="event" value="1">
                        <label for="title">Event Title</label>
                        <input type="text" id="title" name="title" placeholder="Enter event title" required>

                        <label for="image">Event Image</label>
                        <input type="file" id="image" name="image" accept="image/*" required>

                        <label for="date">Event Date</label>
                        <input type="date" id="date" name="date" required>

                        <label for="event_description">Event Description</label>
                        <textarea id="event_description" name="event_description" rows="3" placeholder="Enter event description" required></textarea>

                        <button type="submit">Post Event</button>
                    </form>
                </div>

                </div>
            </section>
        </main>
    </div>
</body>
</html>

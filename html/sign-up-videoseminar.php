<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "pmpc";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $memberID = $_POST['member-id'];
    $seminarCompleted = isset($_POST['seminar-completed']) ? 1 : 0;

    // Update WatchedVideoSeminar
    $stmt = $conn->prepare("UPDATE membership_application SET WatchedVideoSeminar = ? WHERE MemberID = ?");
    $stmt->bind_param('ii', $seminarCompleted, $memberID);
    $stmt->execute();

    // Check the status of the application
    $statusSql = "SELECT FillUpForm, WatchedVideoSeminar, PaidRegistrationFee FROM membership_application WHERE MemberID = ?";
    $stmtStatus = $conn->prepare($statusSql);
    $stmtStatus->bind_param('i', $memberID);
    $stmtStatus->execute();
    $result = $stmtStatus->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Determine the application status
        if ($row['FillUpForm'] && $row['WatchedVideoSeminar'] && $row['PaidRegistrationFee']) {
            $status = "Approved";
        } else {
            $status = "In Progress"; // Change to "Failed" if necessary
        }

        // Update the status
        $updateStatusSql = "UPDATE membership_application SET Status = ? WHERE MemberID = ?";
        $stmtUpdateStatus = $conn->prepare($updateStatusSql);
        $stmtUpdateStatus->bind_param('si', $status, $memberID);
        $stmtUpdateStatus->execute();
    }

    header("Location: sign-up-doa.php?member-id=" . $memberID); // Redirect to the next step
    exit();
}

$memberID = isset($_GET['member-id']) ? $_GET['member-id'] : '';
if (empty($memberID)) {
    die("Error: Member ID is missing.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Video Seminar</title>
    <link rel="stylesheet" href="../css/style.css">  <!-- Main styles -->
    <link rel="stylesheet" href="../css/sign-up-videoseminar.css">  <!-- Signup specific styles -->
</head>
<body>
    <!-- Navigation Bar -->
    <div class="topnav">
        <div class="logo-container">
            <img src="../assets/pmpc-logo.png" alt="PMPC Logo" class="logo">
            <a href="index.php" class="logo-text">PASCHAL</a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="services.html">Services</a>
            <a href="benefits.html">Benefits</a>
            <a href="about.html">About</a>
            <a href="signup.html" class="active">Sign Up</a>
            <a href="apply-loan.html" class="apply-loan">Apply for Loan</a>
        </div>
    </div>

    <!-- Sign Up Content -->
    <div class="background-wrapper">
    <div class="signup-container">
        <h2>Video Seminar</h2>

        <!-- Video Player -->
        <div class="video-seminar">
            <video width="100%" height="auto" controls>
                <source src="../assets/seminar-video.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Confirmation Form -->
        <form class="signup-form" action="sign-up-videoseminar.php?member-id=<?php echo htmlspecialchars($memberID); ?>" method="POST">
            <input type="hidden" name="member-id" value="<?php echo htmlspecialchars($memberID); ?>"> <!-- Member ID from previous step -->

            <div class="form-row">
                <label for="seminar-completed">I have completed the video seminar</label>
                <input type="checkbox" id="seminar-completed" name="seminar-completed">
            </div>

            <!-- Step and Button Navigation -->
        <div class="step-and-buttons-container">
            <div class="step-indicators">
                <span class="step">1</span>
                <span class="step active">2</span>
                <span class="step">3</span>
                <span class="step">4</span>
            </div>
        </div>

            <div class="navigation-buttons">
                <a href="sign-up-membershipapplication.php" class="nav-button prev-button">Previous</a>
                <button type="submit" class="nav-button next-button">Next</button>
            </div>
        </form>

    
    </div>
    </div>

</body>
</html>

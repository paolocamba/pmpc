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

    if (isset($_POST['seminar-completed'])) {
        // Existing seminar-completion logic...

    } elseif (isset($_POST['appointment-date'])) {
        $appointmentDate = $_POST['appointment-date'];

        // Fetch member details for LastName, FirstName, and Email
        $memberQuery = $conn->prepare("SELECT FirstName, LastName, Email FROM member WHERE MemberID = ?");
        $memberQuery->bind_param('i', $memberID);
        $memberQuery->execute();
        $memberResult = $memberQuery->get_result();

        if ($memberResult->num_rows > 0) {
            $memberData = $memberResult->fetch_assoc();
            $firstName = $memberData['FirstName'];
            $lastName = $memberData['LastName'];
            $email = $memberData['Email'];
            $description = "Membership Application Payment";
            $serviceID = 11;

            // Insert the appointment into the appointment table
            $stmt = $conn->prepare("INSERT INTO appointments (MemberID, AppointmentDate, LastName, FirstName, Email, Description, ServiceID) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('isssssi', $memberID, $appointmentDate, $lastName, $firstName, $email, $description, $serviceID);
            $stmt->execute();

            // Update AppointmentDate in membership_application
            $updateStmt = $conn->prepare("UPDATE membership_application SET AppointmentDate = ? WHERE MemberID = ?");
            $updateStmt->bind_param('si', $appointmentDate, $memberID);
            $updateStmt->execute();

            // Redirect to sign-up-submit.php for captcha
            header("Location: sign-up-submit.html?member-id=" . $memberID);
            exit();
        } else {
            die("Error: Member details not found.");
        }
    }
}

// Get member ID from GET parameters
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
    <title>Sign Up - DOA</title>
    <link rel="stylesheet" href="../css/style.css">  <!-- Main styles -->
    <link rel="stylesheet" href="../css/sign-up-doa.css">  <!-- Signup specific styles -->
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

    <!-- Date Appointment Form -->
    <div class="background-wrapper">
    <div class="appointment-container">
        <div class="appointment-form">
            <img src="../assets/pmpc-logo.png" alt="PMPC Logo" class="form-logo">
            <h3>Date of Appointment *</h3>
            <p>For Payment Settlement</p>
            <form action="sign-up-doa.php" method="POST">
                <input type="date" id="appointment-date" name="appointment-date" required>
                
                <!-- Hidden field to store member ID -->
                <input type="hidden" name="member-id" value="<?php echo htmlspecialchars($memberID); ?>"> 

                <!-- Step Navigation with Line -->
                <div class="step-and-buttons-container">
                    <div class="step-indicators">
                        <span class="step completed">1</span>
                        <span class="step completed">2</span>
                        <span class="step active">3</span>
                        <span class="step">4</span>
                    </div>

                    <div class="navigation-buttons">
                        <a href="sign-up-videoseminar.php" class="nav-button previous-button">Previous</a>
                        <button type="submit" class="nav-button next-button">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

</body>
</html>

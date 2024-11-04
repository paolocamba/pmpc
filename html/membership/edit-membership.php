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

// Get the member ID from URL
$memberID = $_GET['id'] ?? null;

if ($memberID) {
    // Fetch member's application data
    $query = "
        SELECT 
            ma.FillUpForm,
            ma.WatchedVideoSeminar,
            ma.PaidRegistrationFee,
            ma.MembershipFeePaidAmount,
            ma.AppointmentDate,
            ma.Status,
            sf.LastName,
            sf.FirstName,
            sf.MiddleName,
            sf.ContactNo,
            mc.Email
        FROM 
            membership_application ma
        JOIN 
            member_credentials mc ON mc.MemberID = ma.MemberID
        JOIN 
            signupform sf ON sf.MemberID = mc.MemberID
        WHERE 
            ma.MemberID = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $memberID);
    $stmt->execute();
    $result = $stmt->get_result();
    $memberData = $result->fetch_assoc();
}

// Update the application form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fillUpForm = isset($_POST['fillUpForm']) ? 1 : 0; // Use 0 for unchecked, 1 for checked
    $watchedVideoSeminar = isset($_POST['watchedVideoSeminar']) ? 1 : 0; // Use 0 for unchecked, 1 for checked
    $membershipFeePaidAmount = $_POST['membershipFeePaidAmount'] ?? 0; // Numeric input for amount
    $status = $_POST['status'] ?? 'InProgress'; // Default status is 'InProgress'

    // Set PaidRegistrationFee based on MembershipFeePaidAmount
    $paidRegistrationFee = ($membershipFeePaidAmount > 0) ? 1 : 0; // 1 for Yes, 0 for No

    // Update member application in the database
    $updateQuery = "
        UPDATE membership_application 
        SET FillUpForm = ?, WatchedVideoSeminar = ?, PaidRegistrationFee = ?, MembershipFeePaidAmount = ?, Status = ?
        WHERE MemberID = ?
    ";
    $updateStmt = $conn->prepare($updateQuery);
    
    // Bind parameters: i for int, s for string
    $updateStmt->bind_param("iisisi", $fillUpForm, $watchedVideoSeminar, $paidRegistrationFee, $membershipFeePaidAmount, $status, $memberID);
    
    if ($updateStmt->execute()) {
        // Update Savings and TypeOfMember in member table
        $memberType = ($membershipFeePaidAmount < 5000) ? 'Associate' : 'Regular';

        // Update the member's savings and type of member
        $updateMemberQuery = "
            UPDATE member
            SET Savings = ?, TypeOfMember = ?
            WHERE MemberID = ?
        ";
        $updateMemberStmt = $conn->prepare($updateMemberQuery);
        $updateMemberStmt->bind_param("ssi", $membershipFeePaidAmount, $memberType, $memberID);
        
        if ($updateMemberStmt->execute()) {
            echo "Membership application and member details updated successfully!";
        } else {
            echo "Error updating member details: " . $conn->error;
        }

        $updateMemberStmt->close();
    } else {
        echo "Error updating membership application: " . $conn->error;
    }
}

// Handle delete request
if (isset($_POST['delete'])) {
    $deleteQuery = "DELETE FROM membership_application WHERE MemberID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $memberID);
    
    if ($deleteStmt->execute()) {
        echo "Membership application deleted successfully!";
        header("Location: admin-members.php");
        exit();
    } else {
        echo "Error deleting membership application: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Members</title>
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
                <li><a href="membership.php" class="active">Members</a></li>
                <li><a href="membership-inbox.php" >Inbox</a></li>
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Edit Membership Application</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Member Application Form -->
            <form method="POST" action="">
                <div class="member-details">
                    <h3>Member: <?php echo htmlspecialchars($memberData['FirstName'] . ' ' . $memberData['LastName']); ?></h3>
                    <p>Email: <?php echo htmlspecialchars($memberData['Email']); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($memberData['ContactNo']); ?></p>
                </div>

                <div class="application-details">
                    <h4>Application Status</h4>
                    <label>
                        Application Form: 
                        <input type="checkbox" name="fillUpForm" value="1" <?php echo $memberData['FillUpForm'] == 1 ? 'checked' : ''; ?>>
                    </label>
                    <br>
                    <label>
                        Video Seminar: 
                        <input type="checkbox" name="watchedVideoSeminar" value="1" <?php echo $memberData['WatchedVideoSeminar'] == 1 ? 'checked' : ''; ?>>
                    </label>
                    <br>
                    <label>
                        Membership Fee Amount: 
                        <input type="number" name="membershipFeePaidAmount" value="<?php echo htmlspecialchars($memberData['MembershipFeePaidAmount']); ?>">
                    </label>
                    <br>
                    <label>
                    Status: 
                    <select name="status">
                        <option value="In progress" <?php echo $memberData['Status'] === 'In progress' ? 'selected' : ''; ?>>In Progress</option>
                        <option value="Completed" <?php echo $memberData['Status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        <option value="Failed" <?php echo $memberData['Status'] === 'Failed' ? 'selected' : ''; ?>>Failed</option>
                    </select>
                </label>
                    <br>
                    <h4>Appointment Set by Member: <?php echo htmlspecialchars($memberData['AppointmentDate']); ?></h4>
                </div>

                <div class="button-container">
                    <button type="submit" class="action-button">Update Application</button>
                    <button type="button" class="action-button delete-button" onclick="confirmDelete()">Delete Application</button>
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
            const confirmDelete = window.confirm("Are you sure you want to delete this application?");
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

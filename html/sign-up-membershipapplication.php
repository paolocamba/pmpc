<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "pmpc";
    
    // Create a database connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize statements
    $stmtAddress = null;

    // Gather and trim variables from the form submission
    $firstName = trim($_POST['first-name']);
    $middleName = trim($_POST['middle-name']);
    $lastName = trim($_POST['last-name']);
    $gender = trim($_POST['gender']);
    $street = trim($_POST['street']);
    $barangay = trim($_POST['barangay']);
    $municipality = trim($_POST['municipality']);
    $province = trim($_POST['province']);
    $tin = trim($_POST['tin']);
    $birthday = trim($_POST['birthday']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);

    // Validate passwords match
    if ($password !== $confirmPassword) {
        die("Error: Passwords do not match.");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check for empty email
    if (empty($email)) {
        die("Error: Email cannot be empty.");
    }

    // Check if email already exists
    $emailCheckStmt = $conn->prepare('SELECT Email FROM member_credentials WHERE Email = ?');
    $emailCheckStmt->bind_param('s', $email);
    $emailCheckStmt->execute();
    $emailCheckStmt->store_result();

    if ($emailCheckStmt->num_rows > 0) {
        die("Error: Email already in use.");
    }

    // Additional fields for membership application
    $fillUpForm = true; // Replace with actual form value
    $watchedVideoSeminar = false; // Replace with actual boolean value from form
    $paidRegistrationFee = 100.00; // Replace with actual fee from form
    $status = "Pending"; // Example status for the application

    // Start transaction
    $conn->begin_transaction();

    // Start transaction
$conn->begin_transaction();

try {
    // Insert the new address into the address table
    $stmtAddress = $conn->prepare('INSERT INTO address (Street, Barangay, Municipality, Province) VALUES (?, ?, ?, ?)');
    if (!$stmtAddress) {
        throw new Exception("Error preparing address insert statement: " . $conn->error);
    }
    $stmtAddress->bind_param('ssss', $street, $barangay, $municipality, $province);
    if (!$stmtAddress->execute()) {
        throw new Exception("Error executing address insert statement: " . $stmtAddress->error);
    }

    // Get the new AddressID
    $newAddressID = $conn->insert_id;

    // Check if the insert was successful and AddressID is valid
    if ($newAddressID <= 0) {
        throw new Exception("Error: Failed to get new AddressID.");
    }

    // Insert into member table with the new AddressID
    $stmt1 = $conn->prepare('INSERT INTO member (FirstName, MiddleName, LastName, Sex, AddressID, TINNumber, Birthday, ContactNo, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    if (!$stmt1) {
        echo "Error preparing member insert statement: " . $conn->error;

    }
    $stmt1->bind_param('sssisssss', $firstName, $middleName, $lastName, $gender, $newAddressID, $tin, $birthday, $phone, $email);
    if (!$stmt1->execute()) {
        throw new Exception("Error executing member insert statement: " . $stmt1->error);
    }

    // Get the new MemberID from the member table
    $newMemberID = $conn->insert_id;

    // Set FillUpForm value
    $fillUpForm = 1; // Completed signup form
    $watchedVideoSeminar = 0; // Not yet watched
    $paidRegistrationFee = 0; // Example fee
    $status = "In Progress"; // Example status for the application

    // Insert into membership_application
    $stmtMembership = $conn->prepare('INSERT INTO membership_application (MemberID, FillUpForm, WatchedVideoSeminar, PaidRegistrationFee, Status) VALUES (?, ?, ?, ?, ?)');
    if (!$stmtMembership) {
        throw new Exception("Error preparing membership application insert statement: " . $conn->error);
    }
    $stmtMembership->bind_param('iiids', $newMemberID, $fillUpForm, $watchedVideoSeminar, $paidRegistrationFee, $status);
    if (!$stmtMembership->execute()) {
        throw new Exception("Error executing membership application insert statement: " . $stmtMembership->error);
    }

    // Insert the new member into the signupform table using the new MemberID
    $stmt2 = $conn->prepare('INSERT INTO signupform (FirstName, MiddleName, LastName, Sex, AddressID, TINNumber, Birthday, ContactNo, MemberID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    if (!$stmt2) {
        throw new Exception("Error preparing signupform insert statement: " . $conn->error);
    }
    $stmt2->bind_param('ssssisssi', $firstName, $middleName, $lastName, $gender, $newAddressID, $tin, $birthday, $phone, $newMemberID);
    if (!$stmt2->execute()) {
        throw new Exception("Error executing signupform insert statement: " . $stmt2->error);
    }

    // Insert into member_credentials with the new MemberID
    $stmt3 = $conn->prepare('INSERT INTO member_credentials (MemberID, Username, Email, Password) VALUES (?, ?, ?, ?)');
    if (!$stmt3) {
        throw new Exception("Error preparing member credentials insert statement: " . $conn->error);
    }
    $stmt3->bind_param('isss', $newMemberID, $username, $email, $hashedPassword);
    if (!$stmt3->execute()) {
        throw new Exception("Error executing member credentials insert statement: " . $stmt3->error);
    }

    // Commit the transaction
    $conn->commit();

    // Redirect to the video seminar page after successful submission
    header("Location: sign-up-videoseminar.php?member-id=" . $newMemberID);
    exit();

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    file_put_contents('error_log.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
    echo "Error: " . $e->getMessage();
}

// Close statements and connection
if (isset($stmtAddress)) $stmtAddress->close();
if (isset($stmt1)) $stmt1->close();
if (isset($stmtMembership)) $stmtMembership->close();
if (isset($stmt2)) $stmt2->close();
if (isset($stmt3)) $stmt3->close();
if (isset($emailCheckStmt)) $emailCheckStmt->close();
$conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Membership Application</title>
    <link rel="stylesheet" href="../css/style.css">  <!-- Main styles -->
    <link rel="stylesheet" href="../css/sign-up-membershipapplication.css">
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
    <div class="signup-container">
        <form class="signup-form" action="sign-up-membershipapplication.php" method="POST">
            <h2>Sign Up | Membership Application</h2>
            <p>To register, please fill out the information below.</p>

            <div class="form-grid">
                <div class="form-row">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" required>
                </div>
                <div class="form-row">
                    <label for="middle-name">Middle Name</label>
                    <input type="text" id="middle-name" name="middle-name">
                </div>
                <div class="form-row">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" required>
                </div>
                <div class="form-row">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" required>
                </div>
                <div class="form-row">
                    <label for="barangay">Barangay</label>
                    <input type="text" id="barangay" name="barangay" required>
                </div>
                <div class="form-row">
                    <label for="municipality">Municipality</label>
                    <input type="text" id="municipality" name="municipality" required>
                </div>
                <div class="form-row">
                    <label for="province">Province</label>
                    <input type="text" id="province" name="province" required>
                </div>
                <div class="form-row">
                    <label for="tin">TIN No. (Required)</label>
                    <input type="text" id="tin" name="tin" required>
                </div>
                <div class="form-row">
                    <label for="birthday">Birthday</label>
                    <input type="date" id="birthday" name="birthday" required>
                </div>
                <div class="form-row">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="form-row">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-row">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-row">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-row">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
            </div>

            <div class="navigation-buttons">
                <a href="sign-up-typemembership.html" class="nav-button prev-button">Previous</a>
                <button type="submit" class="nav-button next-button">Next</button>
            </div>
        </form>
    </div>
</body>
</html>
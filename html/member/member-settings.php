<?php
session_start();

// Check if MemberID is set in the session
if (!isset($_SESSION['MemberID'])) {
    // Redirect to login page if MemberID is not found
    header("Location: ../../html/index.php");
    exit();
}

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

$memberID = $_SESSION['MemberID'];

// Fetch member's information
$query = "
    SELECT 
        m.LastName, 
        m.FirstName, 
        m.MiddleName, 
        m.Sex, 
        m.TINNumber, 
        m.Birthday, 
        m.ContactNo, 
        m.Email,
        mc.Username, 
        mc.Password,
        a.Street, 
        a.Barangay, 
        a.Municipality, 
        a.Province
    FROM 
        member m
    JOIN 
        member_credentials mc ON mc.MemberID = m.MemberID
    JOIN 
        address a ON a.AddressID = m.AddressID
    WHERE 
        m.MemberID = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $memberID);
$stmt->execute();
$result = $stmt->get_result();
$memberData = $result->fetch_assoc();

// Check if data was found
if (!$memberData) {
    echo "No member data found for MemberID: " . $memberID;
    exit();
}

// Handle form submission for saving changes
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $gender = $_POST['gender'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $tin = $_POST['tin'];
    $birthday = $_POST['birthday'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $currentPassword = $_POST['currentPassword'];

    // Verify the entered password matches the stored password
    if (!password_verify($currentPassword, $memberData['Password'])) {
        echo "<script>alert('Invalid current password. Please try again.');</script>";
        exit();
    }

    // If password matches, proceed with the updates
    $conn->begin_transaction(); // Start transaction to ensure consistency

    // Update member table
    $updateMember = "
        UPDATE member 
        SET LastName = ?, FirstName = ?, MiddleName = ?, Sex = ?, TINNumber = ?, Birthday = ?, ContactNo = ?, Email = ?
        WHERE MemberID = ?
    ";
    $stmt = $conn->prepare($updateMember);
    $stmt->bind_param("ssssssssi", $lastName, $firstName, $middleName, $gender, $tin, $birthday, $phoneNumber, $email, $memberID);
    $stmt->execute();

    // Update address table
    $updateAddress = "
        UPDATE address 
        SET Street = ?, Barangay = ?, Municipality = ?, Province = ?
        WHERE AddressID = (SELECT AddressID FROM member WHERE MemberID = ?)
    ";
    $stmt = $conn->prepare($updateAddress);
    $stmt->bind_param("ssssi", $street, $barangay, $municipality, $province, $memberID);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    echo "<script>alert('Account details updated successfully!');</script>";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Manage Account</title>
    <link rel="stylesheet" href="../../css/member-manageaccount.css">
    <link rel="stylesheet" href="../../css/member-general.css">
</head>
<body>

    <div class="container">
        
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <div class="logo">
                    <img src="../../assets/pmpc-logo.png" alt="PMPC Logo">
                </div>
                <h2 class="pmpc-text">PASCHAL</h2>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="member-landing.php">Home</a></li>
                <li><a href="member-dashboard.php">Dashboard</a></li>
                <li><a href="member-services.html">Services</a></li>
                <li><a href="member-inbox.html">Inbox</a></li>
                <li><a href="member-about.html">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-manageaccount.html" class="active">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Account Settings</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <section class="personal-info-section">
            <div class="personal-info-header">
                    <h2>Personal Information</h2>
                    <span>MemberID: <?php echo htmlspecialchars($memberID); ?></span>
                </div>

                <div class="personal-info-form">
                    <div class="input-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($memberData['LastName']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($memberData['FirstName']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="middleName">Middle Name</label>
                        <input type="text" id="middleName" name="middleName" value="<?php echo htmlspecialchars($memberData['MiddleName']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="male" <?php echo ($memberData['Sex'] == 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo ($memberData['Sex'] == 'female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label for="street">Street</label>
                        <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($memberData['Street']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="barangay">Barangay</label>
                        <input type="text" id="barangay" name="barangay" value="<?php echo htmlspecialchars($memberData['Barangay']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="municipality">Municipality</label>
                        <input type="text" id="municipality" name="municipality" value="<?php echo htmlspecialchars($memberData['Municipality']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="province">Province</label>
                        <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($memberData['Province']); ?>">
                    </div>

                    <div class="input-group">
                        <label for="tin">TIN No. (Required)</label>
                        <input type="text" id="tin" name="tin" value="<?php echo htmlspecialchars($memberData['TINNumber']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($memberData['Birthday']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($memberData['ContactNo']); ?>">
                    </div>
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($memberData['Email']); ?>">
                    </div>

                    <div class="button-group">
                        <button class="save-changes" type="button" onclick="askForPassword()">Save Changes</button>
                    </div>
                </div>

                </div>
            </section>
        </div>

    </div>

    <script>
        function askForPassword() {
            const currentPassword = prompt("Please enter your current password:");
            
            if (currentPassword) {
                // Create a hidden input to hold the password
                const passwordInput = document.createElement("input");
                passwordInput.type = "hidden";
                passwordInput.name = "currentPassword";
                passwordInput.value = currentPassword;

                // Append the hidden input to the form
                const form = document.querySelector("form");
                form.appendChild(passwordInput);

                // Submit the form
                form.submit();
            }
        }

        function redirectToIndex() {
            window.location.href = '../../html/index.php';
        }
    </script>

</body>
</html>

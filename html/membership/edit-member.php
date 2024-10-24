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
        m.Savings,
        m.TypeOfMember,
        a.Street, 
        a.Barangay, 
        a.Municipality, 
        a.Province
    FROM 
        member m
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
    // Fetch form data
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
    $savings = $_POST['savings'];
    $typeOfMembership = $_POST['typeOfMembership'];
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
        SET LastName = ?, FirstName = ?, MiddleName = ?, Sex = ?, TINNumber = ?, Birthday = ?, ContactNo = ?, Email = ?, Savings = ?, TypeOfMember = ?
        WHERE MemberID = ?
    ";
    $stmt = $conn->prepare($updateMember);
    $stmt->bind_param("ssssssssssi", $lastName, $firstName, $middleName, $gender, $tin, $birthday, $phoneNumber, $email, $savings, $typeOfMembership, $memberID);
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
    <title>Admin Dashboard - Members</title>
    <link rel="stylesheet" href="../../css/admin-edit-members.css">
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
            </ul>

            <ul class="sidebar-settings">
                <li><a href="admin-settings.html">Settings</a></li>
            </ul>
        </div>

        <main class="main-content">
            <header>
                <h1>Manage Member Information</h1>
                <button class="logout-button" onclick="redirectToIndex()">Log out</button>
            </header>

            <section class="personal-info-section">
                <h2>Personal Information</h2>
                <form method="POST" class="personal-info-form">
                    <div class="input-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($memberData['LastName']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($memberData['FirstName']); ?>" required>
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
                        <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($memberData['Street']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="barangay">Barangay</label>
                        <input type="text" id="barangay" name="barangay" value="<?php echo htmlspecialchars($memberData['Barangay']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="municipality">Municipality</label>
                        <input type="text" id="municipality" name="municipality" value="<?php echo htmlspecialchars($memberData['Municipality']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="province">Province</label>
                        <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($memberData['Province']); ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="tin">TIN No. (Required)</label>
                        <input type="text" id="tin" name="tin" value="<?php echo htmlspecialchars($memberData['TINNumber']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($memberData['Birthday']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($memberData['ContactNo']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($memberData['Email']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="savings">Savings</label>
                        <input type="text" id="savings" name="savings" value="<?php echo htmlspecialchars($memberData['Savings']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="typeOfMembership">Type of Membership</label>
                        <input type="text" id="typeOfMembership" name="typeOfMembership" value="<?php echo htmlspecialchars($memberData['TypeOfMember']); ?>" required>
                    </div>

                    <div class="button-group">
                        <button class="save-changes" type="button" onclick="askForPassword()">Save Changes</button>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <script>
        function askForPassword() {
            const currentPassword = prompt("Please enter your current password:");
            if (currentPassword) {
                const passwordInput = document.createElement("input");
                passwordInput.type = "hidden";
                passwordInput.name = "currentPassword";
                passwordInput.value = currentPassword;

                const form = document.querySelector("form");
                form.appendChild(passwordInput);
                form.submit();
            }
        }

        function redirectToIndex() {
            window.location.href = '../../html/index.php';
        }
    </script>
</body>
</html>


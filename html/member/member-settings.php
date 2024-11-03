<?php
session_start();

// Check if MemberID is set in the session
if (!isset($_SESSION['memberID'])) {
    // Redirect to login page if MemberID is not found
    header("Location: ../../html/index.php");
    exit();
}

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$memberID = $_SESSION['memberID'];

// Handle AJAX request for changing password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currentPassword'], $_POST['newPassword'])) {
    header('Content-Type: application/json'); // Ensure JSON response header
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    // Verify current password
    $query = "SELECT Password FROM member_credentials WHERE MemberID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $memberID);
    $stmt->execute();
    $result = $stmt->get_result();
    $memberData = $result->fetch_assoc();

    if (!$memberData || !password_verify($currentPassword, $memberData['Password'])) {
        echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
        exit();
    }

    // Update the password
    $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);
    $updateQuery = "UPDATE member_credentials SET Password = ? WHERE MemberID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $newPasswordHash, $memberID);
    $updateSuccess = $updateStmt->execute();

    if ($updateSuccess) {
        echo json_encode(['success' => true, 'message' => 'Password changed successfully.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update password.']);
    }
    $conn->close();
    exit();
}


// Fetch member's information for account management display
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

// Handle form submission for saving account details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['newPassword'])) {
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
                <li><a href="member-services.php">Services</a></li>
                <li><a href="member-inbox.php">Inbox</a></li>
                <li><a href="member-about.html">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-manageaccount.php" class="active">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Personal Information</h1>   
            </header>

            <section class="personal-info-section">
                <div class="personal-info-form">
                    <form id="accountForm" method="POST">
                        <div class="input-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($memberData['LastName']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($memberData['FirstName']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="middleName">Middle Name</label>
                            <input type="text" id="middleName" name="middleName" value="<?php echo htmlspecialchars($memberData['MiddleName']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" disabled>
                                <option value="male" <?php echo ($memberData['Sex'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                <option value="female" <?php echo ($memberData['Sex'] == 'female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="street">Street</label>
                            <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($memberData['Street']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="barangay">Barangay</label>
                            <input type="text" id="barangay" name="barangay" value="<?php echo htmlspecialchars($memberData['Barangay']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="municipality">Municipality</label>
                            <input type="text" id="municipality" name="municipality" value="<?php echo htmlspecialchars($memberData['Municipality']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="province">Province</label>
                            <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($memberData['Province']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="tin">TIN No. (Required)</label>
                            <input type="text" id="tin" name="tin" value="<?php echo htmlspecialchars($memberData['TINNumber']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($memberData['Birthday']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" id="phoneNumber" name="phoneNumber" value="<?php echo htmlspecialchars($memberData['ContactNo']); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($memberData['Email']); ?>" readonly>
                        </div>
                        
                        <div class="button-group">
                            <div class="left-buttons">
                                <button class="save-changes" type="button" onclick="askForPassword()">Save Changes</button>
                                <button type="button" class="edit-button" onclick="toggleEdit()">Edit</button>
                            </div>
                            <button type="button" class="change-password" onclick="openChangePasswordModal()">Change Password</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <!-- Change Password Modal -->
        <div id="changePasswordModal" class="modal">
            <div class="modal-content">
                <span class="close-button" onclick="closeChangePasswordModal()">&times;</span>
                <h2>Change Password</h2>
                
                <form id="changePasswordForm">
                    <div class="input-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="input-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="button-group">
                        <button type="button" onclick="submitChangePassword()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleEdit() {
            const formElements = document.querySelectorAll("#accountForm input, #accountForm select");
            formElements.forEach(el => el.readOnly = !el.readOnly);
            document.getElementById("gender").disabled = !document.getElementById("gender").disabled;
            document.getElementById("saveChangesGroup").style.display = formElements[0].readOnly ? "none" : "block";
        }

        function askForPassword() {
            const currentPassword = prompt("Please enter your current password:");
            if (currentPassword) {
                const passwordInput = document.createElement("input");
                passwordInput.type = "hidden";
                passwordInput.name = "currentPassword";
                passwordInput.value = currentPassword;
                document.getElementById("accountForm").appendChild(passwordInput);
                document.getElementById("accountForm").submit();
            }
        }

        function openChangePasswordModal() {
            document.getElementById("changePasswordModal").style.display = "block";
        }

        function closeChangePasswordModal() {
            document.getElementById("changePasswordModal").style.display = "none";
        }

        function submitChangePassword() {
            const currentPassword = document.getElementById("currentPassword").value;
            const newPassword = document.getElementById("newPassword").value;

            if (!currentPassword || !newPassword) {
                alert("Please fill in all fields.");
                return;
            }

            const formData = new URLSearchParams({
                currentPassword: currentPassword,
                newPassword: newPassword
            });

            fetch('member-settings.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Password changed successfully.");
                    closeChangePasswordModal();
                } else {
                    alert(data.error || "Failed to change password.");
                }
            })
            .catch(error => console.error("Error changing password:", error));
        }
    </script>

</body>
</html>

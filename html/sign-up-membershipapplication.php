<?php
// Start session to retain form data in case of validation errors
session_start();

$errorMessage = '';
$form_data = $_SESSION['form_data'] ?? []; // Retrieve previous form data if it exists

// Database connection (moved outside the POST check)
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "pmpc";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gather and trim variables
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

    if ($password !== $confirmPassword) {
        $errorMessage = "Error: Passwords do not match.";
    }

    if (empty($errorMessage)) {
        // Check for existing email, TIN, or phone
        $stmtEmailCheck = $conn->prepare('SELECT Email FROM member_credentials WHERE Email = ?');
        $stmtEmailCheck->bind_param('s', $email);
        $stmtEmailCheck->execute();
        $stmtEmailCheck->store_result();

        if ($stmtEmailCheck->num_rows > 0) {
            $errorMessage = "Email already in use.";
        }

        $stmtEmailCheck->close();

        // Repeat for TIN and phone
        if (empty($errorMessage)) {
            $stmtTINCheck = $conn->prepare('SELECT TINNumber FROM member WHERE TINNumber = ?');
            $stmtTINCheck->bind_param('s', $tin);
            $stmtTINCheck->execute();
            $stmtTINCheck->store_result();

            if ($stmtTINCheck->num_rows > 0) {
                $errorMessage = "TIN already in use.";
            }
            $stmtTINCheck->close();
        }

        if (empty($errorMessage)) {
            $stmtPhoneCheck = $conn->prepare('SELECT ContactNo FROM member WHERE ContactNo = ?');
            $stmtPhoneCheck->bind_param('s', $phone);
            $stmtPhoneCheck->execute();
            $stmtPhoneCheck->store_result();

            if ($stmtPhoneCheck->num_rows > 0) {
                $errorMessage = "Phone number already in use.";
            }
            $stmtPhoneCheck->close();
        }
    }

    if ($errorMessage) {
        $_SESSION['form_data'] = $_POST; // Store form data in session if there's an error
    } else {
        // Additional fields for membership application
        $fillUpForm = true;
        $watchedVideoSeminar = false;
        $paidRegistrationFee = 0.00;
        $status = "Pending";

        // Start transaction
        $conn->begin_transaction();

        try {
            // Insert the new address into the address table
            $stmtAddress = $conn->prepare('INSERT INTO address (Street, Barangay, Municipality, Province) VALUES (?, ?, ?, ?)');
            $stmtAddress->bind_param('ssss', $street, $barangay, $municipality, $province);
            $stmtAddress->execute();
            $newAddressID = $conn->insert_id;

            if ($newAddressID <= 0) {
                throw new Exception("Error: Failed to get new AddressID.");
            }

            // Insert into member table
            $stmt1 = $conn->prepare('INSERT INTO member (FirstName, MiddleName, LastName, Sex, AddressID, TINNumber, Birthday, ContactNo, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt1->bind_param('sssisssss', $firstName, $middleName, $lastName, $gender, $newAddressID, $tin, $birthday, $phone, $email);
            $stmt1->execute();
            $newMemberID = $conn->insert_id;

            // Insert into membership_application
            $stmtMembership = $conn->prepare('INSERT INTO membership_application (MemberID, FillUpForm, WatchedVideoSeminar, PaidRegistrationFee, Status) VALUES (?, ?, ?, ?, ?)');
            $stmtMembership->bind_param('iiids', $newMemberID, $fillUpForm, $watchedVideoSeminar, $paidRegistrationFee, $status);
            $stmtMembership->execute();

            // Insert into signupform
            $stmt2 = $conn->prepare('INSERT INTO signupform (FirstName, MiddleName, LastName, Sex, AddressID, TINNumber, Birthday, ContactNo, MemberID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt2->bind_param('ssssisssi', $firstName, $middleName, $lastName, $gender, $newAddressID, $tin, $birthday, $phone, $newMemberID);
            $stmt2->execute();

            // Insert into member_credentials
            $stmt3 = $conn->prepare('INSERT INTO member_credentials (MemberID, Username, Email, Password) VALUES (?, ?, ?, ?)');
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt3->bind_param('isss', $newMemberID, $username, $email, $hashedPassword);
            $stmt3->execute();

            // Commit the transaction
            $conn->commit();
            unset($_SESSION['form_data']); // Clear session data upon successful submission
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
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Membership Application</title>
    <link rel="stylesheet" href="../css/style.css">
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

    <div class="background-wrapper">
        <div class="signup-container">
            <form class="signup-form" action="sign-up-membershipapplication.php" method="POST">
                <h2>Sign Up | Membership Application</h2>
                <p>To register, please fill out the information below.</p>
                <div class="form-grid">
                <div class="form-row">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" value="<?= htmlspecialchars($form_data['first-name'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="middle-name">Middle Name</label>
                    <input type="text" id="middle-name" name="middle-name" value="<?= htmlspecialchars($form_data['middle-name'] ?? '') ?>">
                </div>
                <div class="form-row">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" value="<?= htmlspecialchars($form_data['last-name'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled <?= !isset($form_data['gender']) ? 'selected' : '' ?>>Select gender</option>
                        <option value="male" <?= isset($form_data['gender']) && $form_data['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= isset($form_data['gender']) && $form_data['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" value="<?= htmlspecialchars($form_data['street'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="barangay">Barangay</label>
                    <input type="text" id="barangay" name="barangay" value="<?= htmlspecialchars($form_data['barangay'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="municipality">Municipality</label>
                    <input type="text" id="municipality" name="municipality" value="<?= htmlspecialchars($form_data['municipality'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="province">Province</label>
                    <input type="text" id="province" name="province" value="<?= htmlspecialchars($form_data['province'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="tin">TIN No. (Required)</label>
                    <input type="text" id="tin" name="tin" pattern="\d{9}" title="TIN must be 9 digits" value="<?= htmlspecialchars($form_data['tin'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="birthday">Birthday</label>
                    <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($form_data['birthday'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" pattern="09\d{9}" title="Phone number must start with 09 and be 11 digits" value="<?= htmlspecialchars($form_data['phone'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($form_data['email'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($form_data['username'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" minlength="8" value="<?= htmlspecialchars($form_data['password'] ?? '') ?>" required>
                </div>
                <div class="form-row">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" value="<?= htmlspecialchars($form_data['first'] ?? '') ?>" required>
                </div>
            </div>


             <!-- Step and Button Navigation -->
             <div class="step-and-buttons-container">
                <div class="step-indicators">
                    <span class="step active">1</span>
                    <span class="step">2</span>
                    <span class="step">3</span>
                    <span class="step">4</span>
                </div>

            <div class="navigation-buttons">
                <a href="sign-up-typemembership.html" class="nav-button prev-button">Previous</a>
                <button type="submit" class="nav-button next-button">Next</button>
            </div>
        </form>

    <!-- Modal -->
    <div id="errorModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Error</h2>
                <p id="error-message"><?= $errorMessage ?></p>
            </div>
        </div>   


        <script>
    document.getElementById('birthday').addEventListener('change', function () {
        const birthday = new Date(this.value);
        const today = new Date();
        const age = today.getFullYear() - birthday.getFullYear();
        const monthDifference = today.getMonth() - birthday.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthday.getDate())) {
            age--;
        }
        if (age < 18) {
            alert('You must be at least 18 years old.');
            this.value = '';  // Clear the field if under 18
        }
    });

    document.getElementById('confirm-password').addEventListener('input', function () {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        if (password !== confirmPassword) {
            this.setCustomValidity("Passwords do not match");
        } else {
            this.setCustomValidity("");
        }
    });

    // Show modal if there's an error
    <?php if ($errorMessage): ?>
        document.getElementById('errorModal').style.display = 'block';
    <?php endif; ?>

    function closeModal() {
        document.getElementById('errorModal').style.display = 'none';
    }

    // Remove the unnecessary alert and use the modal
    document.addEventListener('DOMContentLoaded', function () {
        var errorMessage = "<?php echo $errorMessage; ?>";
        // The modal will be shown automatically if there's an error
        if (errorMessage) {
            // The alert is no longer needed here
            // alert(errorMessage);  // Remove this line
        }
    });
</script>

    </div>
    </div>
</body>
</html>
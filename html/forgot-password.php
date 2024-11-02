<?php 
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = 'localhost'; // Your MySQL host
$db = 'pmpc'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default values for token and email checks
$isTokenValid = false;
$errorMessage = '';

if (isset($_GET["token"]) && isset($_GET["email"])) {
    $email = $_GET["email"];
    $token = $_GET["token"];

    // Check if the token is valid and not expired
    $stmt = $conn->prepare("SELECT * FROM member_credentials WHERE email = ? AND reset_token = ? AND token_expiry > UTC_TIMESTAMP()");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid
        $isTokenValid = true;
    } else {
        $errorMessage = 'Invalid or expired token.';
    }
}

// Handle the password reset only if the form is submitted and the token is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($isTokenValid) {
        $newPassword = $_POST["new-password"];
        $confirmPassword = $_POST["confirm-password"];

        // Ensure password meets the criteria
        $passwordCriteriaNotMet = strlen($newPassword) < 8 || 
            !preg_match('/[A-Z]/', $newPassword) || 
            !preg_match('/[a-z]/', $newPassword) || 
            !preg_match('/[0-9]/', $newPassword) || 
            !preg_match('/[\W]/', $newPassword);

        if ($passwordCriteriaNotMet && $newPassword !== $confirmPassword) {
            echo "<script>alert('The new password and confirm password do not match. Additionally, the password must be at least 8 characters long, with uppercase letters, lowercase letters, numbers, and symbols.');</script>";
        } elseif ($passwordCriteriaNotMet) {
            echo "<script>alert('Password must be at least 8 characters long, with uppercase letters, lowercase letters, numbers, and symbols.');</script>";
        } elseif ($newPassword !== $confirmPassword) {
            echo "<script>alert('The new password and confirm password do not match.');</script>";
        } else {
            // Hash the new password and update it in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE member_credentials SET password = ?, reset_token = NULL, token_expiry = NULL WHERE email = ?");
            $stmt->bind_param("ss", $hashedPassword, $email);

            if ($stmt->execute()) {
                echo "<script>alert('Password reset successfully!'); window.location.href='memblogin.html';</script>";
            } else {
                echo "<script>alert('Error updating password. Please try again.');</script>";
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Invalid or expired token. Please request a new password reset.');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - PASCHAL COOPERATIVE</title>
    <link rel="stylesheet" href="../css/forgot-password.css">
</head>
<body>
    <div class="resetp-container">
        <img src="../assets/pmpc-logo.png" alt="PMPC Logo" class="resetp-logo">
        <h1>PASCHAL COOPERATIVE</h1>
        <p class="rp-text">Reset Your Password</p>

        <?php if (!$isTokenValid && !empty($errorMessage)) : ?>
            <p style="color: red;"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <p class="password-requirements">
            Password must be at least 8 characters long, with uppercase letters, lowercase letters, numbers, and symbols.
        </p>

        <form id="reset-password-form" method="POST" onsubmit="return validatePasswords()">
            <div class="form-group">
                <input type="password" id="new-password" name="new-password" placeholder="New Password" required>
                <span class="toggle-password-icon" onclick="togglePasswordVisibility('new-password', this)">
                    <img src="../assets/hide.png" alt="Hide Password" id="toggle-new-password-icon">
                </span>
            </div>
            <div class="form-group">
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm New Password" required>
                <span class="toggle-password-icon" onclick="togglePasswordVisibility('confirm-password', this)">
                    <img src="../assets/hide.png" alt="Hide Password" id="toggle-confirm-password-icon">
                </span>
            </div>
            <button type="submit" name="reset-password" class="reset-password-button">Reset Password</button>
            <p class="error-message" id="error-message"></p>
        </form>
    </div>

    <script>
    // Function to toggle password visibility
    function togglePasswordVisibility(passwordFieldId, icon) {
        const passwordField = document.getElementById(passwordFieldId);
        const iconImage = icon.querySelector("img");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            iconImage.src = "../assets/view.png";
            iconImage.alt = "Show Password";
        } else {
            passwordField.type = "password";
            iconImage.src = "../assets/hide.png";
            iconImage.alt = "Hide Password";
        }
    }

    function validatePasswords() {
        const newPassword = document.getElementById('new-password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword !== confirmPassword) {
            alert("The new password and confirm password do not match.");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>

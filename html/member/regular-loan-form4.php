<?php
// Start the session and check if the user is logged in
session_start();

// Check if the user is logged in and if LoanID exists
if (!isset($_SESSION['MemberID']) || !isset($_SESSION['loan_application_id'])) {
    header("Location: ../../html/index.html");
    exit();
}

// Get the loan type from the URL (either 'regular' or 'collateral')
$loan_type = isset($_GET['loanType']) ? $_GET['loanType'] : 'regular';

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pmpc";

// Create connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch the LoanID from the session
    $loan_id = $_SESSION['loan_application_id'];

    // Collect form data for employment information
    $employer_name = isset($_POST['employer-name']) ? $_POST['employer-name'] : null;
    $employer_address = isset($_POST['employer-address']) ? $_POST['employer-address'] : null;
    $present_position = isset($_POST['present-position']) ? $_POST['present-position'] : null;
    $date_of_employment = isset($_POST['date-of-employment']) ? $_POST['date-of-employment'] : null;
    $monthly_income = isset($_POST['monthly-income']) ? $_POST['monthly-income'] : 0;
    $contact_person = isset($_POST['contact-person']) ? $_POST['contact-person'] : null;
    $contact_number = isset($_POST['contact-number']) ? $_POST['contact-number'] : null;
    $self_employed_business_type = isset($_POST['self-employed-type']) ? $_POST['self-employed-type'] : null;
    $business_start_date = isset($_POST['business-start']) ? $_POST['business-start'] : null;

    // Update data in the loanapplication table
    $query = "UPDATE loanapplication SET 
              employer_name = ?, 
              employer_address = ?, 
              present_position = ?, 
              date_of_employment = ?, 
              monthly_income = ?, 
              contact_person = ?, 
              contact_telephone_no = ?, 
              self_employed_business_type = ?, 
              business_start_date = ?
              WHERE LoanID = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("ssssdsdssi", 
                      $employer_name, 
                      $employer_address, 
                      $present_position, 
                      $date_of_employment, 
                      $monthly_income, 
                      $contact_person, 
                      $contact_number, 
                      $self_employed_business_type, 
                      $business_start_date,
                      $loan_id);

    if ($stmt->execute()) {
        // Redirect to next step (pass the loanType to form5.php)
        header("Location: regular-loan-form5.php?loanType=" . $loan_type);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($loan_type); ?> Loan Application - Step 4</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="stylesheet" href="../../css/regular-loan.css">
</head>
<body>

    <!-- Container for the sidebar and main content -->
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
                <li><a href="member-services.html" class="active">Services</a></li>
                <li><a href="member-inbox.html">Inbox</a></li>
                <li><a href="member-about.html">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-manageaccount.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1><?php echo ucfirst($loan_type); ?> Loan Application - Step 4</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <h2>Employment Information</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="employer-name">Employer Name</label>
                            <input type="text" id="employer-name" name="employer-name" required>
                        </div>
                        <div class="input-group">
                            <label for="employer-address">Employer Address</label>
                            <input type="text" id="employer-address" name="employer-address" required>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="present-position">Present Position</label>
                            <input type="text" id="present-position" name="present-position" required>
                        </div>
                        <div class="input-group">
                            <label for="date-of-employment">Date of Employment</label>
                            <input type="date" id="date-of-employment" name="date-of-employment">
                        </div>
                        <div class="input-group">
                            <label for="monthly-income">Monthly Income</label>
                            <input type="number" id="monthly-income" name="monthly-income" min="0" required>
                        </div>
                    </div>

                    <!-- Contact Person and Telephone Number -->
                    <div class="input-row">
                        <div class="input-group">
                            <label for="contact-person">Contact Person</label>
                            <input type="text" id="contact-person" name="contact-person" required>
                        </div>
                        <div class="input-group">
                            <label for="contact-number">Telephone Number</label>
                            <input type="tel" id="contact-number" name="contact-number" required>
                        </div>
                    </div>

                    <!-- If Self-Employed -->
                    <h2>Self-Employment Information (Optional)</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="self-employed-type">Type of Business</label>
                            <input type="text" id="self-employed-type" name="self-employed-type">
                        </div>
                        <div class="input-group">
                            <label for="business-start">Start of Business</label>
                            <input type="date" id="business-start" name="business-start">
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="submit-button">Next</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

</body>
</html>

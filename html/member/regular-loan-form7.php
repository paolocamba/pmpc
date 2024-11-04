<?php
// Start the session and check if the user is logged in
session_start();

// Check if the user is logged in and if LoanID exists
if (!isset($_SESSION['MemberID']) || !isset($_SESSION['loan_application_id'])) {
    header("Location: ../memblogin.html");
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

    // Collect form data for references
    $reference1_name = isset($_POST['ref-name'][0]) ? $_POST['ref-name'][0] : null;
    $reference1_address = isset($_POST['ref-address'][0]) ? $_POST['ref-address'][0] : null;
    $reference1_contact_no = isset($_POST['ref-contact'][0]) ? $_POST['ref-contact'][0] : null;

    $reference2_name = isset($_POST['ref-name'][1]) ? $_POST['ref-name'][1] : null;
    $reference2_address = isset($_POST['ref-address'][1]) ? $_POST['ref-address'][1] : null;
    $reference2_contact_no = isset($_POST['ref-contact'][1]) ? $_POST['ref-contact'][1] : null;

    $reference3_name = isset($_POST['ref-name'][2]) ? $_POST['ref-name'][2] : null;
    $reference3_address = isset($_POST['ref-address'][2]) ? $_POST['ref-address'][2] : null;
    $reference3_contact_no = isset($_POST['ref-contact'][2]) ? $_POST['ref-contact'][2] : null;

    // Update data in the loanapplication table
    $query = "UPDATE loanapplication SET 
              reference1_name = ?, 
              reference1_address = ?, 
              reference1_contact_no = ?, 
              reference2_name = ?, 
              reference2_address = ?, 
              reference2_contact_no = ?, 
              reference3_name = ?, 
              reference3_address = ?, 
              reference3_contact_no = ?
              WHERE LoanID = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("sssssssssi", 
                      $reference1_name, 
                      $reference1_address, 
                      $reference1_contact_no, 
                      $reference2_name, 
                      $reference2_address, 
                      $reference2_contact_no, 
                      $reference3_name, 
                      $reference3_address, 
                      $reference3_contact_no, 
                      $loan_id);

    if ($stmt->execute()) {
        // Redirect based on loan type
        if ($loan_type == 'collateral') {
            // Redirect to the collateral loan form if the loan type is collateral
            header("Location: collateral-loan-form.php?loanType=collateral&loanID=" . $loan_id);
        } else {
            // Redirect to loan summary or completion for regular loans
            header("Location: loan-summary.php?loanType=regular&loanID=" . $loan_id);
        }
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
    <title><?php echo ucfirst($loan_type); ?> Loan Application - Step 7</title>
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
                <li><a href="member-services.php">Services</a></li>
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
                <h1><?php echo ucfirst($loan_type); ?> Loan Application - Step 7</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <h2>Reference Information</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="ref-name-0">Reference 1 Name</label>
                            <input type="text" id="ref-name-0" name="ref-name[]" required>
                        </div>
                        <div class="input-group">
                            <label for="ref-address-0">Reference 1 Address</label>
                            <input type="text" id="ref-address-0" name="ref-address[]" required>
                        </div>
                        <div class="input-group">
                            <label for="ref-contact-0">Reference 1 Contact Number</label>
                            <input type="tel" id="ref-contact-0" name="ref-contact[]" required>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="ref-name-1">Reference 2 Name</label>
                            <input type="text" id="ref-name-1" name="ref-name[]" required>
                        </div>
                        <div class="input-group">
                            <label for="ref-address-1">Reference 2 Address</label>
                            <input type="text" id="ref-address-1" name="ref-address[]" required>
                        </div>
                        <div class="input-group">
                            <label for="ref-contact-1">Reference 2 Contact Number</label>
                            <input type="tel" id="ref-contact-1" name="ref-contact[]" required>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="ref-name-2">Reference 3 Name</label>
                            <input type="text" id="ref-name-2" name="ref-name[]" required>
                        </div>
                        <div class="input-group">
                            <label for="ref-address-2">Reference 3 Address</label>
                            <input type="text" id="ref-address-2" name="ref-address[]" required>
                        </div>
                        <div class="input-group">
                            <label for="ref-contact-2">Reference 3 Contact Number</label>
                            <input type="tel" id="ref-contact-2" name="ref-contact[]" required>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="submit-button">Submit Application</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

</body>
</html>

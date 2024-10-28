<?php
// Start the session and check if the user is logged in
session_start();

// Check if the user is logged in and if LoanID exists
if (!isset($_SESSION['MemberID']) || !isset($_SESSION['loan_application_id'])) {
    header("Location: ../../html/index.php");
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

    // Collect form data for debts
    $creditor1_name = isset($_POST['creditor1-name']) ? $_POST['creditor1-name'] : null;
    $creditor1_address = isset($_POST['creditor1-address']) ? $_POST['creditor1-address'] : null;
    $creditor1_original_amount = isset($_POST['creditor1-original-amount']) ? $_POST['creditor1-original-amount'] : null;
    $creditor1_present_balance = isset($_POST['creditor1-present-balance']) ? $_POST['creditor1-present-balance'] : null;
    
    $creditor2_name = isset($_POST['creditor2-name']) ? $_POST['creditor2-name'] : null;
    $creditor2_address = isset($_POST['creditor2-address']) ? $_POST['creditor2-address'] : null;
    $creditor2_original_amount = isset($_POST['creditor2-original-amount']) ? $_POST['creditor2-original-amount'] : null;
    $creditor2_present_balance = isset($_POST['creditor2-present-balance']) ? $_POST['creditor2-present-balance'] : null;
    
    $creditor3_name = isset($_POST['creditor3-name']) ? $_POST['creditor3-name'] : null;
    $creditor3_address = isset($_POST['creditor3-address']) ? $_POST['creditor3-address'] : null;
    $creditor3_original_amount = isset($_POST['creditor3-original-amount']) ? $_POST['creditor3-original-amount'] : null;
    $creditor3_present_balance = isset($_POST['creditor3-present-balance']) ? $_POST['creditor3-present-balance'] : null;
    
    $creditor4_name = isset($_POST['creditor4-name']) ? $_POST['creditor4-name'] : null;
    $creditor4_address = isset($_POST['creditor4-address']) ? $_POST['creditor4-address'] : null;
    $creditor4_original_amount = isset($_POST['creditor4-original-amount']) ? $_POST['creditor4-original-amount'] : null;
    $creditor4_present_balance = isset($_POST['creditor4-present-balance']) ? $_POST['creditor4-present-balance'] : null;

    // Other information
    $property_foreclosed_repossessed = isset($_POST['foreclosure']) && $_POST['foreclosure'] == 'yes' ? 1 : 0;
    $co_maker_cosigner_guarantor = isset($_POST['co-signer']) && $_POST['co-signer'] == 'yes' ? 1 : 0;

    // Update data in the loanapplication table
    $query = "UPDATE loanapplication SET 
              creditor1_name = ?, 
              creditor1_address = ?, 
              creditor1_original_amount = ?, 
              creditor1_present_balance = ?, 
              creditor2_name = ?, 
              creditor2_address = ?, 
              creditor2_original_amount = ?, 
              creditor2_present_balance = ?, 
              creditor3_name = ?, 
              creditor3_address = ?, 
              creditor3_original_amount = ?, 
              creditor3_present_balance = ?, 
              creditor4_name = ?, 
              creditor4_address = ?, 
              creditor4_original_amount = ?, 
              creditor4_present_balance = ?, 
              property_foreclosed_repossessed = ?, 
              co_maker_cosigner_guarantor = ?
              WHERE LoanID = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("ssddssddssddssddiii", 
                      $creditor1_name, 
                      $creditor1_address, 
                      $creditor1_original_amount, 
                      $creditor1_present_balance,
                      $creditor2_name, 
                      $creditor2_address, 
                      $creditor2_original_amount, 
                      $creditor2_present_balance,
                      $creditor3_name, 
                      $creditor3_address, 
                      $creditor3_original_amount, 
                      $creditor3_present_balance,
                      $creditor4_name, 
                      $creditor4_address, 
                      $creditor4_original_amount, 
                      $creditor4_present_balance,
                      $property_foreclosed_repossessed, 
                      $co_maker_cosigner_guarantor,
                      $loan_id);

    if ($stmt->execute()) {
        // Redirect to next step (pass the loanType to form7.php)
        header("Location: regular-loan-form7.php?loanType=" . $loan_type);
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
    <title><?php echo ucfirst($loan_type); ?> Loan Application - Step 6</title>
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
                <li><a href="member-services.html">Services</a></li>
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
                <h1><?php echo ucfirst($loan_type); ?> Loan Application - Step 6</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <h2>Debt and Liability Information</h2>

                    <!-- Creditors Fields (up to 4 creditors) -->
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="creditor<?php echo $i; ?>-name">Creditor <?php echo $i; ?> Name</label>
                            <input type="text" id="creditor<?php echo $i; ?>-name" name="creditor<?php echo $i; ?>-name">
                        </div>
                        <div class="input-group">
                            <label for="creditor<?php echo $i; ?>-address">Creditor <?php echo $i; ?> Address</label>
                            <input type="text" id="creditor<?php echo $i; ?>-address" name="creditor<?php echo $i; ?>-address">
                        </div>
                        <div class="input-group">
                            <label for="creditor<?php echo $i; ?>-original-amount">Creditor <?php echo $i; ?> Original Amount</label>
                            <input type="number" id="creditor<?php echo $i; ?>-original-amount" name="creditor<?php echo $i; ?>-original-amount" step="0.01">
                        </div>
                        <div class="input-group">
                            <label for="creditor<?php echo $i; ?>-present-balance">Creditor <?php echo $i; ?> Present Balance</label>
                            <input type="number" id="creditor<?php echo $i; ?>-present-balance" name="creditor<?php echo $i; ?>-present-balance" step="0.01">
                        </div>
                    </div>
                    <?php endfor; ?>

                    <h2>Other Information</h2>
                    <div class="form-group-vertical">
                        <p>Have you had property foreclosed or repossessed?</p>
                        <label class="radio-inline">
                            <input type="radio" name="foreclosure" value="yes" required> Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="foreclosure" value="no" required> No
                        </label>
                    </div>
    
                    <div class="form-group-vertical">
                        <p>Are you a co-maker, co-signer, or guarantor on any loan not listed above?</p>
                        <label class="radio-inline">
                            <input type="radio" name="co-signer" value="yes" required> Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="co-signer" value="no" required> No
                        </label>
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

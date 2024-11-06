<?php
// Start the session and check if the user is logged in
session_start();

// Check if the user is logged in and if LoanID exists
if (!isset($_SESSION['memberID']) || !isset($_SESSION['loan_application_id'])) {
    header("Location: ../memblogin.html");
    exit();
}

// Get the loan type from the URL (either 'regular' or 'collateral')
$loan_type = isset($_GET['loanType']) ? $_GET['loanType'] : 'regular';

include('../db_connect.php');

// Initialize variables for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch the LoanID from the session
    $loan_id = $_SESSION['loan_application_id'];

    // Collect form data for assets
    $savings_account = isset($_POST['savings-acct']) ? 1 : 0;
    $savings_bank = isset($_POST['bank-savings']) ? $_POST['bank-savings'] : null;
    $savings_branch = isset($_POST['branch-savings']) ? $_POST['branch-savings'] : null;
    $current_account = isset($_POST['current-acct']) ? 1 : 0;
    $current_bank = isset($_POST['bank-current']) ? $_POST['bank-current'] : null;
    $current_branch = isset($_POST['branch-current']) ? $_POST['branch-current'] : null;
    $asset1 = isset($_POST['asset1']) ? $_POST['asset1'] : null;
    $asset2 = isset($_POST['asset2']) ? $_POST['asset2'] : null;
    $asset3 = isset($_POST['asset3']) ? $_POST['asset3'] : null;
    $asset4 = isset($_POST['asset4']) ? $_POST['asset4'] : null;

    // Update data in the loanapplication table
    $query = "UPDATE loanapplication SET 
              savings_account = ?, 
              savings_bank = ?, 
              savings_branch = ?, 
              current_account = ?, 
              current_bank = ?, 
              current_branch = ?, 
              asset1 = ?, 
              asset2 = ?, 
              asset3 = ?, 
              asset4 = ?
              WHERE LoanID = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("ississssssi", 
                      $savings_account, 
                      $savings_bank, 
                      $savings_branch, 
                      $current_account, 
                      $current_bank, 
                      $current_branch, 
                      $asset1, 
                      $asset2, 
                      $asset3, 
                      $asset4, 
                      $loan_id);

    if ($stmt->execute()) {
        // Redirect to next step (pass the loanType to form6.php)
        header("Location: regular-loan-form6.php?loanType=" . $loan_type);
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
    <title><?php echo ucfirst($loan_type); ?> Loan Application - Step 5</title>
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
                <li><a href="member-services.php" class="active">Services</a></li>
                <li><a href="member-inbox.html">Inbox</a></li>
                <li><a href="member-about.php">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-manageaccount.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1><?php echo ucfirst($loan_type); ?> Loan Application - Step 5</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <h2>Savings and Current Account Information</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="savings-acct">Do you have a savings account?</label>
                            <input type="checkbox" id="savings-acct" name="savings-acct">
                        </div>
                        <div class="input-group">
                            <label for="bank-savings">Savings Bank Name</label>
                            <input type="text" id="bank-savings" name="bank-savings">
                        </div>
                        <div class="input-group">
                            <label for="branch-savings">Savings Branch</label>
                            <input type="text" id="branch-savings" name="branch-savings">
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="current-acct">Do you have a current account?</label>
                            <input type="checkbox" id="current-acct" name="current-acct">
                        </div>
                        <div class="input-group">
                            <label for="bank-current">Current Bank Name</label>
                            <input type="text" id="bank-current" name="bank-current">
                        </div>
                        <div class="input-group">
                            <label for="branch-current">Current Branch</label>
                            <input type="text" id="branch-current" name="branch-current">
                        </div>
                    </div>

                    <h2>Other Assets</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="asset1">Asset 1</label>
                            <input type="text" id="asset1" name="asset1">
                        </div>
                        <div class="input-group">
                            <label for="asset2">Asset 2</label>
                            <input type="text" id="asset2" name="asset2">
                        </div>
                        <div class="input-group">
                            <label for="asset3">Asset 3</label>
                            <input type="text" id="asset3" name="asset3">
                        </div>
                        <div class="input-group">
                            <label for="asset4">Asset 4</label>
                            <input type="text" id="asset4" name="asset4">
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

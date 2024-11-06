<?php
// Start the session and check if the user is logged in
session_start();

// Check if the user is logged in
if (!isset($_SESSION['memberID'])) {
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
    // Fetch the MemberID from the session
    $member_id = $_SESSION['memberID'];

    // Collect form data
    $date_of_loan = isset($_POST['date']) ? $_POST['date'] : null;
    $amount_requested = isset($_POST['amount']) ? $_POST['amount'] : null;
    $purpose = isset($_POST['purpose']) ? $_POST['purpose'] : null;
    $loan_term = isset($_POST['loan-term']) ? $_POST['loan-term'] : null;
    $mode_of_payment = isset($_POST['payment']) ? $_POST['payment'] : null;

    // Insert data into the loanapplication table
    $query = "INSERT INTO loanapplication (MemberID, DateOfLoan, AmountRequested, LoanTerm, Purpose, LoanType, ModeOfPayment) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    // Bind the parameters and execute the query
    $stmt->bind_param("issssss", $member_id, $date_of_loan, $amount_requested, $loan_term, $purpose, $loan_type, $mode_of_payment);

    if ($stmt->execute()) {
        // Store the generated LoanID in the session
        $_SESSION['loan_application_id'] = $conn->insert_id; // Store LoanID in session for future updates

        // Redirect to the next step (pass the loan type to the next form)
        header("Location: regular-loan-form2.php?loanType=" . $loan_type);
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
    <title><?php echo ucfirst($loan_type); ?> Loan Application - Step 1</title>
    <link rel="stylesheet" href="../../css/styles.css"> <!-- Link to the updated CSS -->
    <link rel="stylesheet" href="../../css/regular-loan.css"> <!-- Link to the updated CSS -->
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
                <h2 class="pmpc-text">PASCHAL</h2> <!-- PMPC text beside the logo -->
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
                <h1><?php echo ucfirst($loan_type); ?> Loan Application - Step 1</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <div class="input-row">
                        <div class="input-group">
                            <label for="date">Date of Loan</label>
                            <input type="date" id="date" name="date" required>
                        </div>
                        <div class="input-group">
                            <label for="amount">Amount Requested</label>
                            <input type="number" id="amount" name="amount" required>
                        </div>
                        <div class="input-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" id="purpose" name="purpose" required>
                        </div>
                    </div>
                    <div class="input-row">
                    <div class="input-group">
                        <label for="loan-term">Loan Term</label>
                        <select id="loan-term" name="loan-term" required>
                            <option value="" disabled selected hidden>Select Term</option>
                            <option value="3 Months">3 Months</option>
                            <option value="6 Months">6 Months</option>
                            <option value="9 Months">9 Months</option>
                            <option value="12 Months">12 Months</option>
                            <option value="15 Months">15 Months</option>
                            <option value="18 Months">18 Months</option>
                            <option value="21 Months">21 Months</option>
                            <option value="24 Months">24 Months</option>
                        </select>
                    </div>

                        <div class="input-group">
                            <label for="payment">Mode of Payment</label>
                            <select id="payment" name="payment" required>
                                <option value="" disabled selected hidden>Select Mode</option>
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Bi-Monthly">Bi-Monthly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Semi-Anual">Semi-Annual</option>
                            </select>
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

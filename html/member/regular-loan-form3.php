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

    // Collect form data for income and expenses
    $self_income = isset($_POST['self-income']) ? $_POST['self-income'] : null;
    $self_income_amount = isset($_POST['self-income-amount']) ? $_POST['self-income-amount'] : 0;
    $other_income = isset($_POST['other-income']) ? $_POST['other-income'] : null;
    $other_income_amount = isset($_POST['other-income-amount']) ? $_POST['other-income-amount'] : 0;

    $spouse_income = isset($_POST['spouse-income']) ? $_POST['spouse-income'] : null;
    $spouse_other_income = isset($_POST['spouse-other-income']) ? $_POST['spouse-other-income'] : null;
    $spouse_income_amount = isset($_POST['spouse-income-amount']) ? $_POST['spouse-income-amount'] : 0;
    $spouse_other_income_amount = isset($_POST['spouse-other-income-amount']) ? $_POST['spouse-other-income-amount'] : 0;

    // Expenses
    $food_groceries_expense = isset($_POST['food-groceries-expense']) ? $_POST['food-groceries-expense'] : 0;
    $transportation_expense = isset($_POST['transportation-expense']) ? $_POST['transportation-expense'] : 0;
    $schooling_expense = isset($_POST['schooling-expense']) ? $_POST['schooling-expense'] : 0;
    $utilities_expense = isset($_POST['utilities-expense']) ? $_POST['utilities-expense'] : 0;
    $miscellaneous_expense = isset($_POST['miscellaneous-expense']) ? $_POST['miscellaneous-expense'] : 0;
    $total_expenses = isset($_POST['total-expenses']) ? $_POST['total-expenses'] : 0;
    $net_family_income = isset($_POST['net-family-income']) ? $_POST['net-family-income'] : 0;

    // Update data in the loanapplication table
    $query = "UPDATE loanapplication SET 
              self_income = ?, 
              self_income_amount = ?, 
              other_income = ?, 
              other_income_amount = ?, 
              spouse_income = ?, 
              spouse_income_amount = ?, 
              spouse_other_income = ?, 
              spouse_other_income_amount = ?, 
              food_groceries_expense = ?, 
              gas_oil_transportation_expense = ?, 
              schooling_expense = ?, 
              utilities_expense = ?, 
              miscellaneous_expense = ?, 
              total_expenses = ?, 
              net_family_income = ? 
              WHERE LoanID = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param(
        "sdssdssdssssdddi", 
        $self_income, 
        $self_income_amount, 
        $other_income, 
        $other_income_amount, 
        $spouse_income, 
        $spouse_income_amount, 
        $spouse_other_income, 
        $spouse_other_income_amount, 
        $food_groceries_expense, 
        $transportation_expense, 
        $schooling_expense, 
        $utilities_expense, 
        $miscellaneous_expense, 
        $total_expenses, 
        $net_family_income, 
        $loan_id
    );

    if ($stmt->execute()) {
        // Redirect to next step (pass the loanType to form4.php)
        header("Location: regular-loan-form4.php?loanType=" . $loan_type);
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
    <title><?php echo ucfirst($loan_type); ?> Loan Application - Step 3</title>
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
                <li><a href="member-about.html">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-manageaccount.html">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1><?php echo ucfirst($loan_type); ?> Loan Application - Step 3</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <h2>Income Information</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="self-income">Self Income Description</label>
                            <input type="text" id="self-income" name="self-income" required>
                        </div>
                        <div class="input-group">
                            <label for="other-income">Other Income Description</label>
                            <input type="text" id="other-income" name="other-income">
                        </div>
                        <div class="input-group">
                            <label for="self-income-amount">Amount in Pesos (Self Income)</label>
                            <input type="number" id="self-income-amount" name="self-income-amount" min="0" required>
                        </div>
                        <div class="input-group">
                            <label for="other-income-amount">Amount in Pesos (Other Income)</label>
                            <input type="number" id="other-income-amount" name="other-income-amount" min="0">
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="input-group">
                            <label for="spouse-income">Spouse Income Description</label>
                            <input type="text" id="spouse-income" name="spouse-income">
                        </div>
                        <div class="input-group">
                            <label for="spouse-other-income">Spouse Other Income Description</label>
                            <input type="text" id="spouse-other-income" name="spouse-other-income">
                        </div>
                        <div class="input-group">
                            <label for="spouse-income-amount">Amount in Pesos (Spouse Income)</label>
                            <input type="number" id="spouse-income-amount" name="spouse-income-amount" min="0">
                        </div>
                        <div class="input-group">
                            <label for="spouse-other-income-amount">Amount in Pesos (Spouse Other Income)</label>
                            <input type="number" id="spouse-other-income-amount" name="spouse-other-income-amount" min="0">
                        </div>
                    </div>

                    <h2>Expenses Information</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="food-groceries-expense">Food and Groceries Expense</label>
                            <input type="number" id="food-groceries-expense" name="food-groceries-expense" min="0" required>
                        </div>
                        <div class="input-group">
                            <label for="transportation-expense">Gas, Oil, and Transportation Expense</label>
                            <input type="number" id="transportation-expense" name="transportation-expense" min="0" required>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="schooling-expense">Schooling Expense</label>
                            <input type="number" id="schooling-expense" name="schooling-expense" min="0" required>
                        </div>
                        <div class="input-group">
                            <label for="utilities-expense">Utilities Expense (Lights, Water, and Telephone)</label>
                            <input type="number" id="utilities-expense" name="utilities-expense" min="0" required>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="miscellaneous-expense">Miscellaneous Expense</label>
                            <input type="number" id="miscellaneous-expense" name="miscellaneous-expense" min="0" required>
                        </div>
                        <div class="input-group">
                            <label for="total-expenses">Total Expenses</label>
                            <input type="number" id="total-expenses" name="total-expenses" min="0" required>
                        </div>
                        <div class="input-group">
                            <label for="net-family-income">Net Family Income</label>
                            <input type="number" id="net-family-income" name="net-family-income" min="0" required>
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

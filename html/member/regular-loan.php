<?php
// Start the session and check if the user is logged in
session_start();

// Check if the user is logged in
if (!isset($_SESSION['MemberID'])) {
    header("Location: ../../html/index.php");
    exit();
}

include('../db_connect.php');

// Initialize variables for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch the MemberID from the session
    $member_id = $_SESSION['MemberID'];

    // Collect form data with validation
    $date_of_loan = isset($_POST['date']) ? $_POST['date'] : null;
    $amount_requested = isset($_POST['amount']) ? $_POST['amount'] : null;
    $purpose = isset($_POST['purpose']) ? $_POST['purpose'] : null;
    $loan_term = isset($_POST['loan-term']) ? $_POST['loan-term'] : null;
    $mode_of_payment = isset($_POST['payment']) ? $_POST['payment'] : null;
    $years_of_stay = isset($_POST['years-of-stay']) ? $_POST['years-of-stay'] : null;
    $own_house = isset($_POST['own-house']) && $_POST['own-house'] == 'yes' ? 1 : 0;
    $renting = isset($_POST['renting']) && $_POST['renting'] == 'yes' ? 1 : 0;
    $living_with_relative = isset($_POST['living-with-relative']) && $_POST['living-with-relative'] == 'yes' ? 1 : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    // Check if spouse_name exists only for non-single status
    $spouse_name = ($status !== 'Single' && isset($_POST['spouse-name'])) ? $_POST['spouse-name'] : null;

    $num_of_dependents = isset($_POST['num-of-dependents']) ? $_POST['num-of-dependents'] : 0;
    $dependents_in_school = isset($_POST['dependents-in-school']) ? $_POST['dependents-in-school'] : 0;

    // Dependents information
    $dependent1_name = isset($_POST['dependent1-name']) ? $_POST['dependent1-name'] : null;
    $dependent1_age = isset($_POST['dependent1-age']) ? $_POST['dependent1-age'] : null;
    $dependent1_grade_level = isset($_POST['dependent1-grade-level']) ? $_POST['dependent1-grade-level'] : null;
    $dependent2_name = isset($_POST['dependent2-name']) ? $_POST['dependent2-name'] : null;
    $dependent2_age = isset($_POST['dependent2-age']) ? $_POST['dependent2-age'] : null;
    $dependent2_grade_level = isset($_POST['dependent2-grade-level']) ? $_POST['dependent2-grade-level'] : null;
    $dependent3_name = isset($_POST['dependent3-name']) ? $_POST['dependent3-name'] : null;
    $dependent3_age = isset($_POST['dependent3-age']) ? $_POST['dependent3-age'] : null;
    $dependent3_grade_level = isset($_POST['dependent3-grade-level']) ? $_POST['dependent3-grade-level'] : null;
    $dependent4_name = isset($_POST['dependent4-name']) ? $_POST['dependent4-name'] : null;
    $dependent4_age = isset($_POST['dependent4-age']) ? $_POST['dependent4-age'] : null;
    $dependent4_grade_level = isset($_POST['dependent4-grade-level']) ? $_POST['dependent4-grade-level'] : null;

    // Income and expense fields
    $self_income = isset($_POST['self-income']) ? $_POST['self-income'] : 0;
    $other_income = isset($_POST['other-income']) ? $_POST['other-income'] : null;
    $self_income_amount = isset($_POST['self-income-amount']) ? $_POST['self-income-amount'] : 0;
    $other_income_amount = isset($_POST['other-income-amount']) ? $_POST['other-income-amount'] : 0;

    $spouse_income = isset($_POST['spouse-income']) ? $_POST['spouse-income'] : 0;
    $spouse_other_income = isset($_POST['spouse-other-income']) ? $_POST['spouse-other-income'] : null;
    $spouse_income_amount = isset($_POST['spouse-income-amount']) ? $_POST['spouse-income-amount'] : 0;
    $spouse_other_income_amount = isset($_POST['spouse-other-income-amount']) ? $_POST['spouse-other-income-amount'] : 0;
    $total_income = isset($_POST['total-income']) ? $_POST['total-income'] : 0;

    // Expenses
    $food_groceries_expense = isset($_POST['food-groceries-expense']) ? $_POST['food-groceries-expense'] : 0;
    $transportation_expense = isset($_POST['transportation-expense']) ? $_POST['transportation-expense'] : 0;
    $schooling_expense = isset($_POST['schooling-expense']) ? $_POST['schooling-expense'] : 0;
    $utilities_expense = isset($_POST['utilities-expense']) ? $_POST['utilities-expense'] : 0;
    $miscellaneous_expense = isset($_POST['miscellaneous-expense']) ? $_POST['miscellaneous-expense'] : 0;
    $total_expenses = isset($_POST['total-expenses']) ? $_POST['total-expenses'] : 0;
    $net_family_income = isset($_POST['net-family-income']) ? $_POST['net-family-income'] : 0;

    // Employment information
    $employer_name = isset($_POST['employer-name']) ? $_POST['employer-name'] : null;
    $employer_address = isset($_POST['employer-address']) ? $_POST['employer-address'] : null;
    $present_position = isset($_POST['present-position']) ? $_POST['present-position'] : null;
    $date_of_employment = isset($_POST['date-of-employment']) ? $_POST['date-of-employment'] : null;
    $monthly_income = isset($_POST['monthly-income']) ? $_POST['monthly-income'] : 0;
    $contact_person = isset($_POST['contact-person']) ? $_POST['contact-person'] : null;
    $contact_number = isset($_POST['contact-number']) ? $_POST['contact-number'] : null;

    // Assets
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

    // Debts
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

    // References
    $reference1_name = isset($_POST['ref-name'][0]) ? $_POST['ref-name'][0] : null;
    $reference1_address = isset($_POST['ref-address'][0]) ? $_POST['ref-address'][0] : null;
    $reference1_contact_no = isset($_POST['ref-contact'][0]) ? $_POST['ref-contact'][0] : null;
    $reference2_name = isset($_POST['ref-name'][1]) ? $_POST['ref-name'][1] : null;
    $reference2_address = isset($_POST['ref-address'][1]) ? $_POST['ref-address'][1] : null;
    $reference2_contact_no = isset($_POST['ref-contact'][1]) ? $_POST['ref-contact'][1] : null;
    $reference3_name = isset($_POST['ref-name'][2]) ? $_POST['ref-name'][2] : null;
    $reference3_address = isset($_POST['ref-address'][2]) ? $_POST['ref-address'][2] : null;
    $reference3_contact_no = isset($_POST['ref-contact'][2]) ? $_POST['ref-contact'][2] : null;

    // Query to insert data into loanapplication table
    $loan_type = 'Regular'; // Set loan type to Regular

// Correct SQL Insert query
$query = "INSERT INTO loanapplication (
    MemberID, DateOfLoan, AmountRequested, LoanTerm, Purpose, LoanType, ModeOfPayment, 
    years_stay_present_address, own_house, renting, living_with_relative, status, 
    spouse_name, number_of_dependents, dependents_in_school, dependent1_name, dependent1_age, dependent1_grade_level, 
    dependent2_name, dependent2_age, dependent2_grade_level, dependent3_name, dependent3_age, dependent3_grade_level, 
    dependent4_name, dependent4_age, dependent4_grade_level, self_income, self_income_amount, other_income, 
    other_income_amount, spouse_income, spouse_income_amount, spouse_other_income, spouse_other_income_amount, 
    total_income, food_groceries_expense, gas_oil_transportation_expense, schooling_expense, utilities_expense, 
    miscellaneous_expense, total_expenses, net_family_income, employer_name, employer_address, present_position, 
    date_of_employment, monthly_income, contact_person, contact_telephone_no, savings_account, savings_bank, 
    savings_branch, current_account, current_bank, current_branch, asset1, asset2, asset3, asset4, 
    creditor1_name, creditor1_address, creditor1_original_amount, creditor1_present_balance, creditor2_name, 
    creditor2_address, creditor2_original_amount, creditor2_present_balance, creditor3_name, creditor3_address, 
    creditor3_original_amount, creditor3_present_balance, creditor4_name, creditor4_address, creditor4_original_amount, 
    creditor4_present_balance, property_foreclosed_repossessed, co_maker_cosigner_guarantor, reference1_name, 
    reference1_address, reference1_contact_no, reference2_name, reference2_address, reference2_contact_no, 
    reference3_name, reference3_address, reference3_contact_no
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

// Corrected bind_param() to match the number of placeholders
$stmt->bind_param(
    "issssssiiiisssisssisssisssiddssssddddsssssdssssssssssssssssssssssssiiississississ",
    $member_id,
    $date_of_loan,
    $amount_requested,
    $loan_term,
    $purpose,
    $loan_type,
    $mode_of_payment,
    $years_of_stay,
    $own_house,
    $renting,
    $living_with_relative,
    $status,
    $spouse_name,
    $num_of_dependents,
    $dependents_in_school,
    $dependent1_name,
    $dependent1_age,
    $dependent1_grade_level,
    $dependent2_name,
    $dependent2_age,
    $dependent2_grade_level,
    $dependent3_name,
    $dependent3_age,
    $dependent3_grade_level,
    $dependent4_name,
    $dependent4_age,
    $dependent4_grade_level,
    $self_income,
    $self_income_amount,
    $other_income,
    $other_income_amount,
    $spouse_income,
    $spouse_income_amount,
    $spouse_other_income,
    $spouse_other_income_amount,
    $total_income,
    $food_groceries_expense,
    $transportation_expense,
    $schooling_expense,
    $utilities_expense,
    $miscellaneous_expense,
    $total_expenses,
    $net_family_income,
    $employer_name,
    $employer_address,
    $present_position,
    $date_of_employment,
    $monthly_income,
    $contact_person,
    $contact_number,
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
    $reference1_name,
    $reference1_address,
    $reference1_contact_no,
    $reference2_name,
    $reference2_address,
    $reference2_contact_no,
    $reference3_name,
    $reference3_address,
    $reference3_contact_no
);

// Execute the statement
if ($stmt->execute()) {
    // Success, redirect or display a success message
    echo "<p>Loan application submitted successfully!</p>";
} else {
    // Error handling
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regular Loan Application</title>
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
                <h1>Regular Loan Application</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <div class="input-row">
                        <div class="input-group">
                            <label for="date">Date</label>
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
                                <option value="6">6 months</option>
                                <option value="12">12 months</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="payment">Mode of Payment</label>
                            <select id="payment" name="payment" required>
                                <option value="" disabled selected hidden>Select Mode</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                            </select>
                        </div>
                    </div>

        <!-- New Section: Residence and Marital Information -->
        <section class="loan-form">
            <h2>Residence and Marital Information</h2>
            <div class="form-group-horizontal">
                <div>
                    <label for="years-of-stay">Years of stay at present address</label>
                    <input type="text" id="years-of-stay" required>
                </div>
            </div>

            <div class="form-group-horizontal">
                <label for="own-house">Own House</label>
                <select id="own-house" required>
                    <option value="" disabled selected hidden>Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="form-group-horizontal">
                <label for="renting">Renting</label>
                <select id="renting" required>
                    <option value="" disabled selected hidden>Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="form-group-horizontal">
                <label for="living-with-relative">Living with Relative</label>
                <select id="living-with-relative" required>
                    <option value="" disabled selected hidden>Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            <div class="form-group-horizontal">
                <label for="status">Status</label>
                <select id="status" required>
                    <option value="" disabled selected hidden>Select Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="widow">Widow/er</option>
                    <option value="separated">Separated</option>
                    <option value="live-in">Live-in</option>
                </select>
            </div>

            <!-- Always Display Spouse Name Input but Disable for Single -->
            <div class="input-group">
                <label for="spouse-name">Name of Spouse</label>
                <input type="text" id="spouse-name" disabled>
            </div>
        </section>


                <section class="loan-form">
                <h2>NET INCOME</h2>

                <div class="form-group-horizontal">
                    <div>
                        <label>* No. of Dependents</label>
                        <input type="text">
                    </div>
                    <div>
                        <label>* In School</label>
                        <input type="text">
                    </div>
                </div>

                <div class="dependents-section">
                    <div class="form-group">
                        <label>Dependents</label>
                        <label>Age</label>
                        <label>Grade Level</label>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" placeholder="Name">
                        <input type="text" placeholder="Age">
                        <input type="text" placeholder="Grade Level">
                    </div>
            
                    <div class="form-group">
                        <input type="text" placeholder="Name">
                        <input type="text" placeholder="Age">
                        <input type="text" placeholder="Grade Level">
                    </div>
            
                    <div class="form-group">
                        <input type="text" placeholder="Name">
                        <input type="text" placeholder="Age">
                        <input type="text" placeholder="Grade Level">
                    </div>
            
                    <div class="form-group">
                        <input type="text" placeholder="Name">
                        <input type="text" placeholder="Age">
                        <input type="text" placeholder="Grade Level">
                    </div>
                </div>

                <h3>INCOME: (Per Month)</h3>


                <div class="form-group-horizontal">
                <label><strong>Member of the Family</strong></label>
                <input type="text">
                </div>

                <div class="form-group-horizontal">
                    <div>
                        <label>Self Income</label>
                        <input type="text">
                        <label>Other Income</label>
                        <input type="text">
                    </div>
                    <div>
                        <label>Amount in Pesos</label>
                        <input type="text">
                        <label>Amount in Pesos</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-group-horizontal">
                    <div>
                        <label>Spouse Income</label>
                        <input type="text">
                        <label>Other Income</label>
                        <input type="text">
                        
                    </div>
                    <div>
                        <label>Amount in Pesos</label>
                        <input type="text">
                        <label>Amount in Pesos</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-group-horizontal">
                <label><strong>Total Income in Pesos</strong></label>
                <input type="text">
            </div>

                <h3>Expenses: (Per Month)</h3>

                <div class="form-group-horizontal">
                    <label>Food and Groceries</label>
                    <input type="text" placeholder="Expense in Pesos">
                </div>

                <div class="form-group-horizontal">
                    <label>Gas, Oil, and Transportation</label>
                    <input type="text" placeholder="Expense in Pesos">
                </div>

                <div class="form-group-horizontal">
                    <label>Schooling (Tuition and Allowance)</label>
                    <input type="text" placeholder="Expense in Pesos">            
                </div>

                <div class="form-group-horizontal">
                    <label>Lights, Water, and Telephone</label>
                    <input type="text" placeholder="Expense in Pesos">
                 </div>    

                <div class="form-group-horizontal">
                    <label>Miscellaneous</label>
                    <input type="text" placeholder="Expense in Pesos">
                </div>

            <div class="form-group-horizontal">
                <label><strong>Total Expense in Pesos</strong></label>
                <input type="text">
            </div>

            <div class="form-group-horizontal">
                <label><strong>NET FAMILY INCOME</strong></label>
                <input type="text">
            </section>
        

    <section class="loan-form">
    
        <h2>EMPLOYMENT</h2>

        <div class="form-group-horizontal">
            <div>
                <label for="employer-name">* Employer Name</label>
                <input type="text" id="employer-name" required>
            </div>
            <div>
                <label for="employer-address">* Address</label>
                <input type="text" id="employer-address" required>
            </div>
        </div>

        <div class="form-group-horizontal">
            <div>
                <label for="position">* Present Position</label>
                <input type="text" id="position" required>
            </div>
            <div>
                <label for="date-of-employment">* Date of Employment</label>
                <input type="date" id="date-of-employment" required>
            </div>
            <div>
                <label for="monthly-income">* Monthly Income</label>
                <input type="number" id="monthly-income" required>
            </div>
        </div>

        <!-- Contact Person and Telephone Number -->
        <div class="form-group-horizontal">
            <div>
                <label for="contact-person">* Contact Person</label>
                <input type="text" id="contact-person" required>
            </div>
            <div>
                <label for="contact-number">* Telephone No.</label>
                <input type="tel" id="contact-number" required>
            </div>
        </div>

        <div class="form-group-horizontal">
            <div>
                <label for="self-employed-type">* If Self-Employed, Type of Business</label>
                <input type="text" id="self-employed-type">
            </div>
            <div>
                <label for="business-start">* Start of Business</label>
                <input type="date" id="business-start">
            </div>
        </div>
    </section>

    <section class="loan-form">
        <h2>ASSETS</h2>
        
        <div class="form-group-horizontal">
            <div>
                <label for="savings-acct">Savings Account</label>
                <input type="text" id="savings-acct">
            </div>
            <div>
                <label for="bank-savings">Bank</label>
                <input type="text" id="bank-savings">
            </div>
            <div>
                <label for="branch-savings">Branch</label>
                <input type="text" id="branch-savings">
            </div>
        </div>
    
        <div class="form-group-horizontal">
            <div>
                <label for="current-acct">Current Account</label>
                <input type="text" id="current-acct">
            </div>
            <div>
                <label for="bank-current">Bank</label>
                <input type="text" id="bank-current">
            </div>
            <div>
                <label for="branch-current">Branch</label>
                <input type="text" id="branch-current">
            </div>
        </div>
    
        <div class="form-group-horizontal">
            <div>
                <label for="assets-list">List of Assets (Ari-arian)</label>
                <input type="text" id="assets-list">
            </div>
        </div>
        
        <div class="form-group-horizontal">
            <input type="text">
        </div>
    
        <div class="form-group-horizontal">
            <input type="text">
        </div>
    
        <div class="form-group-horizontal">
            <input type="text">
        </div>
        
    </section>

    <section class="loan-form">
        <h2>DEBTS</h2>
        
        <div class="debts-section">
            <div class="form-group-horizontal">
                <div>
                <label for="creditor-name">Creditor's Name</label>
                <input type="text" id="creditor-name" placeholder="Name">
                 </div>
                <div>
                <label for="creditor-address">Address</label>
                <input type="text" id="creditor-address" placeholder="Address">
                </div>
                <div>
                <label for="original-amount">Original Amount</label>
                <input type="number" id="original-amount" placeholder="Amount in Pesos">
                </div>
                <div>
                <label for="present-balance">Present Balance</label>
                <input type="number" id="present-balance" placeholder="Balance in Pesos">
                </div>
            </div>
    
            <div class="form-group-horizontal">
                <input type="text" placeholder="Name">
                <input type="text" placeholder="Address">
                <input type="number" placeholder="Amount in Pesos">
                <input type="number" placeholder="Balance in Pesos">
            </div>
    
            <div class="form-group-horizontal">
                <input type="text" placeholder="Name">
                <input type="text" placeholder="Address">
                <input type="number" placeholder="Amount in Pesos">
                <input type="number" placeholder="Balance in Pesos">
            </div>
    
            <div class="form-group-horizontal">
                <input type="text" placeholder="Name">
                <input type="text" placeholder="Address">
                <input type="number" placeholder="Amount in Pesos">
                <input type="number" placeholder="Balance in Pesos">
            </div>
        </div>
    </section>

    <section class="loan-form">
        <h2>OTHER INFORMATION</h2>
        <label> <i>IF A “YES” ANSWER IS GIVEN TO A QUESTION, EXPLAIN ON ATTACHED SHEET.<br><br></i></label>

        <div class="form-group-vertical">
            <p>1. HAVE YOU HAD PROPERTY FORECLOSED OR REPOSSESSED?</p>
            <label class="radio-inline">
                <input type="radio" name="foreclosure" value="yes" required> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="foreclosure" value="no" required> No
            </label>
        </div>
    
        <div class="form-group-vertical">
            <p>2. ARE YOU A CO-MAKER, CO-SIGNER OR GUARANTOR ON ANY LOAN NOT LISTED ABOVE?</p>
            <label class="radio-inline">
                <input type="radio" name="co-signer" value="yes" required> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="co-signer" value="no" required> No
            </label>
        </div>
    </section>

    <section class="loan-form">
        <h2>REFERENCES</h2>
        <div class="form-group-horizontal">
            <div>
                <label for="ref-name">Reference Name</label>
                <input type="text" id="ref-name" required>
                <input type="text" id="ref-name" required>
                <input type="text" id="ref-name" required>
            </div>
            <div>
                <label for="ref-address">Address</label>
                <input type="text" id="ref-address" required>
                <input type="text" id="ref-address" required>
                <input type="text" id="ref-address" required>
            </div>
            <div>
                <label for="ref-contact">Contact Number</label>
                <input type="tel" id="ref-contact" required>
                <input type="tel" id="ref-contact" required>
                <input type="tel" id="ref-contact" required>
            </div>
        </div>
    </section>

    <div class="button-group">
        <button type="submit" class="submit-button">Submit</button>
    </div>
</form>
</section>
</div>
</div>
                    
</div>
</div>

<script>
    // Disable spouse name input if marital status is single
    document.getElementById('status').addEventListener('change', function() {
        const spouseNameInput = document.getElementById('spouse-name');
        if (this.value === 'single') {
            spouseNameInput.disabled = true;
            spouseNameInput.value = ''; // Clear the input if status is single
        } else {
            spouseNameInput.disabled = false;
        }
    });
</script>

</body>
</html>

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

    // Collect form data for dependents and residence
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

    // Residence and marital information
    $years_of_stay = isset($_POST['years-of-stay']) ? $_POST['years-of-stay'] : null;
    $own_house = isset($_POST['own-house']) && $_POST['own-house'] == 'yes' ? 1 : 0;
    $renting = isset($_POST['renting']) && $_POST['renting'] == 'yes' ? 1 : 0;
    $living_with_relative = isset($_POST['living-with-relative']) && $_POST['living-with-relative'] == 'yes' ? 1 : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    // Check if spouse_name exists only for non-single status
    $spouse_name = ($status !== 'Single' && isset($_POST['spouse-name'])) ? $_POST['spouse-name'] : null;

    // Update data in the loanapplication table
    $query = "UPDATE loanapplication SET 
              number_of_dependents = ?, 
              dependents_in_school = ?, 
              dependent1_name = ?, 
              dependent1_age = ?, 
              dependent1_grade_level = ?, 
              dependent2_name = ?, 
              dependent2_age = ?, 
              dependent2_grade_level = ?, 
              dependent3_name = ?, 
              dependent3_age = ?, 
              dependent3_grade_level = ?, 
              dependent4_name = ?, 
              dependent4_age = ?, 
              dependent4_grade_level = ?, 
              years_stay_present_address = ?, 
              own_house = ?, 
              renting = ?, 
              living_with_relative = ?, 
              status = ?, 
              spouse_name = ? 
              WHERE LoanID = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("iissssssssssiiiiisssi", 
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
                      $years_of_stay, 
                      $own_house, 
                      $renting, 
                      $living_with_relative, 
                      $status, 
                      $spouse_name, 
                      $loan_id);

    if ($stmt->execute()) {
        // Redirect to next step (pass the loanType to form3.php)
        header("Location: regular-loan-form3.php?loanType=" . $loan_type);
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
    <title><?php echo ucfirst($loan_type); ?> Loan Application - Step 2</title>
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
                <h1><?php echo ucfirst($loan_type); ?> Loan Application - Step 2</h1>
            </header>

            <!-- Form Section -->
            <section class="form-section">
                <form method="POST">
                    <!-- Residence and Marital Information -->
                    <h2>Residence and Marital Information</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="years-of-stay">Years of Stay at Present Address</label>
                            <input type="number" id="years-of-stay" name="years-of-stay" min="0" required>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="own-house">Own House</label>
                            <select id="own-house" name="own-house" required>
                                <option value="" disabled selected hidden>Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="renting">Renting</label>
                            <select id="renting" name="renting" required>
                                <option value="" disabled selected hidden>Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="living-with-relative">Living with Relative</label>
                            <select id="living-with-relative" name="living-with-relative" required>
                                <option value="" disabled selected hidden>Select</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="status">Marital Status</label>
                            <select id="status" name="status" required>
                                <option value="" disabled selected hidden>Select Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Separated">Separated</option>
                                <option value="Widow/er">Widow/er</option>
                                <option value="Live-in">Live-in</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="spouse-name">Spouse Name</label>
                            <input type="text" id="spouse-name" name="spouse-name" disabled>
                        </div>
                    </div>

                    <!-- Dependents Information -->
                    <h2>Dependents Information</h2>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="num-of-dependents">Number of Dependents</label>
                            <input type="number" id="num-of-dependents" name="num-of-dependents" min="0" required>
                        </div>
                        <div class="input-group">
                            <label for="dependents-in-school">Dependents in School</label>
                            <input type="number" id="dependents-in-school" name="dependents-in-school" min="0" required>
                        </div>
                    </div>

                    <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="input-row">
                        <div class="input-group">
                            <label for="dependent<?php echo $i; ?>-name">Dependent <?php echo $i; ?> Name</label>
                            <input type="text" id="dependent<?php echo $i; ?>-name" name="dependent<?php echo $i; ?>-name">
                        </div>
                        <div class="input-group">
                            <label for="dependent<?php echo $i; ?>-age">Age</label>
                            <input type="number" id="dependent<?php echo $i; ?>-age" name="dependent<?php echo $i; ?>-age" min="0">
                        </div>
                        <div class="input-group">
                            <label for="dependent<?php echo $i; ?>-grade-level">Grade Level</label>
                            <input type="text" id="dependent<?php echo $i; ?>-grade-level" name="dependent<?php echo $i; ?>-grade-level">
                        </div>
                    </div>
                    <?php endfor; ?>

                    <div class="button-group">
                        <button type="submit" class="submit-button">Next</button>
                    </div>
                </form>
            </section>
        </div>
    </div>

    <script>
        // Disable spouse name input if marital status is single
        document.getElementById('status').addEventListener('change', function() {
            const spouseNameInput = document.getElementById('spouse-name');
            if (this.value === 'Single') {
                spouseNameInput.disabled = true;
                spouseNameInput.value = ''; // Clear the input if status is single
            } else {
                spouseNameInput.disabled = false;
            }
        });
    </script>

</body>
</html>

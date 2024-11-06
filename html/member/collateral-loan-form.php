<?php
// Start the session and check if the user is logged in
session_start();

// Check if the user is logged in and if LoanID exists
if (!isset($_SESSION['memberID']) || !isset($_SESSION['loan_application_id'])) {
    header("Location: ../memblogin.html");
    exit();
}

// Get the loan ID, MemberID, and loan type from the session or URL
$loan_id = $_SESSION['loan_application_id'];
$member_id = $_SESSION['MemberID']; // Get MemberID to rename the file
$loan_type = isset($_GET['loanType']) ? $_GET['loanType'] : 'collateral';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate that the file upload input exists and check for file upload errors
    if (isset($_FILES['file-upload'])) {
        $file_error = $_FILES['file-upload']['error'];

        // Check if there are any errors during the file upload
        if ($file_error === UPLOAD_ERR_OK) {
            // Set the target directory dynamically based on the script location
            $target_dir = __DIR__ . "/../../assets/uploads/collateral/";

            // Ensure the directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0775, true); // Create the directory if it doesn't exist
            }

            // Validate the file type (Allow only specific file types)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = mime_content_type($_FILES['file-upload']['tmp_name']);

            if (!in_array($file_type, $allowed_types)) {
                die("Error: Only JPG, PNG, and GIF files are allowed.");
            }

            // Validate the file size (Limit to 2 MB)
            $max_file_size = 2 * 1024 * 1024; // 2 MB
            if ($_FILES['file-upload']['size'] > $max_file_size) {
                die("Error: File size exceeds the 2 MB limit.");
            }

            // Extract the file extension
            $file_extension = pathinfo($_FILES['file-upload']['name'], PATHINFO_EXTENSION);

            // Rename the file using MemberID and a unique identifier
            $file_name = $member_id . '-' . uniqid() . '.' . $file_extension;
            $target_file = $target_dir . $file_name;

            // Move the file to the target directory
            if (!move_uploaded_file($_FILES['file-upload']['tmp_name'], $target_file)) {
                die("Error uploading the file. Please try again.");
            }
        } else {
            // Display appropriate error messages based on file upload error
            switch ($file_error) {
                case UPLOAD_ERR_INI_SIZE:
                    die("The uploaded file exceeds the upload_max_filesize directive in php.ini.");
                case UPLOAD_ERR_FORM_SIZE:
                    die("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.");
                case UPLOAD_ERR_PARTIAL:
                    die("The uploaded file was only partially uploaded.");
                case UPLOAD_ERR_NO_FILE:
                    die("No file was uploaded.");
                case UPLOAD_ERR_NO_TMP_DIR:
                    die("Missing a temporary folder.");
                case UPLOAD_ERR_CANT_WRITE:
                    die("Failed to write file to disk.");
                case UPLOAD_ERR_EXTENSION:
                    die("File upload stopped by a PHP extension.");
                default:
                    die("Unknown error occurred during file upload.");
            }
        }
    } else {
        die("No file was uploaded.");
    }

    // Collect form data
    $square_meters = $_POST['square-meters'];
    $type_of_land = $_POST['type-of-land'];
    $location = $_POST['location'];
    $right_of_way = $_POST['right-of-way'];

    // Individual facility values ('yes' if selected, 'no' otherwise)
    $hospital = isset($_POST['facility']) && in_array('hospital', $_POST['facility']) ? 'yes' : 'no';
    $clinic = isset($_POST['facility']) && in_array('clinic', $_POST['facility']) ? 'yes' : 'no';
    $school = isset($_POST['facility']) && in_array('school', $_POST['facility']) ? 'yes' : 'no';
    $market = isset($_POST['facility']) && in_array('market', $_POST['facility']) ? 'yes' : 'no';
    $church = isset($_POST['facility']) && in_array('church', $_POST['facility']) ? 'yes' : 'no';
    $public_terminal = isset($_POST['facility']) && in_array('public-terminal', $_POST['facility']) ? 'yes' : 'no';

    // Database connection
    include('../db_connect.php');

    // Insert collateral information into the database
    $query = "INSERT INTO collateral_info (LoanID, square_meters, type_of_land, location, right_of_way, land_title_path, hospital, clinic, school, market, church, public_terminal)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssssssssss", $loan_id, $square_meters, $type_of_land, $location, $right_of_way, $target_file, $hospital, $clinic, $school, $market, $church, $public_terminal);

    if ($stmt->execute()) {
        echo "<p>Collateral information submitted successfully!</p>";
        // Redirect to the next step or summary
        header("Location: loan-summary.php?loanType=collateral&loanID=" . $loan_id);
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
    <title>Member Services Page</title>
    <link rel="stylesheet" href="../../css/collateral-loan.css">
    <link rel="stylesheet" href="../../css/member-general.css">
</head>
<body>

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
                <li><a href="member-inbox.php">Inbox</a></li>
                <li><a href="member-about.php">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-settings.php">Settings</a></li>
            </ul>
        </div> <!-- Close sidebar -->

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Collateral Loan Application</h1>
            </header>

            <!-- Collateral Assessment Section -->
            <section class="loan-form">
                <h2>Collateral Assessment</h2>
                <!-- Combined form for both file upload and other information -->
                <form method="POST" enctype="multipart/form-data">
                    <div class="button-file">
                        <p class="note">Attach Image of Land Title<br>(CTC Copy from Registry of Deeds)</p>
                        <!-- Custom styled label to act as file input button -->
                        <label for="file-upload" class="custom-file-upload"> Choose File</label>
                        <!-- Hidden file input -->
                        <input type="file" id="file-upload" name="file-upload" required style="display: none;">
                        <!-- Display the selected file name -->
                        <p class="file-name" id="file-name">No file chosen</p>
                    </div>

                    <!-- Script to update file name display -->
                    <script>
                        const fileInput = document.getElementById('file-upload');
                        const fileNameDisplay = document.getElementById('file-name');
                        fileInput.addEventListener('change', function(event) {
                            const fileName = event.target.files[0] ? event.target.files[0].name : 'No file chosen';
                            fileNameDisplay.textContent = fileName;
                        });
                    </script>

                    <!-- Land Property Information Section -->
                    <h2>Fill up the necessary information regarding your land property</h2>
                    <div class="form-group">
                        <label for="square-meters">Square Meters:</label>
                        <input type="text" id="square-meters" name="square-meters" required>
                    </div>
                    <div class="form-group">
                        <label for="type-of-land">Type of Land:</label>
                        <select id="type-of-land" name="type-of-land" required>
                            <option value="" disabled selected hidden>Select</option>
                            <option value="Residential">Residential</option>
                            <option value="Commercial">Commercial</option>
                            <option value="Agricultural">Agricultural</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="location">Location:</label>
                        <select id="location" name="location">
                            <option value="" disabled selected hidden>Select</option>
                            <option value="Bagbaguin">Bagbaguin</option>
                                    <option value="Bagong Barrio">Bagong Barrio</option>
                                    <option value="Baka-bakahan">Baka-bakahan</option>
                                    <option value="Bunsuran I">Bunsuran I</option>
                                    <option value="Bunsuran II">Bunsuran II</option>
                                    <option value="Bunsuran III">Bunsuran III</option>
                                    <option value="Cacarong Bata">Cacarong Bata</option>
                                    <option value="Cacarong Matanda">Cacarong Matanda</option>
                                    <option value="Cupang">Cupang</option>
                                    <option value="Malibong Bata">Malibong Bata</option>
                                    <option value="Malibong Matanda">Malibong Matanda</option>
                                    <option value="Manatal">Manatal</option>
                                    <option value="Mapulang Lupa">Mapulang Lupa</option>
                                    <option value="Masagana">Masagana</option>
                                    <option value="Masuso">Masuso</option>
                                    <option value="Pinagkuartelan">Pinagkuartelan</option>
                                    <option value="Poblacion">Poblacion</option>
                                    <option value="Real de Cacarong">Real de Cacarong</option>
                                    <option value="San Roque">San Roque</option>
                                    <option value="Santo Niño">Santo Niño</option>
                                    <option value="Siling Bata">Siling Bata</option>
                                    <option value="Siling Matanda">Siling Matanda</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="right-of-way">Right of Way:</label>
                        <select id="right-of-way" name="right-of-way" required>
                            <option value="" disabled selected hidden>Select</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    <div class="vicinity">
                        <p>Commodities within the Vicinity:</p>
                        <p><i>(Check all that apply)</i></p>
                        <div class="facility-options">
                            <div class="facility-option">
                                <input type="checkbox" id="hospital" name="facility[]" value="hospital">
                                <label for="hospital">Hospital</label>
                            </div>
                            <div class="facility-option">
                                <input type="checkbox" id="market" name="facility[]" value="market">
                                <label for="market">Market</label>
                            </div>
                            <div class="facility-option">
                                <input type="checkbox" id="clinic" name="facility[]" value="clinic">
                                <label for="clinic">Clinic</label>
                            </div>
                            <div class="facility-option">
                                <input type="checkbox" id="church" name="facility[]" value="church">
                                <label for="church">Church</label>
                            </div>
                            <div class="facility-option">
                                <input type="checkbox" id="school" name="facility[]" value="school">
                                <label for="school">School</label>
                            </div>
                            <div class="facility-option">
                                <input type="checkbox" id="public-terminal" name="facility[]" value="public-terminal">
                                <label for="public-terminal">Public Terminal</label>
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="submit-button">Submit</button>
                    </div>
                </form>
            </section>
        </div> <!-- Close main-content -->
    </div> <!-- Close container -->

</body>
</html>


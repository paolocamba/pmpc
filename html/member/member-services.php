<?php
// Start the session and regenerate ID for security
session_start();
session_regenerate_id(true);

// Prevent caching to ensure secure access
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Check if the user is logged in
if (!isset($_SESSION['MemberID'])) {
    header("Location: ../../html/index.html");
    exit();
}

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pmpc";

// Connect to the database with error handling
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve MemberID from session
$member_id = $_SESSION['MemberID'];

// Fetch member details (LastName, FirstName, Email)
$member_query = "SELECT LastName, FirstName, Email FROM member WHERE MemberID = ?";
$stmt = $conn->prepare($member_query);
if ($stmt) {
    $stmt->bind_param("i", $member_id);
    if ($stmt->execute()) {
        $stmt->bind_result($last_name, $first_name, $email);
        $stmt->fetch();
    }
    $stmt->close();
}

// Handle form submission for appointments
$appointment_submitted = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_type = $_POST['service']; // Get selected service
    $appointment_date = $_POST['date'];

    // Map service name to ServiceID
    $service_map = [
        'Life Insurance' => 1,
        'Rice' => 2,
        'Space for Rent' => 3,
        'X-RAY' => 6,
        'Medical Consultation' => 4,
        'Laboratory' => 5,
        'Hilot Healom' => 7,
        'Health Card' => 8
    ];
    $service_id = $service_map[$service_type];

    // Insert appointment into appointments table
    $appointment_query = "INSERT INTO appointments (LastName, FirstName, AppointmentDate, Description, Email, MemberID, ServiceID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($appointment_query);
    if ($stmt) {
        $stmt->bind_param("sssssis", $last_name, $first_name, $appointment_date, $service_type, $email, $member_id, $service_id);
        if ($stmt->execute()) {
            $appointment_submitted = true;
        }
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Services Page</title>
    <link rel="stylesheet" href="../../css/member-services.css">
    <link rel="stylesheet" href="../../css/member-general.css">
</head>
<body>

    <div class="container">
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
                <li><a href="member-settings.php">Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <header>
                <h1>Services</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Services Section -->
            <section class="services-section">
                <!-- Products and Services -->
                <div class="service-card">
                    <h2>Products and Services</h2>
                    <ul>
                        <li>Life Insurance</li>
                        <li>Rice</li>
                        <li>Space for Rent</li>
                    </ul>
                    <button class="avail-button products-button">Avail Products</button>
                </div>

                <!-- Medical Services -->
                <div class="service-card">
                    <h2>Medical Services</h2>
                    <ul>
                        <li>Medical Consultation</li>
                        <li>Laboratory</li>
                        <li>X-RAY</li>
                        <li>Hilot Healom</li>
                        <li>Health Card</li>
                    </ul>
                    <button class="avail-button medical-button">Avail Medical</button>
                </div>

                <!-- Loan Services -->
                <div class="service-card">
                    <div class="loan-service">
                        <h2>Regular Loan</h2>
                        <button class="loan-button" onclick="showModal('modalRegularLoan')">Apply Now</button>
                    </div>

                    <div class="loan-service">
                        <h2>Collateral Loan</h2>
                        <button class="loan-button" onclick="showModal('modalCollateralLoan')">Apply Now</button>
                    </div>
                </div>

                <!-- Amortization Calculator -->
                <div class="service-card">
                    <h2>Amortization Calculator</h2>
                    <button class="loan-button" onclick="window.location.href='amortization-calculator.php'">Try Now</button>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal for Availing Products Services -->
    <div id="availProductsModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('availProductsModal')">&times;</span>
            <div class="modal-body">
                <img src="../../assets/pmpc-logo.png" alt="PMPC Logo" class="modal-logo">
                <h2>Set up Appointment</h2>
                <form method="post">
                    <label for="product-service">Choose Service</label>
                    <select id="product-service" name="service">
                        <option value="Life Insurance">Life Insurance</option>
                        <option value="Rice">Rice</option>
                        <option value="Space for Rent">Space for Rent</option>
                    </select>
                    <label for="product-date">Date</label>
                    <input type="date" id="product-date" name="date" required>
                    <button type="submit" class="submit-button">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Availing Medical Services -->
    <div id="availMedicalModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('availMedicalModal')">&times;</span>
            <div class="modal-body">
                <img src="../../assets/pmpc-logo.png" alt="PMPC Logo" class="modal-logo">
                <h2>Set up Appointment</h2>
                <form method="post">
                    <label for="medical-service">Choose Service</label>
                    <select id="medical-service" name="service">
                        <option value="X-RAY">X-RAY</option>
                        <option value="Medical Consultation">Medical Consultation</option>
                        <option value="Laboratory">Laboratory</option>
                        <option value="Hilot Healom">Hilot Healom</option>
                        <option value="Health Card">Health Card</option>
                    </select>
                    <label for="medical-date">Date</label>
                    <input type="date" id="medical-date" name="date" required>
                    <button type="submit" class="submit-button">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Regular Loan -->
    <div id="modalRegularLoan" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('modalRegularLoan')">&times;</span>
            <div class="modal-body">
                <img src="../../assets/pmpc-logo.png" alt="PMPC Logo" class="modal-logo">
                <h2>Regular Loan</h2>
                <p>Apply for a Regular Loan and get up to 90% of your share capital and savings deposits. Convenient access to funds while leveraging your savings!</p>
                <a href="regular-loan-form1.php?loanType=regular" class="button-link">Go to Application</a>
            </div>
        </div>
    </div>

    <!-- Modal for Collateral Loan -->
    <div id="modalCollateralLoan" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('modalCollateralLoan')">&times;</span>
            <div class="modal-body">
                <img src="../../assets/pmpc-logo.png" alt="PMPC Logo" class="modal-logo">
                <h2>Collateral Loan</h2>
                <p>Apply for a Collateral Loan using your land title and get up to 50% of your collateral's value to cover your financial needs!</p>
                <a href="regular-loan-form1.php?loanType=collateral" class="button-link">Go to Application</a>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeModal('confirmationModal')">&times;</span>
            <div class="modal-body">
                <img src="../../assets/pmpc-logo.png" alt="PMPC Logo" class="modal-logo">
                <h2>Appointment Submitted Successfully</h2>
                <p>Wait for confirmation from the service provider.</p>
                <button onclick="closeModal('confirmationModal')" class="submit-button">OK</button>
            </div>
        </div>
    </div>

    <script>
        // Function to open the modal
        function showModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "flex"; // Show modal
        }

        // Function to close the modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none"; // Hide modal
        }

        // Close the modal if clicking outside of it
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none"; // Hide modal if clicked outside
            }
        };

        // Ensure buttons are only added after DOM is loaded
        document.addEventListener("DOMContentLoaded", function() {
            // Get the buttons for Products and Medical Services
            var productsButton = document.querySelector(".products-button");
            var medicalButton = document.querySelector(".medical-button");

            // Assign event listeners to buttons for opening specific modals
            productsButton.onclick = function() {
                document.getElementById("availProductsModal").style.display = "flex";
            };

            medicalButton.onclick = function() {
                document.getElementById("availMedicalModal").style.display = "flex";
            };

            // Show confirmation modal if appointment is submitted
            <?php if ($appointment_submitted): ?>
                showModal('confirmationModal');
            <?php endif; ?>

            // Close modal functionality for close buttons
            document.querySelectorAll('.close-button').forEach(function(closeBtn) {
                closeBtn.onclick = function() {
                    var modal = closeBtn.closest('.modal');
                    modal.style.display = "none"; // Hide the closest modal
                }
            });
        });
    </script>

</body>
</html>

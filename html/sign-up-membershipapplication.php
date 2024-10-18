<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "pmpc";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collect form data
    $firstName = $_POST['first-name'];
    $middleName = $_POST['middle-name'];
    $lastName = $_POST['last-name']; 
    $gender = $_POST['gender'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $municipality = $_POST['municipality'];
    $province = $_POST['province'];
    $tin = $_POST['tin'];
    $birthday = $_POST['birthday'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username']; // Added username input
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password storage

    // Insert data into address table
    $address_sql = "INSERT INTO address (Street, Barangay, Municipality, Province)
                    VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($address_sql);
    $stmt->bind_param("ssss", $street, $barangay, $municipality, $province);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $addressID = $stmt->insert_id; // Get the last inserted AddressID
        
        // Insert data into members table
        $member_sql = "INSERT INTO member (FirstName, MiddleName, LastName, Sex, AddressID, TINNumber, Birthday, ContactNo, Email)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($member_sql);
        $stmt->bind_param("sssssisss", $firstName, $middleName, $lastName, $gender, $addressID, $tin, $birthday, $phone, $email);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $memberID = $stmt->insert_id; // Get the last inserted MemberID
            
            // Insert into member_credentials table
            $credentials_sql = "INSERT INTO member_credentials (MemberID, Username, Email, Password)
                                VALUES (?, ?, ?, ?)";
            
            $stmt = $conn->prepare($credentials_sql);
            $stmt->bind_param("isss", $memberID, $username, $email, $password);
            $stmt->execute();
            
            if ($stmt->affected_rows > 0) {
                header("Location: sign-up-videoseminar.php"); // Redirect to the next page
                exit();
            } else {
                echo "Error: " . $credentials_sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $member_sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $address_sql . "<br>" . $conn->error;
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
    <title>Sign Up | Membership Application</title>
    <link rel="stylesheet" href="../css/style.css">  <!-- Main styles -->
    <link rel="stylesheet" href="../css/sign-up-membershipapplication.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="topnav">
        <div class="logo-container">
            <img src="../assets/pmpc-logo.png" alt="PMPC Logo" class="logo">
            <a href="index.html" class="logo-text">PASCHAL</a>
        </div>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="services.html">Services</a>
            <a href="benefits.html">Benefits</a>
            <a href="about.html">About</a>
            <a href="signup.html" class="active">Sign Up</a>
            <a href="apply-loan.html" class="apply-loan">Apply for Loan</a>
        </div>
    </div>

    <!-- Sign Up Content -->
    <div class="signup-container">
        <form class="signup-form" action="sign-up-membershipapplication.php" method="POST">
            <h2>Sign Up | Membership Application</h2>
            <p>To register, please fill out the information below.</p>

            <div class="form-grid">
                <div class="form-row">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" required>
                </div>
                <div class="form-row">
                    <label for="middle-name">Middle Name</label>
                    <input type="text" id="middle-name" name="middle-name">
                </div>
                <div class="form-row">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name" required>
                </div>
                <div class="form-row">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
    
                <div class="form-row">
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" required>
                </div>
                <div class="form-row">
                    <label for="barangay">Barangay</label>
                    <input type="text" id="barangay" name="barangay" required>
                </div>
                <div class="form-row">
                    <label for="municipality">Municipality</label>
                    <input type="text" id="municipality" name="municipality" required>
                </div>
                <div class="form-row">
                    <label for="province">Province</label>
                    <input type="text" id="province" name="province" required>
                </div>
                <div class="form-row">
                    <label for="tin">TIN No. (Required)</label>
                    <input type="text" id="tin" name="tin" required>
                </div>
                <div class="form-row">
                    <label for="birthday">Birthday</label>
                    <input type="date" id="birthday" name="birthday" required>
                </div>
                <div class="form-row">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="form-row">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-row">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required> <!-- Added username field -->
                </div>
                <div class="form-row">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-row">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
            </div>

            <div class="navigation-buttons">
                <a href="sign-up-typemembership.html" class="nav-button prev-button">Previous</a>
                <button type="submit" class="nav-button next-button">Next</button>
            </div>
        </form>
    </div>
</body>
</html>

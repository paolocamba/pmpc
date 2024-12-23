<?php
// Start the session and regenerate ID for security
session_start();
session_regenerate_id(true);

// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

// Check if the user is logged in
if (!isset($_SESSION['memberID'])) {
    header("Location: ../memblogin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member About Page</title>
    <link rel="stylesheet" href="../../css/member-about.css"> <!-- Linking CSS -->
    <link rel="stylesheet" href="../../css/member-general.css">
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
                <li><a href="member-services.php">Services</a></li>
                <li><a href="member-inbox.php">Inbox</a></li>
                <li><a href="member-about.php" class="active">About</a></li>
            </ul>
            <ul class="sidebar-settings">
                <li><a href="member-settings.php">Settings</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>About Us</h1>
                <button class="logout-button" onclick="window.location.href='../logout.php'">Log out</button>
            </header>

            <!-- Vision and Mission Section -->
            <section class="vision-mission-section">
                <div class="vision">
                    <img src="../../assets/vision-mission.png" alt="Vision Image">
                    <h2>VISION</h2>
                    <p>"A model cooperative responsive for the total development of its members and the community."</p>
                </div>
                <div class="mission">
                    <img src="../../assets/vision-mission.png" alt="Mission Image">
                    <h2>MISSION</h2>
                    <p>"To share talent, time & treasure for the total development of the members and the community."</p>
                </div>
            </section>

            <!-- Foundation Section -->
            <section class="foundation-section">
                <h2>PUNDASYON NG PASCHAL COOP</h2>
                <div class="foundation-info">
                    <p><strong>Bakit Paschal Coop?</strong> hango sa Paschal Mystery dahil itinatag sa araw ng Linggo ng Pagkabuhay.</p>
                    <p><strong>Kailan Itinatag?</strong> Abril 7, 2007</p>
                    <p><strong>Sino-sino ang Nagtatag?</strong> Carmen Pascual-Santa Maria, mga anak at manugang.</p>
                </div>

                <div class="founders-list">
                    <h3>Mga Piling Kasapi:</h3>
                    <ul>
                        <li>Rev. Fr. Jovy Sebastian - Parish Priest</li>
                        <li>Henry/Rona Marquez - Public Servant, Businessman</li>
                        <li>Dr. Maria Visaya - SM Clinic, Businesswoman</li>
                        <li>Kap. Mario Obispo - Brgy. Capt.-Bunsuran 1st</li>
                        <li>Puring Muriel - Retiree</li>
                        <li>Dr. Rachel Oca - Professor</li>
                        <li>Diosela Salazar - Principal</li>
                        <li>Mauro Casupanan - Businessman</li>
                        <li>Janeth Baldeo - Professor</li>
                        <li>Boyet Santos - Tricycle Operator</li>
                        <li>Rosie Ramos - Owner of province rentals</li>
                        <li>Resty & Ofel Marquez - Hog Raisers</li>
                    </ul>
                </div>
            </section>
        </div>
    </div>

    <script>
        function redirectToIndex() {
            window.location.href = "../../html/index.php";
        }
    </script>

</body>
</html>

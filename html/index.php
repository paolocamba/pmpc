<?php
session_start();

include('db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PASCHAL Multi-Purpose Cooperative</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

</head>
<body>

<!-- Navbar Section -->
<div class="topnav">
    <!-- Logo and PASCHAL Text -->
    <div class="logo-container">
        <img src="../assets/pmpc-logo.png" alt="PMPC Logo" class="logo">
        <a href="index.php" class="logo-text">PASCHAL</a>
    </div>
  
    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="index.php" class="active">Home</a>
        <a href="services.html">Services</a>
        <a href="benefits.html">Benefits</a>
        <a href="about.html">About</a>
        <a href="signup.html" class="signup">Sign Up</a>
        <a href="apply-loan.html" class="apply-loan">Apply for Loan</a>
    </div>
</div>

<!-- Welcome Section -->
<section class="welcome-section">
    <div class="welcome-text">
        <h1>Welcome to <span>PASCHAL</span></h1>
        <h2>Multi-Purpose Cooperative</h2>
        <p>Tulay sa Pag-unlad</p>
        <button class="services-btn" onclick="window.location.href='services.html'">Our Services</button>
    </div>
    <div class="coop-image">
        <img src="../assets/paschal.png" alt="Paschal Coop Building">
    </div>
</section>

<!-- Events and Latest News Section -->
<section class="events-section">
    <h2>Events and Latest News</h2>
    <div class="events-container">
        <?php
        // Fetch events from the database
        $sql = "SELECT title, event_date, event_description, image FROM events ORDER BY event_date DESC LIMIT 5";
        $result = $conn->query($sql);

        // Check if events are available
        if ($result->num_rows > 0) {
            // Loop through each event
            while ($row = $result->fetch_assoc()) {
                echo '<div class="event-card">';
                echo '<img src="/pmpc/assets/uploads/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '" class="event-image">';
                echo '<h3>' . htmlspecialchars($row["title"]) . '</h3>';
                echo '<p class="event-date">Date: ' . htmlspecialchars($row["event_date"]) . '</p>';
                echo '<p>' . htmlspecialchars($row["event_description"]) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No events available.</p>';
        }
        ?>
    </div>
</section>

<!-- Behind the Success Section -->
<section class="success-section">
    <h2>Behind the Success</h2>
    <p>Ang unang tanggapan ng Paschal Coop ay sa bahay ng namayapang Carmen Pascual-Sta.Maria, ina ng mga magkakapatid na nagtatag ng kooperatiba.</p>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/" frameborder="0" allowfullscreen></iframe>
</section>

<!-- Map Section -->
<section class="map-section">
    <h2>Find Us Here</h2>
    <div class="map-container">
    <iframe 
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.3068439400313!2d120.94440701035256!3d14.86411088559424!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ac7f512d6cb9%3A0xfbb772793f32d2b6!2sPaschal%20Multipurpose%20Cooperative!5e0!3m2!1sen!2sph!4v1730049819193!5m2!1sen!2sph" 
  width="600" 
  height="450" 
  style="border:0;" 
  allowfullscreen="" 
  loading="lazy">
</iframe>

</section>

<!-- Footer -->
<footer>
    <div class="footer-container">
        <div class="footer-title">
            <h3>PASCHAL MULTIPURPOSE COOPERATIVE</h3>
        </div>

        <!-- Contact Information Section -->
        <div class="footer-contact">
            <div class="contact-info">
                <p>Corner Acacia St., Bunsuran 1st, Pandi, Bul.</p>
                <p>Main Office</p>
            </div>
            <div class="contact-info">
                <p>0917-520-1287 / 0932-864-5536</p>
                <p>Contact Number</p>
            </div>
        </div>

        <!-- Social Media and Email Section -->
        <div class="footer-social">
            <div class="social-info">
                <p><a href="https://www.facebook.com/paschalcoop">facebook.com/paschalcoop</a></p>
                <p>Facebook</p>
            </div>
            <div class="social-info">
                <p><a href="mailto:paschal_mpc@yahoo.com">paschal_mpc@yahoo.com</a></p>
                <p>Email</p>
            </div>
        </div>

        <hr>
        
        <!-- Footer Bottom Section -->
        <div class="footer-bottom">
            <p>©2024 | PASCHAL Multi-Purpose Cooperative. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>

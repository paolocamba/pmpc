<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: ../../html/index.html"); // Redirect to the login page or homepage
exit();
?>
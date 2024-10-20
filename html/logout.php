<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Correct relative URL path
header("Location: /pmpc/html/about.html");

exit();

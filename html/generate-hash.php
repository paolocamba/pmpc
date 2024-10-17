<?php
// The password you want to hash
$password = "12345678"; // Change this to the password you want to hash

// Generate the password hash
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
echo "Generated Hash: " . $hashedPassword;
?>

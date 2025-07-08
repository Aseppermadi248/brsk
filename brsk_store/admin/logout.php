<?php
session_start();
// Destroy the session
session_destroy();

// Redirect to the login page or homepage
header("Location: ../index.php"); // Or header("Location: index.php"); if you prefer the admin login page
exit();
?>
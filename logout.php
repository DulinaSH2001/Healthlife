<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to sign-in page
header("Location: signin.php");
exit();
?>
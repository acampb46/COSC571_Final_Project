<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user back to the login page after logout
header("Location: login.php");
exit();
?>
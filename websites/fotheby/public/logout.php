<?php
// Start the session (required to access session variables)
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the current session
session_destroy();

// Redirect the user to the homepage
header("Location: index.php");
exit; // Ensure no further code is executed after redirect
?>
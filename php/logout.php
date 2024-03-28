<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other desired page
header("Location: ../html/login.html");
exit; // Make sure to exit after redirecting
?>


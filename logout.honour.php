<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete the user cookie
$cookie_name = "user";
setcookie($cookie_name, "", time() - 3600, "/"); // Set the cookie's expiration time to the past

// Redirect to the login page or any other desired location
header("Location: ?p=login");
exit();
?>

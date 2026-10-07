<?php
session_start();

// Remove specific session variables
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_NAME']);
unset($_SESSION['USER_TYPE_ID']);

// Destroy complete session
session_destroy();

// Redirect to login page
header("Location: ../index.php");
exit();
?>
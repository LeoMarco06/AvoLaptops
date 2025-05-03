<?php
// Start a session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['id'])) {
    // If no session or cookie, redirect to login page
    header("Location: ../index.php");
    exit();
}
?>
<?php
$check = true;
$path = "../";
include_once '../page/header_navbar.php';

$conn = connectToDatabase();

// Elimina il cookie
setcookie("login_token", "", time() - 3600, "/", "", false, true);

session_unset();
session_destroy();

header("Location: ../homepage.php");

exit;
?>
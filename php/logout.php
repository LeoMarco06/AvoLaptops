<?php
session_start();

include './include/connection.php';

$conn = connectToDatabase();

// Elimina il cookie
setcookie("login_token", "", time() - 3600, "/", "", false, true);

session_unset();
session_destroy();

header("Location: ../index.php");

exit;
?>
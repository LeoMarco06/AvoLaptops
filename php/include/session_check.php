<?php
include $path . "include/connection.php";

$conn = connectToDatabase();

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(0); // Session expires when browser closes
    session_start();
}

if ($check) {
    // Check if there is the admin logged in
    if ($admin && $_SESSION['role'] != 1) {
        // Admin is logged in, no action needed
        header("Location: " . $path . "homepage.php");
        exit();
    }
    // Check if the login_token cookie exists
    if (isset($_COOKIE['login_token'])) {
        $loginToken = $_COOKIE['login_token'];

        // Query the database to validate the token and retrieve the user ID
        $stmt = $conn->prepare("SELECT u_id, u_email, u_role FROM users WHERE u_token = ?");
        $stmt->bind_param("s", $loginToken);
        $stmt->execute();
        $result = $stmt->get_result();

        $stmt = $conn->prepare("SELECT u_id, u_email, u_role FROM users WHERE u_token = ?");
        $stmt->bind_param("s", $loginToken);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['u_id']; // Set the user ID in the session
            $_SESSION['email'] = $row['u_email'];
            $_SESSION['role'] = $row['u_role'];
        } else {
            // Invalid token, redirect to login page
            header("Location: " . $path . "user/login.php");
            exit();
        }
    } else if (!isset($_SESSION['id']) && !isset($_COOKIE['login_token'])) {
        // No session or valid cookie, redirect to login page
        header("Location: " . $path . "user/login.php");
        exit();
    }
}
?>
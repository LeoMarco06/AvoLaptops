<?php
// filepath: /opt/lampp/htdocs/AvoLaptops/php/user/register_handler.php
$check = false;
$path = "../";
include_once $path . "include/session_check_.php";
include_once $path . "include/functions/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = connectToDatabase();

    // Validate inputs using the checkRegisterInput function
    $errors = checkRegisterInput($_POST);

    if (!empty($errors)) {
        // Handle errors (e.g., display them to the user)
        foreach ($errors as $field => $error) {
            echo "<script>alert('$error');</script>";
        }
        // Redirect to the registration page if there are errors
        redirect("./register.php");
        exit();
    }

    // Sanitize inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $name = htmlspecialchars(trim($_POST['name']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $dateOfBirth = htmlspecialchars(trim($_POST['date']));
    $password = $_POST['password'];
    $role = 10; // Default role for new users
    $authorized = 0; // Default authorization status

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (u_email, u_name, u_surname, u_date_of_birth, u_password, u_role, u_authorized) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssii", $email, $name, $surname, $dateOfBirth, $hashedPassword, $role, $authorized);

    if ($stmt->execute()) {
        echo "<script>alert('Registrazione completata con successo. Attendi la verifica dell'admin.');</script>";
        header("Location: ./login.php");
        exit();
    } else {
        echo "<script>alert('Errore durante la registrazione: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
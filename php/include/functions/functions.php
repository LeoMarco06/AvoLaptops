<?php
// Set the timezone
date_default_timezone_set('Europe/Rome');

/**
 * Method that validate the user's inputs in the register page.
 * @param mixed $data
 * @return string[]
 */
function checkRegisterInput($data)
{
    $errors = [];

    // Email validation
    if (empty($data['email'])) {
        $errors['email'] = "L'email è obbligatoria";
    } elseif (!preg_match('/[a-z0-9._%+\-]+@itisavogadro.it$/i', $data['email'])) {
        $errors['email'] = "Inserisci un indirizzo email valido del dominio itisavogadro";
    }

    // Name validation
    if (empty($data['name'])) {
        $errors['name'] = "Il nome è obbligatorio";
    } elseif (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s\']+$/u', $data['name'])) {
        $errors['name'] = "Il nome può contenere solo lettere e spazi";
    }

    // Last name validation
    if (empty($data['surname'])) {
        $errors['surname'] = "Il cognome è obbligatorio";
    } elseif (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s\']+$/u', $data['surname'])) {
        $errors['surname'] = "Il cognome può contenere solo lettere e spazi";
    }

    // Password validation
    if (empty($data['password'])) {
        $errors['password'] = "La password è obbligatoria";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,}$/', $data['password'])) {
        $errors['password'] = "La password deve contenere: 8+ caratteri, 1 maiuscola, 1 minuscola, 1 numero, 1 carattere speciale";
    }

    // Confirm password validation
    if (empty($data['confirm-password'])) {
        $errors['confirm-password'] = "Conferma password obbligatoria";
    } elseif ($data['password'] !== $data['confirm-password']) {
        $errors['confirm-password'] = "Le password non coincidono";
    }

    return $errors;
}

/**
 * Method that validate the user's inputs in the login page.
 * @param mixed $data
 * @return string[]
 */
function checkLoginInput($data)
{
    $errors = [];

    // Email validation
    if (empty($data['email'])) {
        $errors['email'] = "L'email è obbligatoria";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Formato email non valido";
    } elseif (!preg_match('/@itisavogadro.it$/i', $data['email'])) {
        $errors['email'] = "L'email deve appartenere al dominio \"itisavogadro.it\"";
    }

    // Password validation
    if (empty($data['password'])) {
        $errors['password'] = "La password è obbligatoria";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,}$/', $data['password'])) {
        $errors['password'] = "La password deve contenere: 8+ caratteri, 1 maiuscola, 1 minuscola, 1 numero, 1 carattere speciale";
    }

    return $errors;
}

/**
 * Method that print all the user's form errors.
 * @param mixed $errors
 * @return void
 */
function showFormErrors($errors)
{
    $message = 'Errors:\n\n';
    foreach ($errors as $error) {
        $message .= 'Error[' . $error . ']\n--------------------------------------------------\n';
    }
    alert($message);
}

/**
 * Method that redirect the user to another page.
 * @param mixed $location
 * @return void
 */
function redirect($location)
{
    echo '<script>window.location.assign("' . htmlspecialchars($location) . '")</script>';
}

/**
 * Method that shows an alert to the user
 * @param mixed $message
 * @return void
 */
function alert($message)
{
    echo '<script>alert("' . htmlspecialchars($message) . '")</script>';
}


/**
 * Method that checks if the user is logged in.
 * @return void
 */
function checkLogin($url)
{
    if (!isset($_SESSION['id'])) {
        redirect($url);
        exit;
    } else if (!isset($_SESSION['id']) && !isset($_COOKIE['login_token'])) {

        echo "<script>alert('Devi essere loggato per accedere a questa pagina.');</script>";

        $conn = connectToDatabase();
        $token = $_COOKIE['login_token'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE u_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $user = $result->fetch_assoc()) {
            // Token valido, ricrea la sessione
            $_SESSION['id'] = $user['u_id'];
            $_SESSION['email'] = $user['u_email'];
        }
    }
}

/**
 * Method that generates a secure token.
 * @param int $length
 * @return string
 */
function generateSecureToken($length = 64)
{
    return bin2hex(random_bytes($length / 2));
}
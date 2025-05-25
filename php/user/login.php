<!DOCTYPE html>
<html lang="it" data-theme="light">

<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Login</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the authentication styles sheet -->
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that validates the form -->
    <script src="../../js/validation_login.js" defer></script>
</head>

<body>
    <?php
    $check = false;
    $path = "../";
    include_once '../page/header_navbar.php';
    ?>

    <main>
        <section class="auth-section" id="login">
            <div class="main-container">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2 class="heading-2">Accedi al tuo account</h2>
                        <p>Inserisci le tue credenziali scolastiche per accedere al servizio</p>
                    </div>

                    <form id="login-form" class="auth-form" action="" method="post">
                        <div class="form-group">
                            <label for="email">Email scolastica</label>
                            <div class="input-group">
                                <i class="fas fa-envelope" id="email-icon"></i>
                                <input type="text" id="email" name="email" placeholder="nome.cognome@itisavogadro.it"
                                    required>
                                <!-- La email deve appartenere al dominio: @itisavogadro.it -->
                            </div>
                            <div id="emailFeedback" style="display: none;"></div>
                            <div id="verificationResult" class="verification-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock" id="password-icon"></i>
                                <input type="password" id="password" name="password" placeholder="La tua password"
                                    required>
                                <button type="button" class="btn-icon password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordFeedback" style="display: none;"></div>
                        </div>

                        <div class="form-options">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Ricordami</label>
                            </div>
                            <!--
                            Password dimenticata, da implementare in futuro
                            <a href="#" class="forgot-password">Password dimenticata?</a>
                            -->
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" onclick="validateForm()">Accedi</button>

                        <div class="auth-footer">
                            <p>Non hai un account? <a href="register.php">Registrati</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "../page/footer.php" ?>

</body>

<?php

include_once '../include/functions/functions.php';

$conn = connectToDatabase();

echo '<script>
    const cookieName = "login_token"; 
    document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; Secure`;
    console.log("Cookie deleted: " + cookieName);
</script>';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];//htmlspecialchars($_POST['password']);
    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE u_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['u_password'])) {
                $_SESSION['id'] = $row['u_id'];
                $_SESSION['email'] = $row['u_email'];
                $_SESSION['role'] = $row['u_role'];

                echo "<script>alert('Accesso effettuato con successo.');</script>";

                if (isset($_POST['remember'])) {
                    //$token = generateSecureToken();

                    // Salva il token nel DB
                    /*$update = $conn->prepare("UPDATE users SET u_token = ? WHERE u_id = ?");
                    $update->bind_param("si", $token, $row['u_id']);
                    $update->execute();*/

                    $stmt = $conn->prepare("SELECT u_token FROM users WHERE u_id = ?;");
                    $stmt->bind_param("i", $row['u_id']);

                    // Execute the statement
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->get_result();

                    // Fetch the value
                    $token = $result->fetch_assoc()['u_token'];


                    // Imposta il cookie (scade tra 30 giorni)
                    //setcookie("login_token", $token, time() + (86400 * 30), "/", "", true, true);
                    echo '<script>
                        const token = "' . $token . '";
                        const expiryDate = new Date();
                        expiryDate.setDate(expiryDate.getDate() + 30); // Set expiration for 30 days
                        document.cookie = `login_token=${token}; expires=${expiryDate.toUTCString()}; path=/; Secure`;
                    </script>';
                }

                echo "<script>window.location.href = '../reservation/prenota.php';</script>";
            } else {
                echo "<script>alert('Password errata.');</script>";
            }
        }

    } else {
        echo "<script>alert('Email o password errati.');</script>";
    }
}

?>

</html>
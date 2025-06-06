<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Nuova password</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the custom styles sheet -->
    <link rel="stylesheet" href="../../css/custom_inputs.css">

    <!-- Link to the authentication styles sheet -->
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that validate password input... -->
    <script src="../../js/edit_password.js" defer></script>

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>
</head>

<body>
    <?php
    $check = true;
    $path = "../";
    $admin = false;
    include_once '../page/header_navbar.php';
    ?>

    <main>
        <section class="auth-section" id="register">
            <div class="main-container">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2 class="heading-2">Modifica la tua password</h2>
                        <p>Inserisci la vecchia password e la tua nuova password per modificarla.</p>
                    </div>

                    <form id="register-form" class="auth-form" action="" method="post">
                        <div class="form-group">
                            <label for="old-password">Vecchia password</label>
                            <div class="input-group">
                                <i class="fas fa-lock" id="old-password-icon"></i>
                                <input type="password" id="old-password" name="old-password"
                                    placeholder="La tua vecchia password" required>
                                <button type="button" class="btn-icon password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="oldPasswordFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="new-password">Nuova password</label>
                            <div class="input-group">
                                <i class="fas fa-lock" id="new-password-icon"></i>
                                <input type="password" id="new-password" name="new-password"
                                    placeholder="La tua nuova password" required>
                                <button type="button" class="btn-icon password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small>Deve contenere: almeno 8 caratteri, 1 maiuscola, 1 minuscola, 1 numero, 1 speciale
                                (!@#$%^&*)</small>
                            <div id="newPasswordFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="confirm-password">Conferma nuova password</label>
                            <div class="input-group">
                                <i class="fas fa-lock" id="confirm-password-icon"></i>
                                <input type="password" id="confirm-password" name="confirm-password"
                                    placeholder="Conferma la tua nuova password" required>
                                <button type="button" class="btn-icon password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="confirmPasswordFeedback" class="feedback-message"></div>
                        </div>
                        <div class="buttons_div">
                            <button type="submit" class="btn btn-primary btn-block" id="save-button">Salva</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "../page/footer.php" ?>

</body>

</html>


<?php
include_once '../include/functions/functions.php';
session_start();

$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if (isset($_POST['old-password']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Le password non corrispondono.');</script>";
        exit();
    }

    $userId = $_SESSION['id'];

    // Check if the old password is correct
    $stmt = $conn->prepare("SELECT u_password FROM users WHERE u_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $hashedOldPassword = $row['u_password'];
        if (password_verify($oldPassword, $hashedOldPassword)) {
            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the password in the database
            $stmt = $conn->prepare("UPDATE users SET u_password = ?, u_token= ? WHERE u_id = ?");
            $token = generateSecureToken();
            $stmt->bind_param("ssi", $hashedNewPassword, $token, $userId);
            if ($stmt->execute()) {
                echo "<script>alert('La tua password è stata aggiornata con successo.');</script>";
                header("Location: ./account.php");
                exit();
            } else {
                echo "<script>alert('Si è verificato un errore durante l\'aggiornamento della password.');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('La vecchia password non è corretta.');</script>";
        }
    } else {
        echo "<script>alert('Utente non trovato.');</script>";
    }
    $stmt->close();
}
?>
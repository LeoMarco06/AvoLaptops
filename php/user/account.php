<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Account</title>

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

    <!-- Script that manages the date picker UX... -->
    <script src="../../js/date_picker.js" defer></script>

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that validates the form -->
    <script src="../../js/validation_account.js" defer></script>

    <!-- Script for the account buttons -->
    <script src="../../js/account_setup_page.js" defer></script>
</head>

<body>
    <?php
    $check = true;
    $path = "../";
    $admin = false;
    include_once $path . 'page/header_navbar.php';
    include_once $path . "include/functions/functions.php";

    $conn = connectToDatabase();

    $sql = "SELECT u_name, u_surname, u_date_birth, u_email FROM users WHERE u_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($name, $surname, $date_birth, $email);
    $stmt->fetch();
    $stmt->close();
    ?>

    <main>
        <section class="auth-section" id="register">
            <div class="main-container">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2 class="heading-2">Il tuo account</h2>
                        <p>Visualizza i dati del tuo account e modificali se necessario.</p>
                    </div>

                    <form id="register-form" class="auth-form" action="" method="post">
                        <div class="form-group">
                            <label for="email">Email scolastica</label>
                            <div class="input-group">
                                <i class="fas fa-envelope" id="email-icon"></i>
                                <input type="text" id="email" name="email" placeholder="nome.cognome@itisavogadro.it"
                                    required onkeyup="checkExists(this.value)"
                                    value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                            <small>La email deve appartenere al dominio itisavogadro.it</small>
                            <div id="emailFeedback" class="feedback-message" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <i class="fas fa-user" id="name-icon"></i>
                                <input type="text" id="name" name="name" placeholder="Il tuo nome"
                                    value="<?php echo htmlspecialchars($name); ?>" required>
                            </div>
                            <div id="nameFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="surname">Cognome</label>
                            <div class="input-group">
                                <i class="fas fa-user" id="surname-icon"></i>
                                <input type="text" id="surname" name="surname" placeholder="Il tuo cognome"
                                    value="<?php echo htmlspecialchars($surname); ?>" required>
                            </div>
                            <div id="surnameFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="date-birth">Data di nascita</label>
                            <div class="input-group">
                                <i class="fa-solid fa-calendar" id="date-birth-icon"></i>
                                <div class="date-picker-container">
                                    <input type="text" class="date-picker-input" id="date-birth" name="dateUnformatted"
                                        placeholder="Seleziona data">
                                    <input type="hidden" id="date" name="date"
                                        value="<?php echo htmlspecialchars($date_birth); ?>">
                                    <div class="date-picker" id="date-birth-picker">
                                        <div class="date-picker-header">
                                            <button type="button" class="prev-year">&lt;&lt;</button>
                                            <button type="button" class="prev-month">&lt;</button>
                                            <h2 class="current-date">
                                                <span class="month-year">
                                                    <span class="current-month"></span>
                                                    <span class="current-year"></span>
                                                </span>
                                            </h2>
                                            <button type="button" class="next-month">&gt;</button>
                                            <button type="button" class="next-year">&gt;&gt;</button>
                                        </div>
                                        <div class="date-picker-weekdays"></div>
                                        <div class="date-picker-days"></div>
                                        <div class="date-picker-footer">
                                            <button type="button" class="today-btn">Oggi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="dateFeedback" class="feedback-message"></div>
                        </div>

                        <p><a href="editPassword.php">Vuoi modificare la tua password ? Premi qui.</a></p>

                        <div class="buttons_div">
                            <button type="button" class="btn btn-primary btn-block" id="edit-button">Modifica</button>
                            <button type="button" class="btn btn-danger btn-block" id="cancel-button">Annulla</button>
                            <button type="submit" class="btn btn-primary btn-block" id="save-button">Salva</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "../page/footer.php" ?>

</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $dateOfBirth = htmlspecialchars(trim($_POST['date']));
    $userId = $_SESSION['id'];

    // Update user in the database
    $stmt = $conn->prepare("UPDATE users SET u_name = ?, u_surname = ?, u_date_birth = ? WHERE u_id = ?");
    $stmt->bind_param("sssi", $name, $surname, $dateOfBirth, $_SESSION['id']);

    if ($stmt->execute()) {
        echo "<script>alert('Dati aggiornati con successo.'); window.location.href = './account.php';</script>";
    } else {
        echo "<script>alert('Errore durante l\'aggiornamento: " . $stmt->error . "');</script>";
    }
    $stmt->close();

}
?>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("date-birth").value = formatDate(new Date(document.getElementById("date").value));
    });

    function formatDate(date) {
        if (!date) return "";

        const day = date.getDate();
        const monthNames = [
            "Gen",
            "Feb",
            "Mar",
            "Apr",
            "Mag",
            "Giu",
            "Lug",
            "Ago",
            "Set",
            "Ott",
            "Nov",
            "Dic",
        ];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();

        return `${day} ${month} ${year}`;
    }
</script>
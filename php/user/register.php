<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Registrati</title>

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

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that validates the form -->
    <script src="../../js/validation_register.js" defer></script>

    <!-- Script that add ajax features -->
    <script src="../../js/email_ajax.js" defer></script>

    <!-- Script that manages the date picker UX... -->
    <script src="../../js/date_picker.js" defer></script>
</head>

<body>
    <?php
    $check = false;
    $path = "../";
    include_once '../page/header_navbar.php';
    ?>

    <main>
        <section class="auth-section" id="register">
            <div class="main-container">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2 class="heading-2">Crea un account</h2>
                        <p>Compila il form con i tuoi dati per registrarti al servizio. Potrai utilizzare l'account
                            quando l'admin avrà verificato e accettato il tuo account</p>
                    </div>

                    <form id="register-form" class="auth-form" action="" method="post">
                        <div class="form-group">
                            <label for="email">Email scolastica</label>
                            <div class="input-group">
                                <i class="fas fa-envelope" id="email-icon"></i>
                                <input type="text" id="email" name="email" placeholder="nome.cognome@itisavogadro.it"
                                    required onkeyup="checkExists(this.value)">
                            </div>
                            <small>La email deve appartenere al dominio itisavogadro.it</small>
                            <div id="emailFeedback" class="feedback-message" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="name">Nome</label>
                            <div class="input-group">
                                <i class="fas fa-user" id="name-icon"></i>
                                <input type="text" id="name" name="name" placeholder="Il tuo nome" required>
                            </div>
                            <div id="nameFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="surname">Cognome</label>
                            <div class="input-group">
                                <i class="fas fa-user" id="surname-icon"></i>
                                <input type="text" id="surname" name="surname" placeholder="Il tuo cognome" required>
                            </div>
                            <div id="surnameFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="date-birth">Data di nascita</label>
                            <div class="input-group">
                                <i class="fa-solid fa-calendar" id="date-birth-icon"></i>
                                <div class="date-picker-container">
                                    <input type="text" class="date-picker-input" id="date-birth" name="date"
                                        placeholder="Seleziona data" readonly>
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
                                            <button type="button" class="clear-btn">Cancella</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="dateFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="codFis">Codice fiscale</label>
                            <div class="input-group">
                                <i class="fas fa-id-card" id="codFis-id-icon"></i>
                                <input type="text" id="codFis" name="codFis" placeholder="Il tuo codice fiscale"
                                    required>
                            </div>
                            <div id="codFisFeedback" class="feedback-message"></div>
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
                            <small>Deve contenere: almeno 8 caratteri, 1 maiuscola, 1 minuscola, 1 numero, 1 speciale
                                (!@#$%^&*)</small>
                            <div id="passwordFeedback" class="feedback-message"></div>
                        </div>

                        <div class="form-group">
                            <label for="confirm-password">Conferma Password</label>
                            <div class="input-group">
                                <i class="fas fa-lock" id="confirm-password-icon"></i>
                                <input type="password" id="confirm-password" name="confirm-password"
                                    placeholder="Conferma la tua password" required>
                                <button type="button" class="btn-icon password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div id="confirmPasswordFeedback" class="feedback-message"></div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Registrati</button>

                        <div class="auth-footer">
                            <p>Hai già un account? <a href="login.php">Accedi</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "../page/footer.php" ?>

</body>

</html>
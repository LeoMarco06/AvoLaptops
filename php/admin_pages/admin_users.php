<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Gestione Utenti</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the custom styles sheet -->
    <link rel="stylesheet" href="../../css/custom_inputs.css">


    <!-- Link to the authentication styles sheet -->
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Link to the users page styles sheet -->
    <link rel="stylesheet" href="../../css/users.css">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that manages the date picker UX... -->
    <script src="../../js/date_picker.js" defer></script>

    <!-- Script that manages modals -->
    <script src="../../js/modal_setup.js" defer></script>

    <!-- Script that manages user modals -->
    <script src="../../js/manage_user.js" defer></script>
</head>

<?php
$check = true;
$admin = true;
$path = "../";
include_once '../page/header_navbar.php';

$conn = connectToDatabase();

$sql = "SELECT u_id, u_name, u_surname, u_email, u_role, u_authorized FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$users_json = json_encode($users);
?>

<body>

    <main>
        <div class="obscure-bg" id="obscure-bg" onclick="closeUserPopup();"></div>
        <div class="main-container">
            <h1 class="heading-1">Gestione Utenti</h1>
            <div class="search-user-input">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search-user" id="search-user" placeholder="Cerca un utente..."
                    class="search-user-bar">
            </div>
            <div class="users-container" id="users-container">
                <?php foreach ($users as $user): ?>
                    <div class="user-card <?php echo $user['u_authorized'] == 0 ? 'not-verified' : ''; ?>">
                        <h3><?php echo htmlspecialchars($user['u_name'] . ' ' . $user['u_surname']); ?></h3>
                        <p>Email: <?php echo htmlspecialchars($user['u_email']); ?></p>
                        <p>Ruolo: <?php echo $user['u_role'] == 1 ? 'Admin' : 'Utente'; ?></p>
                        <div class=" buttons">
                            <button class="btn btn-primary"
                                onclick="viewUser(<?php echo $user['u_id']; ?>)">Visualizza</button>
                            <?php if ($user['u_authorized'] == 1): ?>
                                <button class="btn btn-danger"
                                    onclick="deleteUser(<?php echo $user['u_id']; ?>)">Elimina</button>
                            <?php else: ?>
                                <button class="btn btn-warning"
                                    onclick="confirmUser(<?php echo $user['u_id']; ?>)">Conferma</button>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- No users found message -->
                <div class="no-users-message">
                    <i class="fa-solid fa-user-slash"></i>
                    <span>Nessun utente trovato</span>
                </div>
            </div>

            <!-- Popup for editing user -->
            <div class="popup-container" id="popup-container">
                <div class="popup-header">
                    <h2 id="popup-title">Gestione Utente</h2>
                    <button onclick="closeUserPopup()" class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form id="user-form" class="auth-form">
                    <div class="form-group">
                        <label for="user-name">Nome e cognome</label>
                        <div class="name-group">
                            <div class="form-group left">
                                <input type="text" id="user-name" name="user-name" disabled>
                                <div id="nameFeedback" class="feedback"></div>
                            </div>
                            <div class="form-group right">
                                <input type="text" id="user-surname" name="user-surname" disabled>
                                <div id="surnameFeedback" class="feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user-role">Ruolo</label>
                        <select id="user-role" name="user-role" disabled>
                            <option value="" disabled hidden>Seleziona un ruolo</option>
                            <option value="1">Admin</option>
                            <option value="10">Utente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date-birth">Data di Nascita</label>
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
                                    <button class="today-btn">Oggi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons_div">
                        <button type="button" class="btn btn-primary" id="edit-btn">Modifica</button>
                        <button type="submit" class="btn btn-primary" id="save-btn"
                            style="display: none;">Salva</button>
                        <button type="button" class="btn btn-danger" id="cancel-btn" style="display: none;"
                            onclick="toggleEditMode(false); resetFeedbackStyles();">Annulla</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once "../page/footer.php"; ?>
</body>

<div id="users-data" style="display: none;">
    <?php echo $users_json; ?>
</div>
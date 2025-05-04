<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Gestione Utenti</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the authentication styles sheet -->
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Link to the users page styles sheet -->
    <link rel="stylesheet" href="../../css/users.css">
    
    <!-- Link to the custom styles sheet -->
    <link rel="stylesheet" href="../../css/custom_inputs.css">

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
include '../include/connection.php';
$conn = connectToDatabase();

$sql = "SELECT u_id, u_name, u_surname, u_email, u_role FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$users_json = json_encode($users);
?>

<body>
    <?php include_once '../header_navbar.php'; ?>

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
                    <div class="user-card"">
                        <h3><?php echo htmlspecialchars($user['u_name'] . ' ' . $user['u_surname']); ?></h3>
                        <p>Email: <?php echo htmlspecialchars($user['u_email']); ?></p>
                        <p>Ruolo: <?php echo $user['u_role'] == 0 ? 'Admin' : 'Utente'; ?></p>
                        <div class=" buttons">
                        <button class="btn btn-primary" onclick="viewUser(<?php echo $user['u_id']; ?>)">Visualizza</button>
                        <button class="btn btn-danger" onclick="deleteUser(<?php echo $user['u_id']; ?>)">Elimina</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Popup for editing user -->
        <div class="popup-container" id="popup-container">
            <div class="popup-header">
                <h2 id="popup-title">Gestione Utente</h2>
                <button onclick="closeUserPopup()" class="btn btn-close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="user-form" class="auth-form">
                <div class="form-group">
                    <label for="user-name">Nome</label>
                    <input type="text" id="user-name" name="user-name" disabled>
                    <div id="nameFeedback" class="feedback"></div>
                </div>
                <div class="form-group">
                    <label for="user-surname">Cognome</label>
                    <input type="text" id="user-surname" name="user-surname" disabled>
                    <div id="surnameFeedback" class="feedback"></div>
                </div>
                <div class="form-group">
                    <label for="user-email">Email</label>
                    <input type="email" id="user-email" name="user-email" disabled>
                    <div id="emailFeedback" class="feedback"></div>
                </div>
                <div class="form-group">
                    <label for="user-role">Ruolo</label>
                    <select id="user-role" name="user-role" disabled>
                        <option value="" disabled>Seleziona un ruolo</option>
                        <option value="0">Admin</option>
                        <option value="1">Utente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user-codFis">Codice Fiscale</label>
                    <input type="text" id="user-codFis" name="user-codFis" disabled>
                    <div id="codFisFeedback" class="feedback"></div>
                </div>
                <div class="form-group">
                    <label for="date-birth">Data di Nascita</label>
                    <div class="date-picker-container">
                        <input type="text" class="date-picker-input" id="date-birth" name="date"
                            placeholder="Seleziona data" readonly>
                        <div class="date-picker" id="date-birth-picker">
                            <div class="date-picker-header">
                                <button class="prev-year">&lt;&lt;</button>
                                <button class="prev-month">&lt;</button>
                                <h2 class="current-date">
                                    <span class="month-year">
                                        <span class="current-month"></span>
                                        <span class="current-year"></span>
                                    </span>
                                </h2>
                                <button class="next-month">&gt;</button>
                                <button class="next-year">&gt;&gt;</button>
                            </div>
                            <div class="date-picker-weekdays"></div>
                            <div class="date-picker-days"></div>
                            <div class="date-picker-footer">
                                <button class="today-btn">Oggi</button>
                                <button class="clear-btn">Cancella</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-buttons">
                    <button type="button" class="btn btn-primary" id="edit-btn" onclick="editUser()">Modifica</button>
                    <button type="submit" class="btn btn-primary" id="save-btn" style="display: none;">Salva</button>
                    <button type="button" class="btn btn-secondary" id="cancel-btn" style="display: none;"
    onclick="toggleEditMode(false); resetFeedbackStyles();">Annulla</button>
                </div>
            </form>
        </div>
        </div>
    </main>

    <?php include_once "../footer.php"; ?>
</body>

<div id="users-data" style="display: none;">
    <?php echo $users_json; ?>
</div>
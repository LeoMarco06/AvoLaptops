<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Gestione armadietti</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the authentication styles sheet -->
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../../css/locker_page.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that manages modals -->
    <script src="../../js/modal_setup.js" defer></script>

    <!-- Script that validates the form -->
    <script src="../../js/manage_lockers.js" defer></script>
</head>

<?php
$check = true;
$admin = true;
$path = "../";
include_once '../page/header_navbar.php';
$conn = connectToDatabase();

$sql = "SELECT * FROM lockers";
$stmt = $conn->prepare($sql);
$stmt->execute();
$lockers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$lockers_json = json_encode($lockers);
?>

<body>

    <main>
        <div class="obscure-bg" id="obscure-bg" onclick="closePopup();"></div>
        <div class="main-container">
            <h1 class="heading-1">Gestione Armadietti</h1>
            <div class="locker-search-container">
                <div class="search-locker-input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search-locker" id="search-locker" placeholder="Cerca un armadietto..."
                        class="locker-search-bar">
                </div>
                <button class="btn btn-primary" id="add-locker-btn" onclick="openPopup()">
                    <i class="fa-solid fa-plus" style="padding-right: var(--spacing-sm);"></i>
                    Aggiungi
                </button>
            </div>
            <div class="lockers-container" id="lockers-container">
                <div class="no-lockers-message" style="display: none;">
                    <i class="fa-solid fa-box-open"></i>
                    <span>Nessun armadietto trovato</span>
                </div>
            </div>
            <div class="popup-container" id="popup-container">
                <div class="auth-header">
                    <h2 class="heading-2">Aggiungi un nuovo armadietto</h2>
                    <p>Inserisci i dati dell'armadietto da aggiungere.</p>
                </div>

                <form id="locker-form" class="auth-form" action="" method="post">
                    <div class="form-group">
                        <label for="locker-class">Classe</label>
                        <div class="input-group">
                            <i class="fa-solid fa-box" id="locker-icon"></i>
                            <input type="text" name="lock_class" id="locker-class" placeholder="Classe dell'armadietto"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="locker-floor">Piano</label>
                        <div class="input-group">
                            <i class="fa-solid fa-building" id="locker-icon"></i>
                            <select name="lock_floor" id="locker-floor" placeholder="Piano dell'armadietto" required>
                                <option value="" disabled selected hidden>Piano dell'armadietto</option>
                                <option value="0">Piano terra</option>
                                <option value="1">Piano 1</option>
                                <option value="2">Piano 2</option>
                                <option value="3">Piano 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="locker-incharge">Responsabile</label>
                        <div class="input-group">
                            <i class="fa-solid fa-user" id="locker-icon"></i>
                            <input type="text" name="lock_incharge" id="locker-incharge"
                                placeholder="Responsabile dell'armadietto" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="locker-capacity">Capacità</label>
                        <div class="input-group">
                            <i class="fa-solid fa-boxes-stacked" id="locker-icon"></i>
                            <input type="number" name="lock_capacity" id="locker-capacity"
                                placeholder="Capacità dell'armadietto" min="0" max="100" required>
                        </div>
                    </div>
                    <div class="buttons_div">
                        <button class="btn btn-danger" type="button" onclick="closePopup()">Chiudi</button>
                        <button type="submit" class="btn btn-primary">Aggiungi</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once "../page/footer.php"; ?>
</body>

<div id="lockers-data" style="display: none;">
    <?php echo $lockers_json; ?>
</div>
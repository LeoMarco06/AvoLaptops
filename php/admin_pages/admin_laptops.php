<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Laptops</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the authentication styles sheet -->
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../../css/laptop_page.css">

    <!-- Link to the qr img styles sheet -->
    <link rel="stylesheet" href="../../css/qr_reader.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that manages modals -->
    <script src="../../js/modal_setup.js" defer></script>

    <!-- Script that manages modals -->
    <script src="../../js/create_laptop_qr.js" defer></script>

    <!-- Script that validates the form -->
    <script src="../../js/laptop_page_setup.js" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>

<?php
$check = true;
$admin = true;
$path = "../";
include_once '../page/header_navbar.php';

$conn = connectToDatabase();

// Get the current timestamp
$current_time = time();
$current_hour = (int) date('H', $current_time);

// Imposta orari di apertura e chiusura
$open_hour = 8;
$close_hour = 17;

if ($current_hour < $open_hour) {
    // Prima delle 8:00: oggi alle 8:00
    $day = date('Y-m-d');
    $start_time = sprintf('%02d:00', $open_hour);
} elseif ($current_hour >= $close_hour) {
    // Dopo le 17:00: domani alle 8:00
    $day = date('Y-m-d', strtotime('+1 day'));
    $start_time = sprintf('%02d:00', $open_hour);
} else {
    // Tra 8:00 e 17:00: logica attuale
    $minutes = date('i', $current_time);
    $rounded_minutes = $minutes < 30 ? '00' : '30';
    $day = date('Y-m-d');
    $start_time = date('H', $current_time) . ':' . $rounded_minutes;
}

// Set end time to 30 minutes later
$end_time = date('H:i', strtotime($start_time . ' +30 minutes'));

// Override con GET se presenti
$day = $_GET['day'] ?? $day;
$start_time = $_GET['start_time'] ?? $start_time;
$end_time = $_GET['end_time'] ?? $end_time;


// Get current datetime for status 2 check
$current_datetime = date('Y-m-d H:i:s');

$sql = "SELECT 
    l.lap_id, 
    l.lap_name, 
    l.lap_locker, 
    k.lock_class, 
    m.mod_name AS lap_model, 
    m.mod_RAM AS lap_ram, 
    m.mod_memory AS lap_memory, 
    CASE 
        WHEN MAX(
            CASE 
                WHEN r.res_day = ? 
                     AND ? < r.res_end_time AND ? > r.res_start_time 
                THEN 1 
                ELSE 0 
            END
        ) = 1 THEN 0 
        WHEN MAX(
            CASE 
                WHEN r.res_day = ? 
                     AND TIME_TO_SEC(TIMEDIFF(?, r.res_end_time)) / 60 BETWEEN 0 AND 61 
                THEN 1 
                ELSE 0 
            END
        ) = 1 THEN 2 
        WHEN l.lap_status = -1 THEN -1 
        ELSE 1 
    END AS lap_status
FROM laptops l
LEFT JOIN laptops_reservations lr 
    ON lr.lap_id = l.lap_id
LEFT JOIN reservations r 
    ON r.res_id = lr.res_id
LEFT JOIN models m 
    ON m.mod_id = l.lap_model
INNER JOIN lockers k 
    ON k.lock_id = l.lap_locker
GROUP BY l.lap_id;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $day, $start_time, $end_time, $day, $start_time);
$stmt->execute();
$laptops = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("SELECT lock_id, lock_class FROM lockers");

$stmt->execute();

$lockers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("SELECT mod_id, mod_name FROM models");

$stmt->execute();

$models = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt->close();

$laptops_json = json_encode($laptops);
$lockers_json = json_encode($lockers);
$models_json = json_encode($models);
?>

<body>

    <main>
        <div class="obscure-bg" id="obscure-bg" onclick="closePopup();"></div>
        <div class="main-container">
            <h1 class="heading-1">Laptops</h1>
            <div class="laptop-search-container">
                <div class="search-laptop-input">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search-laptop" id="search-laptop" placeholder="Cerca un laptop..."
                        class="laptop-search-bar">
                </div>
                <button class="btn btn-primary" id="add-laptop-btn" onclick="openPopup()">
                    <i class="fa-solid fa-plus" style="padding-right: var(--spacing-sm);"></i>
                    Aggiungi
                </button>
            </div>

            <div class="laptops-container" id="laptops-container">
                <div class="no-laptops-message" style="display: none;">
                    <i class="fa-solid fa-laptop-medical"></i>
                    <span>Nessun laptop trovato</span>
                </div>
            </div>

            <div class="popup-container" id="popup-container">
                <div class="auth-header">
                    <h2 class="heading-2">Aggiungi un nuovo laptop</h2>
                    <p>Inserisci i dati del laptop da aggiungere.</p>
                </div>

                <form id="laptop-form" class="auth-form" action="" method="post">
                    <div class="form-group">
                        <label for="laptop-name">Nome</label>
                        <div class="input-group">
                            <i class="fa-solid fa-hashtag" id="name-icon"></i>
                            <input type="text" name="lap_name" id="laptop-name" placeholder="Nome del laptop"
                                pattern="^PC-\d{1,3}$"
                                title="Il nome deve contenere 'PC-' seguito dal numero del laptop nell'armadietto"
                                class="input-field" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="laptop-model">Modello</label>
                        <div class="input-group">
                            <i class="fa-solid fa-laptop" id="model-icon"></i>
                            <select name="lap_model" id="laptop-model" required>
                                <option value="" selected disabled>Seleziona un modello</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="locker">Armadietto</label>
                        <div class="input-group">
                            <i class="fa-solid fa-box" id="locker-icon"></i>
                            <select name="lap_locker" id="laptop-locker" required>
                                <option value="" selected disabled>Seleziona un armadietto</option>
                            </select>
                        </div>
                    </div>
                    <div class="buttons_div">
                        <button class="btn btn-primary" type="button" onclick="closePopup()">Chiudi</button>
                        <button id="addBtn" type="button" class="btn btn-primary"
                            onclick="validateForm()">Aggiungi</button>
                    </div>
                </form>
            </div>

            <!-- QR Popup -->
            <div id="qr-popup-admin" class="qr-popup-overlay" style="display:none;">
                <div class="qr-popup-content">
                    <div class="popup-header">
                        <h3 id="popup-qr-title">QR Laptop</h3>
                        <button id="close-qr-popup-admin" class="qr-close-btn">&times;</button>
                    </div>
                    <div id="qr-code">
                        <div class="qr-container" id="qr-code-admin"></div>
                    </div>
                    <pre id="qr-json-admin"></pre>
                    <button id="print-qr-btn" class="btn btn-primary btn-small">Stampa/Salva PDF</button>
                </div>
            </div>
    </main>

    <?php include_once "../page/footer.php" ?>
</body>

<div id="laptops-data" style="display: none;">
    <?php echo $laptops_json; ?>
</div>

<div id="lockers-data" style="display: none;">
    <?php echo $lockers_json; ?>
</div>

<div id="models-data" style="display: none;">
    <?php echo $models_json; ?>
</div>

</html>
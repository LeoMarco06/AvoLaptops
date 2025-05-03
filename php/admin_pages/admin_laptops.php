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

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../../css/laptop_page.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that validates the form -->
    <script src="../../js/laptop_page_setup.js" defer></script>
</head>

<?php
include '../include/connection.php';
include '../include/check_login.php';
$conn = connectToDatabase();

// Get the current timestamp
$current_time = time();

// Round down to the nearest 00 or 30 minutes
$minutes = date('i', $current_time); // Get current minutes
$rounded_minutes = $minutes < 30 ? '00' : '30'; // Round to 00 or 30

$start_time = date('H', $current_time) . ':' . $rounded_minutes; // Combine hours and rounded minutes

// Set end time to 30 minutes later
$end_time = date('H:i', strtotime($start_time . ' +30 minutes')); // Add 30 minutes to start time


// Get today's date
$day = $_GET['day'] ?? date('Y-m-d');

$sql = "SELECT l.lap_id, lap_locker, m.mod_name as lap_model, m.mod_RAM as lap_ram, m.mod_memory as lap_memory, lap_name, k.lock_id, k.lock_class,
CASE 
        WHEN MAX(
            CASE 
                    WHEN r.res_day = ? AND ? < r.res_end_time AND ? > r.res_start_time 
                    THEN 1 -- Reserved flag
                    ELSE 0 -- Not reserved
                END
            ) = 1 THEN 0 -- Unavailable
            WHEN l.lap_status = -1 THEN -1 -- Maintenance
            ELSE 1 -- Available
        END AS lap_status
        FROM laptops l
        LEFT JOIN laptops_reservations lr ON lr.lap_id = l.lap_id
        LEFT JOIN reservations r ON r.res_id = lr.res_id
        INNER JOIN models as m
        INNER JOIN lockers as k ON m.mod_id = l.lap_model AND l.lap_locker = k.lock_id
        GROUP BY l.lap_id;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $day, $start_time, $end_time);
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
    <?php include_once '../header_navbar.php'; ?>

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
            <div class="laptops-container" id="laptops-container"></div>
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
                            <input type="text" name="laptop-name" id="laptop-name" placeholder="Nome del laptop"
                                pattern="^PC-\d{1,3}$"
                                title="Il nome deve contenere 'PC-' seguito dal numero del laptop nell'armadietto"
                                class="input-field" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="laptop-model">Modello</label>
                        <div class="input-group">
                            <i class="fa-solid fa-laptop" id="model-icon"></i>
                            <select name="laptop-model" id="laptop-model" required>
                                <option value="" selected disabled>Seleziona un modello</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="locker">Armadietto</label>
                        <div class="input-group">
                            <i class="fa-solid fa-box" id="locker-icon"></i>
                            <select name="laptop-locker" id="laptop-locker" required>
                                <option value="" selected disabled>Seleziona un armadietto</option>
                            </select>
                        </div>
                    </div>
                    <div class="popup-buttons">
                        <button class="btn btn-primary" type="button" onclick="closePopup()">Cancella</button>
                        <button type="submit" class="btn btn-primary" onclick="validateForm()">Aggiungi</button>
                    </div>
                </form>
            </div>
    </main>

    <?php include_once "../footer.php" ?>

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
<!DOCTYPE html>
<html lang="it" data-theme="light">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Title of the browser tab -->
<title>Avo Laptops | Prenota ora</title>

<!-- Link to the styles sheet -->
<link rel="stylesheet" href="../../css/styles.css">

<!-- Link to the booking styles sheet -->
<link rel="stylesheet" href="../../css/prenota.css">

<!-- Link to the custom styles sheet -->
<link rel="stylesheet" href="../../css/custom_inputs.css">

<!-- Link to the responsive styles sheet -->
<link rel="stylesheet" href="../../css/responsive.css">

<!-- Link to the qr reader styles sheet -->
<link rel="stylesheet" href="../../css/qr_reader.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Script that manages the theme mode, animations, navbar... -->
<script src="../../js/page_setup.js" defer></script>

<!-- Script that handle the custom date picker -->
<script src="../../js/date_picker.js" defer></script>

<!-- Script that handle the custom time picker -->
<script src="../../js/time_picker.js" defer></script>

<!-- Script that manages the booking UX... -->
<script src="../../js/book.js" defer></script>

<!-- Libreria QR code -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<!-- Il tuo script per avviare lo scanner -->
<script src="../../js/qr_reader.js" defer></script>
</head>



<body id="home">
    <?php
    $check = true;
    $path = "../";
    include_once '../page/header_navbar.php';
    include_once '../include/connection.php';

    $conn = connectToDatabase();

    // Get the current timestamp
    $current_time = time();
$current_hour = (int)date('H', $current_time);

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

    // query to get all laptops with their status
// and model name, and check if they are reserved during the specified time
// and date
// status 1 = available, 0 = unavailable, -1 = maintenance, 2 = reserved within last hour
    $stmt = $conn->prepare("SELECT 
    l.lap_id, 
    l.lap_name, 
    l.lap_locker,
    lck.lock_class, 
    m.mod_name AS lap_model,
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
INNER JOIN lockers lck 
    ON lck.lock_id = l.lap_locker
GROUP BY l.lap_id;");


    $stmt->bind_param("sssss", $day, $start_time, $end_time, $day, $start_time);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    $laptops = [];

    // Fetch results (as an example)
    while ($row = $result->fetch_assoc()) {
        $laptops[] = $row;
    }


    $laptops_json = json_encode($laptops);
    ?>

    <main>
        <section id="prenotazione" class="booking-section">
            <div class="main-container">
                <h2 class="section-header">Prenotazione Portatili</h2>

                <!-- Filters -->
                <form id="booking-form" class="booking-form" method="GET" action="">
                    <div class="booking-filters">
                        <div class="filter-group">
                            <div class="box">
                                <div class="text-icon">
                                    <i class="fa-solid fa-calendar"></i>
                                    <label for="start-date">Data inizio</label>
                                </div>
                                <div class="date-picker-container">
                                    <input type="text" class="date-picker-input" id="start-date"
                                        placeholder="Seleziona data" readonly>
                                    <input type="hidden" id="day-hid" name="day">
                                    <div class="date-picker" id="start-date-picker">
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

                            <div class="box right">
                                <div class="text-icon">
                                    <i class="fa-solid fa-clock"></i>
                                    <label for="start-time">Ora inizio</label>
                                </div>
                                <div class="time-picker-container">
                                    <input type="text" id="start-time" class="time-picker-input"
                                        placeholder="Seleziona orario" name="start_time" readonly>
                                    <div class="time-picker-dropdown" id="start-time-picker-dropdown"></div>
                                </div>
                            </div>
                            <div class="box right">
                                <div class="text-icon">
                                    <i class="fa-solid fa-clock"></i>
                                    <label for="end-time">Ora fine</label>
                                </div>
                                <div class="time-picker-container">
                                    <input type="text" id="end-time" class="time-picker-input"
                                        placeholder="Seleziona orario" name="end_time" readonly>
                                    <div class="time-picker-dropdown" id="end-time-picker-dropdown"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Booking summary -->
                <form id="booking-summary-form" class="booking-summary-form" method="POST"
                    action="./manda_prenotazione.php">
                    <input type="hidden" name="day" id="hidden-day">
                    <input type="hidden" name="start_time" id="hidden-start-time">
                    <input type="hidden" name="end_time" id="hidden-end-time">
                    <div class="booking-summary">
                        <h3 class="heading-3">Il tuo carrello</h3>
                        <div class="summary-content">
                            <p>Nessun portatile selezionato</p>
                            <ul id="selected-laptops" class="selected-items-list">
                                <!-- Selected laptops will be inserted here -->
                            </ul>
                            <div class="summary-actions">
                                <button id="clear-selection" class="btn btn-outline btn-small" type="button">Annulla
                                    selezione</button>
                                <button id="confirm-booking" class="btn btn-primary btn-small" type="submit"
                                    disabled>Conferma
                                    prenotazione</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Bottone per aprire il popup QR -->
                <div class="qr-scan-container" style="text-align: center; margin-top: 20px;">
                    <button id="open-qr-popup" class="btn btn-outline btn-small">
                        <i class="fa-solid fa-qrcode"></i> Scansiona QR Code
                    </button>
                </div>

                <!-- Lockers list -->
                <div class="lockers-container">
                    <h3 class="heading-3">Seleziona dall'armadietto</h3>
                    <div class="lockers-grid" id="lockers_container"></div>
                </div>


            </div>
        </section>
    </main>

    <?php include_once "../page/footer.php" ?>
    <!-- Popup per QR code -->
    <div id="qr-popup" class="qr-popup-overlay" style="display: none;">
        <div class="qr-popup-content">
            <div class="popup-header">
                <h3>Scansiona un QR Code</h3>
                <button id="close-qr-popup" class="qr-close-btn">&times;</button>
            </div>

            <div id="qr-reader"></div>
            <div id="qr-screen"></div>
            <p id="qr-result">Inquadra il codice qr presente sul pc e conferma la selezione premendo sul pulsante
                "conferma".</p>
        </div>
    </div>
</body>

</html>
<div id="laptops-data" style="display: none;">
    <?php echo $laptops_json; ?>
</div>

<script>
    // Format the date as "DD MMM YYYY"
    function formatDate(date) {
        if (!date) return "";

        const day = date.getDate();
        const monthNames = ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();

        return `${day} ${month} ${year}`;
    }

    document.getElementById("start-date").value = formatDate(new Date("<?php echo $day; ?>"));
    document.getElementById("start-time").value = "<?php echo $start_time; ?>";
    document.getElementById("end-time").value = "<?php echo $end_time; ?>";
</script>
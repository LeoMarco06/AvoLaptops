<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Prenota ora</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../css/prenota.css">

    <!-- Link to the custom styles sheet -->
    <link rel="stylesheet" href="../css/custom_inputs.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../js/page_setup.js" defer></script>

    <!-- Script that handle the custom date picker -->
    <script src="../js/date_picker.js" defer></script>

    <!-- Script that handle the custom time picker -->
    <script src="../js/time_picker.js" defer></script>

    <!-- Script that manages the booking UX... -->
    <script src="../js/book.js" defer></script>
</head>

<?php
include './include/connection.php';
$conn = connectToDatabase();

$sql = "SELECT lap_id, lap_locker, m.mod_name as lap_model, lap_status, lap_name 
        FROM laptops l
        INNER JOIN models as m 
        ON m.mod_id = l.lap_model";
$stmt = $conn->prepare($sql);
$stmt->execute();
$laptops = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$laptops_json = json_encode($laptops);
?>

<body id="home">
    <?php include_once 'header_navbar.php'; ?>

    <main>
        <section id="prenotazione" class="booking-section">
            <div class="main-container">
                <h2 class="section-header">Prenotazione Portatili</h2>

                <!-- Filters -->
                <div class="booking-filters">
                    <div class="filter-group">
                        <div class="box">
                            <div class="text-icon">
                                <i class="fa-solid fa-calendar"></i>
                                <label for="start-date">Data inizio</label>
                            </div>
                            <div class="date-picker-container">
                                <input type="text" class="date-picker-input" id="start-date" name="date"
                                    placeholder="Seleziona data" readonly>
                                <div class="date-picker" id="start-date-picker">
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

                        <div class="box right">
                            <div class="text-icon">
                                <i class="fa-solid fa-clock"></i>
                                <label for="start-time">Ora inizio</label>
                            </div>
                            <div class="time-picker-container">
                                <input type="text" id="start-time" class="time-picker-input"
                                    placeholder="Seleziona orario" name="start-time" readonly>
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
                                    placeholder="Seleziona orario" name="end-time" readonly>
                                <div class="time-picker-dropdown" id="end-time-picker-dropdown"></div>
                            </div>
                        </div>
                    </div>

                    <button id="filter-btn" class="btn btn-primary filter-btn" style="gap: 10px;"><i
                            class="fa-solid fa-magnifying-glass"></i>Cerca</button>
                </div>

                <!-- Booking summary -->
                <div class="booking-summary">
                    <h3 class="heading-3">Il tuo carrello</h3>
                    <div class="summary-content">
                        <p>Nessun portatile selezionato</p>
                        <ul id="selected-laptops" class="selected-items-list">
                            <!-- Selected laptops will be inserted here -->
                        </ul>
                        <div class="summary-actions">
                            <button id="clear-selection" class="btn btn-outline btn-small">Annulla selezione</button>
                            <button id="confirm-booking" class="btn btn-primary btn-small" disabled>Conferma
                                prenotazione</button>
                        </div>
                    </div>
                </div>

                <!-- Lockers list -->
                <div class="lockers-container">
                    <h3 class="heading-3">Seleziona dall'armadietto</h3>
                    <div class="lockers-grid" id="lockers_container"></div>
                </div>


            </div>
        </section>
    </main>

    <?php include_once "footer.php" ?>

</body>

</html>
<div id="laptops-data" style="display: none;">
    <?php echo $laptops_json; ?>
</div>
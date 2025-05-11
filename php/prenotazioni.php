<<<<<<< HEAD
<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Prenotazioni</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../css/reservations.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../js/page_setup.js" defer></script>

    <!-- Script that manages the reservations UX... -->
    <script src="../js/manage_reservations.js" defer></script>
</head>

<body id="home">
    <?php include_once 'header_navbar.php'; ?>

    <main>
        <section id="prenotazioni" class="my-bookings-section">
            <div class="main-container">
                <h2 class="section-header">Le Mie Prenotazioni</h2>

                <!-- Booking filters -->
                <div class="bookings-filters">
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-status="all">
                            <i class="fas fa-list"></i> Tutte
                        </button>
                        <button class="filter-tab" data-status="pending">
                            <i class="fas fa-hourglass-half"></i> In attesa
                        </button>
                        <button class="filter-tab" data-status="active">
                            <i class="fas fa-laptop"></i> In corso
                        </button>
                        <button class="filter-tab" data-status="completed">
                            <i class="fas fa-check-circle"></i> Terminate
                        </button>
                    </div>

                    <div class="search-box">
                        <div class="input-group">
                            <i class="fas fa-search"></i>
                            <input type="text" id="booking-search" placeholder="Cerca per ID o modello...">
                        </div>
                    </div>
                </div>

                <!-- Booking list -->
                <div class="bookings-list">
                    <?php if (isset($reservations) && !empty($reservations)): ?>
                        <!-- Fa la query a inizio pagina per ottenere $reservations, dopodichè  -->
                        <?php foreach ($reservations as $reservation): ?>
                            <div class="booking-card" data-booking-id="PR-2023-001">
                                <div class="booking-header">
                                    <h3 class="booking-id">PR-2023-001</h3>
                                    <?php if ($reservations["flag"] == 0): ?>
                                        <span class="booking-status pending">
                                            <i class="fas fa-hourglass-half"></i> In attesa di accettazione
                                        </span>
                                    <?php elseif ($reservations["flag"] == 1): ?>
                                        <span class="booking-status active">
                                            <i class="fas fa-laptop"></i> In corso
                                        </span>
                                    <?php else: ?>
                                        <span class="booking-status completed">
                                            <i class="fas fa-check-circle"></i> Terminata
                                        </span>
                                    <?php endif ?>
                                </div>

                                <div class="booking-details">
                                    <div class="detail-group">
                                        <h4 class="detail-label">Portatili prenotati:</h4>
                                        <ul class="laptops-list">
                                            <li>A1-001 (Modello 1)</li>
                                            <li>A1-005 (Modello 1)</li>
                                        </ul>
                                    </div>

                                    <div class="detail-group">
                                        <h4 class="detail-label">Periodo:</h4>
                                        <p>Dal 15/01/2025 al 22/01/2025</p>
                                    </div>

                                    <div class="detail-group">
                                        <h4 class="detail-label">Data prenotazione:</h4>
                                        <p>10/01/2025</p>
                                    </div>
                                    <div class="detail-group">
                                        <h4 class="detail-label">Utente:</h4>
                                        <p>Cognome e nome utente</p>
                                    </div>
                                </div>

                                <div class="booking-actions">
                                    <button class="btn btn-outline btn-small">
                                        <i class="fas fa-info-circle"></i> Dettagli
                                    </button>
                                    <button class="btn btn-outline btn-small cancel-booking">
                                        <i class="fas fa-times"></i> Annulla
                                    </button>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>

                    <!-- If there aren't bookings -->
                    <div class="no-bookings-message" <?php isset($reservations) && !empty($reservations) ? "" : "style=\"display:block;\"" ?>>
                        <i class="fas fa-calendar-times"></i>
                        <p>Nessuna prenotazione trovata</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "footer.php" ?>

</body>

</html>
=======
<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Prenotazioni</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../css/prenotazioni.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../js/page_setup.js" defer></script>

    <!-- Script that manages the reservations UX... -->
    <script src="../js/manage_reservations.js" defer></script>
</head>

<?php
include './include/check_login.php';
?>

<body id="home">
    <?php include_once 'header_navbar.php'; ?>

    <main>
        <section id="prenotazioni" class="my-bookings-section">
            <div class="main-container">
                <h2 class="section-header">Le Mie Prenotazioni</h2>

                <!-- Booking filters -->
                <div class="bookings-filters">
                    <div class="filter-tabs">
                        <button class="filter-tab active" data-status="all">
                            <i class="fas fa-list"></i> Tutte
                        </button>
                        <button class="filter-tab" data-status="pending">
                            <i class="fas fa-hourglass-half"></i> In attesa
                        </button>
                        <button class="filter-tab" data-status="active">
                            <i class="fas fa-laptop"></i> In corso
                        </button>
                        <button class="filter-tab" data-status="completed">
                            <i class="fas fa-check-circle"></i> Terminate
                        </button>
                    </div>

                    <div class="search-box">
                        <div class="input-group">
                            <i class="fas fa-search"></i>
                            <input type="text" id="booking-search" placeholder="Cerca per ID o modello...">
                        </div>
                    </div>
                </div>

                <!-- Booking list -->
                <div class="bookings-list">
                    <!-- Prenotazione 1 - In attesa -->
                    <div class="booking-card pending" data-booking-id="PR-2023-001">
                        <div class="booking-header">
                            <h3 class="booking-id">PR-2023-001</h3>
                            <span class="booking-status pending">
                                <i class="fas fa-hourglass-half"></i> In attesa di accettazione
                            </span>
                        </div>

                        <div class="booking-details">
                            <div class="detail-group">
                                <h4 class="detail-label">Portatili prenotati:</h4>
                                <ul class="laptops-list">
                                    <li>A1-001 (Modello 1)</li>
                                    <li>A1-005 (Modello 1)</li>
                                    <li>A1-001 (Modello 1)</li>
                                    <li>A1-005 (Modello 1)</li>
                                    <li>A1-001 (Modello 1)</li>
                                    <li>A1-005 (Modello 1)</li>
                                    <li>A1-001 (Modello 1)</li>
                                    <li>A1-005 (Modello 1)</li>
                                    <li>A1-001 (Modello 1)</li>
                                    <li>A1-005 (Modello 1)</li>
                                </ul>
                            </div>

                            <div class="detail-group">
                                <h4 class="detail-label">Periodo:</h4>
                                <p>Dal 15/01/2025 al 22/01/2025</p>
                            </div>

                            <div class="detail-group">
                                <h4 class="detail-label">Data prenotazione:</h4>
                                <p>10/01/2025</p>
                            </div>
                        </div>

                        <div class="booking-actions">
                            <button class="btn btn-outline btn-small">
                                <i class="fas fa-info-circle"></i> Dettagli
                            </button>
                            <button class="btn btn-outline btn-small cancel-booking">
                                <i class="fas fa-times"></i> Annulla
                            </button>
                        </div>
                    </div>

                    <!-- Prenotazione 2 - In corso -->
                    <div class="booking-card active" data-booking-id="PR-2023-002">
                        <div class="booking-header">
                            <h3 class="booking-id">PR-2023-002</h3>
                            <span class="booking-status active">
                                <i class="fas fa-laptop"></i> In corso
                            </span>
                        </div>

                        <div class="booking-details">
                            <div class="detail-group">
                                <h4 class="detail-label">Portatili prenotati:</h4>
                                <ul class="laptops-list">
                                    <li>A2-001 (Modello 1)</li>
                                </ul>
                            </div>

                            <div class="detail-group">
                                <h4 class="detail-label">Periodo:</h4>
                                <p>Dal 05/01/2025 al 12/01/2025</p>
                            </div>

                            <div class="detail-group">
                                <h4 class="detail-label">Data prenotazione:</h4>
                                <p>28/12/2024</p>
                            </div>
                        </div>

                        <div class="booking-actions">
                            <button class="btn btn-outline btn-small">
                                <i class="fas fa-info-circle"></i> Dettagli
                            </button>
                            <button class="btn btn-outline btn-small extend-booking">
                                <i class="fas fa-calendar-plus"></i> Estendi
                            </button>
                        </div>
                    </div>

                    <!-- Prenotazione 3 - Terminata -->
                    <div class="booking-card completed" data-booking-id="PR-2023-003">
                        <div class="booking-header">
                            <h3 class="booking-id">PR-2023-003</h3>
                            <span class="booking-status completed">
                                <i class="fas fa-check-circle"></i> Terminata
                            </span>
                        </div>

                        <div class="booking-details">
                            <div class="detail-group">
                                <h4 class="detail-label">Portatili prenotati:</h4>
                                <ul class="laptops-list">
                                    <li>A1-006 (Modello 2)</li>
                                </ul>
                            </div>

                            <div class="detail-group">
                                <h4 class="detail-label">Periodo:</h4>
                                <p>Dal 10/12/2024 al 17/12/2024</p>
                            </div>

                            <div class="detail-group">
                                <h4 class="detail-label">Data prenotazione:</h4>
                                <p>05/12/2024</p>
                            </div>

                            <div class="detail-group">
                                <h4 class="detail-label">Stato restituzione:</h4>
                                <p><i class="fas fa-check" style="color: var(--color-success);"></i> Restituito il
                                    17/12/2024</p>
                            </div>
                        </div>

                        <div class="booking-actions">
                            <button class="btn btn-outline btn-small">
                                <i class="fas fa-info-circle"></i> Dettagli
                            </button>
                            <button class="btn btn-outline btn-small repeat-booking">
                                <i class="fas fa-redo"></i> Ripeti prenotazione
                            </button>
                            <button class="btn btn-outline btn-small">
                                <i class="fas fa-file-pdf"></i> Ricevuta
                            </button>
                        </div>
                    </div>

                    <!-- If there aren't bookings -->
                    <div class="no-bookings-message">
                        <i class="fas fa-calendar-times"></i>
                        <p>Nessuna prenotazione trovata</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "footer.php" ?>

</body>

</html>

<?php
include "./functions.php";


$conn = connectToDatabase();

// Fetch all reservations for the logged-in user
$reservations_result = $conn->query("
    SELECT res_id, res_start_time, res_end_time, res_day, res_flag 
    FROM reservations 
    -- WHERE res_user = " . $_SESSION['id'] . " 
    ORDER BY res_day DESC, res_start_time DESC
");

// Initialize an array to store reservations with laptops
$reservations = array();

if ($reservations_result) {
    // Loop through each reservation
    while ($reservation = $reservations_result->fetch_assoc()) {
        $res_id = $reservation['res_id'];

        // Fetch laptops associated with this reservation
        $laptops_result = $conn->query("
            SELECT l_r.lap_id, m.mod_name, l.lap_name, loc.lock_class 
            FROM laptops_reservations l_r
            INNER JOIN laptops l ON l.lap_id = l_r.lap_id
            INNER JOIN models m ON m.mod_id = l.lap_model 
            INNER JOIN lockers loc ON l.lap_locker = loc.lock_id
            WHERE l_r.res_id = " . $res_id
        );

        // Initialize an array to store laptop IDs and models
        $laptops = array();

        if ($laptops_result) {
            while ($laptop = $laptops_result->fetch_assoc()) {
                $laptops[] = $laptop;
            }
        }

        // Add laptops to the reservation
        $reservation['laptops'] = $laptops;

        // Add reservation to the main array
        $reservations[] = $reservation;
    }
}

// Convert the reservations array to JSON
$json_reservations = json_encode($reservations);

// Print the JSON
//echo $json_reservations;

// Close the connection
$conn->close();

?>

<script defer>
    document.addEventListener('DOMContentLoaded', () => {
        const bookingsList = document.querySelector('.bookings-list');
        const now = new Date();

        function determineStatus(start, end, flag) {
            const startDate = new Date(start);
            const endDate = new Date(end);

            if (now < startDate) return 'pending';
            if (now >= startDate && now <= endDate && flag == 1) return 'active';
            if (now > endDate && flag == 1) return 'completed';
            if (now > endDate && flag == 0) return 'missed'; // 👈 prenotazione mai attivata
            return 'pending';
        }


        function getStatusText(status) {
            switch (status) {
                case 'pending': return 'In attesa di accettazione';
                case 'active': return 'In corso';
                case 'completed': return 'Terminata';
                case 'missed': return 'Prenotazione non attivata';
                case 'sconosciuto': return 'Stato sconosciuto';
                default: return 'Stato non definito';
            }
        }

        function getStatusIcon(status) {
            switch (status) {
                case 'pending': return '<i class="fas fa-hourglass-half"></i>';
                case 'active': return '<i class="fas fa-laptop"></i>';
                case 'completed': return '<i class="fas fa-check-circle"></i>';
                case 'missed': return '<i class="fas fa-ban"></i>';
                case 'sconosciuto': return '<i class="fas fa-question-circle"></i>';
                default: return '<i class="fas fa-question-circle"></i>';
            }
        }


        // Caricamento dei dati passati da PHP
        const reservations = <?= $json_reservations ?>;

        bookingsList.innerHTML = '';

        if (reservations.length === 0) {
            bookingsList.innerHTML = `
            <div class="no-bookings-message">
                <i class="fas fa-calendar-times"></i>
                <p>Nessuna prenotazione trovata</p>
            </div>`;
        } else {
            reservations.forEach(res => {
                const startDatetime = `${res.res_day}T${res.res_start_time}`;
                const endDatetime = `${res.res_day}T${res.res_end_time}`;
                const status = determineStatus(startDatetime, endDatetime, res.res_flag);


                const laptopListHTML = res.laptops.map(laptop => `<li>${laptop.lap_name} (${laptop.lock_class})</li>`).join('');

                bookingsList.innerHTML += `
                <div class="booking-card ${status}" data-booking-id="PR-${res.res_id}">
                    <div class="booking-header">
                        <h3 class="booking-id">PR-${res.res_id}</h3>
                        <span class="booking-status ${status}">
                            ${getStatusIcon(status)} ${getStatusText(status)}
                        </span>
                    </div>

                    <div class="booking-details">
                        <div class="detail-group">
                            <h4 class="detail-label">Portatili prenotati:</h4>
                            <ul class="laptops-list">${laptopListHTML}</ul>
                        </div>

                        <div class="detail-group">
                            <h4 class="detail-label">Periodo:</h4>
                            <p>Dal ${res.res_day} ${res.res_start_time} <br>al ${res.res_day} ${res.res_end_time}</p>
                        </div>

                        <div class="detail-group">
                            <h4 class="detail-label">Data prenotazione:</h4>
                            <p>${res.res_day}</p>
                        </div>
                    </div>

                    <div class="booking-actions">
                        <button class="btn btn-outline btn-small">
                            <i class="fas fa-info-circle"></i> Dettagli
                        </button>
                        ${status === 'active'
                        ? `<button class="btn btn-outline btn-small extend-booking">
            <i class="fas fa-calendar-plus"></i> Estendi
        </button>`
                        : status === 'completed'
                            ? `<button class="btn btn-outline btn-small repeat-booking">
            <i class="fas fa-redo"></i> Ripeti prenotazione
        </button>
       <button class="btn btn-outline btn-small">
            <i class="fas fa-file-pdf"></i> Ricevuta
        </button>`
                            : status === 'missed'
                                ? `<button class="btn btn-outline btn-small repeat-booking">
            <i class="fas fa-redo"></i> Ripeti prenotazione
        </button>`
                                : `<button class="btn btn-outline btn-small cancel-booking">
            <i class="fas fa-times"></i> Annulla
        </button>`
                    }

                    </div>
                </div>
            `;
            });
        }
    });
</script>
>>>>>>> origin/Backend_logic

<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Prenotazioni</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../../css/reservations.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>

    <!-- Script that manages the reservations UX... -->
    <script src="../../js/manage_reservations.js" defer></script>
</head>

<body id="home">
    <?php
    $check = true;
    $path = "../";
    $admin = false;
    include_once '../page/header_navbar.php';

    $status = array(
        0 => 'pending',
        1 => 'active',
        2 => 'completed'
    );


    $conn = connectToDatabase();

    // Update reservation statuses based on current time
    $now = date('Y-m-d H:i:s');

    /*
    // Set to completed if end time is in the past and not canceled
    $conn->query("
    UPDATE reservations
    SET res_flag = -1
    WHERE res_end_time < '$now' AND res_flag != 0
    ");

    // Set to active if current time is between start and end and not canceled
    $conn->query("
    UPDATE reservations
    SET res_flag = 1
    WHERE res_start_time <= '$now' AND res_end_time > '$now' AND res_flag != 0
    ");

    // Set to pending if start time is in the future and not canceled
    $conn->query("
    UPDATE reservations
    SET res_flag = 0
    WHERE res_start_time > '$now' AND res_flag != 0
    ");
    */

    // Fetch all reservations for the logged-in user
    /*$reservations_result = $conn->query("
    SELECT r.res_id, r.res_start_time, r.res_end_time, r.res_day, r.res_flag, u.u_name, u.u_surname
    FROM reservations r
    INNER JOIN users u ON u.u_id = r.res_user 
    WHERE u.u_id = " . $_SESSION['id'] . "
    ORDER BY res_day DESC, res_start_time DESC
");*/
    $reservations_result = $conn->query("
SELECT 
    r.res_id, 
    r.res_start_time, 
    r.res_end_time, 
    r.res_day, 
    r.res_flag, 
    u.u_name, 
    u.u_surname,
    CASE 
        WHEN r.res_flag = 0 THEN -1
        WHEN r.res_flag = 1 AND (
            (r.res_day > CURDATE())
            OR (r.res_day = CURDATE() AND NOW() < CONCAT(r.res_day, ' ', r.res_start_time))
        ) THEN 0
        WHEN r.res_flag = 1 AND r.res_day = CURDATE() AND NOW() BETWEEN CONCAT(r.res_day, ' ', r.res_start_time) AND CONCAT(r.res_day, ' ', r.res_end_time) THEN 1
        WHEN r.res_flag = 1 AND (
            r.res_day < CURDATE()
            OR (r.res_day = CURDATE() AND NOW() >= CONCAT(r.res_day, ' ', r.res_end_time))
        ) THEN 2
        ELSE 'unknown'
    END AS res_status
FROM reservations r
INNER JOIN users u ON u.u_id = r.res_user 
WHERE u.u_id = " . $_SESSION['id'] . "
ORDER BY r.res_day DESC, r.res_start_time DESC
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

    // Close the connection
    $conn->close();

    // echo "<pre>" . print_r($reservations, true) . "</pre>";
    ?>

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

                <!--<?php echo "<pre>" . print_r($reservations, true) . "</pre>"; ?>-->
                <!-- Booking list -->
                <div class="bookings-list" id="bookings_page">
                    <?php if (isset($reservations) && !empty($reservations)): ?>
                        <!-- Fa la query a inizio pagina per ottenere $reservations, dopodichè  -->
                        <?php foreach ($reservations as $reservation): ?>
                            <div class="booking-card <?php echo $status[$reservation["res_status"]] ?>"
                                data-booking-id="PR-2023-001">
                                <div class="booking-header">
                                    <h3 class="booking-id">
                                        <?php echo "PR-" . $reservation["res_day"] . "_" . $reservation["res_id"] ?>
                                    </h3>
                                    <?php if ($reservation["res_status"] == -1): ?>
                                        <span class="booking-status cancelled">
                                            <i class="fa-solid fa-xmark"></i> Cancellata
                                        </span>
                                    <?php elseif ($reservation["res_status"] == 0): ?>
                                        <span class="booking-status pending">
                                            <i class="fas fa-hourglass-half"></i> In attesa
                                        </span>
                                    <?php elseif ($reservation["res_status"] == 1): ?>
                                        <span class="booking-status active">
                                            <i class="fas fa-laptop"></i> In corso
                                        </span>
                                    <?php elseif ($reservation["res_status"] == 2): ?>
                                        <span class="booking-status completed">
                                            <i class="fas fa-check-circle"></i> Terminata
                                        </span>
                                    <?php endif ?>
                                </div>

                                <div class="booking-details">
                                    <div class="detail-group">
                                        <h4 class="detail-label">Portatili prenotati:</h4>
                                        <ul class="laptops-list">
                                            <?php foreach ($reservation['laptops'] as $laptop): ?>
                                                <li><?php echo $laptop['lap_name'] . " (" . $laptop['mod_name'] . ")" ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                    <div class="detail-group">
                                        <h4 class="detail-label">Periodo:</h4>
                                        <p><?php echo "Dalle: " . substr($reservation["res_start_time"], 0, -3) . "  <br>Alle: " . substr($reservation["res_end_time"], 0, -3); ?>
                                        </p>
                                    </div>

                                    <div class="detail-group">
                                        <h4 class="detail-label">Data prenotazione:</h4>
                                        <p><?php echo date("d/m/Y", strtotime($reservation["res_day"])); ?></p>
                                    </div>
                                </div>

                                <div class="booking-actions">
                                    <?php if ($status[$reservation["res_status"]] == "pending"): ?>
                                        <button class="btn btn-danger cancel-booking"
                                            data-id="<?php echo $reservation["res_id"] ?>">
                                            <i class="fa-solid fa-xmark"></i> Elimina
                                        </button>
                                    <?php endif ?>
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

    <?php include_once "../page/footer.php" ?>

</body>

</html>
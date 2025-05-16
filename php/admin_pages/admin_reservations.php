<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Gestione prenotazioni</title>

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
    $check = false;
    $path = "../";
    include_once '../page/header_navbar.php';


    $conn = connectToDatabase();

    // Fetch all reservations for the logged-in user
    $reservations_result = $conn->query("
    SELECT r.res_id, r.res_start_time, r.res_end_time, r.res_day, r.res_flag, u.u_name, u.u_surname
    FROM reservations r
    INNER JOIN users u ON u.u_id = r.res_user 
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

    // Close the connection
    $conn->close();
    ?>


    <main>
        <section id="prenotazioni" class="my-bookings-section">
            <div class="main-container">
                <h2 class="section-header">Prenotazioni</h2>

                <div class="bookings-filters">
                    <div class="search-box admin">
                        <div class="input-group">
                            <i class="fas fa-search"></i>
                            <input type="text" id="booking-search" placeholder="Cerca per ID o modello...">
                        </div>
                    </div>
                </div>


                <!-- Booking list -->
                <div class="bookings-list">

                    <?php if (isset($reservations) && !empty($reservations)): ?>
                        <!-- Fa la query a inizio pagina per ottenere $reservations -->
                        <?php foreach ($reservations as $reservation): ?>
                            <div class="booking-card" data-booking-id="PR-2023-001">
                                <div class="booking-header">
                                    <h3 class="booking-id">
                                        <?php echo "PR-" . $reservation["res_day"] . "-" . $reservation["res_id"] ?>
                                    </h3>
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
                                    <div class="detail-group">
                                        <h4 class="detail-label">Utente:</h4>
                                        <p><?php echo $reservation["u_surname"] . " " . $reservation["u_name"] ?></p>
                                    </div>
                                </div>

                                <div class="booking-actions">
                                    <button class="btn btn-danger">
                                        <i class="fa-solid fa-xmark"></i> Elimina
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

    <?php include_once "../page/footer.php" ?>

</body>

</html>
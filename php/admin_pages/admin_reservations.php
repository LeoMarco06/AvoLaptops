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
    <?php include_once '../header_navbar.php'; ?>

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
                                    <h3 class="booking-id">PR-2023-001</h3>
                                    <button class="btn btn-outline btn-small confirm-button">
                                        <i class="fa-solid fa-check"></i> Conferma
                                    </button>
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
                    <div class="no-bookings-message" <?php isset($reservations) && !empty($reservations)?"":"style=\"display:block;\"" ?>>
                        <i class="fas fa-calendar-times"></i>
                        <p>Nessuna prenotazione trovata</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "../footer.php" ?>

</body>

</html>
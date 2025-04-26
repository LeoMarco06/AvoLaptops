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
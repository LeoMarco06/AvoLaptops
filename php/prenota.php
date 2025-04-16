<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Noleggio Portatili | IIS Amedeo Avogadro</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Link to the booking styles sheet -->
    <link rel="stylesheet" href="../css/prenota.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../js/page_setup.js" defer></script>

    <script src="../js/book.js"></script>
</head>

<body>
    <?php include_once 'header_navbar.php'; ?>

    <main>
        <section id="prenotazione" class="booking-section">
            <div class="main-container">
                <h2 class="section-header">Prenotazione Portatili</h2>

                <!-- Filters -->
                <div class="booking-filters">
                    <div class="filter-group">
                        <label for="booking-date">Data prenotazione:</label>
                        <input type="date" id="booking-date" class="form-control">
                    </div>
                    <div class="filter-group">
                        <label for="return-date">Data restituzione:</label>
                        <input type="date" id="return-date" class="form-control">
                    </div>
                    <button class="btn btn-primary">Applica filtri</button>
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
                            <button id="confirm-booking" class="btn btn-primary btn-small" disabled>Conferma prenotazione</button>
                        </div>
                    </div>
                </div>

                <!-- Lockers list -->
                <div class="lockers-container">
                    <h3 class="heading-3">Seleziona dall'armadietto</h3>
                    <div class="lockers-grid">
                        <!-- Armadietto 1 -->
                        <div class="locker-card">
                            <div class="locker-header">
                                <h4 class="heading-4">Armadietto A1</h4>
                                <span class="locker-status">4/6 disponibili</span>
                            </div>
                            <div class="locker-laptops">
                                <!-- Portatile 1 -->
                                <div class="laptop-item available" data-laptop-id="A1-001">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-001 (Modello 1)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- Portatile 2 -->
                                <div class="laptop-item available" data-laptop-id="A1-002">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-002 (Modello 1)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Portatile 3 - In manutenzione -->
                                <div class="laptop-item maintenance" data-laptop-id="A1-003">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-003 (Modello 2)</span>
                                    </div>
                                    <span class="status-badge"><i class="fas fa-tools"></i> Manutenzione</span>
                                </div>

                                <!-- Portatile 4 - Non disponibile -->
                                <div class="laptop-item unavailable" data-laptop-id="A1-004">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-004 (Modello 2)</span>
                                    </div>
                                    <span class="status-badge"><i class="fas fa-times"></i> Non disponibile</span>
                                </div>

                                <!-- Portatile 5 -->
                                <div class="laptop-item available" data-laptop-id="A1-005">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-005 (Modello 1)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Portatile 6 -->
                                <div class="laptop-item available" data-laptop-id="A1-006">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-006 (Modello 2)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Portatile 7 -->
                                <div class="laptop-item available" data-laptop-id="A1-006">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-007 (Modello 2)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Armadietto 2 -->
                        <div class="locker-card">
                            <div class="locker-header">
                                <h4 class="heading-4">Armadietto A2</h4>
                                <span class="locker-status">2/5 disponibili</span>
                            </div>
                            <div class="locker-laptops">
                                <!-- Portatili armadietto 2... -->
                                <div class="laptop-item available" data-laptop-id="A2-001">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A2-001 (Modello 1)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <div class="laptop-item unavailable" data-laptop-id="A2-002">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A2-002 (Modello 1)</span>
                                    </div>
                                    <span class="status-badge"><i class="fas fa-times"></i> Non disponibile</span>
                                </div>

                                <div class="laptop-item maintenance" data-laptop-id="A2-003">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A2-003 (Modello 2)</span>
                                    </div>
                                    <span class="status-badge"><i class="fas fa-tools"></i> Manutenzione</span>
                                </div>

                                <div class="laptop-item maintenance" data-laptop-id="A2-004">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A2-004 (Modello 2)</span>
                                    </div>
                                    <span class="status-badge"><i class="fas fa-tools"></i> Manutenzione</span>
                                </div>

                                <div class="laptop-item available" data-laptop-id="A2-005">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A2-005 (Modello 1)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Altri armadietti... -->
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "footer.php" ?>

</body>

</html>
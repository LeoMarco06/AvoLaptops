<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Admin</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../js/page_setup.js" defer></script>
</head>

<body id="home">
    <?php include_once 'header_navbar.php'; ?>

    <main>
        <section class="main-banner">
            <div class="main-container">
                <div class="banner-content">
                    <h1 class="heading-1">Area Moderatore</h1>
                    <p>Questa pagina web è un collegamento per gli utenti admin che permette di usufruire ai servizi di
                        moderatore. Premi sui collegamenti qua sotto per essere reindirizzato alla pagina a cui sei
                        interessato.</p>
                </div>
            </div>
        </section>

        <section id="servizi" class="features-section">
            <div class="main-container">
                <h2 class="section-header">Servizi admin</h2>
                <div class="features-grid admin-features">
                    <a class="feature-item" href="admin_pages/admin_users.php">
                        <div class="feature-icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="heading-3">Utenti</h3>
                        <p>Aggiungi o elimina i dati degli utenti registrati</p>
                    </a>
                    <a class="feature-item" href="admin_pages/admin_laptops.php">
                        <div class="feature-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3 class="heading-3">Gestione laptop</h3>
                        <p>Aggiungi/Elimina i laptop salvati nel database</p>
                    </a>
                    <a class="feature-item" href="admin_pages/admin_lockers.php">
                        <div class="feature-icon">
                            <i class="fa-solid fa-box"></i>
                        </div>
                        <h3 class="heading-3">Gestione armadietti</h3>
                        <p>Aggiungi/Elimina gli armadietti salvati nel database</p>
                    </a>
                    <a class="feature-item" href="admin_pages/admin_reservations.php">
                        <div class="feature-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <h3 class="heading-3">Gestione prenotazioni</h3>
                        <p>Gestisci le prenotazioni effettuate dagli utenti registrati</p>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "footer.php" ?>

</body>

</html>
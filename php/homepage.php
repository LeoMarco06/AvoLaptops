<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Noleggio Portatili | IIS Amedeo Avogadro</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../css/styles.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../css/responsive.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../js/page_setup.js" defer></script>
</head>

<body>
    <?php include_once 'header_navbar.php'; ?>

    <main>
        <section id="home" class="main-banner">
            <div class="main-container">
                <div class="banner-content">
                    <h1 class="heading-1">Noleggio Portatili Scolastici</h1>
                    <p>Prenota il tuo dispositivo per le lezioni, progetti e studio in tutta semplicità</p>
                    <div class="banner-actions">
                        <button class="btn btn-primary" onclick="window.location.replace('prenota.php')">Prenota ora</button>
                        <button class="btn btn-outline" onclick="window.location.replace('https\:\/\/www.itisavogadro.edu.it')">La nostra scuola</button>
                    </div>
                </div>
                <div class="banner-image">
                    <img src="../img/avo-img.png" alt="Portatile scolastico">
                </div>
            </div>
        </section>

        <section id="servizi" class="features-section">
            <div class="main-container">
                <h2 class="section-header">Come funziona</h2>
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="heading-3">Scegli il dispositivo</h3>
                        <p>Seleziona tra i nostri portatili disponibili quello che fa per te</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="heading-3">Prenota il periodo</h3>
                        <p>Indica le date in cui ti servirà il dispositivo</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fa-solid fa-hand"></i>
                        </div>
                        <h3 class="heading-3">Ritira i computer</h3>
                        <p>Mostra la tua prenotazione a chi gestisce i pc e ritirali</p>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3 class="heading-3">Utilizza e restituisci</h3>
                        <p>Al termine del periodo, riconsegna il dispositivo in segreteria</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="portatili" class="products-section">
            <div class="main-container">
                <h2 class="section-header">Modelli</h2>
                <div class="products-grid">
                    <!-- Device models -->
                    <div class="product-card">
                        <div class="product-image">
                            <img src="../img/model1.png" alt="Portatile base">
                        </div>
                        <div class="product-details">
                            <h3 class="heading-3">Modello 1</h3>
                            <ul class="product-specs">
                                <li><i class="fas fa-microchip"></i> Intel i3-1115G4</li>
                                <li><i class="fas fa-memory"></i> 8GB RAM</li>
                                <li><i class="fas fa-hdd"></i> 256GB SSD</li>
                                <li><i class="fas fa-tv"></i> 15.6" FHD</li>
                            </ul>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-image">
                            <img src="../img/model2.png" alt="Portatile base">
                        </div>
                        <div class="product-details">
                            <h3 class="heading-3">Modello 2</h3>
                            <ul class="product-specs">
                                <li><i class="fas fa-microchip"></i> Intel i3-1115G4</li>
                                <li><i class="fas fa-memory"></i> 8GB RAM</li>
                                <li><i class="fas fa-hdd"></i> 256GB SSD</li>
                                <li><i class="fas fa-tv"></i> 15.6" FHD</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Other models... -->
                </div>
            </div>
        </section>

        <section class="cta-section">
            <div class="main-container">
                <div class="cta-content">
                    <h2 class="heading-2">Pronto a noleggiare?</h2>
                    <p>Accedi con le tue credenziali scolastiche per prenotare il tuo dispositivo</p>
                    <button class="btn btn-primary" onclick="window.location.replace('login.php#login')">Accedi ora</button>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "footer.php" ?>

</body>

</html>
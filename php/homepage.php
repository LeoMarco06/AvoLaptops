<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | IIS Amedeo Avogadro</title>

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

    <?php
    $check = false;
    $path = "./";
    $admin = false;
    include_once './page/header_navbar.php';
    include_once 'include/connection.php';
    $conn = connectToDatabase();
    $stmt = $conn->prepare("SELECT * FROM models");
    $stmt->execute();
    $models = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    ?>

    <main>
        <section class="main-banner">
            <div class="main-container">
                <div class="banner-content">
                    <h1 class="heading-1">Avo Laptops</h1>
                    <p>Prenota il tuo dispositivo per le lezioni, progetti e studio in tutta semplicità</p>
                    <div class="banner-actions">
                        <button class="btn btn-primary"
                            onclick="window.location.replace('./reservation/prenota.php')">Prenota
                            ora</button>
                        <button class="btn btn-outline"
                            onclick="window.location.replace('https\:\/\/www.itisavogadro.edu.it')">La nostra
                            scuola</button>
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
                    <?php foreach ($models as $model): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="../img/deafult_model.png" alt="Portatile base">
                            </div>
                            <div class="product-details">
                                <h3 class="heading-3">Modello <?php echo $model["mod_id"] ?></h3>
                                <ul class="product-specs">
                                    <li><i class="fas fa-microchip"></i> <?php echo $model["mod_CPU"] ?></li>
                                    <li><i class="fas fa-memory"></i> <?php echo $model["mod_RAM"] ?>GB RAM</li>
                                    <li><i class="fas fa-hdd"></i> <?php echo $model["mod_memory"] ?>GB SSD</li>
                                    <li><i class="fas fa-tv"></i> <?php echo $model["mod_display"] ?>" FHD</li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <div class="main-container">
                <div class="cta-content">
                    <h2 class="heading-2">Pronto a prenotare?</h2>
                    <?php if (!isset($_SESSION['id'])): ?>
                        <p>Accedi con le tue credenziali scolastiche per prenotare il tuo dispositivo</p>
                        <button class="btn" onclick="window.location.replace('./user/login.php#login')">Accedi
                            ora</button>
                    <?php else: ?>
                        <p>Visita la pagina dedicata per prenotare i laptop</p>
                        <button class="btn" onclick="window.location.replace('./reservation/prenota.php#login')">Prenota
                            ora</button>
                    <?php endif ?>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "./page/footer.php" ?>

</body>

</html>
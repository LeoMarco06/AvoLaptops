<!DOCTYPE html>
<html lang="it" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Statistiche</title>

    <!-- Link to the styles sheet -->
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- Link to the responsive styles sheet -->
    <link rel="stylesheet" href="../../css/responsive.css">

    <!-- Link to the statistics styles sheet -->
    <link rel="stylesheet" href="../../css/statistics.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>
</head>

<body id="home">
    <?php include_once '../header_navbar.php'; ?>

    <main>
        <section class="main-banner">
            <div class="main-container">
                <div class="banner-content">
                    <h1 class="heading-1">Statistiche</h1>
                    <p>In questa pagina puoi trovare infografiche e dati sulle prenotazioni che sono state fatte fino al
                        giorno d'oggi, ad esempio in che orari sono più richiesti, per quante ore in media, se sono
                        richiesti portatili maggiormente da
                        professori o professoresse e così via.</p>
                </div>
            </div>
        </section>

        <section id="servizi" class="features-section">
            <div class="main-container">
                <div class="statistics-container">
                    <!--ESEMPIO INFOGRAFICA-->
                    <div class="statistic-item">
                        <h2 class="header2">INFOGRAFICA 1</h2>
                        <!--<div class="statistics-graph"></div>-->
                    </div>


                    <!--ALTRE INFOGRAFICHE-->

                    <?php if(isset($_SESSION["u_role"]) && $_SESSION["u_role"] == 0): ?>
                        <!--INFOGRAFICHE ADMIN-->
                    <?php endif ?>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "../footer.php" ?>

</body>

</html>
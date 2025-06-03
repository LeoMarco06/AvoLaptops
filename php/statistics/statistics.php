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
    <link rel="stylesheet" href="../../css/auth.css">

    <!-- Link to the statistics styles sheet -->
    <link rel="stylesheet" href="../../css/statistics.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Script that manages the theme mode, animations, navbar... -->
    <script src="../../js/page_setup.js" defer></script>
    <script type="text/javascript" src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
</head>

<body id="home">
    <?php
    $check = true;
    $path = "../";
    include_once '../page/header_navbar.php';

    $conn = connectToDatabase();

    /***  COUNTING AVAILABLE LAPTOPS  ***/
    $query = "  SELECT COUNT(lap_id) as id
                    FROM laptops
                    WHERE lap_status = 1 ";
    $result = $conn->query($query);
    //echo $conn->error;
    if ($result) {
        $row = $result->fetch_array();
        $available_laptops = $row["id"];
        //echo $available_laptops;
    }

    /***  COUNTING UNAVAILABLE LAPTOPS   ***/
    $query = "  SELECT COUNT(lap_id) as id
                    FROM laptops
                    WHERE lap_status = 0 ";
    $result = $conn->query($query);
    //echo $conn->error;
    if ($result) {
        $row = $result->fetch_array();
        $unavailable_laptops = $row["id"];
        //echo $unavailable_laptops;
    }

    /***  COUNTING LAPTOPS IN MAINTENANCE  ***/
    $query = "  SELECT COUNT(lap_id) as id
                    FROM laptops
                    WHERE lap_status = -1 ";
    $result = $conn->query($query);
    //echo $conn->error;
    if ($result) {
        $row = $result->fetch_array();
        $maintenance_laptops = $row["id"];
        //echo $maintenance_laptops;
    }

    /****  ABOUT USERS   ****/
    /***  COUNT ALL USERS REGISTERED   ***/
    $query = "  SELECT COUNT(u_id)
                    FROM users";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $total_users = $row["COUNT(u_id)"];
    }
    /***  COUNT ALL USERS WITH FLAG 1 (authorized) THAT MADE A MINIMUM OF 1 RESERVATION  ***/
    $query = "  SELECT COUNT(DISTINCT u_id)
                    FROM users 
                    INNER JOIN reservations r 
                    ON u_id = res_user 
                    WHERE u_authorized = 1";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $users_res = $row["COUNT(DISTINCT u_id)"];
    }
    /***  COUNT USERS NOT AUTHORIZED   ***/
    $query = "  SELECT COUNT(u_id)
                    FROM users
                    WHERE u_authorized = 0";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $users_unauth = $row["COUNT(u_id)"];
    }
    /***  COUNT USERS AUTHORIZED   ***/
    $query = "  SELECT COUNT(u_id)
                    FROM users
                    WHERE u_authorized = 1";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $users_auth = $row["COUNT(u_id)"];
    }
    ?>

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

                    <!--INFOGRAFICA 1-->
                    <div class="statistic-item">
                        <h2 class="header2">Stato dei portatili</h2>
                        <div id="chartContainer1" style="width: 55%; height: 300px; display: inline-block;"></div>
                        <!--PULSANTE CHE ESPORRTA SOLO IN PDF-->
                        <!--<div class="pulsante"><input type="submit" id="exportLaptops" value="Esporta come PDF" class="btn btn-primary"></div>-->
                    </div>

                    <!--INFOGRAFICA 2-->
                    <div class="statistic-item">
                        <h2 class="header2">Utenti</h2>
                        <div id="chartContainer2" style="width: 90%; height: 300px; display: inline-block;"></div>
                        <!--PULSANTE CHE ESPORRTA SOLO IN PDF-->
                        <!--<div class="pulsante"><input type="submit" id="exportUsers" value="Esporta come PDF" class="btn btn-primary"></div>-->
                    </div>

                    <?php
                    if (isset($_SESSION["u_role"]) && $_SESSION["u_role"] == 0): ?>
                        <!--INFOGRAFICHE ADMIN-->
                    <?php endif ?>
                </div>
                <br><br>
                <label for="year">Se vuoi visualizzare un grafico temporale riguardo alla quantità di prenotazioni
                    sono avvenute in un anno, di seguito seleziona l'anno.</label><br>
                <form class="form-year" action="temporal_graphic.php" method="POST">
                    <select name="year" required>
                        <?php
                        $sql = "SELECT DISTINCT YEAR(res_day) AS res_year
                        FROM reservations";
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['res_year'] . '">' . $row['res_year'] . '</option><br><br>';
                        }
                        ?>
                    </select><br>

                    <div class="pulsante"><input type="submit" value="Invia" class="btn btn-primary"></div>
                </form>
            </div>
        </section>

        <script>
            window.onload = function () {
                /*  GRAPHIC FOR THE STATUS OF ALL LAPTOPS */
                var chart = new CanvasJS.Chart("chartContainer1",
                    {
                        //backgroundColor: "transparent",
                        exportEnabled: true,
                        exportFileName: "GraficoPortatili",
                        animationEnabled: true,
                        data: [
                            {
                                type: "pie",
                                yValueFormatString: "##0.00\"%\"",
                                indexLabel: "{label} {y}",
                                showInLegend: true,
                                dataPoints: [
                                    { y: <?php echo ($available_laptops) ?>, legendText: " <?php echo "portatili disponibili: " . $available_laptops ?>", label: "<?php echo "% disponibili" ?>" },
                                    { y: <?php echo ($maintenance_laptops) ?>, legendText: "<?php echo "portatili in manutenzione: " . $maintenance_laptops ?>", label: "<?php echo '%  in manutenzione' ?>" },
                                    { y: <?php echo ($unavailable_laptops) ?>, legendText: "<?php echo "portatili non disponibili: " . $unavailable_laptops ?>", label: "<?php echo '%  non disponibili' ?>" }
                                ]
                            }
                        ]
                    });
                chart.render();
                /*** SCARICA IN FORMATO PDF !!***/
                /*var canvasLaptop = $("#chartContainer1 .canvasjs-chart-canvas").get(0);
                $("#exportLaptops").click(function () {
                    var dataURL = canvasLaptop.toDataURL();
                    var pdf = new jsPDF();
                    pdf.addImage(dataURL, 'JPEG', 15, 10); //addImage(image, format, x-coordinate, y-coordinate, width, height)
                    pdf.save("chartLaptop.pdf");
                }); */

                var chart = new CanvasJS.Chart("chartContainer2",
                    {
                        //backgroundColor: "transparent",
                        exportEnabled: true,
                        exportFileName: "GraficoUtenti",
                        animationEnabled: true,
                        data: [
                            {
                                type: "pie",
                                yValueFormatString: "##0.00\"%\"",
                                indexLabel: "{label} {y}",
                                showInLegend: true,
                                dataPoints: [
                                    { y: <?php echo ($total_users) ?>, legendText: " <?php echo "totale degli utenti registrati: " . $total_users ?>", label: " <?php echo "% registrati" ?>" },
                                    { y: <?php echo ($users_res) ?>, legendText: "<?php echo "utenti con almeno una prenotazione effettuata: " . $users_res ?>", label: " <?php echo "% almeno 1 prenotazione effettuata" ?>" },
                                    { y: <?php echo ($users_auth) ?>, legendText: "<?php echo "utenti autorizzati: " . $users_auth ?>", label: " <?php echo "%  autorizzati" ?>" },
                                    { y: <?php echo ($users_unauth) ?>, legendText: "<?php echo "utenti non autorizzati: " . $users_unauth ?>", label: " <?php echo "%  non autorizzati" ?>" },
                                ]
                            }
                        ]
                    });
                chart.render();

                /*** SCARICA IN FORMATO PDF !!***/
                /*var canvasUsers = $("#chartContainer2 .canvasjs-chart-canvas").get(0);
                $("#exportUsers").click(function () {
                    var dataURL = canvasUsers.toDataURL();
                    var pdf = new jsPDF();
                    pdf.addImage(dataURL, 'JPEG', 15, 10); //addImage(image, format, x-coordinate, y-coordinate, width, height)
                    pdf.save("chartUsers.pdf");
                });*/
            };
        </script>
    </main>

    <?php include_once "../page/footer.php" ?>

</body>

</html>
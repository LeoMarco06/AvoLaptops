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
    <script type="text/javascript" src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
    <script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.stock.min.js"></script>
</head>

<body id="home">
    <?php
    $check = true;
    $path = "../";
    include_once '../page/header_navbar.php';

    $conn = connectToDatabase();

    $year = $_REQUEST['year'];
    //echo $year;
    
    /****  COUNTING ALL RESERVATIONS OF THE YEAR   ****/
    /***  COUNTING RESERVATIONS OF JANUARY  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 01 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $jan_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF FEBRUARY  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 02 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $feb_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF MARCH  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 03 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $mar_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF APRIL  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 04 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $apr_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF MAY  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 05 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $apr_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF JUNE  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 06 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $jun_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF JULY  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 07 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $jul_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF AUGUST  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 08 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $aug_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF SEPTEMBER  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 09 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $sep_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF OCTOBER  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 10 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $oct_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF NOVEMBER  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 11 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $nov_reservation = $row["COUNT(res_id)"];
    }

    /***  COUNTING RESERVATIONS OF DECEMBER  ***/
    $query = "  SELECT COUNT(res_id)
                    FROM reservations
                    WHERE MONTH(res_day) = 12 AND YEAR(res_day) = $year";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_array();
        $dec_reservation = $row["COUNT(res_id)"];
    }
    ?>

    <main>
        <section class="main-banner">
            <div class="main-container">
                <div class="banner-content">
                    <h1 class="heading-1">Statistica temporale</h1>
                    <p></p>
                </div>
            </div>
        </section>

        <section id="servizi" class="features-section">
            <div class="main-container">
                <div class="statistics-container">

                    <!--ESEMPIO INFOGRAFICA-->
                    <div class="statistic-item">
                        <h2 class="header2">RESERVATIONS DURING THE YEAR <?php echo $year ?></h2>
                        <div id="StockChartContainer" style="width: 55%; height: 300px; display: inline-block;"></div>
                    </div>
                </div>
        </section>

        <script>
            window.onload = function () {
                /*  GRAPHIC FOR THE RESERVATIONS OF THE YEAR */
                var stockChart = new CanvasJS.StockChart("StockChartContainer",
                    {
                        backgroundColor: "transparent",
                        animationEnabled: true,
                        charts: [{
                            axisX: {
                                title: "Month",
                                valueFormatString: "MMM YYYY",
                                titleFontSize: 14
                            },
                            axisY: {
                                title: "Quantity of laptops",
                                titleFontSize: 14
                            },
                            data: [{
                                type: "column",
                                yValueFormatString: "##0.00\"%\"",
                                dataPoints: [
                                    { x: new Date(<?php echo $year ?>, 0), y: <?php echo $jan_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 1), y: <?php echo $feb_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 2), y: <?php echo $mar_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 3), y: <?php echo $apr_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 4), y: <?php echo $apr_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 5), y: <?php echo $jun_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 6), y: <?php echo $jul_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 7), y: <?php echo $aug_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 8), y: <?php echo $sep_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 9), y: <?php echo $oct_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 10), y: <?php echo $nov_reservation ?> },
                                    { x: new Date(<?php echo $year ?>, 11), y: <?php echo $dec_reservation ?> }
                                ]
                            }]
                        }],
                    });
                stockChart.render();
            };
        </script>
    </main>

    <?php include_once "../page/footer.php" ?>

</body>

</html>
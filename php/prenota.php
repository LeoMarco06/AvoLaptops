<!DOCTYPE html>
<html lang="it" data-theme="light">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Title of the browser tab -->
    <title>Avo Laptops | Prenota ora</title>

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

    <!-- Script that manages the booking UX... -->
    <script src="../js/book.js" defer></script>
</head>

<?php
include './include/connection.php';
$conn = connectToDatabase();

$day = "2025-04-23";
$start_time = "13:00:00";
$end_time = "15:00:00";

// query to get all laptops with their status
// and model name, and check if they are reserved during the specified time
// and date
// status 1 = available, 0 = unavailable, -1 = maintenance
$sql = "SELECT 
            l.lap_id, 
            l.lap_name, 
            l.lap_status,
            l.lap_locker, 
            m.mod_name AS lap_model,
            CASE 
                WHEN r.res_id IS NOT NULL AND r.res_day = '" . $day . "' 
                     AND ('" . $start_time . "' < r.res_end_time AND '" . $end_time . "' > r.res_start_time)
                THEN 0 
                ELSE l.lap_status 
            END AS updated_status
        FROM laptops l
        LEFT JOIN laptops_reservations lr 
            ON lr.lap_id = l.lap_id
        LEFT JOIN reservations r 
            ON r.res_id = lr.res_id
        LEFT JOIN models m 
            ON m.mod_id = l.lap_model";

$result = $conn->query($sql);

$laptops = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $laptops[] = $row;
    }
}

$laptops_json = json_encode($laptops);
?>

<body>
    <?php include_once 'header_navbar.php'; ?>

    <main>
        <section id="prenotazione" class="booking-section">
            <div class="main-container">
                <h2 class="section-header">Prenotazione Portatili</h2>
                <form action="./manda_prenotazione.php" method="POST">
                    <div>
                        <!-- Filters -->
                        <div class="booking-filters">
                            <div class="filter-group">
                                <label for="booking-date">Data prenotazione:</label>
                                <input type="date" name="data-prenotazione" id="booking-date" class="form-control">
                            </div>
                            <div class="filter-group">
                                <label for="return-date">Data restituzione:</label>
                                <input type="date" name="data-restituzione" id="return-date" class="form-control">
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
                                    <button id="clear-selection" class="btn btn-outline btn-small" type="button">Annulla
                                        selezione</button>

                                    <button id="confirm-booking" class="btn btn-primary btn-small" type="submit"
                                        disabled>Conferma prenotazione</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <!-- Lockers list -->
                <div class="lockers-container">
                    <h3 class="heading-3">Seleziona dall'armadietto</h3>
                    <div class="lockers-grid">

                        <!-- Locker Example -->
                        <div class="locker-card">
                            <div class="locker-header">
                                <h4 class="heading-4">Armadietto B1</h4>
                                <span class="locker-status">1/3 disponibili</span>
                            </div>
                            <div class="locker-laptops">
                                <!-- Available Laptop -->
                                <div class="laptop-item available" data-laptop-id="B1-001">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>B1-001 (Modello 1)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>

                                <!-- Maintenance Laptop -->
                                <div class="laptop-item maintenance" data-laptop-id="B1-002">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>B1-002 (Modello 2)</span>
                                    </div>
                                    <span class="status-badge">
                                        <i class="fas fa-tools"></i> Manutenzione
                                    </span>
                                </div>

                                <!-- Unavailable Laptop -->
                                <div class="laptop-item unavailable" data-laptop-id="B1-003">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>B1-003 (Modello 3)</span>
                                    </div>
                                    <span class="status-badge">
                                        <i class="fas fa-times"></i> Non disponibile
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>

    <?php include_once "footer.php" ?>

</body>

</html>

<script>
    function createLaptop(laptop) {
        const div = document.createElement('div');
        div.dataset.laptopId = laptop.id;

        const info = `
        <div class="laptop-info">
            <i class="fas fa-laptop"></i>
            <span>${laptop.name} (${laptop.model})</span>
        </div>
    `;

        if (laptop.status == "1") {
            div.classList.add('laptop-item', "available");
            div.innerHTML = info + `
            <button class="btn-icon select-laptop">
                <i class="fas fa-plus"></i>
            </button>
        `;

        } else if (laptop.status == "-1") {
            div.classList.add('laptop-item', "maintenance");
            div.innerHTML = info + `
            <span class="status-badge"><i class="fas fa-tools"></i> Maintenance</span>
        `;
        } else if (laptop.status == "0") {
            div.classList.add('laptop-item', "unavailable");
            div.innerHTML = info + `
            <span class="status-badge"><i class="fas fa-times"></i> Unavailable</span>
        `;
        }
        return div;
    }


    function createLocker(locker) {
        const card = document.createElement('div');

        card.classList.add('locker-card');

        const header = `
        <div class="locker-header">
            <h4 class="heading-4">${locker.name}</h4>
            <span class="locker-status">${locker.available}/${locker.total} available</span>
        </div>
    `;

        const laptopContainer = document.createElement('div');
        laptopContainer.classList.add('locker-laptops');
        locker.laptops.forEach(laptop => {
            const laptopElement = createLaptop(laptop);
            laptopContainer.appendChild(laptopElement);
        });
        card.innerHTML = header;
        card.appendChild(laptopContainer);
        return card;
    }
    function loadAllLockers(data) {
        const container = document.querySelector('.lockers-grid');
        container.innerHTML = ''; // clear existing content
        data.forEach(locker => {
            const card = createLocker(locker);
            container.appendChild(card);
        });
    }
    // Group laptops by locker
    function groupByLocker(data) {
        const lockerMap = {};
        data.forEach(item => {
            const lockerId = item.lap_locker;
            if (!lockerMap[lockerId]) {
                lockerMap[lockerId] = {
                    name: `Locker ${lockerId}`,
                    total: 0,
                    available: 0,
                    laptops: []
                };
            }
            const laptop = {
                id: item.lap_id,
                name: item.lap_name,
                model: item.lap_model,
                status: item.updated_status // change this logic if needed
            };
            lockerMap[lockerId].laptops.push(laptop);
            lockerMap[lockerId].total++;
            if (item.updated_status == "1") { // updated condition to check updated_status
                lockerMap[lockerId].available++;
            }
        });
        return Object.values(lockerMap);
    }

    const lockersData = <?php echo $laptops_json; ?>;

    const groupedLockers = groupByLocker(lockersData);

    loadAllLockers(groupedLockers);
</script>
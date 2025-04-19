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

<?php
include './include/connection.php';
$conn = connectToDatabase();

$sql = "SELECT lap_id, lap_locker, m.mod_name as lap_model, lap_status, lap_name 
        FROM laptops l
        INNER JOIN models as m 
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
                            <button id="confirm-booking" class="btn btn-primary btn-small" disabled>Conferma
                                prenotazione</button>
                        </div>
                    </div>
                </div>

                <!-- Lockers list -->
                <div class="lockers-container">
                    <h3 class="heading-3">Seleziona dall'armadietto</h3>
                    <div class="lockers-grid">
                        <!-- Locker Example -->
                        <div class="locker-card">
                            <div class="locker-header">
                                <h4 class="heading-4">Armadietto A1</h4>
                                <span class="locker-status">4/6 disponibili</span>
                            </div>
                            <div class="locker-laptops">
                                <!-- Laptop Example -->
                                <div class="laptop-item available" data-laptop-id="A1-001">
                                    <div class="laptop-info">
                                        <i class="fas fa-laptop"></i>
                                        <span>A1-001 (Modello 1)</span>
                                    </div>
                                    <button class="btn-icon select-laptop">
                                        <i class="fas fa-plus"></i>
                                    </button>
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
                status: item.lap_status // change this logic if needed
            };

            lockerMap[lockerId].laptops.push(laptop);
            lockerMap[lockerId].total++;
            if (item.lap_status == "1") {
                lockerMap[lockerId].available++;
            }
        });

        return Object.values(lockerMap);
    }

    const lockersData = <?php echo $laptops_json; ?>;

    const groupedLockers = groupByLocker(lockersData);
    loadAllLockers(groupedLockers);

</script>
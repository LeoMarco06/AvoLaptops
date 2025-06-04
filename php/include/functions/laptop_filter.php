<?php
header("Content-Type: application/json");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$day = htmlspecialchars($_GET['date']);
$start_time = htmlspecialchars($_GET['start_time']);
$end_time = htmlspecialchars($_GET['end_time']);


$check = true;
$path = "../../";
$admin = false;
include_once '../session_check.php';

// Query to the database to get the laptops that are available for the given date and time
$conn = connectToDatabase();

$current_datetime = date('Y-m-d H:i:s');

$sql = "SELECT 
    l.lap_id, 
    l.lap_name, 
    l.lap_locker,
    lck.lock_class, 
    m.mod_name AS lap_model,
    CASE 
        WHEN MAX(
            CASE 
                WHEN r.res_day = ? 
                     AND ? < r.res_end_time AND ? > r.res_start_time 
                THEN 1 
                ELSE 0 
            END
        ) = 1 THEN 0 
        WHEN MAX(
            CASE 
                WHEN r.res_day = ?
                     AND TIME_TO_SEC(TIMEDIFF(?, r.res_end_time)) / 60 BETWEEN 0 AND 61 
                THEN 1 
                ELSE 0 
            END
        ) = 1 THEN 2 
        WHEN l.lap_status = -1 THEN -1 
        ELSE 1 
    END AS lap_status
FROM laptops l
LEFT JOIN laptops_reservations lr 
    ON lr.lap_id = l.lap_id
LEFT JOIN reservations r 
    ON r.res_id = lr.res_id
LEFT JOIN models m 
    ON m.mod_id = l.lap_model
INNER JOIN lockers lck 
    ON lck.lock_id = l.lap_locker
GROUP BY l.lap_id;";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nella preparazione della query', 'details' => $conn->error]);
    exit;
}

if (!$stmt->bind_param("sssss", $day, $start_time, $end_time, $day, $start_time)) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nel bind dei parametri', 'details' => $stmt->error]);
    exit;
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nell\'esecuzione della query', 'details' => $stmt->error]);
    exit;
}

$result = $stmt->get_result();
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Errore nel recupero dei risultati', 'details' => $stmt->error]);
    exit;
}

$data = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($data);

$conn->close();
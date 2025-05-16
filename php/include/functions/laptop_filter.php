<?php
$date = htmlspecialchars($_GET['date']);
$start_time = htmlspecialchars($_GET['start_time']);
$end_time = htmlspecialchars($_GET['end_time']);

include "../connection.php";

// Query to the database to get the laptops that are available for the given date and time
$conn = connectToDatabase();

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

$stmt->bind_param("sss", $date, $start_time, $end_time);

$stmt->execute();

$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

header("Content-Type: application/json");
echo json_encode($result);

$conn->close();
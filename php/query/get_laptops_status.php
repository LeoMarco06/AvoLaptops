<?php
include '../include/connection.php';
$conn = connectToDatabase();

/*$day = $_POST["date"] ?? null;
$start_time = $_POST["start-time"] ?? null;
$end_time = $_POST["end-time"] ?? null;*/

$day = "2025-04-23";
$start_time = "13:00:00";
$end_time = "15:00:00";

if (!$day || !$start_time || !$end_time) {
    echo json_encode(["error" => "Missing required parameters"]);
    exit;
}

$stmt = $conn->prepare("
    SELECT DISTINCT
        l.lap_id, 
        l.lap_name, 
        l.lap_locker, 
        m.mod_name AS lap_model,
        CASE 
            WHEN r.res_id IS NOT NULL AND r.res_day = ? AND r.res_flag = 1
                 AND (? < r.res_end_time AND ? > r.res_start_time)
            THEN 0 
            ELSE CASE 
                WHEN l.lap_status = -1 THEN -1
                ELSE 1
            END
        END AS updated_status
    FROM laptops l
    LEFT JOIN laptops_reservations lr ON lr.lap_id = l.lap_id
    LEFT JOIN reservations r ON r.res_id = lr.res_id
    LEFT JOIN models m ON m.mod_id = l.lap_model
");

$stmt->bind_param("sss", $day, $start_time, $end_time);
$stmt->execute();
$result = $stmt->get_result();

$laptops = [];
while ($row = $result->fetch_assoc()) {
    $laptops[] = $row;
}

echo json_encode($laptops);
?>
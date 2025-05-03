<?php
include './include/check_login.php';

$date = htmlspecialchars($_GET['date']);
$start_time = htmlspecialchars($_GET['start_time']);
$end_time = htmlspecialchars($_GET['end_time']);

include "./include/connection.php";

// Query to the database to get the laptops that are available for the given date and time
$conn = connectToDatabase();

$sql = "SELECT * FROM laptops";

$stmt = $conn->prepare($sql);

// $stmt->bind_param("sss", $date, $start_time, $end_time);

$stmt->execute();

$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

header("Content-Type: application/json");
echo json_encode($result);

$conn->close();

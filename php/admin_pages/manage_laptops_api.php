<?php
include "../include/connection.php";

$conn = connectToDatabase();

if($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $lap_id = $_REQUEST['lap_id'];

    $sql = "DELETE FROM laptops WHERE lap_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lap_id);
}
else if($_SERVER["REQUEST_METHOD"] == "PUT") {
    $lap_id = $_REQUEST['lap_id'];
    $lap_status = $_REQUEST['lap_status'];
    
    $sql = "UPDATE laptops SET lap_status = ? WHERE lap_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $lap_status, $lap_id);
}

$stmt->execute();

$conn->close();
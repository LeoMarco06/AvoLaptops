<?php
include "../../include/connection.php";

$conn = connectToDatabase();

session_start();

if ($_SESSION['role'] != 1) {
    // Admin is logged in, no action needed
    header("Location: ../../homepage.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $lock_id = $_REQUEST['lock_id'];

    $sql = "DELETE FROM lockers WHERE lock_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lock_id);
    $stmt->execute();
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lock_class = $_POST['lock_class'];
    $lock_floor = $_POST['lock_floor'];
    $lock_incharge = $_POST['lock_incharge'];
    $lock_capacity = $_POST['lock_capacity'];

    $sql = "INSERT INTO lockers (lock_class, lock_floor, lock_incharge, lock_capacity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $lock_class, $lock_floor, $lock_incharge, $lock_capacity);
    $stmt->execute();

    // Recupera l'ultimo record inserito
    $last_id = $conn->insert_id;
    $result = $conn->query("SELECT * FROM lockers WHERE lock_id = $last_id");
    $newLocker = $result->fetch_assoc();

    header("Content-Type: application/json");
    echo json_encode($newLocker);
}

$conn->close();
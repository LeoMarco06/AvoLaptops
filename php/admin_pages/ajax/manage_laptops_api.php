<?php
$check = true;
$path = "../../";
$admin = true;
include_once '../../page/header_navbar.php';

session_start();

if ($_SESSION['role'] != 1) {
    // Admin is logged in, no action needed
    header("Location: ../../homepage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $lap_id = $_REQUEST['lap_id'];

    $sql = "DELETE FROM laptops WHERE lap_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lap_id);
} else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $lap_id = $_REQUEST['lap_id'];
    $lap_status = $_REQUEST['lap_status'];

    $sql = "UPDATE laptops SET lap_status = ? WHERE lap_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $lap_status, $lap_id);
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add a new laptop
    $lap_name = $_POST['lap_name'];
    $lap_model = $_POST['lap_model'];
    $lap_locker = $_POST['lap_locker'];
    $status = 1;

    $sql = "INSERT INTO laptops (lap_name, lap_model, lap_locker, lap_status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $lap_name, $lap_model, $lap_locker, $status);
}

$stmt->execute();

$conn->close();
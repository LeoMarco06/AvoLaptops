<?php
$check = true;
$path = "../../";
$admin = true;
include_once '../../page/header_navbar.php';

$conn = connectToDatabase();

$id = $_GET['u_id'];

$sql = "DELETE FROM users WHERE u_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$conn->close();
?>
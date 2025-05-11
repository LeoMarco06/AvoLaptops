<?php
$check = true;
$path = "../../";
include_once '../../page/header_navbar.php';

$conn = connectToDatabase();

$id = $_REQUEST['u_id'];

$sql = "UPDATE users SET u_authorized = 1 WHERE u_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$conn->close();
?>
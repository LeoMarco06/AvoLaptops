<?php
include "../include/connection.php";

$conn = connectToDatabase();

$id = $_REQUEST['u_id'];

$sql = "DELETE FROM users WHERE u_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$conn->close();
?>
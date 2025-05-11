<?php
include "../include/connection.php";

$conn = connectToDatabase();

$id = $_REQUEST['u_id'];

$sql = "SELECT * FROM users WHERE u_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$user = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();

echo json_encode($user);
?>
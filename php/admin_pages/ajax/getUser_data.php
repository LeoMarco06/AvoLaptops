<?php
$check = true;
$path = "../../";
$admin = true;
include_once '../../page/header_navbar.php';

$conn = connectToDatabase();

$id = $_REQUEST['u_id'];

$sql = "SELECT * FROM users WHERE u_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$user = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();

// Clean the output buffer before sending the JSON
if (ob_get_level()) {
    ob_clean();
}

header('Content-Type: application/json');
echo json_encode($user);
?>
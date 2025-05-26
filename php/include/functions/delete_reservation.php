<?php
$check = true;
$path = "../../";
include '../session_check.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function deleteReservation($reservationId)
{
    $conn = connectToDatabase();

    // Prepare the SQL statement to update the reservation status
    $stmt = $conn->prepare("DELETE FROM reservations WHERE res_id = ?");
    $stmt->bind_param("i", $reservationId);

    // Execute the statement
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$reservationId = htmlspecialchars($_REQUEST['id']);


if (deleteReservation($reservationId)) {
    echo "Reservation deleted successfully.";
} else {
    echo "Failed to cancel reservation.";
}

?>
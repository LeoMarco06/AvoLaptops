<?php
$check = true;
$path = "../../";
include '../session_check.php';

function cancelReservation($reservationId)
{
    $conn = connectToDatabase();

    // Prepare the SQL statement to update the reservation status
    $stmt = $conn->prepare("UPDATE reservations SET res_flag = 0 WHERE res_id = ?");
    $stmt->bind_param("i", $reservationId);

    // Execute the statement
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$reservationId = htmlspecialchars($_REQUEST['id']);


if (cancelReservation($reservationId)) {
    echo "Reservation canceled successfully.";
} else {
    echo "Failed to cancel reservation.";
}

?>
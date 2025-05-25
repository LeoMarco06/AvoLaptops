<?php
$check = true;
$path = "../";
include_once '../page/header_navbar.php';

$conn = connectToDatabase();

$laptop_id = $_POST['laptop_ids'];


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $day = $_POST['day'];
    $user_id = $_SESSION['id'];

    // Prepare and bind for reservations
    $stmt = $conn->prepare("INSERT INTO reservations (res_start_time, res_end_time, res_day, res_user, res_flag) VALUES (?, ?, ?, ?, 1)");
    $stmt->bind_param("sssi", $start_time, $end_time, $day, $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Query to get the last reservation ID
        $result = $conn->query("SELECT MAX(res_id) AS last_reservation_id FROM reservations");

        if ($result && $row = $result->fetch_assoc()) {
            $res_id = $row['last_reservation_id'];
        }

        // Insert laptops into laptops_reservations
        foreach ($laptop_id as $lap_id) {
            $stmt_laptops = $conn->prepare("INSERT INTO laptops_reservations (res_id, lap_id) VALUES (?, ?)");
            $stmt_laptops->bind_param("ii", $res_id, $lap_id);

            if (!$stmt_laptops->execute()) {
                echo "<script>alert('Errore durante l\'associazione del laptop alla prenotazione. Riprova.');</script>";
            }

            $stmt_laptops->close();
        }

        echo "<script>alert('Prenotazione effettuata con successo!');</script>";
        echo "<script>window.location.href = './prenota.php';</script>";
    } else {
        echo "<script>alert('Errore durante la prenotazione. Riprova.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
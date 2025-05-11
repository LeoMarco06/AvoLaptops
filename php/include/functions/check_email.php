<?php
$email = htmlspecialchars($_GET['email']);

include "./include/connection.php";

// Connect to the db only if the email is valid
if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@(?:studenti\.)?itisavogadro\.it$/i', $email)) {
    
    $conn = connectToDatabase();

    $sql = "SELECT * FROM users WHERE u_email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    if (count($stmt->get_result()->fetch_all()) > 0) {
        echo "Email già registrata...";
    }

    $conn->close();
}

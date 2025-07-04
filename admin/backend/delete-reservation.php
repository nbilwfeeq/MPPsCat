<?php
include '../database/config.php';

if (isset($_POST['id_reservation'])) {
    $id_reservation = $_POST['id_reservation'];

    $stmt = $connect->prepare("DELETE FROM reservations WHERE id_reservation = ?");
    $stmt->bind_param("i", $id_reservation);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Tempahan berjaya dipadam.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Terdapat ralat semasa memadam tempahan.'
        ]);
    }
}
?>

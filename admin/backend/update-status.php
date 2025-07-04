<?php
include '../database/config.php';

if (isset($_POST['id_reservation']) && isset($_POST['currentStatus'])) {
    $id_reservation = $_POST['id_reservation'];
    $currentStatus = $_POST['currentStatus'];

    $newStatus = ($currentStatus == 1) ? 2 : 1;

    $stmt = $connect->prepare("UPDATE reservations SET status_tempahan = ? WHERE id_reservation = ?");
    $stmt->bind_param("ii", $newStatus, $id_reservation);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'newStatus' => $newStatus,
            'message' => 'Status berjaya dikemaskini.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Terdapat ralat semasa mengemaskini status.'
        ]);
    }
}
?>

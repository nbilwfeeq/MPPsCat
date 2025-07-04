<?php
session_start();
include '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_reservation'])) {
    $id_reservation = $_POST['id_reservation'];
    
    // Check if reservation exists
    $stmt = $connect->prepare("SELECT * FROM reservations WHERE id_reservation = ?");
    $stmt->bind_param("i", $id_reservation);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Proceed to cancel reservation
        $stmt = $connect->prepare("DELETE FROM reservations WHERE id_reservation = ?");
        $stmt->bind_param("i", $id_reservation);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Tempahan berjaya dibatalkan.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal membatalkan tempahan.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Tempahan tidak dijumpai.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Request tidak sah.']);
}

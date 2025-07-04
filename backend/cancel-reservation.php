<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../database/config.php';
include '../session/security.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?status=unauthorized");
    exit();
}

if (isset($_GET['id_reservation'])) {
    // Get the reservation ID from the URL
    $id_reservation = $_GET['id_reservation'];

    // Delete the reservation from the reservations table
    $stmt = $connect->prepare("DELETE FROM reservations WHERE id_reservation = ? AND nokp = ?");
    $stmt->bind_param("is", $id_reservation, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        // If the query executes successfully, redirect to the reservations page with a success status
        header("Location: ../myreservations.php?status=cancelled");
        exit();
    } else {
        // If there's an error, redirect with an error status
        header("Location: ../myreservations.php?status=error");
        exit();
    }
} else {
    // If no reservation ID is provided, redirect back with an error message
    header("Location: ../myreservations.php?status=error");
    exit();
}
?>

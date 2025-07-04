<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../database/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?status=unauthorized");
    exit();
}

$nokp = $_SESSION['user_id'];

// Handle Payment Submission
if (isset($_POST['submit_payment'])) {
    // Ensure we get the latest `id_reservation` directly from the database for this user
    $stmt = $connect->prepare("SELECT id_reservation FROM reservations WHERE nokp = ? ORDER BY id_reservation DESC LIMIT 1");
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservation = $result->fetch_assoc();
    
    if (!$reservation) {
        header("Location: ../myreservations.php?status=reservation_not_found");
        exit();
    }

    // Use the latest reservation ID
    $id_reservation = $reservation['id_reservation'];
    $email = $_POST['email'] ?? '';
    $nama_penuh = $_POST['nama_penuh'] ?? '';
    $notel = $_POST['notel'] ?? '';
    $payment_type = $_POST['payment_type'] ?? '';
    $status_payment = 1; // Default status for now

    // Retrieve the total price for the specific `id_reservation`
    $stmt = $connect->prepare("SELECT total_prices FROM reservations WHERE id_reservation = ? AND nokp = ?");
    $stmt->bind_param("is", $id_reservation, $nokp);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $total_prices = $row['total_prices'];
    } else {
        header("Location: ../myreservations.php?status=reservation_not_found");
        exit();
    }

    // Check if payment proof was uploaded (only if payment type is TNG)
    if ($payment_type === 'TNG' && isset($_FILES['payment_proof'])) {
        $file = $_FILES['payment_proof'];
        $allowed_types = ['image/jpeg', 'image/png'];

        if (in_array($file['type'], $allowed_types)) {
            $upload_dir = '../uploads/payment_proof/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_name = 'proof_' . time() . '.' . $file_extension;
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($file['tmp_name'], $file_path)) {
                $payment_proof = $file_name;
            } else {
                header("Location: ../myreservations.php?status=upload_failed");
                exit();
            }
        } else {
            header("Location: ../myreservations.php?status=invalid_file_type");
            exit();
        }
    } else {
        $payment_proof = null; // No proof for cash payment or if TNG proof wasn't uploaded
    }

    // Insert payment details into the payments table with the correct id_reservation
    $stmt = $connect->prepare("INSERT INTO payments (id_reservation, email, nama_penuh, nokp, notel, total_prices, payment_proof, payment_type, status_payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssi", $id_reservation, $email, $nama_penuh, $nokp, $notel, $total_prices, $payment_proof, $payment_type, $status_payment);
    
    if ($stmt->execute()) {
        header("Location: ../myreservations.php?status=submitted");
        exit();
    } else {
        header("Location: ../myreservations.php?status=error");
        exit();
    }
}

// Handle Payment Cancellation
if (isset($_POST['cancel_payment'])) {
    $id_reservation = $_POST['id_reservation'] ?? null;

    if ($id_reservation) {
        // Delete the reservation from the reservations table
        $stmt = $connect->prepare("DELETE FROM reservations WHERE id_reservation = ? AND nokp = ?");
        $stmt->bind_param("is", $id_reservation, $nokp);

        if ($stmt->execute()) {
            // Redirect to reservations.php after successful cancellation
            header("Location: ../reservations.php?status=cancelled");
            exit();
        } else {
            header("Location: ../reservations.php?status=error");
            exit();
        }
    } else {
        header("Location: ../reservations.php?status=invalid_reservation");
        exit();
    }
}
?>

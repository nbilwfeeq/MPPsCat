<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $nama_penuh = htmlspecialchars($_POST['nama_penuh']);
    $nokp = htmlspecialchars($_POST['nokp']);
    $notel = htmlspecialchars($_POST['notel']);
    $reserve_date = htmlspecialchars($_POST['reserve_date']);
    $reserve_time = htmlspecialchars($_POST['reserve_time']);
    $status_tempahan = htmlspecialchars($_POST['status_tempahan']);
    $colored_pages = intval($_POST['colored_pages']);
    $bw_pages = intval($_POST['bw_pages']);
    $total_pages = intval($_POST['total_pages']);

    // Format total_prices to have 2 decimal places
    $total_prices = number_format(floatval($_POST['total_prices']), 2, '.', '');

    // Combine date and time into a single datetime string
    $reserve_datetime = $reserve_date . ' ' . $reserve_time;

    // Handle file upload
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Validate file: Allow PDF, DOCX, PNG, and JPG
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'];
    if ($fileError === 0) {
        if (in_array($fileType, $allowedTypes)) {
            if ($fileSize < 5000000) { // Limit file size to 5MB
                $fileDestination = '../uploads/' . uniqid('', true) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
                if (move_uploaded_file($fileTmpName, $fileDestination)) {

                    // Insert data into the database
                    $stmt = $connect->prepare("INSERT INTO reservations (email, nama_penuh, nokp, notel, reserve_date, file, status_tempahan, colored_pages, bw_pages, total_pages, total_prices) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssssssds", $email, $nama_penuh, $nokp, $notel, $reserve_datetime, $fileDestination, $status_tempahan, $colored_pages, $bw_pages, $total_pages, $total_prices);

                    if ($stmt->execute()) {
                        header("Location: ../payments.php?status=reserved");
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                } else {
                    echo "Failed to move the uploaded file.";
                }
            } else {
                echo "File size is too large. Maximum allowed size is 5MB.";
            }
        } else {
            echo "Invalid file type. Allowed file types: PDF, DOCX, JPG, PNG.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Invalid request.";
}
?>

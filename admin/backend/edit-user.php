<?php
include '../database/config.php';
include '../session/security.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $nokp = $_POST['nokp'];
    $nama_penuh = $_POST['nama_penuh'];
    $email = $_POST['email'];
    $notel = $_POST['notel'];
    $kategori = $_POST['kategori'];

    // Update user information in the database based on 'nokp'
    $query = "UPDATE user SET nama_penuh = ?, email = ?, notel = ?, kategori = ? WHERE nokp = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("sssss", $nama_penuh, $email, $notel, $kategori, $nokp);

    if ($stmt->execute()) {
        // Redirect to the users list with success message
        header("Location: ../users.php?status=edited");
    } else {
        // Redirect with an error message if update fails
        header("Location: ../update-user.php?nokp=$nokp&status=edit_failed");
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$connect->close();
?>

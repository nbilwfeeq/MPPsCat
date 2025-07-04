<?php
include '../database/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize the form data
    $nama_penuh = strtoupper(trim($_POST['nama_penuh'])); // Convert to uppercase
    $email = $_POST['email'];
    $nokp = $_POST['nokp'];
    $notel = $_POST['notel'];
    $kategori = $_POST['kategori'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        // Display an error message and prevent further processing
        header("Location: ../create-user.php?status=passwordMismatch");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert data into the users table
    $sql = "INSERT INTO user (nama_penuh, email, nokp, notel, kategori, password) 
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $connect->prepare($sql)) {
        // Bind the parameters to the query
        $stmt->bind_param("ssssss", $nama_penuh, $email, $nokp, $notel, $kategori, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect or display success message
            header("Location: ../users.php?status=registered");
        } else {
            // Display error message if insertion fails
            header("Location: ../create-user.php?status=registerError");
        }
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $connect->error;
    }

    // Close the database connection
    $connect->close();
}
?>

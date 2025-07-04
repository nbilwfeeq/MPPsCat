<?php
include '../database/config.php'; // Include the database configuration file

if (isset($_POST['register'])) {
    // Retrieve and sanitize form data
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $nama_penuh = strtoupper(mysqli_real_escape_string($connect, $_POST['nama_penuh']));
    $nokp = mysqli_real_escape_string($connect, $_POST['nokp']);
    $notel = mysqli_real_escape_string($connect, $_POST['notel']);
    $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the user already exists
    $check_user_query = "SELECT * FROM user WHERE email = '$email' OR nokp = '$nokp' LIMIT 1";
    $result = mysqli_query($connect, $check_user_query);

    if (mysqli_num_rows($result) > 0) {
        // User already exists
        header("Location: ../register.php?status=exists");
        exit();
    }

    // Prepare the insert query
    $insert_query = "INSERT INTO user (email, nama_penuh, nokp, notel, kategori, password) 
                     VALUES ('$email', '$nama_penuh', '$nokp', '$notel', '$kategori', '$hashed_password')";

    if (mysqli_query($connect, $insert_query)) {
        // Registration successful
        header("Location: ../index.php?status=registered");
    } else {
        // Registration failed
        header("Location: ../register.php?status=registerError");
    }
} else {
    // If the form is not submitted properly, redirect to the register page
    header("Location: ../register.php");
}
?>

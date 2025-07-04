<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database/config.php';
include 'session/security.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?status=unauthorized");
    exit();
}

// Ambil informasi pengguna dari database menggunakan user_id (atau nokp)
$nokp = $_SESSION['user_id'];  // Menganggap user_id disimpan di session
$stmt = $connect->prepare("SELECT id, nama_penuh, email, notel FROM user WHERE nokp = ?");
$stmt->bind_param("s", $nokp);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$page = 'Edit Profil | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';

// Proses pengiriman form untuk memperbarui informasi pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai yang diupdate dari form
    $email = htmlspecialchars($_POST['email']);
    $notel = htmlspecialchars($_POST['notel']);

    // Perbarui informasi pengguna di database
    $update_stmt = $connect->prepare("UPDATE user SET email = ?, notel = ? WHERE nokp = ?");
    $update_stmt->bind_param("sss", $email, $notel, $nokp);

    if ($update_stmt->execute()) {
        // Pesan sukses
        $message = "Profil telah dikemaskini.";
    } else {
        // Pesan error
        $message = "Terdapat ralat semasa mengemaskini profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Sistem Cetakan Atas Talian - MPP CatS">
    <meta name="description" content="Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar, Kolej Vokasional Kuala Selangor">
    <link rel="shortcut icon" href="images/icon-mpp.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/main-styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title><?php echo $page; ?></title>
</head>
<body>

    <?php include 'includes/sidebar.php'; ?>

    <div class="container height-100">
        <br>
        <h3>Edit Profil Anda</h3>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Form untuk menampilkan dan mengedit informasi profil -->
        <form method="POST" action="edit_profile.php">
            <div class="mb-3">
                <label for="nama_penuh" class="form-label">Nama Penuh</label>
                <input type="text" class="form-control" id="nama_penuh" value="<?php echo htmlspecialchars($user['nama_penuh']); ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Emel</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="notel" class="form-label">Nombor Telefon</label>
                <input type="text" class="form-control" id="notel" name="notel" value="<?php echo htmlspecialchars($user['notel']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Kemas Kini</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

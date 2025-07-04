<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database/config.php';
include 'session/security.php';

// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?status=unauthorized");
    exit();
}

// set nokp to user_id
$nokp = $_SESSION['user_id'];

// get user info
$stmt = $connect->prepare("SELECT * FROM user WHERE nokp = ?");
$stmt->bind_param("s", $nokp);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// get specific reservation info if provided, otherwise get the latest reservation
$id_reservation = $_GET['id_reservation'] ?? null;

if ($id_reservation) {
    // Fetch specific reservation based on id_reservation
    $stmt = $connect->prepare("SELECT * FROM reservations WHERE nokp = ? AND id_reservation = ?");
    $stmt->bind_param("si", $nokp, $id_reservation);
} else {
    // Fetch the latest reservation if no id_reservation is passed
    $stmt = $connect->prepare("SELECT * FROM reservations WHERE nokp = ? ORDER BY reserve_date DESC LIMIT 1");
    $stmt->bind_param("s", $nokp);
}
$stmt->execute();
$result = $stmt->get_result();
$reservation = $result->fetch_assoc();

$page = 'Pembayaran | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Sistem Cetakan Atas Talian - MPP CatS">
    <meta name="description" content="Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar, Kolej Vokasional Kuala Selangor">
    <link rel="shortcut icon" href="images/icon-mpp.png" type="image/x-icon">

    <!--==================CSS=================-->
    <link rel="stylesheet" href="styles/main-styles.css?v=<?php echo time(); ?>">

    <!--===============Bootstrap 5.2==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.min.css">

    <!--=============== BoxIcons ===============-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!--=============== Google Fonts ===============-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    
    <title><?php echo htmlspecialchars($page); ?></title>

    <style>
        .container {
            border: 1px solid black;
            padding: 10px;
            background-color: white;
            box-shadow: 3px 4px 8px rgba(0, 0, 0, 0.4); 
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <br>
        <h3>Pembayaran</h3>
        <br>
        <form action="backend/process-payment.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($reservation['id_reservation'] ?? ''); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
            
            <!-- Form fields for user details -->
            <div class="mb-3">
                <label for="nama_penuh" class="form-label">Nama Penuh</label>
                <input type="text" class="form-control" id="nama_penuh" name="nama_penuh" value="<?php echo htmlspecialchars($user['nama_penuh']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="notel" class="form-label">No. Telefon</label>
                <input type="text" class="form-control" id="notel" name="notel" value="<?php echo htmlspecialchars($user['notel']); ?>" readonly>
            </div>
            
            <!-- Hidden input for total prices -->
            <input type="hidden" name="total_prices" value="<?= htmlspecialchars($reservation['total_prices'] ?? ''); ?>">
            
            <!-- Display total price -->
            <hr>
            <div class="form-group">
                <label>Total Price: RM <?php echo htmlspecialchars($reservation['total_prices'] ?? '0.00'); ?></label>
            </div>
            
            <!-- Payment Method Selection -->
            <br>
            <div class="form-group">
                <label for="payment_method">Payment Method</label>
                <select class="form-control" id="payment_method" name="payment_type"> <!-- Updated name to payment_type -->
                    <option value="">Pilih Method Pembayaran :-</option>
                    <option value="TNG">TNG e-Wallet</option>
                    <option value="CASH">Cash / Tunai</option>
                </select>
            </div>
            
            <!-- TNG Proof Upload -->
            <br>
            <div id="tng_proof" class="form-group" style="display: none;">
                <img src="images/tng-qr.jpg" style="width: 260px; height: 350px;"><br><br>
                <label for="payment_proof">Upload Bukti Pembayaran (JPG, PNG)</label>
                <input type="file" class="form-control-file" id="payment_proof" name="payment_proof" accept="image/*">
            </div>
            
            <br>
            <button type="submit" name="submit_payment" class="btn btn-primary">Submit Payment</button>
            <button type="return" name="cancel_payment" class="btn btn-danger">Cancel</button>
        </form>
    </div>

    <br>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>

    <script>
        document.getElementById('payment_method').addEventListener('change', function () {
            var tngProof = document.getElementById('tng_proof');
            tngProof.style.display = this.value === 'TNG' ? 'block' : 'none';
        });

        // SweetAlert for success notification
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status == 'reserved') {
            Swal.fire({
                icon: 'success',
                title: 'Tempahan Berjaya !',
                text: 'Tempahan Anda Telah Berjaya.'
            }).then(() => {
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } else if (status === 'submitted') {
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berjaya!',
                text: 'Pembayaran Anda Telah Berjaya Dihantar.'
            }).then(() => {
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        }
    </script>
    
</body>
</html>

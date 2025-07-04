<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database/config.php';
include 'session/security.php';

// check if user logged in
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

// get reservations info for the current user
$stmt = $connect->prepare("SELECT * FROM reservations WHERE nokp = ?");
$stmt->bind_param("s", $nokp);
$stmt->execute();
$reservation_result = $stmt->get_result();
$reservations = $reservation_result->fetch_all(MYSQLI_ASSOC);

// get payments info for the current user
$stmt = $connect->prepare("SELECT * FROM payments WHERE nokp = ?");
$stmt->bind_param("s", $nokp);
$stmt->execute();
$payment_result = $stmt->get_result();
$payments = $payment_result->fetch_all(MYSQLI_ASSOC);

$page = 'Tempahan | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';
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

    <title><?php echo $page; ?></title>

    <style>
        .status-pending {
            background-color: white;
        }

        .status-approved {
            background-color: white;
        }

        .status-rejected {
            background-color: white;
        }
    </style>
</head>
<body>

<?php include 'includes/sidebar.php'; ?>

<div class="container mt-5">
    <br>
    <h3>Tempahan Anda</h3>
    <br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Bil</th>
                <th>Nama Penuh</th>
                <th>No. Kad Pengenalan</th>
                <th>Halaman Berwarna</th>
                <th>Halaman Hitam & Putih</th>
                <th>Jumlah Halaman</th>
                <th>Jumlah Harga</th>
                <th>Tarikh Tempahan</th>
                <th>Status Payment</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
    <?php if (count($reservations) > 0) : ?>
        <?php $bil = 1; foreach ($reservations as $row) : ?>
            <tr class="
                <?php 
                // Apply classes based on status_tempahan
                if ($row['status_tempahan'] == 1) {
                    echo 'status-pending';
                } elseif ($row['status_tempahan'] == 2) {
                    echo 'status-approved';
                } elseif ($row['status_tempahan'] == 3) {
                    echo 'status-rejected';
                }
                ?>
            ">
                <td><?php echo $bil++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_penuh']); ?></td>
                <td><?php echo htmlspecialchars($row['nokp']); ?></td>
                <td>
                    <?php echo htmlspecialchars($row['colored_pages']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['bw_pages']); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['total_pages']); ?>
                </td>
                <td>RM <?php echo htmlspecialchars($row['total_prices']); ?></td>
                <td><?php echo htmlspecialchars($row['reserve_date']); ?></td>
                <td>
                    <span style="background-color: 
                        <?php 
                            if ($row['status_tempahan'] == 1) { 
                                echo '#e2e72c'; 
                            } elseif ($row['status_tempahan'] == 2) { 
                                echo 'green'; 
                            } elseif ($row['status_tempahan'] == 3) { 
                                echo 'red'; 
                            }
                        ?>; 
                        color: white; border-radius: 15px; padding: 3px 8px;">
                        <?php 
                            if ($row['status_tempahan'] == 1) { 
                                echo 'Waiting'; 
                            } elseif ($row['status_tempahan'] == 2) { 
                                echo 'Complete'; 
                            } elseif ($row['status_tempahan'] == 3) { 
                                echo 'Rejected'; 
                            }
                        ?>
                    </span>
                </td>
                <td>
                    <?php if ($row['status_tempahan'] == 2) : ?>
                        
                    <?php else : ?>
                        <a href="backend/cancel-reservation.php?id_reservation=<?php echo $row['id_reservation']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this reservation?');">Batal</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="9" class="text-center">Tiada Tempahan</td>
        </tr>
    <?php endif; ?>
</tbody>

    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>
<script>
    const url = new URLSearchParams(window.location.search);
    const status = url.get('status');

    if (status === 'submitted') {
        Swal.fire({
            icon: 'success',
            title: 'Tempahan Berjaya!',
            text: 'Tempahan Anda Telah Berjaya.'
        }).then(() => {
            const urlWithoutStatus = window.location.href.split('?')[0];
            window.history.replaceState({}, document.title, urlWithoutStatus);
        });
    } else if (status === 'cancelled') {
        Swal.fire({
            icon: 'success',
            title: 'Tempahan Dibatalkan!',
            text: 'Tempahan Anda telah berjaya dibatalkan.'
        }).then(() => {
            const urlWithoutStatus = window.location.href.split('?')[0];
            window.history.replaceState({}, document.title, urlWithoutStatus);
        });
    } else if (status === 'error') {
        Swal.fire({
            icon: 'error',
            title: 'Ralat!',
            text: 'Terdapat ralat semasa membatalkan tempahan. Sila cuba lagi.'
        });
    }
</script>

</body>
</html>

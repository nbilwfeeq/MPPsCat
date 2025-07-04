<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'database/config.php';
include 'session/security.php';

// Check if user logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php?status=unauthorized");
    exit();
}

// Get user info from database using user_id (or nokp)
$nokp = $_SESSION['user_id']; // Assuming user_id is stored in session
$stmt = $connect->prepare("SELECT id, nama_penuh, email, notel FROM user WHERE nokp = ?");
$stmt->bind_param("s", $nokp);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$page = 'Edit Profil | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';

// Handle the form submission for updating user info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated values from the form
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $notel = htmlspecialchars($_POST['notel']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format emel tidak sah. Sila masukkan emel yang betul.";
    } elseif (!preg_match('/^[0-9]{10,15}$/', $notel)) {
        $message = "Nombor telefon tidak sah. Pastikan hanya nombor dengan panjang 10-15 digit.";
    } else {
        // Update user info in the database
        $update_stmt = $connect->prepare("UPDATE user SET email = ?, notel = ? WHERE nokp = ?");
        $update_stmt->bind_param("sss", $email, $notel, $nokp);

        if ($update_stmt->execute()) {
            $message = "Profil telah dikemaskini dengan berjaya.";
        } else {
            $message = "Terdapat ralat semasa mengemaskini profil.";
        }
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

    <!--==================CSS=================-->
    <link rel="stylesheet" href="styles/main-styles.css?v=<?php echo time(); ?>">

    <!--===============Bootstrap 5.2==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">

    <title><?php echo $page; ?></title>

    <style>
        /* Custom Styles for Button */
        .btn-kemas-kini {
            background-color: #007bff; /* Blue background */
            color: #fff;
            border: 2px solid #007bff;
            border-radius: 30px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-kemas-kini:hover {
            background-color: #0056b3; /* Darker blue when hover */
            border-color: #0056b3;
            transform: translateY(-3px);
        }

        .btn-kemas-kini:active {
            background-color: #004085; /* Even darker blue when clicked */
            border-color: #004085;
            transform: translateY(1px);
        }

        .alert {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <?php include 'includes/sidebar.php'; ?>

    <div class="container height-100">
        <br>
        <h3>Edit Profil Anda</h3>

        <?php if (isset($message)): ?>
            <div class="alert <?php echo strpos($message, 'berjaya') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Profile information display and edit form -->
        <form method="POST" action="edit_profile.php">
            <div class="mb-3">
                <label for="nama_penuh" class="form-label">Nama Penuh</label>
                <input type="text" class="form-control" id="nama_penuh" value="<?php echo htmlspecialchars($user['nama_penuh']); ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="notel" class="form-label">Nombor Telefon</label>
                <input type="text" class="form-control" id="notel" name="notel" value="<?php echo htmlspecialchars($user['notel']); ?>" required>
            </div>

            <button type="submit" class="btn btn-kemas-kini">Kemas Kini</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

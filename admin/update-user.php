<?php 
    include 'database/config.php';
    include 'session/security.php';

    $page = 'Kemaskini Data Pengguna | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';

    // Get user data to pre-fill the form using 'nokp' instead of 'id'
    $nokp = $_GET['nokp'];  // Assuming 'nokp' is passed as a URL parameter
    $query = "SELECT * FROM user WHERE nokp = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "Pengguna tidak dijumpai!";
        exit;
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

    <!-- ==================CSS=================-->
    <link rel="stylesheet" href="styles/main-styles.css?v=<?php echo time(); ?>">

    <!--===============Bootstrap 5.2==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!--=============== BoxIcons ===============-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!--=============== Google Fonts ===============-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

    <title><?php echo $page; ?></title>

    <style>
        .form-control-file {
            display: block;
            width: 50%;
        }
        .btn-custom {
            background-color: transparent;
            border: 2px solid black; 
            color: black;
        }
        .btn-custom:hover {
            color: #fff;
            background-color: var(--main-purple2); 
            border: none;
        }
    </style>
</head>

<body>

    <?php include('includes/topbar.php'); ?>

    <div class="content container p-3">
        <h1>Kemaskini Maklumat Pengguna</h1>
        <div class="hr">
            <hr>
        </div>

        <form id="updateForm" action="backend/edit-user.php" method="post">
            <input type="hidden" name="nokp" value="<?php echo $user['nokp']; ?>"> <!-- Hidden input for user 'nokp' -->

            <div class="row">
                <div class="col-md-6">
                    <!-- Pre-fill form fields with existing user data -->
                    <div class="mb-3">
                        <label class="form-label" for="nama_penuh">Nama Pengguna</label>
                        <input type="text" class="form-control" id="nama_penuh" name="nama_penuh" value="<?php echo $user['nama_penuh']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="nokp">No. Kad Pengenalan</label>
                        <input type="text" class="form-control" id="nokp" name="nokp" value="<?php echo $user['nokp']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="notel">No. Telefon</label>
                        <input type="text" class="form-control" id="notel" name="notel" value="<?php echo $user['notel']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="kategori">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="PELAJAR" <?php if ($user['kategori'] == 'PELAJAR') echo 'selected'; ?>>PELAJAR</option>
                            <option value="PENSYARAH" <?php if ($user['kategori'] == 'PENSYARAH') echo 'selected'; ?>>PENSYARAH</option>
                            <option value="KAKITANGAN" <?php if ($user['kategori'] == 'KAKITANGAN') echo 'selected'; ?>>KAKITANGAN</option>
                            <option value="LAIN-LAIN" <?php if ($user['kategori'] == 'LAIN-LAIN') echo 'selected'; ?>>LAIN-LAIN</option>
                        </select>
                    </div>

                    <br> 

                    <div class="mb-3">
                        <button type="submit" class="btn btn-custom">
                            <i class="bx bxs-user-check"></i>&nbsp;Kemaskini Pengguna
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="mt-3">
            <button class="btn btn-secondary" onclick="window.location='users.php'">
                <i class="bx bx-arrow-back"></i>&nbsp;Kembali
            </button>
        </div>
    </div>
</body>
</html>

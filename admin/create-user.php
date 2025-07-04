<?php 
    include 'database/config.php';
    include 'session/security.php';
    $page = 'Tambah Data Pengguna | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';
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
        <h1>Tambah Maklumat Pengguna</h1>
        <div class="hr">
            <hr>
        </div>

        <form id="addForm" action="backend/add-user.php" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="nama_penuh">Nama Pengguna</label>
                        <input type="text" class="form-control" id="nama_penuh" name="nama_penuh" required placeholder="Nama Penuh">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Email Pengguna">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="nokp">No. Kad Pengenalan</label>
                        <input type="text" class="form-control" id="nokp" name="nokp" required placeholder="No. Kad Pengenalan (IC)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="notel">No. Telefon</label>
                        <input type="text" class="form-control" id="notel" name="notel" required placeholder="No. Telefon">
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="kategori">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="PELAJAR">PELAJAR</option>
                            <option value="PENSYARAH">PENSYARAH</option>
                            <option value="KAKITANGAN">KAKITANGAN</option>
                            <option value="LAIN-LAIN">LAIN-LAIN</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">Katalaluan</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Sahkan Katalaluan</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>

                    <br> 

                    <div class="mb-3">
                        <button type="submit" class="btn btn-custom">
                            <i class="bx bxs-user-plus"></i>&nbspTambah Pengguna
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div class="mt-3">
            <button class="btn btn-secondary" onclick="window.location='users.php'">
                <i class="bx bx-arrow-back"></i>&nbspKembali
            </button>
        </div>
    </div>

    <!--=============== Bootstrap 5.2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== jQuery ===============-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!--=============== SweetAlert2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JavaScript to automatically convert 'nama_penuh' to uppercase -->
    <script>
        document.getElementById('nama_penuh').addEventListener('input', function(event) {
            event.target.value = event.target.value.toUpperCase();
        });
    </script>

    <script>
        // JavaScript for form validation and submission
        $('#addUserForm').on('submit', function (event) {
            event.preventDefault();

            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Katalaluan tidak sepadan!',
                    text: 'Sila pastikan katalaluan dan sahkan katalaluan adalah sama.',
                });
                return;
            }

            this.submit();  // Proceed to submit the form if passwords match
        });
    </script>
</body>

</html>

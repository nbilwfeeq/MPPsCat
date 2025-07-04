<?php 
include 'database/config.php';
include 'session/security.php';

$page = 'Daftar Akaun | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';
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

    <!--=============== BoxIcons ===============-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!--=============== Google Fonts ===============-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">

    <title><?php echo $page; ?></title>

    <style>
        .profile-pic-wrapper {
            width: 250px;
            height: 250px;
            margin: 0 auto;
            position: relative;
        }

        .profile-pic {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .form-control-file {
            display: block;
            margin: 10px auto;
            width: 100px;
            text-align: center;
        }

        body {
            background-color: var(--main-purple2);
        }

        .btn-success {
            background-color: transparent; 
            border: 2px solid black; 
            color: black; 
            padding: 10px 20px; 
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease; 
        }

        .btn-success:hover {
            background-color: var(--main-purple2); 
            color: white; 
            border-color: var(--main-purple2); 
        }

        .btn-danger {
            background-color: transparent; 
            border: 2px solid black; 
            color: black; 
            padding: 10px 20px; 
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease; 
        }

        .btn-danger:hover {
            background-color: var(--red); 
            color: white; 
            border-color: var(--red); 
        }

        .hidden {
            display: none;
        }

        .uppercase-text {
            text-transform: uppercase; /* Transform user input to uppercase */
        }

        .uppercase-text::-webkit-input-placeholder {
            text-transform: none; /* Chrome, Safari, Edge */
        }

        .uppercase-text:-moz-placeholder {
            text-transform: none; /* Firefox 18- */
        }

        .uppercase-text::-moz-placeholder {
            text-transform: none; /* Firefox 19+ */
        }

        .uppercase-text:-ms-input-placeholder {
            text-transform: none; /* Internet Explorer 10+ */
        }

        .form-control-file {
            width: 100px;
        }

    </style>

</head>
<body>
    
    <!-- Register Form -->
    <div class="login mt-4">
        <div class="login-form h-100">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-lg-9 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <!-- <marquee class="p-3 text-bg-danger">Ibnu Firnas Knowledge Center dalam proses penyelenggaraan, Harap maaf atas semua kesulitan.</marquee> -->
                                    <img src="images/logo-mpp (black).png" class="w-25" alt="ibnu-firnas">
                                </div>
                                <hr>
                                <form id="registerForm" action="backend/signup.php" method="post" enctype="multipart/form-data">
                                    <h5>DAFTAR AKAUN</h5>
                                    <div id="form-register">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" placeholder="Masukkan Email" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="nama_penuh" class="form-label">Nama Penuh</label>
                                            <input type="text" class="form-control uppercase-text" name="nama_penuh" placeholder="Masukkan Nama Penuh" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="nokp" class="form-label">No. Kad Pengenalan <b>Tanpa (-)</b></label>
                                            <input type="text" class="form-control uppercase-text" name="nokp" placeholder="Masukkan No. Kad Pengenalan" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="notel" class="form-label">No. Telefon <b>Tanpa (-)</b></label>
                                            <input type="text" class="form-control uppercase-text" name="notel" placeholder="Masukkan No. Telefon" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="kategori" class="form-label">Kategori</label>
                                            <select class="form-control" name="kategori" required>
                                                <option value="">Pilih Kategori :-</option>
                                                <option value="PELAJAR">PELAJAR</option>
                                                <option value="PENSYARAH">PENSYARAH</option>
                                                <option value="LAIN-LAIN">LAIN-LAIN</option>
                                            </select>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="password" class="form-label">Kata Laluan</label>
                                            <input type="password" class="form-control" name="password" placeholder="Masukkan Kata Laluan" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="confirm-password" class="form-label">Mengesahkan Kata Laluan</label>
                                            <input type="password" class="form-control" name="confirm-password" placeholder="Masukkan Pengesahan Kata Laluan" required>
                                            <br>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="showPass"> Tunjuk kata laluan
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button id="btnRegister" name="register" type="submit" class="btn btn-success w-100">Daftar Masuk</button>
                                        <br>
                                        <button id="btnReturn" name="return" type="button" class="btn btn-danger w-100">Kembali</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br><br><br>
    
    <?php include 'includes/footer.php'; ?>

    <!--=============== Bootstrap 5.2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!--=============== jQuery ===============-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!--=============== Datatables ===============-->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!--=============== SweetAlert2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Show or hide password
        $('#showPass').click(function() {
            var pass = $('input[name=password]');
            var confirmPass = $('input[name=confirm-password]');

            if (pass.attr('type') == 'text') {
                pass.attr('type', 'password');
                confirmPass.attr('type', 'password');
            } else {
                pass.attr('type', 'text');
                confirmPass.attr('type', 'text');
            }
        });

        // Convert text inputs to uppercase on form submission
        $('#registerForm').submit(function(event) {
            // Check if passwords match
            var password = $('input[name=password]').val();
            var confirmPassword = $('input[name=confirm-password]').val();
            
            if (password !== confirmPassword) {
                event.preventDefault(); // Prevent form submission
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal!',
                    text: 'Pengesahan Password Tidak Sama.'
                });
                return;
            }

            // Convert text inputs to uppercase
            $('input.uppercase-text').each(function() {
                $(this).val($(this).val().toUpperCase());
            });
        });

        const parameter = new URLSearchParams(window.location.search);
        const getURL = parameter.get('status');

        if (getURL == 'missingFields') {
            Swal.fire({
                icon: 'error',
                title: 'Pendaftar Gagal!',
                text: 'Akaun pengguna ini adalah berjawatan pelajar, sila isi program dan no matriks.'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        }

        else if (getURL == 'exists') {
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Gagal!',
                text: 'Akaun pengguna ini telah wujud, sila cuba akaun yang lain.'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        }

        else if (getURL == 'registerError') {
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Gagal!',
                text: 'Akaun pengguna tidak berjaya ditambah.'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } 

        else if (getURL == 'fileUploadError') {
            Swal.fire({
                icon: 'error',
                title: 'Upload Gambar Gagal!',
                text: 'Cuba gambar yang berbeza atau cuba sekali lagi.'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } 
        
        else if (getURL == 'passwordError') {
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Gagal!',
                text: 'Pengesahan Password Tidak Sama.'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        }

        // Redirect to login page (index.php)
        document.getElementById('btnReturn').addEventListener('click', function() {
            window.location.href = 'index.php';
        });
    </script>

</body>
</html>
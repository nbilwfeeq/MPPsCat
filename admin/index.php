<?php 
include 'database/config.php';
include 'session/security.php';

$page = 'sCat | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';
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
</head>
<style>
    body {
        background-color: var(--white);
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
</style>
<body>

    <div class="login mt-4">
        <div class="login-form h-100">
            <div class="container h-100">
                <div class="row align-items-center h-100">
                    <div class="col-lg-5 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <!-- <marquee class="p-3 text-bg-danger">P.I.F Knowledge Center dalam proses penyelenggaraan, maaf atas semua kesulitan.</marquee> -->
                                    <img src="images/logo-mpp (black).png" class="w-50" alt="logo-mpp">
                                    <h5>Sistem Cetakan Atas Talian <br>Majlis Perwakilan Pelajar</h5>
                                    <p class="text-muted">Kolej Vokasional Kuala Selangor<br>Kementerian Pendidikan Malaysia</p>
                                </div>
                                <hr>
                                <form id="loginForm" action="backend/login.php" method="post">
                                    <h5>LOG MASUK</h5>
                                    <div id="form-login">
                                        <div class="form-group">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="password" class="form-label">Kata Laluan</label>
                                            <input type="password" class="form-control" name="password" placeholder="Masukkan Kata Laluan" required>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="showPass"> Tunjuk kata laluan
                                                </div>
                                            </div>
                                            <br>
                                            Tidak mempunyai akaun? Hubungi <a href="#" style="color: black;">013-755-8636</a> (Admin)
                                        </div>
                                    </div>
                                    <br>
                                    <button id="btnSubmit" name="login" type="submit" class="btn btn-success w-100">Log Masuk</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#showPass').click(function() {
            var pass = $('input[name=password]');
            if (pass.attr('type') == 'text') {
                pass.attr('type', 'password');
            } else {
                pass.attr('type', 'text');
            }
        });

        // sweet alert catch
        const url = new URLSearchParams(window.location.search);
        const status = url.get('status');

        if (status == 'invalid') {
            Swal.fire({
                icon: 'error',
                title: 'Log Masuk Gagal !',
                text: 'No. Kad Pengenalan atau Kata Laluan Tidak Sah'
            }).then(() => {
                // Remove the status=invalid parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } else if (status == 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Log Masuk Gagal !',
                text: 'Sistem Tidak Dapat Diakses!'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } else if (status == 'registered') {
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Berjaya!',
                text: 'Pendaftaran Akaun Anda Berjaya!'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } else if (status == 'loggedOut') {
            Swal.fire({
                icon: 'success',
                title: 'Log Keluar Berjaya!',
                text: 'Log Keluar Anda Berjaya!'
            }).then(() => {
                // Remove the status=error parameter from the URL
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        }
    </script>
</body>
</html>

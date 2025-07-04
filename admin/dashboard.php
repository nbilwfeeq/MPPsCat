<?php 
    include 'database/config.php';
    $page = 'Dashboard Admin | Sistem Pengurusan Data dan Tempahan Buku Ibnu Firnas';
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
    <link rel="stylesheet" href="styles/dashboard-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/main-style.css?v=<?php echo time(); ?>">

    <!--===============Bootstrap 5.2==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <!--=============== BoxIcons ===============-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <!--=============== Google Fonts ===============-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    

    <title><?php echo $page; ?></title>
</head>
<style>
    .content {
        position: relative;
        min-height: 100vh;
    }
</style>

<body onload="document.body.classList.add('loaded')">
    <div class="loader"></div>

    <?php include('includes/topbar.php'); ?>

    <div class="content container p-3">
    <h1>Dashboard Admin</h1>
    <p>Welcome, Admin!</p>
    <div class="hr"><hr></div>
    <div class="row justify-content-center">

        <div class="col-lg-5 mb-4">
            <a href="users.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><i class='bx bxs-user'></i>&nbspPengguna</h2>
                        <h6 class="card-subtitle mb-2">Jumlah Pengguna</h6>
                        <h1 class="card-text" style="color : var(--purple);">
                            <span class="counter" data-count="<?php
                                $res_user = mysqli_query($connect, "SELECT * FROM user");
                                $count_user = mysqli_num_rows($res_user);
                                echo $count_user;
                            ?>">0</span>
                        </h1>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-5 mb-4">
            <a href="reservations.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><i class='bx bxs-message-square-detail'></i>&nbspTempahan Cetakan</h2>
                        <h6 class="card-subtitle mb-2">Jumlah Tempahan Cetakan</h6>
                        <h1 class="card-text" style="color : var(--purple);">
                            <span class="counter" data-count="<?php
                                $res_reserves = mysqli_query($connect, "SELECT * FROM reservations");
                                $count_reserves = mysqli_num_rows($res_reserves);
                                echo $count_reserves;
                            ?>">0</span>
                        </h1>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-5 mb-4">
            <a href="payments.php" class="text-decoration-none">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title"><i class='bx bxs-message-square-detail'></i>&nbspRekod Bayaran</h2>
                        <h6 class="card-subtitle mb-2">Jumlah Pembayaran</h6>
                        <h1 class="card-text" style="color : var(--purple);">
                            <span class="counter" data-count="<?php
                                $res_reserves = mysqli_query($connect, "SELECT * FROM payments");
                                $count_reserves = mysqli_num_rows($res_reserves);
                                echo $count_reserves;
                            ?>">0</span>
                        </h1>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

    <?php include('includes/footer.php'); ?>

    </div>
    <!--Container Main end-->

    <!--=============== Bootstrap 5.2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== jQuery ===============-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!--=============== Datatables ===============-->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!--=============== SweetAlert2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--============== Counter Effects =========-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.counter').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-count');

                $({ countNum: $this.text() }).animate({
                    countNum: countTo
                },
                {
                    duration: 1000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }
                });
            });

            const parameter = new URLSearchParams(window.location.search);
            const getURL = parameter.get('status');

            if (getURL == 'loggedIn') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berjaya Log Masuk!',
                    text: 'SELAMAT DATANG, ADMIN!'
                }).then(() => {
                    // Remove the status=loggedIn parameter from the URL
                    const urlWithoutStatus = window.location.href.split('?')[0];
                    window.history.replaceState({}, document.title, urlWithoutStatus);
                });
            }
        });
    </script>

</body>

</html>

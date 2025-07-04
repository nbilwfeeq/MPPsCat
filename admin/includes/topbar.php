<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.min.css">
<link rel="stylesheet" href="../styles/main-style.css">

<style>
    
    /* Mobile (Smartphone) */
    @media (max-width: 480px) {
        /* CSS rules for mobile devices */
        .logo-mpp {
            width: 3rem;
        }
    }

    /* Desktops */
    @media (min-width: 1280px) {
        /* CSS rules for desktops */
        .logo-mpp {
            width: 7rem;
        }
    }

    /* Huge size (Larger screen) */
    @media (min-width: 1281px) {
        /* CSS rules for larger screens */
        .logo-mpp {
            width: 7rem;
        }
    }

    /* Smooth hover effect */
    .navbar-nav .nav-link, .navbar-nav .nav-link i {
        transition: color 0.1s ease;
    }

    .navbar-nav .nav-link:hover, .navbar-nav .nav-link i:hover {
        color: var(--main-purple2) !important;
    }

    .navbar-nav .nav-link i {
        margin-right: 5px;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
    }

    .navbar-brand img {
        margin-right: 10px;
    }

    .navbar-brand b {
        color: var(--main-purple2);
        padding-left: 10px;
    }
    
    /* Active link style */
    .navbar-nav .nav-link.active {
        color: var(--main-purple2) !important;
    }
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
            <img src="../images/logo-mpp (black).png" class="logo-mpp" alt="Logo">
            <b>S</b>istem <b> C</b>etakan <b> A</b>tas <b> T</b>alian
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="dashboard.php"><i class='bx bxs-dashboard'></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users.php"><i class='bx bxs-user'></i>Data Pengguna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservations.php"><i class='bx bxs-message-square-detail'></i>Senarai Tempahan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="payments.php"><i class='bx bxs-file'></i>Rekod Bayaran</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="settings.php"><i class='bx bx-cog'></i>Tetapan</a>
                </li> -->
                <li class="nav-item">
                    <a href="backend/logout.php" id="logout-button" class="nav-link"><i class='bx bx-log-out'></i>Log Keluar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>

<script>
    // SweetAlert for logout confirmation
    const logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Adakah Anda Pasti?',
                text: "Anda Akan Dilog Keluar!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Saya Pasti!',
                cancelButtonText: 'Tidak, Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'backend/logout.php';
                }
            });
        });
    }

    // Add active class to the current page link
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        
        navLinks.forEach(link => {
            if (link.href.includes(currentPath)) {
                link.classList.add('active');
            }
        });
    });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.min.css">
<link rel="stylesheet" href="../styles/main-styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">


<style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");


    :root {
        --header-height: 4.3rem;
        --nav-width: 68px;
        --body-font: "Nunito", sans-serif;
        --normal-font-size: 1rem;
        --z-fixed: 1030;
    }

    *, ::before, ::after {
        box-sizing: border-box;
    }

    body {
        position: relative;
        margin: var(--header-height) 0 0 0;
        padding: 0 1rem;
        transition: margin-left 0.5s, padding-left 0.5s;
    }

    a {
        text-decoration: none;
    }

    .header {
        width: 100%;
        height: var(--header-height);
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1rem;
        background-color: var(--purple);
        z-index: var(--z-fixed);
        transition: padding-left 0.5s;
    }

    .header_toggle {
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: transform 0.5s; /* Smooth transition for toggle button */
    }

    .header_content {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--purple);
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
        transition: margin-left 0.5s;
    }

    .header_text {
        font-size: 2vh;
        margin-right: 20px;
    }

    .header_img {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        overflow: hidden;
    }

    .header_img img {
        width: 100%;
        height: auto;
    }


    .l-navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--nav-width);
        height: 100vh;
        background-color: var(--main-purple2);
        padding: 0.5rem 1rem 0 0;
        transition: width 0.5s; /* Smooth transition for width */
        z-index: var(--z-fixed);
    }

    .nav {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
    }

    .nav_logo,
    .nav_link {
        display: grid;
        grid-template-columns: max-content max-content;
        align-items: center;
        column-gap: 1rem;
        padding: 0.5rem 0 0.5rem 1.5rem;
    }

    .nav_logo {
        margin-bottom: 2rem;
    }

    .nav_logo-icon {
        font-size: 1.25rem;
        color: var(--purple);
    }

    .nav_logo-name {
        color: var(--purple);
        font-weight: 700;
    }

    .nav_link {
        position: relative;
        color: white;
        margin-bottom: 1.5rem;
        transition: 0.3s;
        text-decoration: none;
    }

    .nav_link:hover {
        color: var(--purple);
        text-decoration: none;
    }

    .nav_icon {
        font-size: 1.25rem;
    }

    .show {
        left: 0;
    }

    .active {
        color: var(--purple);
    }

    .active::before {
        content: "";
        position: absolute;
        left: 0;
        width: 2px;
        height: 32px;
        background-color: var(--purple);
    }

    .height-100 {
        height: 100vh;
    }

    .l-navbar.show {
        width: calc(var(--nav-width) + 156px); /* Adjust sidebar width on large screens */
    }

    .body-pd {
        padding-left: var(--nav-width);
        transition: padding-left 0.5s; /* Smooth transition for padding */
    }

    .l-navbar.show + .body-pd {
        padding-left: calc(var(--nav-width) + 156px); /* Adjust padding to account for expanded sidebar */
    }

    .header {
        transition: padding-left 0.5s;
    }

    .header_toggle {
        transition: transform 0.5s;
    }

    @media screen and (min-width: 768px) {
        body {
            margin: calc(var(--header-height) + 1rem) 0 0 0;
            padding-left: calc(var(--nav-width) + 0rem);
            padding-right: calc(var(--nav-width) + -10rem);
        }

        .header {
            height: calc(var(--header-height) + 1rem);
            padding-left: calc(var(--nav-width) + 2rem);
        }

        .header_content {
            font-size: 1.25rem;
        }

        .header_content p{
            font-size: 1rem;
        }

        .header_text {
            font-size: 2rem;
            margin-left: 30px;
            color: white;
        }

        .header_img {
            width: 60px;
            height: 60px;
        }

        .l-navbar.show {
            width: calc(var(--nav-width) + 156px);
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 156px);
        }
    }

    @media screen and (max-width: 767px) {

        body {
              padding-left: calc(0rem);
              padding-right: calc(0rem);
        }

        .l-navbar {
            width: var(--nav-width);
            height: 100vh;
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            z-index: var(--z-fixed);
            transition: width 0.5s; /* Smooth transition for sidebar width */
        }

        .header {
            height: calc(var(--header-height) + 1rem);
            padding-left: var(--nav-width);
        }

        .header_toggle {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            transform: translateX(0); /* Initial position */
            transition: transform 0.5s; /* Smooth transition for button movement */
            z-index: var(--z-fixed);
        }

        .header_text {
            font-size: 0.9rem;
            margin-right: 20px;
            color: white;
        }

        .header_img {
            display: block;
            margin-left: auto;
        }

        .l-navbar.show {
            display: block;
            width: var(--nav-width);
            transition: width 0.5s; /* Smooth transition for width */
        }

        .body-pd {
            padding-left: var(--nav-width);
            transition: padding-left 0.5s; /* Smooth transition for padding */
        }

        .l-navbar.show ~ .body-pd {
            padding-left: calc(var(--nav-width) + 0px); /* Adjust padding for expanded sidebar */
        }

        .l-navbar.show ~ .header_toggle {
            transform: translateX(calc(var(--nav-width) + 10px));
        }
    }


</style>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_content">
            <span class="header_text"> <b>sCat</b><p>WELCOME, <?php echo htmlspecialchars($user['nama_penuh']); ?>!</p></span>
        </div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <div class="nav_list">
                    <a href="dashboard.php" class="nav_link" id="nav-dashboard"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span> </a>
                    <a href="reservations.php" class="nav_link" id="nav-reservations"> <i class="bi bi-journal-text nav_icon"></i> <span class="nav_name">Borang Tempahan</span> </a>
                    <a href="myreservations.php" class="nav_link" id="nav-myreservations"> <i class="bi bi-list-check nav_icon"></i> <span class="nav_name">Tempahan</span> </a>
                    <a href="profile.php" class="nav_link" id="nav-profile"> <i class='bx bxs-user nav_icon'></i> <span class="nav_name">Profil Anda</span> </a>
                </div>
            </div> 
            <a href="backend/logout.php" class="nav_link" id="logout-button"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Log Keluar</span> </a>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId);

            if (toggle && nav && bodypd && headerpd) {
                toggle.addEventListener('click', () => {
                    nav.classList.toggle('show');
                    toggle.classList.toggle('bx-x');
                    bodypd.classList.toggle('body-pd');
                    headerpd.classList.toggle('body-pd');
                    headerpd.classList.toggle('header-expanded'); // Add class for expanded header
                });
            }
        };

        showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

        /*===== LINK ACTIVE =====*/
        const linkColor = document.querySelectorAll('.nav_link');

        function colorLink() {
            if (linkColor) {
                linkColor.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        }
        linkColor.forEach(l => l.addEventListener('click', colorLink));

        // Highlight active link based on current URL
        const currentUrl = window.location.pathname.split('/').pop();
        const navLinks = {
            'dashboard.php': document.getElementById('nav-dashboard'),
            'reservations.php': document.getElementById('nav-reservations'),
            'myreservations.php': document.getElementById('nav-myreservations'),
            'myhistory.php': document.getElementById('nav-myhistory'),
            'profile.php': document.getElementById('nav-profile')
        };

        if (navLinks[currentUrl]) {
            navLinks[currentUrl].classList.add('active');
        }

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
                        window.location.href = 'loading-page.php?target=backend/logout.php';
                    }
                })
            });
        }
    });
    </script>

</body>

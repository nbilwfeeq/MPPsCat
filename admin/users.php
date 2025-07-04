<?php 
    include 'database/config.php';
    $page = 'Data Pengguna | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';

    // get user info
    $stmt = $connect->prepare("SELECT * FROM user WHERE nokp = ?");
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
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

    <style>
        .btn-custom {
            background-color: transparent;
            border: 2px solid black; 
            color: black;
            transition: all 0.1s ease; 
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
        <h1>Pangkalan Data Pengguna</h1>
        <div class="hr">
            <hr>
        </div>

        <div class='p-3'>
            <button class="btn btn-custom" onclick="window.location='create-user.php'"><i class='bx bxs-user-account'></i>&nbspTambah Pengguna</button>
            <!-- <button class="btn btn-secondary" onclick="window.location='#'"><i class='bx bx-cloud-upload'></i>&nbspMuat Naik Data .CSV</button> -->
        </div>
        <br>
        <div class="filter-container d-flex justify-content-between align-items-center mb-3">
            <div class="search-bar d-flex align-items-center">
                Show
                <select id="entriesPerPage" class="form-select entries-select ms-2">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                entries
            </div>
            <div class="filter-selects d-flex align-items-center">
                <input type="text" id="searchBar" class="form-control me-2 flex-grow-1" placeholder="Cari Pengguna...">
                <select id="filterKategori" class="form-select me-2">
                    <option value="">--Semua Kategori--</option>
                    <option value="PELAJAR">PELAJAR</option>
                    <option value="PENSYARAH">PENSYARAH</option>
                    <option value="KAKITANGAN">KAKITANGAN</option>
                    <option value="LAIN-LAIN">LAIN-LAIN</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="userData">
                <thead>
                    <tr>
                        <th>Bil</th>
                        <th>Email</th>
                        <th>Nama Pengguna</th>
                        <th>No. Kad Pengenalan</th>
                        <th>No. Telefon</th>
                        <th>Kategori</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows populated by JavaScript -->
                </tbody>
            </table>
        </div>
        
    </div>

    <!--=============== Bootstrap 5.2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--=============== jQuery ===============-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!--=============== Datatables ===============-->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!--=============== SweetAlert2 ===============-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
            $(document).ready(function () {
            // Initialize the DataTable
            let table = $('#userData').DataTable({
                paging: false,
                searching: false
            });

            // Load table data
            function loadTable(search = '', kategori = '', entries = 10) {
                $.ajax({
                    url: 'backend/get-users.php',
                    type: 'GET',
                    data: { search, kategori, entries },
                    success: function (data) {
                        // Clear the table data
                        table.clear().draw();

                        // Append the new data
                        $('#userData tbody').html(data);

                        // Reinitialize the DataTable
                        table.rows.add($(data)).draw();
                    }
                });
            }

            // Initial load
            loadTable();

            // Real-time search
            $('#searchBar').on('keyup', function () {
                let search = $(this).val();
                let kategori = $('#filterKategori').val();
                let entries = $('#entriesPerPage').val();
                loadTable(search, kategori, entries);
            });

            // Kategori filter
            $('#filterKategori').on('change', function () {
                let search = $('#searchBar').val();
                let kategori = $(this).val();
                let entries = $('#entriesPerPage').val();
                loadTable(search, kategori, entries);
            });

            // Entries per page
            $('#entriesPerPage').on('change', function () {
                let search = $('#searchBar').val();
                let kategori = $('#filterKategori').val();
                let entries = $(this).val();
                loadTable(search, kategori, entries);
            });
        });


        //==========alert=============//

        function editUser(nokp) {
            Swal.fire({
                icon: 'warning',
                title: 'Anda Pasti ?',
                text: 'Anda pasti ingin mengemaskini data pengguna ini?',
                showDenyButton: true,
                confirmButtonText: 'Ya',
                denyButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    const editURL = 'update-user.php?nokp=' + encodeURIComponent(nokp);
                    window.location.href = editURL;
                }
            })
        }

        function deleteUser(nokp) {
            Swal.fire({
                icon: 'warning',
                title: 'Anda Pasti?',
                text: 'Anda pasti ingin memadam rekod dan data pengguna ini?',
                showDenyButton: true,
                confirmButtonText: 'Ya',
                denyButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    const deleteURL = 'backend/delete-user.php?nokp=' + encodeURIComponent(nokp);
                    window.location.href = deleteURL;
                }
            });
        }
        
        const parameter = new URLSearchParams(window.location.search);
        const getURL = parameter.get('status');

        if (getURL == 'deleted') {
            Swal.fire({
                icon: 'success',
                title: 'Berjaya!',
                text: 'Maklumat pengguna berjaya dipadam!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#28a745',
                iconColor: '#fff',
                color: '#fff',
            }).then(() => {
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } else if (getURL == 'edited') {
            Swal.fire({
                icon: 'success',
                title: 'Berjaya!',
                text: 'Maklumat pengguna berjaya dikemaskini!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#28a745',
                iconColor: '#fff',
                color: '#fff',
            }).then(() => {
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } else if (getURL == 'registered') {
            Swal.fire({
                icon: 'success',
                title: 'Berjaya!',
                text: 'Maklumat pengguna berjaya ditambah!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#28a745',
                iconColor: '#fff',
                color: '#fff',
            }).then(() => {
                const urlWithoutStatus = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutStatus);
            });
        } 
    </script>
</body>

</html>

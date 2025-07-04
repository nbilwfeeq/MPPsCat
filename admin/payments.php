<?php 
    include 'database/config.php';
    $page = 'Rekod Bayaran | Sistem Cetakan Atas Talian Majlis Perwakilan Pelajar';

    // get user info
    $stmt = $connect->prepare("SELECT * FROM user WHERE nokp = ?");
    $stmt->bind_param("s", $nokp);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // get reservation info
    $stmt = $connect->prepare("SELECT * FROM reservations");
    $stmt->execute();
    $reservationsResult = $stmt->get_result();
    $reservations = $reservationsResult->fetch_all(MYSQLI_ASSOC);

    // get payment info
    $stmt = $connect->prepare("SELECT * FROM payments");
    $stmt->execute();
    $reservationsResult = $stmt->get_result();
    $reservations = $reservationsResult->fetch_all(MYSQLI_ASSOC);
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

        .form-control {
            width: 40vh;
        }
    </style>
</head>

<body>
    <?php include('includes/topbar.php'); ?>

    <div class="content container p-3">
        <h1>Senarai Rekod Bayaran </h1>
        <div class="hr"><hr></div>
        <br>
        <div class="filter-container d-flex justify-content-between align-items-center mb-3">
            <div class="search-bar d-flex align-items-center">
                <input type="text" id="searchBar" class="form-control me-2 flex-grow-1" placeholder="Cari Nama Pengguna...">
                <!-- <select id="filterStatus" class="form-select me-2">
                    <option value="">--Status--</option>
                    <option value="Waiting">Waiting</option>
                    <option value="Complete">Complete</option>
                </select> -->
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="paymentsData">
                <thead>
                    <tr>
                        <th>Id Bayaran</th>
                        <th>Id Tempahan</th>
                        <th>Nama Pengguna</th>
                        <th>No. Telefon</th>
                        <th>Jumlah Harga</th>
                        <th>Jenis Bayaran</th>
                        <th>Bukti Bayaran (TNG)</th>
                        <!-- <th>Status</th>
                        <th>Tindakan</th> -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            let table = $('#paymentsData').DataTable({ paging: false, searching: false });

            // Load the table data function
            function loadTable(search = '', stat = '') {
                $.ajax({
                    url: 'backend/get-payments.php',
                    type: 'GET',
                    data: { search, stat },
                    success: function (data) {
                        table.clear().draw();  // Clear existing data
                        $('#paymentsData tbody').html(data);  // Insert new data
                        table.rows.add($(data)).draw();  // Redraw the table
                    }
                });
            }

            loadTable();  // Initial table load

            // Handle the real-time search input
            $('#searchBar').on('keyup', function () {
                let search = $(this).val();
                let stat = $('#filterStatus').val();
                loadTable(search, stat);
            });

            // Handle the status filter
            $('#filterStatus').on('change', function () {
                let search = $('#searchBar').val();
                let stat = $(this).val();
                loadTable(search, stat);
            });

            // Handle the click event for changing status (Selesai/Batal)
            $('paymentsData').on('click', '.btn-success, .btn-warning', function () {
                let button = $(this);
                let id_reservation = button.data('id_reservation');
                let currentStatus = (button.hasClass('btn-success')) ? 1 : 2;

                $.ajax({
                    url: 'backend/update-status-payment.php',
                    type: 'POST',
                    data: { id_reservation: id_reservation, currentStatus: currentStatus },
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            let newStatus = response.newStatus;
                            // Update the button text and style
                            if (newStatus === 2) {
                                button.removeClass('btn-success').addClass('btn-warning').text('Batal');
                            } else {
                                button.removeClass('btn-warning').addClass('btn-success').text('Selesai');
                            }
                            // Refresh the table to reflect the updated status
                            loadTable();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('Failed to update status.');
                    }
                });
            });
        });
    </script>
</body>
</html>

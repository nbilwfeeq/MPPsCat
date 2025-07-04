<?php
include '../database/config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$stat = isset($_GET['stat']) ? $_GET['stat'] : '';

$query = "SELECT 
            r.*, 
            p.payment_type, 
            p.payment_proof 
          FROM 
            reservations r 
          LEFT JOIN 
            payments p 
          ON 
            r.id_reservation = p.id_reservation 
          WHERE 
            1=1";

if (!empty($search)) {
    $query .= " AND (r.email LIKE '%$search%' OR r.nama_penuh LIKE '%$search%' OR r.nokp LIKE '%$search%' OR r.notel LIKE '%$search%')";
}

if (!empty($stat)) {
    $query .= " AND r.status_tempahan = '$stat'";
}

$result = mysqli_query($connect, $query);

if (!$result) {
    echo "<tr><td colspan='15'>Error fetching reservations data</td></tr>";
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id_reservation']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nama_penuh']) . "</td>";
    echo "<td>" . htmlspecialchars($row['notel']) . "</td>";
    echo "<td>" . htmlspecialchars($row['reserve_date']) . "</td>";
    echo "<td>" . htmlspecialchars($row['reserve_time']) . "</td>";
    echo "<td>" . htmlspecialchars($row['colored_pages']) . "</td>";
    echo "<td>" . htmlspecialchars($row['bw_pages']) . "</td>";
    echo "<td>" . htmlspecialchars($row['total_pages']) . "</td>";
    echo "<td>" . htmlspecialchars($row['total_prices']) . "</td>";
    echo "<td><span style='background-color: " . ($row['status_tempahan'] == 1 ? '#e2e72c' : 'green') . "; color: white; border-radius: 15px; padding: 2px 10px;'>" . ($row['status_tempahan'] == 1 ? 'Waiting' : 'Complete') . "</span></td>";

    $filePath = "../uploads/" . htmlspecialchars($row['file']);
    echo "<td>
            <div class='d-flex'>
                <a href='$filePath' target='_blank' class='btn btn-primary btn-sm' style='margin-right: 5px;'><i class='bx bx-low-vision'></i></a>
                <a href='$filePath' download class='btn btn-primary btn-sm'><i class='bx bx-download'></i></a>
            </div>
          </td>";
    
    // Check if the payment type is TNG to display the "Open" button
    if ($row['payment_type'] === 'TNG' && !empty($row['payment_proof'])) {
        $paymentProofPath = "../uploads/payment_proof/" . htmlspecialchars($row['payment_proof']);
        echo "<td><a href='$paymentProofPath' target='_blank' class='btn btn-primary'>Papar</a></td>";
    } else {
        echo "<td></td>"; // Empty cell for non-TNG payments or missing proof
    }

    echo "<td>
            <button class='btn btn-success btn-complete' data-id_reservation='" . htmlspecialchars($row['id_reservation']) . "'>Selesai</button>
          </td>";

    echo "<td>
            <button class='btn btn-danger btn-delete' data-id_reservation='" . htmlspecialchars($row['id_reservation']) . "'>Padam</button>
          </td>";

    echo "</tr>";
}

mysqli_close($connect);
?>

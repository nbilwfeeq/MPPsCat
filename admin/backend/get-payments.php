<?php
include '../database/config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$stat = isset($_GET['stat']) ? $_GET['stat'] : '';

$query = "SELECT * FROM payments WHERE 1=1";

if (!empty($search)) {
    $query .= " AND (email LIKE '%$search%' OR nama_penuh LIKE '%$search%' OR nokp LIKE '%$search%' OR notel LIKE '%$search%')";
}

if (!empty($stat)) {
    $query .= " AND status_payment = '$stat'";
}

$result = mysqli_query($connect, $query);

if (!$result) {
    echo "<tr><td colspan='14'>Error fetching payments data</td></tr>";
    exit;
}

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id_payment']) . "</td>";
    echo "<td>" . htmlspecialchars($row['id_reservation']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nama_penuh']) . "</td>";
    echo "<td>" . htmlspecialchars($row['notel']) . "</td>";
    echo "<td>" . htmlspecialchars($row['total_prices']) . "</td>";
    echo "<td>" . htmlspecialchars($row['payment_type']) . "</td>";
    
    // Check if the payment type is TNG to display the "Open" button
    if ($row['payment_type'] === 'TNG' && !empty($row['payment_proof'])) {
        $paymentProofPath = "../uploads/payment_proof/" . htmlspecialchars($row['payment_proof']);
        echo "<td><a href='$paymentProofPath' target='_blank' class='btn btn-primary'>Papar</a></td>";
    } else {
        echo "<td></td>"; // Empty cell for non-TNG payments or missing proof
    }

    echo "</tr>";
}

mysqli_close($connect);
?>

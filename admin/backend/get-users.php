<?php
session_start();
include '../database/config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$entries = isset($_GET['entries']) ? intval($_GET['entries']) : 10;

// Build the query
$query = "SELECT * FROM user WHERE (nama_penuh LIKE ? OR email LIKE ? OR nokp LIKE ?)";
$params = ["%$search%", "%$search%", "%$search%"];

if ($kategori) {
    $query .= " AND kategori = ?";
    $params[] = $kategori;
}

$stmt = $connect->prepare($query);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Fetch results
$index = 1;
while ($data = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$index}</td>
        <td>" . htmlspecialchars($data['email']) . "</td>
        <td>" . htmlspecialchars($data['nama_penuh']) . "</td>
        <td>" . htmlspecialchars($data['nokp']) . "</td>
        <td>" . htmlspecialchars($data['notel']) . "</td>
        <td>" . htmlspecialchars($data['kategori']) . "</td>
        <td>
            <button class='btn btn-warning btn-sm' onclick=\"editUser('" . htmlspecialchars($data['nokp']) . "')\"><i class='bx bx-edit-alt'></i></button>
            <button class='btn btn-danger btn-sm' onclick=\"deleteUser('" . htmlspecialchars($data['nokp']) . "')\"><i class='bx bx-trash'></i></button>
        </td>
    </tr>";
    $index++;
}
?>

<?php
include 'config/koneksi.php';

$id = $_GET['id'];

$query = "
    SELECT t.id, t.tanggal, b.nama, b.harga, d.jumlah, d.subtotal
    FROM transaksi t
    JOIN detail_transaksi d ON t.id = d.id_transaksi
    JOIN buah b ON d.id_buah = b.id
    WHERE t.id = $id
";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="window.print()">
    <div class="container mt-5">
        <h3 class="text-center">Nota Penjualan Buah</h3>
        <hr>
        <p><strong>ID Transaksi:</strong> <?= $data['id']; ?></p>
        <p><strong>Tanggal:</strong> <?= $data['tanggal']; ?></p>

        <table class="table table-bordered">
            <tr>
                <th>Nama Buah</th>
                <td><?= $data['nama']; ?></td>
            </tr>
            <tr>
                <th>Harga</th>
                <td>Rp <?= number_format($data['harga']); ?></td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td><?= $data['jumlah']; ?></td>
            </tr>
            <tr>
                <th>Subtotal</th>
                <td><strong>Rp <?= number_format($data['subtotal']); ?></strong></td>
            </tr>
        </table>

        <p class="text-center">Terima kasih telah berbelanja</p>
    </div>
</body>
</html>

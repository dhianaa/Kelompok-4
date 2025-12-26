<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Penjualan Buah</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="buah.php">Data Buah</a>
                <a class="nav-link" href="transaksi.php">Transaksi</a>
                <a class="nav-link active" href="laporan.php">Laporan</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Laporan Penjualan</h2>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Buah</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "
                    SELECT t.id, t.tanggal, b.nama, d.jumlah, d.subtotal
                    FROM transaksi t
                    JOIN detail_transaksi d ON t.id = d.id_transaksi
                    JOIN buah b ON d.id_buah = b.id
                    ORDER BY t.tanggal DESC
                ";
                $result = mysqli_query($conn, $query);
                $total = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    $total += $row['subtotal'];
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['jumlah']}</td>
                        <td>Rp " . number_format($row['subtotal']) . "</td>
                    </tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total Penjualan</th>
                    <th>Rp <?= number_format($total); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

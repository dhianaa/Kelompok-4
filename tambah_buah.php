<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">Penjualan Buah</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link active" href="buah.php">Data Buah</a>
                <a class="nav-link" href="transaksi.php">Transaksi</a>
                <a class="nav-link" href="laporan.php">Laporan</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Tambah Buah</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Nama Buah</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Tambah</button>
            <a href="buah.php" class="btn btn-secondary">Kembali</a>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            if (!empty($nama) && $harga > 0 && $stok >= 0) {
                $query = "INSERT INTO buah (nama, harga, stok) VALUES ('$nama', $harga, $stok)";
                mysqli_query($conn, $query);
                header("Location: buah.php");
            } else {
                echo "<div class='alert alert-danger'>Data tidak valid!</div>";
            }
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
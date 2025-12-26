<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buah</title>
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
        <h2>Data Buah</h2>
        <a href="tambah_buah.php" class="btn btn-primary mb-3">Tambah Buah</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM buah";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nama']}</td>
                        <td>Rp {$row['harga']}</td>
                        <td>{$row['stok']}</td>
                        <td>
                            <a href='buah.php?edit={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='buah.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        <?php
        // Edit
        if (isset($_GET['edit'])) {
            $id = $_GET['edit'];
            $query = "SELECT * FROM buah WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            echo "<h3>Edit Buah</h3>
            <form method='POST'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <div class='mb-3'><input type='text' name='nama' class='form-control' value='{$row['nama']}' required></div>
                <div class='mb-3'><input type='number' name='harga' class='form-control' value='{$row['harga']}' required></div>
                <div class='mb-3'><input type='number' name='stok' class='form-control' value='{$row['stok']}' required></div>
                <button type='submit' name='update' class='btn btn-success'>Update</button>
            </form>";
        }
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $nama = $_POST['nama'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];
            if (!empty($nama) && $harga > 0 && $stok >= 0) {
                $query = "UPDATE buah SET nama='$nama', harga=$harga, stok=$stok WHERE id=$id";
                mysqli_query($conn, $query);
                header("Location: buah.php");
            } else {
                echo "<div class='alert alert-danger'>Data tidak valid!</div>";
            }
        }
        // Delete
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $query = "DELETE FROM buah WHERE id=$id";
            mysqli_query($conn, $query);
            header("Location: buah.php");
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
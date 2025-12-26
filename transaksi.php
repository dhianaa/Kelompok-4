<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan</title>
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
            <a class="nav-link active" href="transaksi.php">Transaksi</a>
            <a class="nav-link" href="laporan.php">Laporan</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Transaksi Penjualan</h2>

    <form method="POST">
        <div class="mb-3">
            <label>Pilih Buah</label>
            <select name="id_buah" class="form-control" required>
                <option value="">-- Pilih Buah --</option>
                <?php
                $query = "SELECT * FROM buah WHERE stok > 0";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id']}'>
                            {$row['nama']} - Rp {$row['harga']} (Stok: {$row['stok']})
                          </option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Jual</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $id_buah = (int) $_POST['id_buah'];
        $jumlah  = (int) $_POST['jumlah'];

        // Ambil data buah
        $query_buah = "SELECT * FROM buah WHERE id = $id_buah";
        $result_buah = mysqli_query($conn, $query_buah);
        $buah = mysqli_fetch_assoc($result_buah);

        if ($buah && $jumlah > 0 && $jumlah <= $buah['stok']) {

            $subtotal = $jumlah * $buah['harga'];

            // Insert transaksi
            $query_transaksi = "INSERT INTO transaksi (total) VALUES ($subtotal)";
            mysqli_query($conn, $query_transaksi);
            $id_transaksi = mysqli_insert_id($conn);

            // Insert detail transaksi
            $query_detail = "INSERT INTO detail_transaksi 
                (id_transaksi, id_buah, jumlah, subtotal)
                VALUES ($id_transaksi, $id_buah, $jumlah, $subtotal)";
            mysqli_query($conn, $query_detail);

            // Update stok buah
            $stok_baru = $buah['stok'] - $jumlah;
            $query_update = "UPDATE buah SET stok = $stok_baru WHERE id = $id_buah";
            mysqli_query($conn, $query_update);

            echo "<div class='alert alert-success mt-3'>
                    Transaksi berhasil!
                  </div>";

        } else {
            echo "<div class='alert alert-danger mt-3'>
                    Jumlah tidak valid atau stok tidak mencukupi!
                  </div>";
        }
    }
    ?>
</div>

</body>
</html>

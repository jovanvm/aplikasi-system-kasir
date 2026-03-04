<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Ambil data transaksi utama
$transaksi = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi='$id'");
$data_transaksi = mysqli_fetch_assoc($transaksi);

// Ambil detail produk
$query = mysqli_query($conn, "
    SELECT d.*, p.nama_produk 
    FROM detail_transaksi d
    JOIN produk p ON d.id_produk = p.id_produk
    WHERE d.id_transaksi = '$id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Phoebe's Kitchen</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="produk.php">Kelola Produk</a></li>
        <li><a href="transaksi.php">Transaksi</a></li>
        <li><a href="laporan.php">Laporan & Detail</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<!-- MAIN -->
<div class="main">

    <div class="topbar">
        <h1>Detail Transaksi #<?= $id; ?></h1>
        <div>
            Halo, <?= $_SESSION['username']; ?>
        </div>
    </div>

    <!-- INFO TRANSAKSI -->
    <div class="card">
        <h3>Informasi Transaksi</h3>
        <br>
        <p><strong>Tanggal:</strong> <?= $data_transaksi['tanggal']; ?></p>
        <p><strong>Total:</strong> Rp <?= number_format($data_transaksi['total'],0,',','.'); ?></p>
        <p><strong>Bayar:</strong> Rp <?= number_format($data_transaksi['bayar'],0,',','.'); ?></p>
        <p><strong>Kembalian:</strong> Rp <?= number_format($data_transaksi['kembalian'],0,',','.'); ?></p>

        <br>
        <a href="laporan.php" class="btn">Kembali ke Laporan</a>
    </div>

    <br>

    <!-- TABEL DETAIL PRODUK -->
    <div class="card">
        <h3>Daftar Produk</h3>
        <br>
        <table>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_produk']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td>Rp <?= number_format($row['subtotal'],0,',','.'); ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>

</body>
</html>
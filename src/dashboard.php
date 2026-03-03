<?php
session_start();
include 'koneksi.php';

// Cek login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Hitung jumlah produk
$query_produk = mysqli_query($conn, "SELECT COUNT(*) as total_produk FROM produk");
$data_produk = mysqli_fetch_assoc($query_produk);
$total_produk = $data_produk['total_produk'];

// Hitung jumlah transaksi hari ini
$query_transaksi = mysqli_query($conn, 
    "SELECT COUNT(*) as total_transaksi 
     FROM transaksi 
     WHERE DATE(tanggal) = CURDATE()");
$data_transaksi = mysqli_fetch_assoc($query_transaksi);
$total_transaksi = $data_transaksi['total_transaksi'];

// Hitung total pendapatan hari ini
$query_pendapatan = mysqli_query($conn, 
    "SELECT SUM(total) as total_pendapatan 
     FROM transaksi 
     WHERE DATE(tanggal) = CURDATE()");
$data_pendapatan = mysqli_fetch_assoc($query_pendapatan);
$total_pendapatan = $data_pendapatan['total_pendapatan'];

if ($total_pendapatan == null) {
    $total_pendapatan = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sistem Kasir</title>
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

<!-- MAIN CONTENT -->
<div class="main">

    <div class="topbar">
        <h1>Dashboard</h1>
        <div>
            Halo, <?php echo $_SESSION['username']; ?>
        </div>
    </div>

    <div class="grid">

        <div class="card">
            <h3>Total Produk</h3>
            <h2><?php echo $total_produk; ?></h2>
        </div>

        <div class="card">
            <h3>Transaksi Hari Ini</h3>
            <h2><?php echo $total_transaksi; ?></h2>
        </div>

        <div class="card">
            <h3>Pendapatan Hari Ini</h3>
            <h2>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h2>
        </div>

    </div>

</div>

</body>
</html>
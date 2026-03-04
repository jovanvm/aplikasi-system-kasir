<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Filter tanggal
$where = "";
if (isset($_GET['tanggal']) && $_GET['tanggal'] != "") {
    $tanggal = $_GET['tanggal'];
    $where = "WHERE DATE(tanggal) = '$tanggal'";
}

// Ambil data transaksi
$query = mysqli_query($conn, "SELECT * FROM transaksi $where ORDER BY tanggal DESC");

// Hitung total pendapatan
$total_pendapatan = 0;
$sum_query = mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi $where");
$sum_data = mysqli_fetch_assoc($sum_query);
if ($sum_data['total'] != null) {
    $total_pendapatan = $sum_data['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="wrapper">

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
<div class="main-content">

    <div class="container-fluid py-4">

        <h3 class="mb-4">Laporan Penjualan</h3>

        <!-- FILTER -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="date" name="tanggal" class="form-control"
                                value="<?= isset($_GET['tanggal']) ? $_GET['tanggal'] : '' ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-brown w-100">
                                Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="laporan.php" class="btn btn-reset w-100">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="card shadow-sm">
            <div class="card-header">
                Data Transaksi
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['id_transaksi']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td>Rp <?= number_format($row['total'],0,',','.'); ?></td>
                        <td>Rp <?= number_format($row['bayar'],0,',','.'); ?></td>
                        <td>Rp <?= number_format($row['kembalian'],0,',','.'); ?></td>
                        <td>
                            <a href="detail_transaksi.php?id=<?= $row['id_transaksi']; ?>" 
                               class="btn btn-detail btn-sm">
                               Lihat
                            </a>
                        </td>
                    </tr>
                    <?php } ?>

                    <tr class="total-row">
                        <th colspan="3">Total Pendapatan</th>
                        <th colspan="4">
                            Rp <?= number_format($total_pendapatan,0,',','.'); ?>
                        </th>
                    </tr>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
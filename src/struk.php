<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Ambil data transaksi
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
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: monospace;
        }
        .struk {
            width: 300px;
            margin: auto;
        }
        hr {
            border: 1px dashed black;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="struk">

    <h3 style="text-align:center;">Phoebe's Kitchen</h3>
    <p style="text-align:center;">
        Jl. Raya Barat No.21 Singaparna, Kab. Tasikmalaya<br>
        IG: phoebes.kitchen
    </p>

    <hr>

    <p>
        ID Transaksi : <?= $id; ?><br>
        Tanggal : <?= $data_transaksi['tanggal']; ?><br>
        Kasir : <?= $_SESSION['username']; ?>
    </p>

    <hr>

    <?php while ($row = mysqli_fetch_assoc($query)) { ?>
        <p>
            <?= $row['nama_produk']; ?><br>
            <?= $row['jumlah']; ?> x 
            Rp <?= number_format($row['subtotal'] / $row['jumlah'],0,',','.'); ?>
            <span style="float:right;">
                Rp <?= number_format($row['subtotal'],0,',','.'); ?>
            </span>
        </p>
    <?php } ?>

    <hr>

    <p>
        Total :
        <span style="float:right;">
            Rp <?= number_format($data_transaksi['total'],0,',','.'); ?>
        </span>
    </p>

    <p>
        Bayar :
        <span style="float:right;">
            Rp <?= number_format($data_transaksi['bayar'],0,',','.'); ?>
        </span>
    </p>

    <p>
        Kembali :
        <span style="float:right;">
            Rp <?= number_format($data_transaksi['kembalian'],0,',','.'); ?>
        </span>
    </p>

    <hr>

    <p style="text-align:center;">
        Terima Kasih<br>
        Sudah Berbelanja 🙏
    </p>

    <br><br>

    <div class="no-print" style="text-align:center;">
        <button onclick="window.print()">🖨 Print</button>
        <br><br>
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>

</div>

</body>
</html>
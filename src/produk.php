<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

/* =========================
   TAMBAH PRODUK
========================= */
if (isset($_POST['tambah'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = intval($_POST['harga']);
    $stok  = intval($_POST['stok']);

    mysqli_query($conn, "INSERT INTO produk (nama_produk, harga, stok) 
                         VALUES ('$nama','$harga','$stok')");

    header("Location: produk.php");
    exit;
}

/* =========================
   HAPUS PRODUK
========================= */
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    mysqli_query($conn, "DELETE FROM produk WHERE id_produk='$id'");
    header("Location: produk.php");
    exit;
}

/* =========================
   UPDATE PRODUK
========================= */
if (isset($_POST['update'])) {
    $id    = intval($_POST['id_produk']);
    $nama  = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = intval($_POST['harga']);
    $stok  = intval($_POST['stok']);

    mysqli_query($conn, "UPDATE produk 
                         SET nama_produk='$nama',
                             harga='$harga',
                             stok='$stok'
                         WHERE id_produk='$id'");

    header("Location: produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk</title>
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
        <h1>Kelola Produk</h1>
        <div>Halo, <?= $_SESSION['username']; ?></div>
    </div>

    <!-- FORM TAMBAH -->
    <div class="card">
        <h3>Tambah Produk</h3>
        <form method="POST" class="form-produk">
            <input type="text" name="nama_produk" placeholder="Nama Produk" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <input type="number" name="stok" placeholder="Stok" required>
            <button type="submit" name="tambah" class="btn">Tambah</button>
        </form>
    </div>

    <br>

    <!-- TABEL -->
    <div class="card">
        <h3>Data Produk</h3>
        <br>
        <table>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th width="180">Aksi</th>
            </tr>

            <?php
            $no = 1;
            $data = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");
            while ($row = mysqli_fetch_assoc($data)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['nama_produk']; ?></td>
                    <td>Rp <?= number_format($row['harga'],0,',','.'); ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td>
    <div class="aksi-btn">
        <a href="?edit=<?= $row['id_produk']; ?>" class="btn-edit">Edit</a>
        <a href="?hapus=<?= $row['id_produk']; ?>" 
           class="btn-hapus"
           onclick="return confirm('Yakin hapus?')">
           Hapus
        </a>
    </div>
</td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- FORM EDIT -->
    <?php
    if (isset($_GET['edit'])) {
        $id_edit = intval($_GET['edit']);
        $edit = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_edit'");
        $data_edit = mysqli_fetch_assoc($edit);

        if ($data_edit) {
    ?>
        <br>
        <div class="card">
            <h3>Edit Produk</h3>
            <form method="POST" class="form-produk">
                <input type="hidden" name="id_produk" value="<?= $data_edit['id_produk']; ?>">
                <input type="text" name="nama_produk" value="<?= $data_edit['nama_produk']; ?>" required>
                <input type="number" name="harga" value="<?= $data_edit['harga']; ?>" required>
                <input type="number" name="stok" value="<?= $data_edit['stok']; ?>" required>
                <button type="submit" name="update" class="btn">Update</button>
            </form>
        </div>
    <?php 
        }
    } 
    ?>

</div>

</body>
</html>
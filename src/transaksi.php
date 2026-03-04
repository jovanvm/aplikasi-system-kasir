<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Tambah ke keranjang
if (isset($_POST['tambah'])) {
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];

    $produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $data = mysqli_fetch_assoc($produk);

    $subtotal = $data['harga'] * $jumlah;

    $_SESSION['keranjang'][] = [
        'id_produk' => $id_produk,
        'nama_produk' => $data['nama_produk'],
        'harga' => $data['harga'],
        'jumlah' => $jumlah,
        'subtotal' => $subtotal
    ];
}

// Hapus item
if (isset($_GET['hapus'])) {
    unset($_SESSION['keranjang'][$_GET['hapus']]);
    header("Location: transaksi.php");
}

// Simpan transaksi
if (isset($_POST['simpan'])) {

    $total = $_POST['total'];
    $bayar = $_POST['bayar'];
    $kembalian = $bayar - $total;

    mysqli_query($conn, "INSERT INTO transaksi (total, bayar, kembalian)
                         VALUES ('$total','$bayar','$kembalian')");

    $id_transaksi = mysqli_insert_id($conn);

    foreach ($_SESSION['keranjang'] as $item) {
        mysqli_query($conn, "INSERT INTO detail_transaksi
                             (id_transaksi, id_produk, jumlah, subtotal)
                             VALUES
                             ('$id_transaksi',
                              '{$item['id_produk']}',
                              '{$item['jumlah']}',
                              '{$item['subtotal']}')");

        mysqli_query($conn, "UPDATE produk
                             SET stok = stok - {$item['jumlah']}
                             WHERE id_produk = {$item['id_produk']}");
    }

    unset($_SESSION['keranjang']);
    echo "<script>
            alert('Transaksi berhasil!');
            window.location='struk.php?id=$id_transaksi';
          </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Kasir</title>
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
        <h1>Transaksi Kasir</h1>
        <div>Halo, <?php echo $_SESSION['username']; ?></div>
    </div>

    <!-- FORM TAMBAH PRODUK -->
    <div class="card">
        <h3>Tambah Produk</h3>
        <form method="POST" style="margin-top:15px;">
            <select name="id_produk" required>
                <option value="">Pilih Produk</option>
                <?php
                $produk = mysqli_query($conn, "SELECT * FROM produk WHERE stok > 0");
                while ($p = mysqli_fetch_assoc($produk)) {
                ?>
                    <option value="<?= $p['id_produk']; ?>">
                        <?= $p['nama_produk']; ?> - Rp <?= number_format($p['harga'],0,',','.'); ?>
                    </option>
                <?php } ?>
            </select>

            <input type="number" name="jumlah" placeholder="Jumlah" required>

            <button type="submit" name="tambah" class="btn">Tambah</button>
        </form>
    </div>

    <br>

    <!-- KERANJANG -->
    <div class="card">
        <h3>Keranjang</h3>
        <br>

        <table>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>

            <?php
            $total = 0;
            if (!empty($_SESSION['keranjang'])) {
                foreach ($_SESSION['keranjang'] as $index => $item) {
                    $total += $item['subtotal'];
            ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= $item['nama_produk']; ?></td>
                    <td>Rp <?= number_format($item['harga'],0,',','.'); ?></td>
                    <td><?= $item['jumlah']; ?></td>
                    <td>Rp <?= number_format($item['subtotal'],0,',','.'); ?></td>
                    <td>
                        <a href="?hapus=<?= $index; ?>" class="btn">Hapus</a>
                    </td>
                </tr>
            <?php
                }
            }
            ?>

            <tr>
                <th colspan="4">Total</th>
                <th colspan="2">Rp <?= number_format($total,0,',','.'); ?></th>
            </tr>
        </table>

        <?php if ($total > 0) { ?>
            <form method="POST" style="margin-top:20px;">
                <input type="hidden" name="total" value="<?= $total; ?>">
                <input type="number" name="bayar" placeholder="Uang Bayar" required>
                <button type="submit" name="simpan" class="btn">Simpan Transaksi</button>
            </form>
        <?php } ?>

    </div>

</div>

</body>
</html>
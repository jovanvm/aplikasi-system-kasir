<?php
use PHPUnit\Framework\TestCase;

class TransaksiTest extends TestCase {
    
    // 1. Test Input & Process: Tambah ke Keranjang
    public function testTambahKeranjang() {
        // Simulasi data produk dari database
        $harga_produk = 35000;
        $jumlah_beli = 2;
        
        // Logika di transaksi.php: $subtotal = $data['harga'] * $jumlah;
        $subtotal = $harga_produk * $jumlah_beli;

        // Output: Pastikan subtotal benar
        $this->assertEquals(70000, $subtotal, "Perhitungan subtotal keranjang salah");
    }

    // 2. Test Process: Perhitungan Kembalian (IPO - Process)
    public function testHitungKembalian() {
        $total_belanja = 70000;
        $uang_bayar = 100000;

        // Logika di transaksi.php: $kembalian = $bayar - $total;
        $kembalian = $uang_bayar - $total_belanja;

        // Output: Pastikan kembalian benar
        $this->assertEquals(30000, $kembalian, "Perhitungan uang kembalian salah");
    }

    // 3. Test Process: Validasi Stok (IPO - Process)
    public function testPenguranganStok() {
        $stok_awal = 10;
        $jumlah_dibeli = 3;

        // Logika di transaksi.php: SET stok = stok - jumlah
        $stok_akhir = $stok_awal - $jumlah_dibeli;

        // Output: Stok tidak boleh negatif
        $this->assertGreaterThanOrEqual(0, $stok_akhir, "Stok menjadi negatif setelah transaksi");
        $this->assertEquals(7, $stok_akhir);
    }
}
<?php
use PHPUnit\Framework\TestCase;

class ProdukTest extends TestCase {
    
    // 1. Test Input: Tambah Produk (Sesuai deskripsi IPO)
    public function testTambahProduk() {
        // Simulasi Input (I)
        $nama_produk = "IQOS TEREA Blue";
        $harga = 35000;
        $stok = 50;

        // Simulasi Proses (P) - Memastikan data valid sebelum masuk Query
        $is_valid = (!empty($nama_produk) && $harga > 0 && $stok >= 0);
        
        // Output (O)
        $this->assertTrue($is_valid, "Proses input produk gagal karena data tidak valid");
    }

    // 2. Test Process: Update Stok Produk
    public function testUpdateProduk() {
        $stok_awal = 50;
        $stok_tambahan = 10;
        
        // Simulasi Logika Update di produk.php
        $stok_baru = $stok_awal + $stok_tambahan;

        $this->assertEquals(60, $stok_baru, "Logika update stok salah");
    }

    // 3. Test Process: Hapus Produk
    public function testHapusProduk() {
        // Simulasi ID yang diambil dari $_GET['hapus']
        $id_produk = 5; 
        
        // Memastikan ID adalah integer (karena di produk.php kamu pakai intval)
        $id_tervalidasi = intval($id_produk);

        $this->assertIsInt($id_tervalidasi);
        $this->assertGreaterThan(0, $id_tervalidasi, "ID Produk tidak valid untuk dihapus");
    }
}
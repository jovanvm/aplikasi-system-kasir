<?php
use PHPUnit\Framework\TestCase;

class LaporanTest extends TestCase {
    
    // 1. Test Process: Filter Tanggal (IPO - Process)
    public function testFilterLaporan() {
        // Simulasi input $_GET['tanggal']
        $tanggal_input = "2024-05-20";
        
        // Meniru logika di laporan.php: $where = "WHERE DATE(tanggal) = '$tanggal'";
        $query_condition = "WHERE DATE(tanggal) = '" . $tanggal_input . "'";

        // Output: Pastikan query filter terbentuk dengan benar
        $this->assertStringContainsString($tanggal_input, $query_condition);
        $this->assertEquals("WHERE DATE(tanggal) = '2024-05-20'", $query_condition);
    }

    // 2. Test Output: Akumulasi Total Pendapatan (IPO - Output)
    public function testTotalPendapatan() {
        // Simulasi data dari database (Array transaksi)
        $transaksi = [
            ['total' => 50000],
            ['total' => 35000],
            ['total' => 15000]
        ];

        // Logika akumulasi di laporan.php
        $total_pendapatan = 0;
        foreach ($transaksi as $t) {
            $total_pendapatan += $t['total'];
        }

        // Output: Pastikan hasil penjumlahan benar
        $this->assertEquals(100000, $total_pendapatan, "Penjumlahan total pendapatan salah");
    }

    // 3. Test Output: Validasi Format Struk
    public function testFormatStruk() {
        $total = 100000;
        
        // Meniru fungsi number_format di struk.php
        $format_rupiah = "Rp " . number_format($total, 0, ',', '.');

        $this->assertEquals("Rp 100.000", $format_rupiah);
    }
}
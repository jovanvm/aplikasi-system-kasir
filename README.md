# Sistem Kasir - Phoebe's Kitchen

Proyek ini adalah aplikasi manajemen kasir sederhana yang dikembangkan untuk memenuhi Tugas Praktikum Mata Kuliah Rancang Bangun Perangkat Lunak (RBPL). Aplikasi ini mengimplementasikan konsep Version Control menggunakan Git dengan alur kerja kolaborasi kelompok.

## 1. Deskripsi Proyek
Aplikasi **Phoebe's Kitchen** dirancang untuk membantu pengelolaan data produk, transaksi penjualan, hingga pembuatan laporan pendapatan secara digital. Pengembangan aplikasi ini berfokus pada alur kerja **IPO (Input, Process, Output)** yang relevan dengan kebutuhan sistem kasir.

## 2. Fitur Utama (IPO)
Sesuai dengan kriteria tugas, fitur-fitur yang tersedia meliputi:
* **Input Data:** Kelola data produk (tambah, edit, hapus) dan input nominal pembayaran pada transaksi.
* **Proses:** Perhitungan otomatis subtotal keranjang, total belanja, uang kembalian, serta pengurangan stok produk secara otomatis saat transaksi disimpan.
* **Output:** Ringkasan laporan pendapatan, detail riwayat transaksi, dan cetak struk belanja dalam format yang rapi.

## 3. Struktur Folder Proyek
Proyek ini mengikuti standar struktur folder yang diinstruksikan:
* `src/`: Berisi kode sumber utama aplikasi (.php, .css).
* `tests/`: Berisi file unit testing (AuthTest, ProdukTest, TransaksiTest, LaporanTest).
* `docs/`: Berisi dokumentasi teknis dan laporan log Git.
* `assets/`: Berisi file pendukung seperti CSS dan komponen UI (header/sidebar).

## 4. Dependensi & Kebutuhan Sistem
Untuk menjalankan aplikasi ini dan melakukan pengujian, diperlukan:
* **Web Server:** XAMPP (PHP versi 7.4 atau lebih baru) & MySQL Database.
* **Dependency Manager:** Composer (untuk instalasi PHPUnit).
* **Testing Tool:** PHPUnit (terinstal via Composer di folder `/vendor`).
* **Browser:** Google Chrome/Microsoft Edge (disarankan untuk fitur cetak struk).

## 5. Cara Menjalankan Aplikasi
1.  **Clone Repositori:**
    ```bash
    git clone [https://github.com/jovanvm/aplikasi-system-kasir.git](https://github.com/jovanvm/aplikasi-system-kasir.git)
    ```
2.  **Persiapan Database:**
    * Buka `phpMyAdmin`.
    * Buat database baru bernama `db_kasir`.
    * Import file SQL (jika ada) atau sesuaikan konfigurasi di `src/koneksi.php`.
3.  **Instalasi Dependensi:**
    Pastikan Composer sudah terinstal, lalu jalankan perintah berikut di terminal:
    ```bash
    composer install
    ```
4.  **Akses Aplikasi:**
    Pindahkan folder proyek ke `C:/xampp/htdocs/`, jalankan Apache & MySQL di XAMPP, lalu akses `localhost/Sistem Kasir/src/login.php`.

## 6. Cara Menjalankan Pengujian (Testing)
Setiap fitur telah dilengkapi dengan unit test untuk menjamin kualitas kode. Gunakan perintah berikut di terminal VS Code:
```bash
./vendor/bin/phpunit tests/AuthTest.php
./vendor/bin/phpunit tests/ProdukTest.php
./vendor/bin/phpunit tests/TransaksiTest.php
./vendor/bin/phpunit tests/LaporanTest.php
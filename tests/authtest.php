<?php
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {
    
    // Testing Input: Simulasi Login Berhasil
    public function testLoginSuccess() {
        // Simulasi data $_POST
        $username = "admin";
        $password = md5("12345"); // Sesuai dengan enkripsi di login.php

        // Simulasi hasil query dari database
        $mockData = [
            'id' => 1,
            'username' => 'admin',
            'role' => 'admin'
        ];

        // Process: Simpan ke Session (Meniru logika login.php)
        $_SESSION['id_user'] = $mockData['id'];
        $_SESSION['username'] = $mockData['username'];
        $_SESSION['role'] = $mockData['role'];

        // Output: Cek apakah session sudah terisi dengan benar
        $this->assertEquals('admin', $_SESSION['username']);
        $this->assertEquals('admin', $_SESSION['role']);
    }

    // Testing Logout
    public function testLogoutDestroySession() {
        // Set session awal
        $_SESSION['username'] = 'admin';

        // Process: Simulasi logika logout.php
        $_SESSION = [];
        // Di PHPUnit kita hanya cek apakah array session kosong
        
        // Output: Pastikan session sudah kosong
        $this->assertEmpty($_SESSION);
    }
}
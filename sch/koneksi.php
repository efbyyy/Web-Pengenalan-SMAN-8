<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$database = "sman8"; // Pastikan sesuai dengan nama database kamu

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

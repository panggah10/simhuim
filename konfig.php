<?php

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "db_simh";

$base_url = "http://localhost/sirusak/";

// Membuat koneksi ke database
$koneksi = mysqli_connect($server, $user, $pass, $dbname);

// Mengecek apakah koneksi berhasil
if (!$koneksi) {
	die("Koneksi gagal: " . mysqli_connect_error());
} else {
	// echo "Koneksi berhasil :)";
}

// Tutup koneksi setelah selesai jika diperlukan
// mysqli_close($koneksi);
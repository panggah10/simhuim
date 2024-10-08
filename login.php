<?php
session_start();
extract($_POST);
include './konfig.php';

// Query menggunakan prepared statement untuk menghindari SQL Injection
$query = "SELECT * FROM tbl_user WHERE username = ? AND password = ?";
$stmt = mysqli_prepare($koneksi, $query);

// Mengikat parameter
mysqli_stmt_bind_param($stmt, "ss", $username, $password);

// Menjalankan query
mysqli_stmt_execute($stmt);

// Mengambil hasil
$result = mysqli_stmt_get_result($stmt);

// Cek apakah ada hasil
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['id_user'] = $row['id_user'];
        $_SESSION['hak_akses'] = $row['hak_akses'];
        $_SESSION['grup'] = $row['grup'];

        // Pengalihan halaman sesuai dengan hak akses
        if ($row['hak_akses'] == "Dokter") {
            header("Location: dokter.php?view=tampil_pasien_dokter");
            exit(); // Menghentikan eksekusi setelah pengalihan
        } elseif ($row['hak_akses'] == "Front Office") {
            header("Location: front-office.php?view=tampil_pasien");
            exit();
        } elseif ($row['hak_akses'] == "Departemen") {
            header("Location: departemen.php?view=tampil_pasien");
            exit();
        } else {
            // Jika tidak ada hak akses yang sesuai, hancurkan sesi
            session_destroy();
            echo "<script>location.href='index.php?error=hakakses';</script>";
            exit();
        }
    }
} else {
    // Jika username atau password salah
    echo "<script>location.href='index.php?error=salah';</script>";
    exit();
}

// Tutup statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($koneksi);

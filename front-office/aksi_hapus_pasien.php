<?php
// Aktifkan output buffering
ob_start();

include 'konfig.php';

$id_pasien = $_GET['id_pasien'];

// Query untuk menghapus pasien
$query = "DELETE FROM tbl_pasien WHERE id_pasien='$id_pasien'";

// Eksekusi query
mysqli_query($koneksi, $query);

// Alihkan ke halaman tampil pasien setelah data dihapus
header("location:front-office.php?view=tampil_pasien");

// Kosongkan output buffering dan kirim output
ob_end_flush();

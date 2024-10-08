<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "insert into tbl_pri values(null,'$id_pasien', '$id_ruang', '$tanggal_checkin', '$tanggal_checkout', '$hari_menginap', '$diagnosa', '$biaya', '$bayar')";
mysqli_query($koneksi, $query);
echo json_encode(array('success' => 'true'));

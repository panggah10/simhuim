<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "insert into tbl_pasien values(null,'$nama','$alamat', '$jenis_kelamin', '$no_telepon') ";
mysqli_query($koneksi, $query);

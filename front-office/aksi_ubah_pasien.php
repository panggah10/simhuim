<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "update tbl_pasien set nama_pasien='$nama', alamat='$alamat', jenis_kelamin = '$jenis_kelamin', no_telepon = '$no_telepon' where id_pasien='$id_pasien' ";
mysqli_query($koneksi, $query);
header("location:../front-office.php?view=tampil_pasien");

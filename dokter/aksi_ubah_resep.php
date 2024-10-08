<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../konfig.php';
extract($_POST);
$query = "update tbl_resep set nama_resep = '$nama_resep', rincian_resep = '$rincian_resep' where id_resep='$id_resep' ";
mysqli_query($koneksi, $query);
header("location:../dokter.php?view=tampil_resep");

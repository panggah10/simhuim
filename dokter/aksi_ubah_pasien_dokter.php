<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "update tbl_prj set diagnosa = '$diagnosa', tindakan = '$tindakan' where no_rj='$no_rj' ";
mysqli_query($koneksi, $query);
header("location:../dokter.php?view=tampil_pasien_dokter");

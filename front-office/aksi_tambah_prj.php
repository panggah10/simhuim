<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "insert into tbl_prj values(null,'$id_dokter','$id_pasien', '$departemen', curtime(), '$keluhan', null, '$biaya', '$bayar', null)";
mysqli_query($koneksi, $query);
return true;

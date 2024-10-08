<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "update tbl_prj set id_pasien='$id_pasien', departemen = '$departemen', tanggal = curtime(), keluhan = '$keluhan', biaya = '$biaya', bayar = '$bayar' where no_rj='$no_rj' ";
mysqli_query($koneksi, $query);
header("location:../front-office.php?view=tampil_prj");

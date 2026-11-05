<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "insert into tbl_pasien values(null,'$nama','$tmp_lahir','$tgl_lahir','$alamat', '$jenis_kelamin', '$no_telepon', '$agama','$pend_terakhir','$pekerjaan','$nama_pj_pasien','$hub_pj_pasien','$pekerjaan_pj','$no_pj') ";
mysqli_query($koneksi, $query);

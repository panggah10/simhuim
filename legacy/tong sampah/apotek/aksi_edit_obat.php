<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
extract($_POST);
$query = "update tbl_obat set nama_obat='$nama_obat', satuan='$satuan', deskripsi = '$deskripsi', harga = '$harga' where id_obat='$id_obat' ";
mysql_query($query);   
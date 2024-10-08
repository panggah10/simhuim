<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../konfig.php';
$id = $_GET['id_resep'];
$query = "delete from tbl_resep where id_resep='$id' ";
mysqli_query($koneksi, $query);
?>
<script type="text/javascript">
    location.href = '../dokter.php?view=tampil_resep';
</script>
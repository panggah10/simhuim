<?php
include('../konfig.php');
if ($_POST) {
    $q = $_POST['search'];
    $sql_res = mysqli_query($koneksi, "select id_pasien,nama_pasien, alamat from tbl_pasien where id_pasien like '%$q%' or nama_pasien like '%$q%' order by id_pasien LIMIT 5");
    while ($row = mysqli_fetch_array($sql_res)) {
        $id_pasien = $row['id_pasien'];
        $nama = $row['nama_pasien'];
        $alamat = $row['alamat'];
        $b_id_pasien = '<strong>' . $q . '</strong>';
        $b_nama = '<strong>' . $q . '</strong>';
        $final_id_pasien = str_ireplace($q, $b_id_pasien, $id_pasien);
        $final_nama = str_ireplace($q, $b_nama, $nama);
?>
        <div class="show" align="left">
            <span class="id"><?php echo $final_id_pasien; ?></span>&nbsp;<br />
            <span class="nama"><?php echo $final_nama ?></span>, <?php echo $alamat; ?><br />
        </div>
<?php
    }
}
?>
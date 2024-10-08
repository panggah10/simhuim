<?php
$connection = mysqli_connect("localhost", "root", "", "sirusak");
$perawatan = mysqli_real_escape_string($connection, $_GET['perawatan']);
$pelayanan = mysqli_real_escape_string($connection, $_GET['pelayanan']);
$tipe_kamar = mysqli_real_escape_string($connection, $_GET['tipe_kamar']);

mysqli_select_db($connection, "sirusak_tek");
$result = mysqli_query($connection, "SELECT * FROM tbl_tarif_ri WHERE perawatan = '$perawatan' and pelayanan = '$pelayanan' and tipe_kamar = '$tipe_kamar' ");
 
while($row = mysqli_fetch_array($result))
  {
    echo '<div>';
    echo '<h3 id="id_tarif">'.$row['id_tarif_ri'].'</h3>';
    echo '<h3 id="tarif">'.$row['tarif'].'</h3>';
    echo '</div>';
  }
 
mysqli_free_result($result);
mysqli_close($connection);
 
?>
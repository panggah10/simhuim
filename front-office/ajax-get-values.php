<?php
$connection = mysqli_connect("localhost", "root", "", "sirusak_tek");
 
$selectvalue = mysqli_real_escape_string($connection, $_GET['svalue']);
 
mysqli_select_db($connection, "sirusak_tek");
$result = mysqli_query($connection, "SELECT id_user, nama_dokter FROM tbl_dokter WHERE departemen = '$selectvalue'");
 
echo '<option value="">Pilih Dokter</option>';
while($row = mysqli_fetch_array($result))
  {
    echo '<option value="'.$row['id_user'].'">' . $row['nama_dokter'] . "</option>";
    //echo $row['drink_type'] ."<br/>";
  }
 
mysqli_free_result($result);
mysqli_close($connection);
 
?>
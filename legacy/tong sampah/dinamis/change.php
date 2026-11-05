<?php
include('config.php');

//collect the passed id
$id = $_GET['departemen'];

//run a prepared statement 
$stmt = $conn->query('SELECT id_user, nama_dokter FROM tbl_dokter WHERE departemen = '.$id.'');

//loop through all returned rows
while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
    echo "<option value='$row->id_user'>$row->nama_dokter</option>";
}
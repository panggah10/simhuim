<?php
include('../tcpdf/tcpdf.php');
include('../konfig.php');

$pdf = new tcpdf();

$pdf->AddPage();

$query = "SELECT r.id_resep, p.nama_pasien, r.nama_resep, r.rincian_resep, d.nama_dokter, r.tanggal from tbl_resep r left join tbl_pasien p on r.id_pasien = p.id_pasien left join tbl_dokter d on r.id_dokter = d.id_user where r.id_resep = " . $_GET['id_resep'];
$result = mysqli_query($koneksi, $query);
if (mysqli_num_rows($result)) {
    //echo"ada isinya";	
    while ($row = mysqli_fetch_array($result)) {

        $html = '<html>
    <head>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
    </head>
    <body>
        <div align="center">
            <h2>Rumah Sakit Tekom 49</h2>
            <h3>Rumahnya Mahasiswa <i>"Sakit"</i></h3>
            Jalan Kumbang No.14, Bogor<br>
            <hr>
            <h3>
                <label class="label label-info">&nbsp;&nbsp;&nbsp;Resep Dokter&nbsp;&nbsp;&nbsp;</label>
            </h3>
            <h4>
                <label class="label label-danger">' . $row["nama_dokter"] . '</label>
            </h4><br><br>
            
            <table border="0" width ="100%" >
            <tr><td height="30px" width="100px" align="left" valign="middle">Nama Pasien</td><td width="30px">:</td><td align="left" valign="top">' . $row["nama_pasien"] . '</td></tr>
                <tr><td height="30px" width="100px" align="left" valign="middle">Resep</td><td width="30px">:</td><td align="left" valign="top">' . $row["nama_resep"] . '</td></tr>
                <tr><td height="300px" width="100px" align="left" valign="top">Rincian</td><td width="30px">:</td><td valign="top" align="left">' . $row["rincian_resep"] . '</td></tr>
            </table>
            <div align="right">Bogor, ' . $row["tanggal"] . '</div>
        </div>
    </body>
</html>';
    }
} else {
    $html = "kosong";
}

$pdf->writeHTML($html);

$pdf->Output();

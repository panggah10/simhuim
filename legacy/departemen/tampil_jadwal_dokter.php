<table id="datatable" class="stripe">
    <thead>
        <th></th>
        <th>Nama Dokter</th>
        <th>Jadwal Praktik</th>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * from tbl_dokter where departemen = '" . $_SESSION['grup'] . "'";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result)) {
            //echo"ada isinya";	
            while ($row = mysqli_fetch_array($result)) {
        ?>
                <tr>
                    <td><img src="images/dokter/<?php echo $row['id_user']; ?>.png" </td>
                    <td>
                        <h2><label class="label label-info"><?php echo $row['nama_dokter']; ?></label></h2>
                    </td>
                    <td><?php echo $row['jadwal_praktik']; ?> </td>

                </tr>
        <?php
            }
        } else {
            echo "kosong";
        }
        ?>
    </tbody>
    <tfoot>
        <th></th>
        <th>Nama Dokter</th>
        <th>Jadwal Praktik</th>
    </tfoot>
</table>
<table id="datatable" class="stripe">
    <thead>
        <th>No RJ</th>
        <th>Nama Pasien</th>
        <th>Keluhan</th>
        <th>Dokter</th>
        <th>Status</th>
        <th>Aksi</th>
    </thead>
    <tbody>
        <?php
        $query = "SELECT rj.no_rj, p.nama_pasien, rj.keluhan, d.nama_dokter, rj.diagnosa FROM tbl_prj rj left join tbl_pasien p on rj.id_pasien=p.id_pasien left join tbl_dokter d on d.id_user = rj.id_dokter where rj.departemen = '" . $_SESSION['grup'] . "' order by rj.tanggal desc";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result)) {
            //echo"ada isinya";	
            while ($row = mysqli_fetch_array($result)) {
        ?>
                <tr>
                    <td class="no_rj"><?php echo $row['no_rj']; ?> </td>
                    <td class="nama_pasien"><?php echo $row['nama_pasien']; ?> </td>
                    <td class="keluhan"><?php echo $row['keluhan']; ?> </td>
                    <td class="nama_dokter"><?php echo $row['nama_dokter']; ?> </td>
                    <td><?php echo $row['diagnosa'] == null ? '<span class="label label-danger">BELUM</span>' : '<span class="label label-success">DIPERIKSA</span>'; ?> </td>
                    <td><?php echo '<button id="' . $row['no_rj'] . '" class="btn btn-success btn-sm edit_data" data-toggle="modal" data-target="#editModal">
    <i class="glyphicon glyphicon-edit"></i> Pilih Dokter
</button>';
                        ?></td>
                </tr>
        <?php
            }
        } else {
            echo "kosong";
        }
        ?>
    </tbody>
    <tfoot>
        <th>No RJ</th>
        <th>Nama Pasien</th>
        <th>Keluhan</th>
        <th>Dokter</th>
        <th>Status</th>
        <th>Aksi</th>
    </tfoot>
</table>

<!---------------------------- tambah ------------------------->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Ubah Dokter Pemeriksa Pasien</h4>
            </div>
            <div class="modal-body">
                <form name="ubah_pasien" id="ubah_pasien" method="POST" action="departemen/aksi_ubah_pasien.php">

                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </span>
                        <input type="text" id="no_rj" name="no_rj" value="" class="form-control input-lg" readonly>
                    </div>

                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="text" id="nama_pasien" name="nama" placeholder="Nama Pasien" class="form-control input-lg" readonly />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-question-sign"></i>
                        </span>
                        <textarea name="keluhan" placeholder="Keluhan" id="keluhan" class="form-control" rows="5" readonly></textarea>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="fa fa-user-md"></i>
                        </span>
                        <select name="nama_dokter" id="nama_dokter" class="form-control input-lg" required>
                            <option value=''>Pilih Dokter</option>
                            <?php
                            $query = "SELECT distinct id_user, nama_dokter from tbl_dokter where departemen = '" . $_SESSION['grup'] . "'";
                            $result = mysqli_query($koneksi, $query);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value="' . $row['id_user'] . '">' . $row['nama_dokter'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div align="center">
                        <button type="reset" class="btn btn-inverse btn-lg"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submit"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan </button>
                    </div>
                </form>

            </div>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->
<!------------------------- edit -------------------->

<script type="text/javascript">
    $(document).ready(function() {
        $("button.edit_data").click(function() {
            var myModal = $('#editModal');
            // now get the values from the table
            var no_rj = $(this).closest('tr').find('td.no_rj').html();
            var nama_pasien = $(this).closest('tr').find('td.nama_pasien').html();
            var keluhan = $(this).closest('tr').find('td.keluhan').html();
            var nama_dokter = $(this).closest('tr').find('td.nama_dokter').html();

            document.getElementById('no_rj').value = no_rj;
            document.getElementById('nama_pasien').value = nama_pasien;
            document.getElementById('keluhan').value = keluhan;
            document.getElementById('nama_dokter').value = nama_dokter;

        });
    });
</script>
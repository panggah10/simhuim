<div align="center"><h2>Kelola Obat-Obatan</h2>
    <br>
<button class="btn btn-success btn-large" data-toggle="modal" data-target="#tambahModal">
    <i class="glyphicon glyphicon-edit"></i> Tambah Obat
</button></div>
<table id="datatable" class="display stripe">
    <thead>
    <th>ID Obat</th>
    <th>Nama Obat</th>
    <th>Satuan</th>
    <th>Deskripsi</th>
    <th>Harga</th>
    <th>Aksi</th>
</thead>
<tbody>
    <?php
    $query = "SELECT * from tbl_obat ";
    $result = mysql_query($query);
    if (mysql_num_rows($result)) {
        //echo"ada isinya";	
        while ($row = mysql_fetch_array($result)) {
            ?>
            <tr>
                <td class="id_obat"><?php echo $row['id_obat']; ?> </td>
                <td class="nama_obat"><?php echo $row['nama_obat']; ?> </td>
                <td class="satuan"><?php echo $row['satuan']; ?> </td>
                <td class="deskripsi"><?php echo $row['deskripsi']; ?> </td>
                <td class="harga"><?php echo $row['harga']; ?> </td>
                <td><?php echo '<button id="' . $row['id_obat'] . '" class="btn btn-info btn-sm edit_data" data-toggle="modal" data-target="#editModal">
    <i class="glyphicon glyphicon-edit"></i> Edit</button> <a class="btn btn-danger btn-sm" href="?view=aksi_hapus_obat.php?id_obat=' . $row['id_obat'] . '"><i class="glyphicon glyphicon-trash"></i>  Hapus </a>';
            ?></td>
            </tr>
            <?php
        }
    } else {
        echo"kosong";
    }
    ?>
</tbody>
<tfoot>    
<th>ID Obat</th>
<th>Nama Obat</th>
<th>Satuan</th>
<th>Deskripsi</th>
<th>Harga</th>
<th>Aksi</th>
</tfoot>
</table>

<!---------------------------- tambah ------------------------->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Ubah Dokter Pemeriksa Pasien</h4>
            </div> 
            <div class="modal-body">
                <form name="tambah_obat" id="tambah_obat" method="POST">

                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="text" id="nama_obat" name="nama_obat" placeholder="Nama Obat" class="form-control input-lg"/>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-question-sign"></i>
                        </span>
                        <input type="text" name="satuan" id="satuan" value="" placeholder="Satuan" class="form-control input-lg" />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-question-sign"></i>
                        </span>
                        <input type="text" name="deskripsi" id="deskripsi" value="" placeholder="Deskripsi" class="form-control input-lg" />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-question-sign"></i>
                        </span>
                        <input type="text" name="harga" id="harga" value="" placeholder="Harga" class="form-control input-lg" />

                    </div> 
                    <br>
                </form>
                    <div align="center">
                        <button type="reset" class="btn btn-inverse btn-lg"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submit"><i class="glyphicon glyphicon-floppy-disk"></i>  Simpan </button>
                    </div>

            </div>

        </div> 
    </div><!-- /.modal-content --> 
</div><!-- /.modal -->

<!---------------------------- edit ------------------------->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Ubah Dokter Pemeriksa Pasien</h4>
            </div> 
            <div class="modal-body">
                <form name="edit_obat" id="edit_obat" method="POST">

                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </span>
                        <input type="text" id="id_obat_edit" name="id_obat" value="" class="form-control input-lg" readonly="">
                    </div>

                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="text" id="nama_obat_edit" name="nama_obat" placeholder="Nama Obat" class="form-control input-lg"/>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-question-sign"></i>
                        </span>
                        <input type="text" name="satuan" id="satuan_edit" value="" placeholder="Satuan" class="form-control input-lg" />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-question-sign"></i>
                        </span>
                        <input type="text" name="deskripsi" id="deskripsi_edit" value="" placeholder="Deskripsi" class="form-control input-lg" />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            Rp
                        </span>
                        <input type="text" name="harga" id="harga_edit" value="" placeholder="Harga" class="form-control input-lg" />
                        <span class="input-group-addon">
                            ,-
                        </span>
                    </div> 
                    <br>
                    
                </form>
                <div align="center">
                        <button type="reset" class="btn btn-inverse btn-lg"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submit_edit"><i class="glyphicon glyphicon-floppy-disk"></i>  Simpan </button>
                    </div>

            </div>

        </div> 
    </div><!-- /.modal-content --> 
</div><!-- /.modal -->
<!------------------------- edit -------------------->

<script type="text/javascript">
    $(document).ready(function () {
        $("button.edit_data").click(function () {
            var myModal = $('#editModal');
            // now get the values from the table
            var id_obat = $(this).closest('tr').find('td.id_obat').html();
            var nama_obat = $(this).closest('tr').find('td.nama_obat').html();
            var satuan = $(this).closest('tr').find('td.satuan').html();
            var deskripsi = $(this).closest('tr').find('td.deskripsi').html();
            var harga = $(this).closest('tr').find('td.harga').html();

            document.getElementById('id_obat_edit').value = id_obat;
            document.getElementById('nama_obat_edit').value = nama_obat;
            document.getElementById('satuan_edit').value = satuan;
            document.getElementById('deskripsi_edit').value = deskripsi;
            document.getElementById('harga_edit').value = harga;
        });
        
        $("button#submit").click(function () {
            $.ajax({
                type: "POST",
                url: "apotek/aksi_tambah_obat.php",
                data: $('form#tambah_obat').serialize(),
                success: function (msg) {
                    $("#tambahModal").modal('hide')
                    location.href = 'apoteker.php?view=tampil_obat';
                    ;
                },
                error: function () {
                    alert("Gagal menambah obat baru");
                }
            });
        });
        
        $("button#submit_edit").click(function () {
            $.ajax({
                type: "POST",
                url: "apotek/aksi_edit_obat.php",
                data: $('form#edit_obat').serialize(),
                success: function (msg) {
                    $("#editModal").modal('hide');
                    location.href = 'apoteker.php?view=tampil_obat';
                },
                error: function () {
                    alert("Gagal engedit obat");
                }
            });
        });
    });

</script>


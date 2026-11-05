<div align="center">
    <h1><label class="label label-info">Kelola Resep</label></h1>
    <br>
    <button class="btn btn-primary btn-large" data-toggle="modal" data-target="#tambahModal">
        <i class="glyphicon glyphicon-plus-sign"></i> Tambah Resep
    </button>
</div>
<br>
<table id="datatable" class="display stripe">
    <thead>
        <th width="10%">ID Resep</th>
        <th>Nama Pasien</th>
        <th>Nama Resep</th>
        <th width="30%">Rincian Resep</th>
        <th>Aksi</th>
    </thead>
    <tbody>
        <?php
        $query = "SELECT r.id_resep, p.nama_pasien, r.nama_resep, r.rincian_resep, d.nama_dokter from tbl_resep r left join tbl_pasien p on r.id_pasien = p.id_pasien left join tbl_dokter d on r.id_dokter = d.id_user where d.nama_dokter = '" . $_SESSION['grup'] . "' group by r.id_resep";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result)) {
            //echo"ada isinya";	
            while ($row = mysqli_fetch_array($result)) {
        ?>
                <tr>
                    <td class="id_resep"><?php echo $row['id_resep']; ?> </td>
                    <td class="nama_pasien"><?php echo $row['nama_pasien']; ?> </td>
                    <td class="nama_resep"><?php echo $row['nama_resep']; ?> </td>
                    <td class="rincian_resep"><?php echo $row['rincian_resep']; ?> </td>
                    <td><?php echo '<button id="' . $row['id_resep'] . '" class="btn btn-info btn-sm edit_data" data-toggle="modal" data-target="#editModal">
    <i class="glyphicon glyphicon-edit"></i> Ubah</button> <a class="btn btn-danger btn-sm" href="dokter/aksi_hapus_resep.php?id_resep=' . $row['id_resep'] . '"><i class="glyphicon glyphicon-trash"></i>  Hapus </a>';
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
        <th>ID Resep</th>
        <th>Nama Pasien</th>
        <th>Nama Resep</th>
        <th>Rincian Resep</th>
        <th>Aksi</th>
    </tfoot>
</table>

<!---------------------------- tambah ------------------------->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Tambah Resep</h4>
            </div>
            <div class="modal-body">
                <form name="tambah_pasien" id="tambah_pasien" method="POST" action="dokter/aksi_tambah_resep.php">
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="hidden" value="" name="id_pasien" id="id_pasien_hidden" />
                        <input type="text" value="" name="search" class="search form-control input-lg" id="searchid" placeholder="Cari pasien" required autofocus autocomplete="off" />
                        <div id="result"></div>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-bookmark"></i>
                        </span>
                        <input type="text" id="nama_resep" name="nama_resep" placeholder="Nama Resep" class="form-control input-lg" />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="fa fa-medkit"></i>
                        </span>
                        <textarea name="rincian_resep" placeholder="Obat" class="form-control" rows="5"></textarea>
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

<!---------------------------- edit ------------------------->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Ubah Resep</h4>
            </div>
            <div class="modal-body">
                <form name="ubah_resep" id="ubah_resep" method="POST" action="dokter/aksi_ubah_resep.php">
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="hidden" value="" name="id_resep" id="id_resep_ubah" />
                        <input type="text" value="" name="search" class="search form-control input-lg" id="nama_pasien_ubah" placeholder="Cari pasien" required readonly="" autocomplete="off" />
                        <div id="result"></div>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-bookmark"></i>
                        </span>
                        <input type="text" id="nama_resep_ubah" name="nama_resep" placeholder="Nama Resep" class="form-control input-lg" />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="fa fa-medkit"></i>
                        </span>
                        <textarea name="rincian_resep" id="rincian_resep_ubah" placeholder="Obat" class="form-control" rows="5"></textarea>
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

<!------------------------- cari pasien -------------------->
<script type="text/javascript">
    $(function() {
        $(".search").keyup(function() {
            var searchid = $(this).val();
            var dataString = 'search=' + searchid;
            if (searchid != '') {
                $.ajax({
                    type: "POST",
                    url: "front-office/cari-pasien.php",
                    data: dataString,
                    cache: false,
                    success: function(html) {
                        $("#result").html(html).show();
                    }
                });
            }
            return false;
        });

        jQuery("#result").live("click", function(e) {
            var $clicked = $(e.target);
            var $id = $clicked.find('.id').html();
            var $nama = $clicked.find('.nama').html();
            var dec_id = $("<div/>").html($id).text();
            var dec_nama = $("<div/>").html($nama).text();
            $('#id_pasien_hidden').val(dec_id);
            $('#searchid').val(dec_nama);
        });
        jQuery(document).live("click", function(e) {
            var $clicked = $(e.target);
            if (!$clicked.hasClass("search")) {
                jQuery("#result").fadeOut();
            }
        });
        $('#searchid').click(function() {
            jQuery("#result").fadeIn();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("button.edit_data").click(function() {
            var myModal = $('#editModal');
            // now get the values from the table
            var id_resep = $(this).closest('tr').find('td.id_resep').html();
            var nama_pasien = $(this).closest('tr').find('td.nama_pasien').html();
            var nama_resep = $(this).closest('tr').find('td.nama_resep').html();
            var rincian_resep = $(this).closest('tr').find('td.rincian_resep').html();


            document.getElementById('id_resep_ubah').value = id_resep;
            document.getElementById('nama_pasien_ubah').value = nama_pasien;
            document.getElementById('nama_resep_ubah').value = nama_resep;
            document.getElementById('rincian_resep_ubah').value = rincian_resep;



        });
    });
</script>
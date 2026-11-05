<div align="center">
    <h1><label class="label label-info">Data Pasien Rawat Jalan</label></h1>
    <br>
    <button class="btn btn-primary btn-large" data-toggle="modal" data-target="#tambahModal">
        <i class="glyphicon glyphicon-plus-sign"></i> Tambah Pasien Rawat Jalan
    </button>
</div>
<br>
<table id="datatable" class="display stripe">
    <thead>
        <th>No</th>
        <th>Pasien</th>
        <th>Departemen</th>
        <th>Tanggal</th>
        <th>Pembayaran</th>
        <th>Aksi</th>
    </thead>
    <?php
    $queryselect = "SELECT * FROM tbl_prj, tbl_pasien where
            tbl_prj.id_pasien = tbl_pasien.id_pasien order by 
            tbl_prj.no_rj desc";
    $resultselect = mysqli_query($koneksi, $queryselect);
    if (mysqli_num_rows($resultselect)) {
        //echo"ada isinya";	
        $no = 1;
        while ($row = mysqli_fetch_array($resultselect)) {
    ?>
            <tr>
                <td><?php echo $no; ?> </td>
                <td><?php echo $row['nama_pasien']; ?> </td>
                <td><?php echo $row['departemen']; ?> </td>
                <td><?php echo $row['tanggal']; ?> </td>
                <td><?php
                    if ($row['bayar'] >= $row['biaya']) {
                        echo "<span class='label label-success'>ClEAR</span>";
                    } else {
                        echo "<span class='label label-danger'>BELUM</span>";
                    };
                    ?> </td>
                <td> <?php echo "<a class='btn btn-info btn-sm' href='front-office.php?view=tampil_ubah_prj&no_rj=" . $row['no_rj'] . "'><i class='glyphicon glyphicon-edit'></i></a> | 
                    <a class='btn btn-danger btn-sm' href='front-office.php?view=aksi_hapus_prj&no_rj=" . $row['no_rj'] . "' onclick='return confirm(&quot;Apakah anda yakin akan menghapus data pasien rawat jalan tersebut?&quot;)'><i class='glyphicon glyphicon-trash'></i></a>";
                        ?>

                </td>

            </tr>
    <?php
            $no++;
        }
    } else {
        echo "kosong";
    }
    ?>
    <tfoot>
        <th>No</th>
        <th>Pasien</th>
        <th>Departemen</th>
        <th>Tanggal</th>
        <th>Pembayaran</th>
        <th>Aksi</th>
    </tfoot>
</table>

<!---------------------------- tambah ------------------------->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Tambah Pasien Rawat Jalan</h4>
            </div>
            <div class="modal-body">
                <form name="tambah_prj" id="tambah_prj" method="POST">


                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="hidden" value="" name="id_pasien" id="id_pasien_hidden" />
                        <input type="text" value="" name="search" class="search form-control input-lg" id="searchid" autocomplete="off" placeholder="Masukan ID / Nama Pasien" required autofocus />

                        <div id="result"></div>

                    </div>

                    <div class="input-group input-lg ">

                        <span class="input-group-addon">
                            <i class="fa fa-hospital-o fa-lg"></i>
                        </span>
                        <select name='departemen' id='departemen' class="form-control input-lg">
                            <option value=''>Pilih Departemen</option>
                            <?php
                            $query = "SELECT distinct departemen from tbl_dokter";
                            $result = mysqli_query($koneksi, $query);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option>' . $row['departemen'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-question-sign"></i>
                        </span>
                        <textarea name="keluhan" placeholder="Keluhan" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="biaya" name="biaya" placeholder="Biaya" class="form-control input-lg" />
                        <span class="input-group-addon">,-</span>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" name="bayar" placeholder="Bayar" class="form-control input-lg" value="" required />
                        <span class="input-group-addon">,-</span>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-inverse"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                <button type="submit" class="btn btn-primary" id="submit"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan </button>

            </div>

        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->

<!------------------------- submit form dari modal -------------------->
<script type="text/javascript">
    $(document).ready(function() {
        $("button#submit").click(function() {
            $.ajax({
                type: "POST",
                url: "front-office/aksi_tambah_prj.php",
                data: $('form#tambah_prj').serialize(),
                success: function(msg) {
                    $("#tambahModal").modal('hide')
                    location.href = 'front-office.php?view=tampil_prj';;
                },
                error: function() {
                    alert("Gagal menambah pasien rawat jalan baru");
                }
            });
        });
    });
</script>

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

<!------------------------- lihat tarif -------------------->

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#departemen").change(function(event) {
            var selectvalue = $(this).val();
            $.ajax({
                url: 'front-office/aksi_lihat_tarif_rj.php?departemen=' + selectvalue,
                success: function(tarif) {
                    document.getElementById('biaya').value = tarif;
                }
            });
        });
    });
</script>

<!--<script type="text/javascript">
    $(document).ready(function ($) {
        var list_target_id = 'list-target'; //first select list ID
        var list_select_id = 'list-select'; //second select list ID
        var initial_target_html = '<option value="">Pilih Dokter</option>'; //Initial prompt for target select

        $('#' + list_target_id).html(initial_target_html); //Give the target select the prompt option

        $('#' + list_select_id).change(function (e) {
            //Grab the chosen value on first select list change
            var selectvalue = $(this).val();


            //Display 'loading' status in the target select list
            $('#' + list_target_id).html('<option value="">Loading...</option>');

            if (selectvalue == "") {
                //Display initial prompt in target select if blank value selected
                $('#' + list_target_id).html(initial_target_html);
            } else {
                //Make AJAX request, using the selected value as the GET
                $.ajax({url: 'ajax-get-values.php?svalue=' + selectvalue,
                    success: function (output) {
                        //alert(output);
                        $('#' + list_target_id).html(output);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }});

                $.ajax({url: 'get-tarif-rj.php?departemen=' + selectvalue,
                    success: function (output) {
                        //alert(output);
                        document.getElementById('biaya').value = output;
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + " " + thrownError);
                    }});
            }
        });
    });
</script>-->
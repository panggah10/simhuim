<div align="center">
    <h1><label class="label label-warning">Data Pasien Rawat Inap</label></h1>
    <br>
    <button class="btn btn-primary btn-large" data-toggle="modal" data-target="#tambahModal">
        <i class="glyphicon glyphicon-plus-sign"></i> Tambah Pasien Rawat Inap
    </button>
</div>
<br>
<table id="datatable" class="display stripe">
    <thead>
        <th>No</th>
        <th>Pasien</th>
        <th>Kamar</th>
        <th>Check in</th>
        <th>Check out</th>
        <th>Pembayaran</th>
        <th>Aksi</th>
    </thead>
    <?php
    $queryselect = "SELECT * FROM tbl_pri, tbl_pasien where
            tbl_pri.id_pasien = tbl_pasien.id_pasien order by 
            tbl_pri.no_ri desc";
    $resultselect = mysqli_query($koneksi, $queryselect);
    if (mysqli_num_rows($resultselect)) {
        //echo "ada isinya";	
        $no = 1;
        while ($row = mysqli_fetch_array($resultselect)) {
    ?>
            <tr>
                <td><?php echo $no; ?> </td>
                <td><?php echo $row['nama_pasien']; ?> </td>
                <td><?php echo $row['id_ruang']; ?> </td>
                <td><?php echo $row['tanggal_checkin']; ?> </td>
                <td><?php echo $row['tanggal_checkout']; ?> </td>
                <td><?php
                    if ($row['bayar'] >= $row['biaya']) {
                        echo "<span class='label label-success'>SELESAI</span>";
                    } else {
                        echo "<span class='label label-danger'>BELUM</span>";
                    };
                    ?> </td>
                <td><?php echo "<a class='btn btn-info btn-sm' href='front-office.php?view=tampil_ubah_pri&no_ri=" . $row['no_ri'] . "'><i class='glyphicon glyphicon-edit'></i></a> | 
                    <a class='btn btn-danger btn-sm' href='front-office.php?view=aksi_hapus_pri&no_ri=" . $row['no_ri'] . "' onclick='return confirm(&quot;Apakah anda yakin akan menghapus data pasien rawat inap tersebut?&quot;)'><i class='glyphicon glyphicon-trash'></i></a>";
                    ?></td>

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
        <th>Kamar</th>
        <th>Check in</th>
        <th>Check out</th>
        <th>Pembayaran</th>
        <th>Aksi</th>
    </tfoot>
</table>
<!---------------------------- tambah ------------------------->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Tambah Pasien Rawat Inap</h4>
            </div>
            <div class="modal-body">
                <form name="tambah_pri" id="tambah_pri" method="POST">
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="hidden" value="" name="id_pasien" id="id_pasien_hidden" />
                        <input type="text" value="" name="search" class="search form-control input-lg" id="searchid" placeholder="Masukan ID / Nama Pasien" required autofocus autocomplete="off" />
                        <div id="result"></div>
                    </div>

                    <div class="input-group input-lg " align="center">
                        Jenis Perawatan<br>
                        <div id="perawatan" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info">
                                <input type="radio" id="perawatan1" name="perawatan" value="Rawat Inap per hari"> Rawat Inap per hari
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="perawatan2" name="perawatan" value="Ruang ICU"> Ruang ICU
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="perawatan3" name="perawatan" value="Perinatologi"> Perinatologi
                            </label>
                        </div>
                        <br>Jenis Pelayanan<br>
                        <div class="btn-group" data-toggle="buttons">

                            <label class="btn btn-info">
                                <input type="radio" id="pelayanan1" name="pelayanan" value="Dokter Spesials dan Umum"> Dokter Spesials dan Umum
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="pelayanan2" name="pelayanan" value="Dokter Umum"> Dokter Umum
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="pelayanan3" name="pelayanan" value="Instalasi  Anestesi"> Instalasi Anestesi
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="pelayanan4" name="pelayanan" value="Gizi Rawat Inap"> Gizi Rawat Inap
                            </label>
                        </div>
                        <br>Fasilitas<br>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info">
                                <input type="radio" id="tipe_kamar1" name="tipe_kamar" value="Kelas VIP"> Kelas VIP
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="tipe_kamar2" name="tipe_kamar" value="Kelas I"> Kelas I
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="tipe_kamar3" name="tipe_kamar" value="Kelas II"> Kelas II
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="tipe_kamar4" name="tipe_kamar" value="Kelas III"> Kelas III
                            </label>
                        </div>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="date" id="tanggal_checkin" name="tanggal_checkin" placeholder="Tanggal Check In" class="form-control input-lg" required style="width: 50%;" />
                        <input type="date" id="tanggal_checkout" name="tanggal_checkout" placeholder="Tanggal Check Out" class="form-control input-lg" required style="width: 50%;" />
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>

                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </span>
                        <textarea name="diagnosa" placeholder="Diagnosa" class="form-control" rows="5" required></textarea>
                    </div>
                    <div align="center">
                        <button type="button" id="btn_cek_tarif" class="btn btn-success"><i class="glyphicon glyphicon-eye-open"></i> &nbsp; Cari Ruangan</button>
                    </div>
                    <div class="input-group input-lg" align="center">

                        <span class="input-group-addon">Ruang</span>
                        <input type="text" value="" name="id_ruang" id="id_ruang" class="form-control input-lg" readonly="" required="" style="width: 50%;text-align:center;font-size: 30;" />
                        <input type="text" value="" name="hari_menginap" id="hari_menginap" class="form-control input-lg" readonly="" required="" style="width: 50%;text-align:center;font-size: 30;" />
                        <span class="input-group-addon">hari</span>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="biaya" name="biaya" placeholder="Biaya" class="form-control input-lg" value="" readonly required style="font-size: 25px;" />
                        <span class="input-group-addon">,-</span>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" name="bayar" placeholder="Bayar" class="form-control input-lg" value="" required style="font-size: 25px;" />
                        <span class="input-group-addon">,-</span>
                    </div>
                    <div align="center">
                        <button type="reset" class="btn btn-inverse btn-lg"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submit"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan </button>
                    </div>
                </form>

            </div>
            <!--            <div class="modal-footer"> 
                            <button type="reset" class="btn btn-inverse"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                            <button type="submit" class="btn btn-primary" id="submit"><i class="glyphicon glyphicon-floppy-disk"></i>  Simpan </button>
                        </div>-->
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal -->
<script type="text/javascript">
    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "tanggal_checkin",
            dateFormat: "%Y-%m-%d",
            yearsRange: [2000, 2025]
        });
        new JsDatePick({
            useMode: 2,
            target: "tanggal_checkout",
            dateFormat: "%Y-%m-%d",
            yearsRange: [2000, 2025]
        });
    };
</script>
<!------------------------- submit form dari modal -------------------->
<script type="text/javascript">
    $(document).ready(function() {
        $("button#submit").click(function() {
            $.ajax({
                type: "POST",
                url: "front-office/aksi_tambah_pri.php",
                data: $('form#tambah_pri').serialize(),
                success: function(msg) {
                    if (msg.success == true) {
                        $("#tambahModal").modal('hide');
                        location.href = 'front-office.php?view=tampil_pri';
                    } else {
                        alert("Gagal menambah pasien rawat inap baru");
                    }
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
        $("#btn_cek_tarif").click(function() {
            if (document.getElementById("perawatan1").checked) {
                var perawatan = document.getElementById("perawatan1").value;
            } else if (document.getElementById("perawatan2").checked) {
                var perawatan = document.getElementById("perawatan2").value;
            } else if (document.getElementById("perawatan3").checked) {
                var perawatan = document.getElementById("perawatan3").value;
            }

            if (document.getElementById("pelayanan1").checked) {
                var pelayanan = document.getElementById("pelayanan1").value;
            } else if (document.getElementById("pelayanan2").checked) {
                var pelayanan = document.getElementById("pelayanan2").value;
            } else if (document.getElementById("pelayanan3").checked) {
                var pelayanan = document.getElementById("pelayanan3").value;
            } else if (document.getElementById("pelayanan4").checked) {
                var pelayanan = document.getElementById("pelayanan4").value;
            }

            if (document.getElementById("tipe_kamar1").checked) {
                var tipe_kamar = document.getElementById("tipe_kamar1").value;
            } else if (document.getElementById("tipe_kamar2").checked) {
                var tipe_kamar = document.getElementById("tipe_kamar2").value;
            } else if (document.getElementById("tipe_kamar3").checked) {
                var tipe_kamar = document.getElementById("tipe_kamar3").value;
            } else if (document.getElementById("tipe_kamar4").checked) {
                var tipe_kamar = document.getElementById("tipe_kamar4").value;
            }

            $.ajax({
                url: 'front-office/aksi_lihat_tarif_ri.php?pelayanan=' + pelayanan +
                    '&perawatan=' + perawatan + '&tipe_kamar=' + tipe_kamar,
                success: function(respon) {
                    var id = $(respon).find('#id_tarif').text();
                    var tarif = $(respon).find('#tarif').text();



                    function parseDate(str) {
                        var mdy = str.split('-')
                        return new Date(mdy[0], mdy[1] - 1, mdy[2]);
                    }

                    function daydiff(first, second) {
                        return (second - first) / (1000 * 60 * 60 * 24);
                    }

                    var hari_menginap = daydiff(parseDate($('#tanggal_checkin').val()), parseDate($('#tanggal_checkout').val()));
                    document.getElementById("id_ruang").value = id;
                    document.getElementById("hari_menginap").value = hari_menginap;

                    var biaya = tarif * hari_menginap;
                    document.getElementById("biaya").value = biaya;

                }
            });
        });
    });
</script>
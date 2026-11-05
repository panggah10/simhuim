<?php
if (isset($_GET)) {
    include 'konfig.php';
    $id_ubah = $_GET['no_ri'];
    $query = "SELECT * FROM tbl_pri, tbl_pasien, tbl_tarif_ri where "
        . "tbl_pri.id_pasien = tbl_pasien.id_pasien and tbl_tarif_ri.id_tarif_ri = tbl_pri.id_ruang and "
        . "tbl_pri.no_ri = '$id_ubah'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
?>

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Ubah Data Rawat Inap</h4>
            </div>
            <div class="modal-body">
                <form name="ubah_pri" id="ubah_pri" method="POST" action="front-office/aksi_ubah_pri.php ">
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="hidden" value="<?php echo $id_ubah; ?>" name="no_ri" />
                        <input type="hidden" value="<?php echo $row['id_pasien']; ?>" name="id_pasien" id="id_pasien_hidden" />
                        <input type="text" value="<?php echo $row['nama_pasien']; ?>" name="search" class="search form-control input-lg" id="searchid" placeholder="Masukan ID / Nama Pasien" required autofocus autocomplete="off" />
                        <div id="result"></div>
                    </div>

                    <div align="center">
                        Jenis Perawatan<br>
                        <div id="perawatan" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info <?php echo $row['perawatan'] == 'Rawat Inap per hari' ? 'active' : ''; ?>">
                                <input type="radio" id="perawatan1" name="perawatan" value="Rawat Inap per hari" <?php echo $row['perawatan'] == 'Rawat Inap per hari' ? 'checked' : ''; ?>> Rawat Inap per hari
                            </label>
                            <label class="btn btn-info <?php echo $row['perawatan'] == 'Ruang ICU' ? 'active' : ''; ?>">
                                <input type="radio" id="perawatan2" name="perawatan" value="Ruang ICU" <?php echo $row['perawatan'] == 'Ruang ICU' ? 'checked' : ''; ?>> Ruang ICU
                            </label>
                            <label class="btn btn-info <?php echo $row['perawatan'] == 'Perinatologi' ? 'active' : ''; ?>">
                                <input type="radio" id="perawatan3" name="perawatan" value="Perinatologi" <?php echo $row['perawatan'] == 'Perinatologi' ? 'checked' : ''; ?>> Perinatologi
                            </label>
                        </div>
                        <br>Jenis Pelayanan<br>
                        <div class="btn-group" data-toggle="buttons">

                            <label class="btn btn-info <?php echo $row['pelayanan'] == 'Dokter Spesials dan Umum' ? 'active' : ''; ?>">
                                <input type="radio" id="pelayanan1" name="pelayanan" value="Dokter Spesials dan Umum" <?php echo $row['pelayanan'] == 'Perinatologi' ? 'checked' : ''; ?>> Dokter Spesials dan Umum
                            </label>
                            <label class="btn btn-info <?php echo $row['pelayanan'] == 'Dokter Umum' ? 'active' : ''; ?>">
                                <input type="radio" id="pelayanan2" name="pelayanan" value="Dokter Umum" <?php echo $row['pelayanan'] == 'Dokter Umum' ? 'checked' : ''; ?>> Dokter Umum
                            </label>
                            <label class="btn btn-info <?php echo $row['pelayanan'] == 'Instalasi  Anestesi' ? 'active' : ''; ?>">
                                <input type="radio" id="pelayanan3" name="pelayanan" value="Instalasi  Anestesi" <?php echo $row['pelayanan'] == 'Instalasi  Anestesi' ? 'checked' : ''; ?>> Instalasi Anestesi
                            </label>
                            <label class="btn btn-info <?php echo $row['pelayanan'] == 'Gizi Rawat Inap' ? 'active' : ''; ?>">
                                <input type="radio" id="pelayanan4" name="pelayanan" value="Gizi Rawat Inap" <?php echo $row['pelayanan'] == 'Gizi Rawat Inap' ? 'checked' : ''; ?>> Gizi Rawat Inap
                            </label>
                        </div>
                        <br>Fasilitas<br>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-info <?php echo $row['tipe_kamar'] == 'Kelas VIP' ? 'active' : ''; ?>">
                                <input type="radio" id="tipe_kamar1" name="tipe_kamar" value="Kelas VIP" <?php echo $row['tipe_kamar'] == 'Kelas VIP' ? 'checked' : ''; ?>> Kelas VIP
                            </label>
                            <label class="btn btn-info <?php echo $row['tipe_kamar'] == 'Kelas I' ? 'active' : ''; ?>">
                                <input type="radio" id="tipe_kamar2" name="tipe_kamar" value="Kelas I" <?php echo $row['tipe_kamar'] == 'Kelas I' ? 'checked' : ''; ?>> Kelas I
                            </label>
                            <label class="btn btn-info <?php echo $row['tipe_kamar'] == 'Kelas II' ? 'active' : ''; ?>">
                                <input type="radio" id="tipe_kamar3" name="tipe_kamar" value="Kelas II" <?php echo $row['tipe_kamar'] == 'Kelas II' ? 'checked' : ''; ?>> Kelas II
                            </label>
                            <label class="btn btn-info <?php echo $row['tipe_kamar'] == 'Kelas III' ? 'active' : ''; ?>">
                                <input type="radio" id="tipe_kamar4" name="tipe_kamar" value="Kelas III" <?php echo $row['tipe_kamar'] == 'Kelas III' ? 'checked' : ''; ?>> Kelas III
                            </label>
                        </div>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                        <input type="date" id="tanggal_checkin" name="tanggal_checkin" placeholder="Tanggal Check In" value="<?php echo $row['tanggal_checkin'] ?>" class="form-control input-lg" required style="width: 50%;" />
                        <input type="date" id="tanggal_checkout" name="tanggal_checkout" placeholder="Tanggal Check Out" value="<?php echo $row['tanggal_checkout'] ?>" class="form-control input-lg" required style="width: 50%;" />
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-calendar"></i>
                        </span>
                    </div>

                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-check"></i>
                        </span>
                        <input type="text" name="diagnosa" placeholder="Diagnosa" value="<?php echo $row['diagnosa'] ?>" class="form-control input-lg" required />
                    </div>
                    <div align="center">
                        <button type="button" id="btn_cek_tarif" class="btn btn-success"><i class="glyphicon glyphicon-eye-open"></i> &nbsp; Cari Ruangan</button>
                    </div>
                    <div class="input-group input-lg" align="center">

                        <span class="input-group-addon">Ruang</span>
                        <input type="text" value="<?php echo $row['id_ruang'] ?>" name="id_ruang" id="id_ruang" class="form-control input-lg" readonly="" required="" style="width: 50%;text-align:center;font-size: 30;" />
                        <input type="text" value="<?php echo $row['hari_menginap'] ?>" name="hari_menginap" id="hari_menginap" class="form-control input-lg" readonly="" required="" style="width: 50%;text-align:center;font-size: 30;" />
                        <span class="input-group-addon">hari</span>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" id="biaya" name="biaya" placeholder="Biaya" class="form-control input-lg" value="<?php echo $row['biaya'] ?>" readonly required style="font-size: 25px;" />
                        <span class="input-group-addon">,-</span>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">Rp</span>
                        <input type="text" name="bayar" placeholder="Bayar" class="form-control input-lg" value="<?php echo $row['bayar'] ?>" required style="font-size: 25px;" />
                        <span class="input-group-addon">,-</span>
                    </div>
                    <div align="center">
                        <button type="reset" class="btn btn-inverse btn-lg"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submit"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan </button>
                    </div>
                </form>

            </div>


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

            <!------------------------- lihat kalender -------------------->

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
<?php
        }
    }
}

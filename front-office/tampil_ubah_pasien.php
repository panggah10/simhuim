<?php
if (isset($_GET)) {
    include './konfig.php';
    $id_ubah_pasien = $_GET['id_pasien'];
    $query = "SELECT * FROM tbl_pasien where id_pasien = '$id_ubah_pasien'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
?>
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> <i class="glyphicon glyphicon-edit"></i> Edit Biodata Pasien</h4>
            </div>
            <div class="modal-body">
                <form name="edit_pasien" id="edit_pasien" method="POST" action="front-office/aksi_ubah_pasien.php">
                    <input type="hidden" name="id_pasien" value="<?php echo $id_ubah_pasien; ?>" />
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="text" name="nama" placeholder="Nama Pasien" class="form-control input-lg" value="<?php echo $row['nama_pasien'] ?>" required autofocus />
                    </div>
                    <div class="input-group input-lg ">

                        <span class="input-group-addon">
                            <h3>
                                <input type="radio" name="jenis_kelamin" value="L" required <?php
                                                                                            if ($row['jenis_kelamin'] == 'L') {
                                                                                                echo 'checked';
                                                                                            }
                                                                                            ?>><span class="label label-danger">Laki-Laki</span></input>
                                <input type="radio" name="jenis_kelamin" value="P" required <?php
                                                                                            if ($row['jenis_kelamin'] == 'P') {
                                                                                                echo 'checked';
                                                                                            }
                                                                                            ?>><span class="label label-info">Perempuan</span></input>
                            </h3>
                        </span>

                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-home"></i>
                        </span>
                        <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" placeholder="Alamat" class="form-control input-lg" required />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-phone"></i>
                        </span>
                        <input type="text" name="no_telepon" value="<?php echo $row['no_telepon']; ?>" placeholder="Nomor Telepon" class="form-control input-lg" required />
                    </div>
                    <div align="center">
                        <button type="reset" class="btn btn-inverse btn-lg"><i class="glyphicon glyphicon-refresh"></i> Reset </button>
                        <button type="submit" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan </button>
                    </div>
                </form>
            </div>


            <!-- SweetAlert & jQuery Script -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
            <script type="text/javascript">
                $(document).ready(function() {
                    $("button#submit").click(function(event) {
                        event.preventDefault(); // Mencegah submit default
                        $.ajax({
                            type: "POST",
                            url: "front-office/aksi_ubah_pasien.php", // URL untuk proses backend
                            data: $('form#tambah_pasien').serialize(), // Mengambil data dari form
                            success: function(msg) {
                                // SweetAlert jika berhasil
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Data pasien berhasil diubah!',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Menutup modal dan redirect ke daftar pasien
                                        $("#tambahModal").modal('hide');
                                        window.location.href = 'front-office.php?view=tampil_pasien';
                                    }
                                });
                            },
                            error: function() {
                                // SweetAlert jika gagal
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat edit pasien baru.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    });
                });
            </script>


<?php
        }
    }
}
?>
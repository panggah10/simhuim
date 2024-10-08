<!-- Tampilan Data Pasien -->
<div align="center">
    <h1 style="color: teal; font-weight:500">Data Pasien Terdaftar</h1>
    <br>
    <button class="btn btn-success btn-large" data-toggle="modal" data-target="#tambahModal">
        <i class="glyphicon glyphicon-plus-sign"></i> Tambah Data Pasien
    </button>
</div>
<br>
<table id="datatable" class="display stripe">
    <thead>
        <th>No</th>
        <th>ID Pasien</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Telepon</th>
        <th>Aksi</th>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM tbl_pasien ORDER BY id_pasien DESC";
        $result = mysqli_query($koneksi, $query);
        if (mysqli_num_rows($result)) {
            $no = 1;
            while ($row = mysqli_fetch_array($result)) {
        ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $row['id_pasien']; ?></td>
                    <td><?php echo $row['nama_pasien']; ?></td>
                    <td><?php echo $row['jenis_kelamin']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td><?php echo $row['no_telepon']; ?></td>
                    <td><?php echo "<a class='btn btn-info btn-sm' href='front-office.php?view=tampil_ubah_pasien&id_pasien=" . $row['id_pasien'] . "'><i class='glyphicon glyphicon-edit'></i></a> | 
                            <a class='btn btn-danger btn-sm' href='#' onclick='confirmDelete(" . $row['id_pasien'] . ")'><i class='glyphicon glyphicon-trash'></i></a>";
                        ?></td>
                </tr>
        <?php
                $no++;
            }
        } else {
            echo "<tr><td colspan='7'>Data tidak ditemukan</td></tr>";
        }
        ?>
    </tbody>
    <tfoot>
        <th>No</th>
        <th>ID Pasien</th>
        <th>Nama Pasien</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Telepon</th>
        <th>Aksi</th>
    </tfoot>
</table>

<!-- Modal Tambah Data Pasien -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-edit"></i> Biodata Pasien Baru</h4>
            </div>
            <div class="modal-body">
                <form name="tambah_pasien" id="tambah_pasien" method="POST">
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="nama" placeholder="Nama Pasien" class="form-control input-lg" required autofocus />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input type="text" name="tmp_lahir" placeholder="Tempat Lahir" class="form-control input-lg" required autofocus />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input type="date" name="tgl_lahir" placeholder="Tanggal Lahir" class="form-control input-lg" required autofocus />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-danger">
                                    <input type="radio" id="laki_laki" name="jenis_kelamin" value="L" required>
                                    <h4>Laki-Laki</h4>
                                </label>
                                <label class="btn btn-info">
                                    <input type="radio" id="perempuan" name="jenis_kelamin" value="P" required>
                                    <h4>Perempuan</h4>
                                </label>
                            </div>
                        </span>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="alamat" placeholder="Alamat" class="form-control input-lg" required></textarea>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                        <input type="text" name="no_telepon" placeholder="Nomor Telepon" class="form-control input-lg" required />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-book"></i> <!-- Icon for religion -->
                        </span>
                        <div>
                            <label><input type="radio" name="agama" value="Islam" required> Islam</label>
                            <label><input type="radio" name="agama" value="Kristen" required> Kristen</label>
                            <label><input type="radio" name="agama" value="Katolik" required> Katolik</label>
                            <label><input type="radio" name="agama" value="Hindu" required> Hindu</label>
                            <label><input type="radio" name="agama" value="Buddha" required> Buddha</label>
                            <label><input type="radio" name="agama" value="Konghucu" required> Konghucu</label>
                        </div>
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                        <input type="text" name="pend_terakhir" placeholder="Pendidikan Terakhir" class="form-control input-lg" required />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                        <input type="text" name="pekerjaan" placeholder="Pekerjaan" class="form-control input-lg" required />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" name="nama_pj_pasien" placeholder="Nama PJ Pasien" class="form-control input-lg" required />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
                        <input type="text" name="hub_pj_pasien" placeholder="Hubungan PJ Pasien" class="form-control input-lg" required />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
                        <input type="text" name="pekerjaan_pj" placeholder="Pekerjaan PJ" class="form-control input-lg" required />
                    </div>
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                        <input type="text" name="no_pj" placeholder="Nomor Telepon PJ" class="form-control input-lg" required />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-inverse"><i class="glyphicon glyphicon-refresh"></i> Reset</button>
                <button type="submit" class="btn btn-primary" id="submit"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert & jQuery Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert CDN -->
<script type="text/javascript">
    $(document).ready(function() {
        $("button#submit").click(function(event) {
            event.preventDefault(); // Mencegah submit default
            $.ajax({
                type: "POST",
                url: "front-office/aksi_tambah_pasien.php", // URL untuk proses backend
                data: $('form#tambah_pasien').serialize(), // Mengambil data dari form
                success: function(msg) {
                    // SweetAlert jika berhasil
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data pasien berhasil ditambahkan!',
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
                        text: 'Terjadi kesalahan saat menambahkan pasien baru.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
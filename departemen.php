<?php

include 'konfig.php';
session_start();
if ($_SESSION['hak_akses'] == 'Departemen') {
?>
    <html>

    <head>
        <title>Halaman Departemen</title>
        <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome-4.1.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <link href="images/logouim.png" rel="shortcut icon">
        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
            });
        </script>
        <style type="text/css">
            /*	#searchid
                        {
                                width:500px;
                                border:solid 1px #000;
                                padding:10px;
                                font-size:14px;
                        }*/
            .navbar {
                background-image: url(images/uimbg.jpg);
                /* background-color: #098F96; */
                /* Ganti warna latar belakang di sini */
                padding: 10px;
                /* Padding untuk ruang di dalam navbar */

            }

            #result {
                position: absolute;
                width: 300px;
                padding: 5px;
                display: none;
                margin-top: 40px;
                border-top: 0px;
                overflow: hidden;
                border: 1px #CCC solid;
                background-color: white;
                z-index: 10;
                font-size: 14px;
                border-radius: 2px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .show {
                padding: 10px;
                border-bottom: 1px #999 dashed;
                /*		font-size:12px; */
                height: 50px;
            }

            .show:hover {
                background: #428bca;
                color: #fff;
                cursor: pointer;
            }
        </style>

    </head>

    <body>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="-webkit-box-shadow: 0px 0px 10px #888888;">
            <div class="navbar-header">
                <a class="navbar-brand" href="#" style="color: aliceblue;">Sistem Informasi Rumah Sakit</a>
            </div>
            <!-- <p class="navbar-text">Departemen <?php echo $_SESSION['grup']; ?></p> -->
            <div>
                <ul class="nav navbar-nav">
                    <li <?php if (isset($_GET['view'])) {
                            echo $_GET['view'] == 'tampil_pasien' || $_GET['view'] == 'ubah_pasien' ? 'class=""' : '';
                        } ?>><a href="?view=tampil_pasien" style="color: aliceblue;">Pasien &nbsp;
                            <span class="label label-warning" style="border-radius: 50px;">
                                <?php
                                $hitung_pasien = mysqli_query($koneksi, "select * from tbl_prj where departemen='" . $_SESSION['grup'] . "'");
                                echo mysqli_num_rows($hitung_pasien);
                                ?></span></a>
                    </li>
                    <li <?php if (isset($_GET['view'])) {
                            echo $_GET['view'] == 'tampil_jadwal_dokter' ? 'class=""' : '';
                        } ?>><a href="?view=tampil_jadwal_dokter" style="color: aliceblue;">Dokter &nbsp;
                            <span class="label label-info" style="border-radius: 50px;">
                                <?php
                                $hitung_pasien = mysqli_query($koneksi, "select * from tbl_dokter where departemen='" . $_SESSION['grup'] . "'");
                                echo mysqli_num_rows($hitung_pasien);
                                ?></span></a>
                    </li>

                </ul>

                <p class="navbar-text navbar-right" style="color: aliceblue;"><?php echo $_SESSION['username']; ?> login sebagai <?php echo $_SESSION['hak_akses']; ?> bagian <?php echo $_SESSION['grup']; ?> | <a class="btn btn-default btn-xs" href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a> &nbsp;</p>
            </div>

        </nav>
        <div class="container">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php
                        if (isset($_GET['view'])) {
                            $view = $_GET['view'];
                            include 'departemen/' . $view . '.php';
                        } else {
                            $_GET['view'] = 'tampil_pasien';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <footer align="center"><b style="color: black;">
                    © Copyright UIM Yogyakarta 2024</b>
            </footer>
    </body>

    </html>
<?php
} else {
    echo "<script>
        alert('Forbidden access');
	location.href='index.php';
	</script>";
    exit();
}
?>
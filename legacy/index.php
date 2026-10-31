<?php

include './konfig.php';
session_start();
if (isset($_SESSION['hak_akses']) == null) {
?>
    <html>

    <head>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="font-awesome-4.1.0/css/font-awesome.min.css">
        <style type="text/css">
            body {
                background-image: url(images/uimbg.jpg);
                background-size: cover;
                /* Ukuran gambar akan menyesuaikan dengan layar */
                background-position: center;
                /* Memastikan gambar tetap berada di tengah */
                background-repeat: no-repeat;
                /* Agar gambar tidak berulang */
                background-attachment: fixed;
                /* Agar gambar tetap di tempat saat menggulir */
            }
        </style>
        <title>UIM Yogyakarta</title>
        <link href="images/logouim.png" rel="shortcut icon">
    </head>

    <body>
        <div align="center">
            <br>
            <h1><b style="color: aliceblue;">Sistem Informasi Mini Hospital UIM Yogyakarta</b></h1>


            <div align="center" style="width:320px;margin-top:5%;">
                <form name="login_form" method="post" class="well well-lg" action="login.php" style="-webkit-box-shadow: 0px 0px 20px #888888;">
                    <div style="display: flex; justify-content: center;">
                        <img src="images/logouim.png" alt="Logo UIM" style="width: 100%; height: 100%; ">
                    </div>
                    <br>
                    <br>
                    <?php
                    if (isset($_GET['error'])) {
                        echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
      Password atau username kurang tepat
    </div>';
                    }
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="username" id="username" class="form-control" type="text" placeholder="Username" autocomplete="off" autofocus="" />
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input name="password" id="password" class="form-control" type="password" placeholder="Password" autocomplete="off" />
                    </div>
                    <br />
                    <input name="submit" type="submit" value="Login" class="btn btn-primary btn-block">
                </form>

            </div>
        </div>
        <br>
        <br>
        <br>

        <footer align="center"><b style="color: aliceblue;">
                © Copyright UIM Yogyakarta 2024</b>
        </footer>
    </body>

    </html>
<?php
} else {
    if ($_SESSION['hak_akses'] == "Dokter") {
        header("location:dokter.php");
    } elseif ($_SESSION['hak_akses'] == "Front Office") {
        header("location:front-office.php?view=tampil_pasien");
    } elseif ($_SESSION['hak_akses'] == "Departemen") {
        header("location:departemen.php?view=tampil_pasien");
    } elseif ($_SESSION['hak_akses'] == "Apoteker") {
        header("location:apoteker.php");
    } elseif ($_SESSION['hak_akses'] == "perawat") {
        header("location:perawat.php");
    } else {
        echo 'user tidak ditemukan';
        session_destroy();
    }
}
?>
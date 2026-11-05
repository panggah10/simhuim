<?php
include 'konfig.php';
session_start();
if ($_SESSION['hak_akses'] == 'Apoteker') {
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
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#datatable').dataTable();
                });
            </script>
        </head>

        <body>
            <nav class="navbar navbar-default navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Sistem Informasi Rumah Sakit</a>
                </div>
                <p class="navbar-text">Apoteker <?php echo $_SESSION['grup']; ?></p>
                <div>
                    <ul class="nav navbar-nav">
                            <li <?php 
                            if(isset($_GET['view'])) { echo $_GET['view']=='tampil_ambil_resep' ? 'class="active"':''; } ?>><a href="?view=tampil_ambil_resep">Resep &nbsp;
                                    <span class="label label-warning" style="border-radius: 50px;"> 
                                    <?php
                                    $hitung1 = mysql_query("select id_resep from tbl_resep");
                                    echo mysql_num_rows($hitung1);
                                    ?></span></a>
                            </li>
                            <li <?php 
                            if(isset($_GET['view'])) { echo $_GET['view']=='tampil_obat' ? 'class="active"':''; } ?>><a href="?view=tampil_obat">Obat &nbsp;
                                    <span class="label label-info" style="border-radius: 50px;"> 
                                    <?php
                                    $hitung2 = mysql_query("select id_obat from tbl_obat");
                                    echo mysql_num_rows($hitung2);
                                    ?></span></a>
                            </li>  
                             
                     </ul>
                    
                    <p class="navbar-text navbar-right"><?php echo $_SESSION['username']; ?> login sebagai apoteker | <a class="btn btn-default btn-xs" href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a>  &nbsp;</p>
                </div>
                                
            </nav>
            <div class="container">
                <div class="col-lg-12">
                    <div class="panel panel-default"> 
                        <div class="panel-body">
                            <?php
                            
                            if (isset($_GET['view'])) {
                                $view = $_GET['view'];
                                include 'apotek/'.$view . '.php';
                            } else {
                                $_GET['view'] = 'tampil_ambil_resep';
                            }
                            ?>
                        </div>
                    </div>
                </div>


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


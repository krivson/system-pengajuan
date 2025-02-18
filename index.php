<?php
    include 'system/koneksi.php';
    session_start();
    $logged_in = false;
    if (empty($_SESSION['email'])) {
        echo "<script type='text/javascript'>document.location='login?proses=error ';</script>";
    }
    else {
        $logged_in = true;

            $query_cek = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
                $result_cek = mysqli_query($con, $query_cek);
                $data_cek = mysqli_fetch_assoc($result_cek);

        if ($data_cek['role'] == "tim"){
        }else {
            echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
        }
    }
    
    function tanggal_indo($tanggal){
        $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Home</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/dist/sweetalert.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar1.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="index" class="simple-text">
    <?php
    $query_login = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
        $result_login = mysqli_query($con, $query_login);
        if(!$result_login){
        die ("Query Error: ".mysqli_errno($con).
            " - ".mysqli_error($con)); 
        }
        $data_login = mysqli_fetch_assoc($result_login);
        $id_login = $data_login["id_user"];
        $username_login = $data_login["username"];
    ?>
                        System Pengajuan<br><small>( TIM ) - <?php echo $username_login ?></small>
                    </a>
                </div>

                <ul class="nav"> 
                    <li class="active">
                        <a href="index">
                            <i class="pe pe-7s-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li>
                        <a href="pengajuan">
                            <i class="pe pe-7s-note2"></i>
                            <p>Pengajuan</p>
                        </a>
                    </li>
                    <li>
                        <a href="riwayat">
                            <i class="pe pe-7s-timer"></i>
                            <p>Riwayat</p>
                        </a>
                    </li>
                    <li>
                        <a href="notifikasi">
                            <i class="pe pe-7s-bell"></i>

    <?php
        $query_notifikasi = " SELECT a.id_riwayat FROM riwayat 
                AS a INNER JOIN pengajuan AS b WHERE a.id_pengajuan = b.id_pengajuan
                AND b.id_user = '$id_login' AND a.notifikasi= '1' ";
        $result_notifikasi = mysqli_query($con, $query_notifikasi);
        $banyakdata_notifikasi = $result_notifikasi->num_rows;
    ?>


                            <p>Notifikasi 
    <?php
        if ($banyakdata_notifikasi > 0){
            if( $banyakdata_notifikasi <= 10 ){
                $hasil = $banyakdata_notifikasi;
                echo "<span class='new badge'>$hasil</span>";
            }else{
                $hasil = "10 +";
                echo "<span class='new badge'>$hasil</span>";
            }
        }else{

        }
    ?>
                            </p>
                        </a>
                    </li> 
                    <li>
                        <a href="profil">
                            <i class="pe pe-7s-user"></i>
                            <p>Profile</p>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick = "logout()">
                            <i class="pe pe-7s-back"></i>
                            <p>Log out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                        <h4 class="title">Pemberitauan</h4>
        <?php
            $query_catatan = "SELECT * FROM catatan";
            $result_catatan = mysqli_query($con, $query_catatan);
            if(!$result_catatan){
            die ("Query Error: ".mysqli_errno($con).
                " - ".mysqli_error($con));
            }
            $data_catatan = mysqli_fetch_assoc($result_catatan);
            $update = $data_catatan['update_catatan'];
        ?>
                                            <p class="category">Update Terakhir : <b><?php echo tanggal_indo($update) ?></b></p>
                                        </div>
                                        <div class="content">
                                        <p>
        <?php 
        if ( $data_catatan['catatan'] == '' ){
            echo "<small style='color:#bfbfbf'>- Tidak ada catatan -</small>";
        }else{
            echo $data_catatan['catatan'];
        }
        ?>
                                        </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">
                                        10 Pengajuan Terakhir <br>
                                    </h4>
                                </div>
                                <div class="content">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <tbody>
    <?php
        $query_pengajuan = "SELECT a.id_pengajuan, a.event, a.id_user,  b.username, a.status
                                FROM pengajuan AS a INNER JOIN user AS b WHERE a.id_user = b.id_user
                                ORDER BY a.id_pengajuan DESC LIMIT 10 ";
        $result_pengajuan = mysqli_query($con, $query_pengajuan);
        if(!$result_pengajuan){
            die ("Query Error: ".mysqli_errno($con).
            " - ".mysqli_error($con));
        }
        if($result_pengajuan->num_rows == 0){
                                            echo "<tr>
                                                <td colspan='3'>Anda tidak memiliki pengajuan</td>
                                            </tr>";
        }
        else {
            while($data_pengajuan = mysqli_fetch_assoc($result_pengajuan)){
                                            echo '<tr>
                                                <td> '.$data_pengajuan['event'].' - '.$data_pengajuan['username'].' - ';
                if( $data_pengajuan['status'] == "menunggu" ){
                                                echo '<span class="badge menunggu upper">'.$data_pengajuan['status'].'</span>';
                }else if ($data_pengajuan['status'] == "proses"){
                                                echo '<span class="badge proses upper">'.$data_pengajuan['status'].'</span>';
                }else{
                                                echo '<span class="badge selesai upper">'.$data_pengajuan['status'].'</span>';
                }   
                                                echo '</td>
                                                <td class="td-actions text-right">
                                                    <a href="detail_pengajuan?id='.$data_pengajuan['id_pengajuan'].'">
                                                        <button type="button" rel="tooltip" title="Lihat Pengajuan" class="btn btn-info btn-simple btn-xs">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>';
            }
        }
    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <a href="pengajuan"><i class="fa fa-link"></i> Lihat Semua Pengajuan </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title" align="center">
                                    Notifikasi
                                    </h4>
                                </div>
                                <div class="content">
    <?php
        $query2 = "SELECT a.id_riwayat, a.kegiatan, a.id_pengajuan, b.event, a.jenis_riwayat, a.kegiatan3, 
                a.tanggal_kegiatan, b.id_user, a.notifikasi FROM riwayat 
                AS a INNER JOIN pengajuan AS b WHERE a.id_pengajuan = b.id_pengajuan
                AND b.id_user = '$id_login' ORDER BY id_riwayat DESC LIMIT 3" ;
        $result2 = mysqli_query($con, $query2);
        if(!$result2){
            die ("Query Error: ".mysqli_errno($con).
            " - ".mysqli_error($con));
        }
        if($result2->num_rows == 0){
                    echo "<p>Anda tidak memiliki notifikasi !</p>";
        }
        else {
            while($data2 = mysqli_fetch_assoc($result2)){ 
                            echo '<a href="system/notifikasi_pengajuan?id='.$data2['id_riwayat'].'" style="color:black">
                                <div class="card">
                                    <div class="content">
                                        <input type="hidden" name="id_pengajuan" value="'.$data2['id_pengajuan'].'">
                                            <h5><b>'.$data2['jenis_riwayat'].'</b> - '.$data2['event'].'
                                            <br>
                                        <small>'.$data2['kegiatan3'].'</small></h5>';                           
            if ($data2['notifikasi'] == "1"){
                                    echo '<div align="right">
                                        <span class="badge upper">Belum Dibaca</span>
                                    </div>';  
            }
            else{
            }
                                echo '</div>
                                </div>
                            </a>';
            }
        }
    ?>  

                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <a href="notifikasi"><i class="fa fa-link"></i> Lihat Semua Notifikasi </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div align="right">
                            <a href="tambah_pengajuan">
                                <button type="button" rel="tooltip" class="btn btn-primary btn-fill">
                                    <i class="fa fa-plus"></i> Tambah Pengajuan
                                </button>
                            </a>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="assets/dist/sweetalert-dev.js"></script>
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
	<script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="assets/js/light-bootstrap-dashboard.js"></script>
	<script src="assets/js/demo.js"></script>
	<script type="text/javascript">
    	$(document).ready(function(){
        	demo.initChartist();
    	});

        function logout() {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin keluar ",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00", 
                confirmButtonText: "Logout",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function(){
                document.location="logout";
            })
        }
	</script>

</html>

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

    $query_login = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
        $result_login = mysqli_query($con, $query_login);
            if(!$result_login){
                die ("Query Error: ".mysqli_errno($con).
                    " - ".mysqli_error($con));
            }
        $data = mysqli_fetch_assoc($result_login);
        $id = $data["id_user"];
        $username = $data["username"];
        $email = $data["email"];
        $namadepan = $data["nama_depan"]; 
        $namabelakang = $data["nama_belakang"];
        $jk = $data["jk"];
        $nohp = $data["no_hp"];
        $alamat = $data["alamat"];
        $role = $data["role"];
        $pembuatan_akun = $data["pembuatan_akun"];
        $update = $data["update_akun"];
        
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
	<title>Profil</title>
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
                        System Pengajuan<br><small>( TIM ) - <?php echo $username ?></small>
                </a>
            </div>

            <ul class="nav">
                <li>
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
               AND b.id_user = '$id' AND a.notifikasi= '1' ";
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
                <li class="active">
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
                                <h4 class="title">Profile <br> <small>Pembuatan Akun : <?php echo tanggal_indo($pembuatan_akun) ?> / Perubahan Terakhir : <?php echo tanggal_indo($update) ?></small></h4>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="hidden" name="id" value="<?php echo $id ?>">
                                                <input type="text" name="username" id="username" class="form-control" placeholder="username" value="<?php echo $username ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Email">Email address</label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="email" value="<?php echo $email ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Depan</label>
                                                <input type="text" name="nama_depan" id="nama_depan" class="form-control" placeholder="Nama Depan" value="<?php echo $namadepan ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Belakang</label>
                                                <input type="text" name="nama_belakang" id="nama_belakang" class="form-control" placeholder="Nama Belakang" value="<?php echo $namabelakang ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" value="<?php echo $alamat ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>No. Hp</label>
                                                <input type="number" name="nohp" id="no_hp" class="form-control" placeholder="No Hp" value="<?php echo $nohp ?>" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Pengaturan</h4>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group" align="center">
                                                <label for="Username">Bio Data</label>
                                                <br>
                                                <a href="ubah_bio">
                                                    <button type="button" class="btn btn-primary col-md-12 btn-fill">
                                                        <i class="fa fa-info"></i> Ubah Bio Data
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"  align="center">
                                                <label for="Email">Email</label><br>
                                                <a href="ubah_email">
                                                    <button type="button" class="btn btn-primary col-md-12 btn-fill">
                                                        <i class="fa fa-info"></i> Ubah Email
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group"  align="center">
                                                <label for="Password">Password</label><br>
                                                <a href="ubah_password">
                                                    <button type="button" class="btn btn-primary col-md-12 btn-fill">
                                                        <i class="fa fa-info"></i> Ubah Password
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

<?php
if (isset($_GET['proses'])) {
    echo '<script type="text/javascript">';
    $proses = ($_GET["proses"]);
    if($proses == "edit"){
            echo'swal({
                title: "Terubah!",
                text: "Profil telah diubah.",
                type: "success",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
  } 
    echo '</script>';
}
?>
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

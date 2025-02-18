<?php
    include '../system/koneksi.php';
    session_start();
    $logged_in = false;
    if (empty($_SESSION['email'])) {
        echo "<script type='text/javascript'>document.location='../login?proses=error ';</script>";
    }
    else {
        $logged_in = true;

            $query_cek = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
                $result_cek = mysqli_query($con, $query_cek);
                $data_cek = mysqli_fetch_assoc($result_cek);

        if ($data_cek['role'] == "manajemen"){
        }else {
            echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="../assets/img/icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>User</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/dist/sweetalert.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="../assets/img/sidebar1.jpg">
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
        $username = $data_login["username"];
    ?>
                        System Pengajuan<br><small>( MANAJEMEN ) - <?php echo $username ?></small>
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a href="index">
                            <i class="pe pe-7s-graph"></i>
                            <p>Dashboard</p>
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
                    <li class="active">
                        <a data-toggle="collapse" href="#componentsExamples" aria-expanded="true">
                            <i class="pe-7s-server"></i>
                            <p>Master</p>
                        </a>
                        <div class="collapse in" id="componentsExamples">
                            <ul class="nav">
                                <li class="active"><a href="user">Pengguna</a></li>
                                <li><a href="jenis_pengajuan">Jenis Pengajuan</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="profil">
                            <i class="pe pe-7s-user"></i>
                            <p>Profil</p>
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
                                    <h4 class="title">Tambah Data User</h4>
                                </div>
                                <div class="content">
                                    <form id="form_user" method="post" action="system/proses_tambah_user">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required 
                                                    oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                    oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Email">Email address</label>
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required
                                                    oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                    oninput="setCustomValidity('')"> 
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Password">Password</label>
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="password" required 
                                                    oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                    oninput="setCustomValidity('')" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Depan</label>
                                                    <input type="text" name="nama_depan" id="nama_depan" class="form-control" placeholder="Nama Pertama" required
                                                    oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                    oninput="setCustomValidity('')" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Nama Belakang</label>
                                                    <input type="text" name="nama_belakang" id="nama_belakang" class="form-control" placeholder="Nama Terakhir" required 
                                                    oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                    oninput="setCustomValidity('')" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <br>
                                                        <input type="radio" name="jeniskelamin" id="jeniskelamin" value="laki-laki" required
                                                        oninvalid="this.setCustomValidity('Pilih salah satu jenis kelamin berikut !')" onclick="clearValidity();">
                                                        Laki - Laki
                                                        <input type="radio" name="jeniskelamin" id="jeniskelamin" value="perempuan" required
                                                        onclick="clearValidity()"> 
                                                        Perempuan
    <script>
        function clearValidity(){
            document.getElementById('jeniskelamin').setCustomValidity('');
        }
    </script> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" required
                                                    oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                    oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>No. Hp</label>
                                                    <input type="number" name="nohp" id="no_hp" class="form-control" placeholder="No. Hp" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Role</label>
                                                    <br>
                                                        <input type="radio" name="role" id="role" value="manajemen" required
                                                        oninvalid="this.setCustomValidity('Pilih salah satu role berikut !')" onclick="clearValidity();"> 
                                                            Manajemen
                                                        <input type="radio" name="role" id="role" value="tim" required onclick="clearValidity()"> 
                                                            Tim
    <script>
        function clearValidity(){
            document.getElementById('role').setCustomValidity('');
        }
    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div align="right">
                                            <a href="user">
                                                <button type="button" rel="tooltip" class="btn btn-info btn-fill">
                                                            <i class="fa fa-arrow-left"></i> Kembali
                                                </button>
                                            </a>
                                            <button type="submit" name="input" rel="tooltip" class="btn btn-primary btn-fill">
                                                    <i class="fa fa-check"></i> Tambah
                                            </button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <script src="../assets/dist/sweetalert-dev.js"></script>
    <script src="../assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../assets/js/bootstrap-checkbox-radio-switch.js"></script>
	<script src="../assets/js/chartist.min.js"></script>
    <script src="../assets/js/bootstrap-notify.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="../assets/js/light-bootstrap-dashboard.js"></script>
	<script src="../assets/js/demo.js"></script>
<?php 
if (isset($_GET['error'])) {
    echo'<script type="text/javascript">';
    $error = ($_GET["error"]);
        if($error == "true"){
            echo'swal({
                title: "Mohon Maaf!",
                text: "Email atau Username yang anda masukan sudah ada!",
                type: "error",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
        }
    echo'</script>';
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
                document.location="../logout";
            })
        }
	</script>
</html>

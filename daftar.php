<?php
    include 'system/koneksi.php';
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>User</title>
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
        <div class="sidebar" data-color="green" data-image="assets/img/sidebar.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">
                        Pengajuan Pengadaaan <small>Barang & Training</small>
                    </a>
                </div>
                <ul class="nav">
                    <li class="active">
                        <a href="daftar" >
                            <i class="pe-7s-add-user"></i>
                            <p>Daftar</p>
                        </a>
                    </li>
                    <li>
                        <a href="lupa_password">
                            <i class="pe-7s-unlock"></i>
                            <p>Lupa Password</p>
                        </a>
                    </li>
                    <li>
                        <a href="login">
                            <i class="pe pe-7s-back"></i>
                            <p>Kembali Login</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <div class="content">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Daftar</h4>
                        </div>
                        <div class="content">
                            <form id="form_user" method="post" action="system/proses_daftar">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required 
                                                oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Email">Email address</label>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required
                                                oninvalid="this.setCustomValidity('Mohon sesuikan form berikut !')"  
                                                oninput="setCustomValidity('')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="password" required 
                                                oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                oninput="setCustomValidity('')" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="Password">Konfirmasi Password</label>
                                            <input type="password" name="konfirmasi_password" id="password" class="form-control" placeholder="password" required 
                                                oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                oninput="setCustomValidity('')" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Depan</label>
                                            <input type="text" name="nama_depan" id="nama_depan" class="form-control" placeholder="Nama Depan" required
                                                oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                oninput="setCustomValidity('')" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nama Belakang</label>
                                            <input type="text" name="nama_belakang" id="nama_belakang" class="form-control" placeholder="Nama Belakang" required 
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
                                <div align="right">
                                    <button type="submit" name="input" rel="tooltip" class="btn btn-primary btn-fill">
                                        <i class="fa fa-check"></i> Daftar
                                    </button>
                                </div>
                            </form>
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
if (isset($_GET['error'])) {
    echo'<script type="text/javascript">';
    $error = ($_GET["error"]);
        if($error == "true1"){
            echo'swal({
                title: "Mohon Maaf!",
                text: "Email sudah terdaftar!",
                type: "error",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
        } 
        if($error == "true2"){
            echo'swal({
                title: "Mohon Maaf!",
                text: "Konfirmasi password anda tidak sama!",
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
	</script>
</html>

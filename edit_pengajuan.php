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
    if (isset($_GET['id'])) {
        $id = ($_GET["id"]); 
        $query = "SELECT a.id_pengajuan, a.event, a.id_jenis_pengajuan, a.jenis_pengajuan,
                  a.biaya,  a.alasan, a.keterangan FROM pengajuan AS a INNER JOIN jenis_pengajuan AS b
                  WHERE id_pengajuan ='$id' AND a.id_jenis_pengajuan = a.id_jenis_pengajuan";
        $result = mysqli_query($con, $query);
        if(!$result){
        die ("Query Error: ".mysqli_errno($con).
            " - ".mysqli_error($con));
        }
        $data = mysqli_fetch_assoc($result);
        $id_pengajuan = $data["id_pengajuan"];
        $jenis_pengajuan = $data["jenis_pengajuan"];
        $event = $data["event"];
        $biaya = $data["biaya"]; 
        $alasan = $data["alasan"];
        $keterangan = $data["keterangan"];
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
	<link rel="icon" type="image/png" href="assets/img/icon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Pengajuan</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/lightbox.min.css">
    <link rel="stylesheet" href="assets/dist/sweetalert.css">
  <script src="assets/dist/sweetalert-dev.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar" data-color="green" data-image="assets/img/sidebar.jpg">
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
                    <li >
                        <a href="index">
                            <i class="pe pe-7s-home"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="active">
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="title">Edit Pengajuan</h4>
                                        </div>  
                                        <div class="col-md-6" align="right">
                                            <?php echo tanggal_indo(date("Y-m-d")); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <form id="form_user" method="post" action="system/proses_edit_pengajuan?id=<?php echo $id_pengajuan?>" enctype="multipart/form-data">
                                    <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Event</label>
                                                    <input type="text" name="event" id="form_pengajuan" class="form-control" placeholder="Event" required 
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                        oninput="setCustomValidity('')" >
                                                    <input type="hidden" name="id_pengaju" id="form_pengajuan" value="<?php echo $id_login ?>" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Pengajuan</label>
                                                    <br>
                                                    <div class="col-md-12">
                                                        <input type="text" name="jenis_pengajuan" id="form_pengajuan" class="form-control" placeholder="Jenis pengajuan" required 
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                        oninput="setCustomValidity('')" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Biaya</label>
                                                    <br>
                                                    <div class="col-md-1">
                                                        Rp.
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="number" name="biaya" id="form_pengajuan" class="form-control" placeholder="Biaya" required 
                                                            oninvalid="this.setCustomValidity('Mohon isi form berikut !')"  
                                                            oninput="setCustomValidity('')" >
                                                    </div>
                                                    <div class="col-md-1">
                                                        ,00,-
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea rows="5" name="keterangan" id="form_pengajuan" class="form-control" placeholder="Silakan Tulis Keterangan Anda Disini" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alasan</label>
                                                    <textarea rows="5" name="alasan" id="form_pengajuan" class="form-control" placeholder="Silakan Tulis Alasan Anda Disini " ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div align="right">
                                            <a href="detail_pengajuan?id=<?php echo $id_pengajuan ?>">
                                                <button type="button" rel="tooltip" class="btn btn-info btn-fill">
                                                    <i class="fa fa-arrow-left"></i> Batal
                                                </button>
                                            </a>
                                            <button type="submit" name="input" rel="tooltip" class="btn btn-primary btn-fill">
                                                    <i class="fa fa-check"></i> Ajukan
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
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
	<script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="assets/js/light-bootstrap-dashboard.js"></script>
	<script src="assets/js/demo.js"></script>
    <script src="assets/js/lightbox-plus-jquery.min.js"></script>
<?php
    if (isset($_GET['proses'])) {
    echo '<script type="text/javascript">';
        $proses = ($_GET["proses"]);
        if($proses == "error"){
            echo'swal({
                title: "Mohon Maaf!",
                text: "Terjadi kesalahan !",
                type: "error",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
        }else if ($proses == "size"){
            echo'swal({
                title: "Mohon Maaf!",
                text: "Ukuran gambar terlalu besar !",
                type: "error",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
        }else if ($proses == "format"){
            echo'swal({
                title: "Mohon Maaf!",
                text: "Format gambar tidak sesuai !",
                type: "error",
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
        
    function readURL(input) { 
        if (input.files && input.files[0]) {
        var reader = new FileReader(); 
        
            reader.onload = function (e) { 
            $('#preview_gambar') 
            .attr('src', e.target.result)
            .width(250); 
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    function myFunction() {
        document.getElementById("demo").innerHTML = "<img id='preview_gambar' /><br><label>Max size : 1MB</label>";
    }

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
        function hapusgambar(id) {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin menghapus gambar ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF4A55",
                confirmButtonText: "Iya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function(){
                document.location="system/hapus_gambar?id="+id;
            })
        }
	</script>
</html>

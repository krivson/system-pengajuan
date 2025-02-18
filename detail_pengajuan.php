<?php
    include"system/koneksi.php";
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
        $query = "SELECT a.id_pengajuan, a.event, a.id_user,  b.username, a.id_jenis_pengajuan, c.jenis_pengajuan, a.tanggal_pengajuan, 
                      a.biaya, a.alasan, a.keterangan, a.jadwal_pelaksanaan, a.catatan, a.status, a.update_pengajuan
                    FROM pengajuan AS a INNER JOIN user AS b INNER JOIN jenis_pengajuan AS c WHERE a.id_user = b.id_user AND a.id_jenis_pengajuan = a.id_jenis_pengajuan AND a.id_pengajuan like '$id'" ;
        $result = mysqli_query($con, $query);
            if(!$result){
            die ("Query Error: ".mysqli_errno($con).
                " - ".mysqli_error($con));
            }
        $data = mysqli_fetch_assoc($result);
        $id_pengajuan = $data["id_pengajuan"];
        $event = $data["event"];
        $pengaju = $data["username"];
        $jenis_pengajuan = $data["jenis_pengajuan"];
        $tanggal_pengajuan = $data["tanggal_pengajuan"];
        $biaya = $data["biaya"];
        $alasan = $data["alasan"];
        $status = $data["status"];
        $keterangan = $data["keterangan"];
        $update = $data["update_pengajuan"];
        $pelaksanaan = $data["jadwal_pelaksanaan"];
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
                                    <h4 class="title">
                                        <div align="center">
                                            <b><?php echo $event ?></b><br>
                                            <small>
                                                <?php
                                                    echo '<b>'.$pengaju.'</b> / <small>'.tanggal_indo($tanggal_pengajuan).'</small>';
                                                ?> / 
<?php                                                
                    if( $data['status'] == "menunggu" ){
                                                            echo '<span class="badge menunggu upper">'.$data['status'].'</span>';
                    }else if ($data['status'] == "proses"){
                                                            echo '<span class="badge proses upper">'.$data['status'].'</span>';
                    }else{
                                                            echo '<span class="badge selesai upper">'.$data['status'].'</span>';
                    }
?>
                                            </small> 
                                        </div>
                                    </h4>
                                <hr>
                                </div>
                                <div class="content">
                                    <form id="form_pengajuan_diterima" method="post" >
                                    <input type="hidden" name="id_pengajuan" value="<?php echo $id_pengajuan ?>">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <table>
                                                        <tr>
                                                            <td width="180px"></td>
                                                            <td width="25px"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td><h5><b>Jenis Pengajuan </h5></b></td>
                                                            <td><h5><b> : </h5></b></td>
                                                            <td><h5> <?php echo $jenis_pengajuan ?> </h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td><h5><b>Biaya</h5></b></td>
                                                            <td><h5><b> : </h5></b></td>
                                                            <td><h5>  Rp. <?php echo $biaya ?>,00,-</h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td><h5><b>Alasan</h5></b></td>
                                                            <td><h5><b> : </h5></b></td>
                                                            <td><h5>  <?php echo $alasan ?></h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td><h5><b>Keterangan</h5></b></td>
                                                            <td><h5><b> : </h5></b></td>
                                                            <td><h5> <?php echo $keterangan ?></h5></td>
                                                        </tr>
                                                   
                                                    </tabel>
    <?php
        if( $data['status'] == "menunggu" ){

        }
        else if ($data['status'] == "proses"){
            echo '
                                                    <table>
                                                        <tr>
                                                            <td width="180px"></td>
                                                            <td width="25px"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td><h5><b>Jadwal Pelaksanaan</h5></b></td>
                                                            <td><h5><b> : </h5></b></td>
                                                            <td><h5>'.tanggal_indo(''.$data['jadwal_pelaksanaan'].'').'</h5></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="center">
                                                                <pre><p>'.$data['catatan'].'</p></pre>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <hr>
                                                    <table>
                                                        <tr>
                                                            <td colspan="5"><h5><b>Riwayat</h5></b></td>
                                                        </tr>
            ';
        }
        else if ($data['status'] == "selesai"){
            echo '
                                                </table>
                                                <hr>
                                                <table>
                                                    <tr>
                                                        <td colspan="7"><h5><b>Riwayat</h5></b></td>
                                                    </tr>';
        }
    ?>
<?php
    $query2 = "SELECT * FROM riwayat WHERE id_pengajuan ='$id' ORDER BY id_riwayat DESC" ;
    $result2 = mysqli_query($con, $query2);
        if(!$result2){
            die ("Query Error: ".mysqli_errno($con).
            " - ".mysqli_error($con)); 
        }
    $no = 1;
      while($data2 = mysqli_fetch_assoc($result2)){
                                                    echo '<tr>
                                                        <td width="10px">'.$no.'</td>
                                                        <td width="10px"> . </td>
                                                        <td width="180px"> <b>'.$data2['kegiatan2'] .'</b> </td>
                                                        <td width="10px"> : </td>
                                                        <td width="100px"><small>'.tanggal_indo(''.$data2['tanggal_kegiatan'].'').'</small></td>';
        if($data2['kegiatan2'] == "Pengajuan Diselesaikan"){

        }else{
                                                        echo '<td width="10px"> : </td>
                                                        <td><small>'.$data2['catatan'].'</small></td>';
        }
                                                    echo'</tr>';
                                                $no++;
      }                                                      
?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div align="right">
                                        <a href="pengajuan">
                                            <button type="button" rel="tooltip" class="btn btn-info btn-fill" title="kembali">
                                                <i class="fa fa-list"></i> Pengajuan 
                                            </button>
                                        </a>
    <?php
    if( $data['status'] == "menunggu"){
        if ( $pengaju == $username_login ){
                                                    echo '<a href="edit_pengajuan?id='.$id_pengajuan.'"
                                                        <button type="button" rel="tooltip" title="Ubah Pengajuan" class="btn btn-primary btn-fill" >
                                                            <i class="fa fa-edit"></i> Ubah Pengajuan
                                                        </button>
                                                    </a>
                                                    <button onclick="batalpengajuan('.$id_pengajuan.')" type="button" rel="tooltip" title="hapus Pengajuan" class="btn btn-danger btn-fill">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>'; 
        }        
    }
        else if ($data['status'] == "proses"){

        }else {
            if ( $pengaju == $username_login ){
                                            echo'<button onclick="hapuspengajuan('.$id_pengajuan.')" type="button" rel="tooltip" title="hapus Pengajuan" class="btn btn-danger btn-fill">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>';                                      
            }
        }
    ?>
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
    echo'<script type="text/javascript">';
        $proses = ($_GET["proses"]);
        if($proses == "edit"){
            echo'swal({
                title: "Terubah!",
                text: "Data pengajuan telah diubah.",
                type: "success",
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
                document.location="logout";
            })
        }

        function batalpengajuan(id) {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin membatalkan pengajuan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00",
                confirmButtonText: "Iya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function(){
                document.location="system/hapus_pengajuan?id="+id;
            })
        }
        function hapuspengajuan(id) {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin menghapus pengajuan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF4A55",
                confirmButtonText: "Iya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function(){
                document.location="system/hapus_pengajuan?id="+id;
            })
        }
	</script>

</html>

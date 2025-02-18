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
?> 
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Riwayat</title>
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/datepicker.css">
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
                    <li >
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
                    <li class="active">
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
                                            <h4 class="title">Riwayat</h4>
                                        </div>  
                                    </div>
                                    <br>    
                                    <form id="form_pencarian" action="?" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label> Judul Pengajuan</label>
                                                    <input type="text" name="pengajuan" class="form-control" >
                                                </div> 
                                            </div>
                                                <?php
                                                    $query_MIN = "SELECT MIN(tanggal_pengajuan) from pengajuan WHERE status LIKE 'selesai'";
                                                    $result_MIN = mysqli_query($con, $query_MIN);
                                                    $data_MIN = mysqli_fetch_assoc($result_MIN);
                                                    $MIN = date_create($data_MIN['MIN(tanggal_pengajuan)']);
                                                    $awal = date_format($MIN,"d-m-Y");
                                                ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label> Tanggal Pengajuan Awal </label>
                                                    <input type="text" name="pertama" id="datepicker1" class="form-control" value="<?php echo $awal;?>">
                                                </div> 
                                            </div>
                                                <?php
                                                    $query_MAX = "SELECT MAX(tanggal_pengajuan) from pengajuan WHERE status LIKE 'selesai'";
                                                    $result_MAX = mysqli_query($con, $query_MAX);
                                                    $data_MAX = mysqli_fetch_assoc($result_MAX);
                                                    $MAX = date_create($data_MAX['MAX(tanggal_pengajuan)']);
                                                    $akhir = date_format($MAX,"d-m-Y");
                                                ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label> Tanggal Pengajuan Akhir </label>
                                                    <input type="text" name="terakhir" id="datepicker2" class="form-control" value="<?php echo $akhir; ?>" >
                                                    </div> 
                                            </div>
                                            <div class="col-md-1">
                                                <label><br></label>
                                                <button type="submit" class="btn btn-primary btn-fill">
                                                        <i class="fa fa-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </from>
                                </div>
    <?php
        if (isset($_GET['pengajuan'])) {
            $pengajuan = ($_GET["pengajuan"]);
            $first = date_create(($_GET["pertama"]));
            $lass = date_create(($_GET["terakhir"]));
            $awal = date_format($first,"Y-m-d");
            $akhir = date_format($lass,"Y-m-d");

            if( $pengajuan == ""){
                $query = "SELECT a.id_pengajuan, a.event, a.id_user,  b.username, a.id_jenis_pengajuan, c.jenis_pengajuan , a.tanggal_pengajuan,
                            a.biaya, a.status FROM pengajuan AS a INNER JOIN user AS b INNER JOIN jenis_pengajuan AS c WHERE a.id_user = b.id_user AND a.id_jenis_pengajuan = a.id_jenis_pengajuan
                            AND b.username like '$username_login' AND (a.tanggal_pengajuan BETWEEN '$awal' AND '$akhir') 
                            AND a.status like 'selesai' ORDER BY a.id_pengajuan DESC" ;
            }
            else {
                $query = "SELECT a.id_pengajuan, a.event, a.id_user,  b.username, a.id_jenis_pengajuan, c.jenis_pengajuan ,a.tanggal_pengajuan,
                            a.biaya, a.status FROM pengajuan AS a INNER JOIN user AS b INNER JOIN jenis_pengajuan AS c WHERE a.id_user = b.id_user AND a.id_jenis_pengajuan = a.id_jenis_pengajuan
                            AND b.username like '$username_login' AND a.event like '%$pengajuan%' 
                            AND (a.tanggal_pengajuan BETWEEN '$awal' AND '$akhir') 
                            AND a.status like 'selesai' ORDER BY a.id_pengajuan DESC" ;
            }
        }
        else{    
            $query = "SELECT a.id_pengajuan, a.event, a.id_user,  b.username, a.id_jenis_pengajuan, c.jenis_pengajuan ,a.tanggal_pengajuan,
                        a.biaya, a.status FROM pengajuan AS a INNER JOIN user AS b INNER JOIN jenis_pengajuan AS c  WHERE a.id_user = b.id_user AND a.id_jenis_pengajuan = a.id_jenis_pengajuan
                        AND b.username like '$username_login' AND a.status like 'selesai' ORDER BY a.id_pengajuan DESC" ;
        }
    ?>
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>No</th>
                                            <th>Pengajuan</th>
                                            <th>Jenis</th>
                                            <th>tanggal</th>
                                            <th>biaya</th>
                                            <th>status</th>
                                            <th>Tindak Lanjut</th>
                                        </thead>
                                        <tbody>
    <?php
        $result = mysqli_query($con, $query);
                                                
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
                return $split[2] . ' - ' . $bulan[ (int)$split[1] ] . ' - ' . $split[0];
            }

        if(!$result){
            die ("Query Error: ".mysqli_errno($con).
            " - ".mysqli_error($con));
        }
        if($result->num_rows == 0){
                                            echo "<tr>
                                                <td colspan='7' align='center'>
                                                    Anda tidak memiliki riwayat pengajuan 
                                                    <br>
                                                    <a href='riwayat'>
                                                        <button type='button' class='btn btn-primary btn-fill btn-sm'>
                                                            <i class='fa fa-refresh'></i> Refresh data
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>";
        }
        else {
        $no = 1;
        while($data = mysqli_fetch_assoc($result))
        {
                                            echo '<tr>
                                                <td align = "center">'.$no.'</td>
                                                <td align = "center">'.$data['event'].'</td>
                                                <td align = "center">'.$data['jenis_pengajuan'].'</td>
                                                <td align = "center">'.tanggal_indo(''.$data['tanggal_pengajuan'].'').'</td>
                                                <td align = "center">'.$data['biaya'].'</td>
                                                <td align = "center">
                                                    <span class="badge  upper">'.$data['status'].'</span>
                                                </td>
                                                <td align="center">
                                                    <a href="detail_pengajuan?id='.$data['id_pengajuan'].'">
                                                        <button type="button" class="btn btn-info btn-fill btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <button onclick="hapus('.$data['id_pengajuan'].')" type="button" class="btn btn-danger  btn-fill btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>';
                                            $no++;
            }
        }
    ?>
                                        </tbody>
                                    </table>
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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php
    if (isset($_GET['proses'])) {
        echo '<script type="text/javascript">';
        $proses = ($_GET["proses"]);
        if($proses == "delete"){
            echo'swal({
                    title: "Terhapus!",
                    text: "Pengajuan telah dihapus.",
                    type: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#00ff00"
            })';
        }else if($proses == "tambah"){
            echo'swal({
                    title: "Tertambah!",
                    text: "Pengajuan telah ditambah.",
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

        function hapus(id) {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin menghapus pengajuan",
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
        
        $( function() {
            $( "#datepicker1" ).datepicker({
                dateFormat: "dd-mm-yy",
                monthNames: [ "Januari", "Febuari", "Maret", 
                            "April", "Mei", "Juni", 
                            "Juli", "Agustus", "September", 
                            "Oktober", "November", "December" ],
                dayNamesMin: [ "Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab" ]
                
            });
            $( "#datepicker2" ).datepicker({
                dateFormat: "dd-mm-yy",
                monthNames: [ "Januari", "Febuari", "Maret", 
                            "April", "Mei", "Juni", 
                            "Juli", "Agustus", "September", 
                            "Oktober", "November", "December" ],
                dayNamesMin: [ "Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab" ]
                
            });
        } );
    </script>
</html>

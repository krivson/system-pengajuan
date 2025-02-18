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
    <div class="sidebar" data-color="blue" data-image="../assets/img/1.jpg">
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="title">Data Pengguna</h4>
                                    </div>  
                                    <div class="col-md-6" align="right">
                                        <a href="tambah_user">
                                            <button type="button" class="btn btn-primary btn-fill">
                                                <i class="fa fa-plus"></i> Tambah Pengguna
                                            </button> 
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <form id="form_pencarian"  action="?" method="get">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Pencarian : </label>

<?php
        if (isset($_GET['cari'])) {
            $username = ($_GET["cari"]);
?>  
                <input type="text" name="cari" id="cari" class="form-control" placeholder="Username" value="<?php echo $username ?>">
<?php
        }
        else {
?>
                <input type="text" name="cari" id="cari" class="form-control" placeholder="Username">
<?php
        }
?>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label><br></label>
                                            <button type="submit" rel="tooltip" class="btn btn-primary btn-fill">
                                                <i class="fa fa-search"></i> Cari
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="content table-responsive table-full-width">        
<?php
        if (isset($_GET['cari'])) {
            $username = ($_GET["cari"]);
                $query = "SELECT * FROM user WHERE username like '%$username%' ORDER BY role" ;
        }
        else {
                $query = "SELECT * FROM user ORDER BY role" ;
        }

            $result = mysqli_query($con, $query);
            if($result->num_rows == 0){
                                    echo '<div class="content table-responsive table-full-width">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Tindak Lanjut</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="8" align="center">
                                                        Anda tidak memiliki pengajuan
                                                        <br>
                                                        <a href="user">
                                                            <button type="button" class="btn btn-primary btn-fill btn-sm">
                                                                <i class="fa fa-refresh"></i> Refresh data
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>';
            }
            else {
                                    echo '<div class="content table-responsive table-full-width">
                                        <table class="table table-hover table-striped table-paginate">
                                            <thead>
                                                <th align="center">No</th>
                                                <th align="center">Username</th>
                                                <th align="center">Email</th>
                                                <th align="center">Role</th>
                                                <th align="center">Tindak Lanjut</th>
                                            </thead>
                                            <tbody>';                                        
                $no = 1;
                    $query_tim = "SELECT * FROM user WHERE ROLE = 'tim'" ;
                    $result_tim = mysqli_query($con, $query_tim);
                    $no = 1;
                while($data = mysqli_fetch_assoc($result)){
                                                echo '<tr>
                                                <td align="center">'.$no.'</td>
                                                <td align="center">'.$data['username'].'</td>
                                                <td align="center">'.$data['email'].'</td>
                                                <td align="center">'.$data['role'].'</td>
                                                <td align="center">
                                                    <a href="detail_user?id='.$data['id_user'].'">
                                                        <button type="button" class="btn btn-info btn-fill btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>';
                    if( $data['email'] == $_SESSION['email'] ){
                                                    echo '<button  type="button" rel="tooltip" class="btn btn-danger btn-fill btn-sm" disabled>
                                                        <i class="fa fa-trash"></i>
                                                    </button>';
                    }
                    else{
                        if ($result_tim->num_rows == 1){
                                                    echo' <button type="button" rel="tooltip" class="btn btn-danger btn-fill btn-sm" disabled>
                                                        <i class="fa fa-trash"></i>
                                                    </button>';
                        }else{
                                                    echo' <button onclick="hapususer('.$data['id_user'].')"  type="button" rel="tooltip" class="btn btn-danger btn-fill btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>';
                        }
                    }
                                        $no++;
                    }
                                            echo'</tbody>
                                        </table>
                                    </div>';
                }
            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
    <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" language="javascript" src="http:////cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="http://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
	<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../assets/js/bootstrap-checkbox-radio-switch.js"></script>
	<script src="../assets/js/chartist.min.js"></script>
    <script src="../assets/js/bootstrap-notify.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script src="../assets/js/light-bootstrap-dashboard.js"></script>
	<script src="../assets/js/demo.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../assets/dist/sweetalert-dev.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
        $('.table-paginate').dataTable({      
            "searching": false,
            "paging": false, 
            "info": false,         
            "lengthChange":false 
        });
    } );
    </script>
<?php
if (isset($_GET['proses'])) {
    $proses = ($_GET["proses"]);
        echo'<script type="text/javascript">';
    if($proses == "delete"){
            echo 'swal({
                title: "Terhapus!",
                text: "Data user telah dihapus.",
                type: "success",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
    }
    else if ($proses == "edit") { 
            echo 'swal({
                title: "Terubah!",
                text: "Data user telah diubah.",
                type: "success",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })';
    }
    else if ($proses == "tambah") { 
            echo 'swal({
                title: "Tertambah!",
                text: "Data user telah ditambah.",
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
                document.location="../logout";
            })
        }

        function editprofil(id) {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin mengubah pengguna",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00ff00",
                confirmButtonText: "Iya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function(){
                document.location="edit_user?id="+id;
            })
        }       
        function hapususer(id) {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin menghapus pengguna",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            },
            function(){
                document.location="system/hapus_user?id="+id;
            })
        }
	</script>
</html>

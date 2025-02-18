<?php
include '../system/koneksi.php';
session_start();
$logged_in = false;
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='../login?proses=error ';</script>";
} else {
    $logged_in = true;

    $query_cek = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
    $result_cek = mysqli_query($con, $query_cek);
    $data_cek = mysqli_fetch_assoc($result_cek);

    if ($data_cek['role'] == "manajemen") {
    } else {
        echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    }
}

function tanggal_indo($tanggal)
{
    $bulan = array(
        1 => 'Januari',
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
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Pengajuan</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/animate.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/dist/sweetalert.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../assets/css/datepicker.css">
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
                        if (!$result_login) {
                            die("Query Error: " . mysqli_errno($con) .
                                " - " . mysqli_error($con));
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
                        <a data-toggle="collapse" href="#componentsExamples">
                            <i class="pe-7s-server"></i>
                            <p>Master</p>
                        </a>
                        <div class="collapse" id="componentsExamples">
                            <ul class="nav">
                                <li><a href="user">Pengguna</a></li>
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
                        <a href="#" onclick="logout()">
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
                                            <h4 class="title">Data Pengajuan</h4>
                                        </div>
                                    </div>
                                    <br>
                                    <?php
                                    if (isset($_GET['judul'])) {
                                        $event = ($_GET["judul"]);
                                        $first = ($_GET["tanggal_awal"]);
                                        $lass = ($_GET["tanggal_akhir"]);
                                        $sts = ($_GET["status"]);
                                        ?>
                                        <form id="form_pencarian" action="?" method="get">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label> Judul Pengajuan</label>
                                                        <input type="text" name="judul" class="form-control"
                                                            value="<?php echo $event; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> Tanggal Pengajuan Awal </label>
                                                        <input type="text" name="tanggal_awal" id="datepicker1"
                                                            class="form-control" value="<?php echo $first; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> Tanggal Pengajuan Akhir </label>
                                                        <input type="text" name="tanggal_akhir" id="datepicker2"
                                                            class="form-control" value="<?php echo $lass; ?>">
                                                    </div>
                                                </div>
                                                <?php
                                                if ($sts == "semua") {
                                                    ?>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label> Status</label>
                                                            <select name="status" form="form_pencarian" class="form-control">
                                                                <option value="semua" selected>Semua</option>
                                                                <option value="menunggu">Menunggu</option>
                                                                <option value="proses">Proses</option>
                                                                <option value="selesai">Selesai</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else if ($sts == "menunggu") {
                                                    ?>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label> Status</label>
                                                                <select name="status" form="form_pencarian" class="form-control">
                                                                    <option value="semua">Semua</option>
                                                                    <option value="menunggu" selected>Menunggu</option>
                                                                    <option value="proses">Proses</option>
                                                                    <option value="selesai">Selesai</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php
                                                } else if ($sts == "proses") {
                                                    ?>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label> Status</label>
                                                                    <select name="status" form="form_pencarian" class="form-control">
                                                                        <option value="semua">Semua</option>
                                                                        <option value="menunggu">Menunggu</option>
                                                                        <option value="proses" selected>Proses</option>
                                                                        <option value="selesai">Selesai</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                    <?php
                                                } else if ($sts == "selesai") {
                                                    ?>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label> Status</label>
                                                                        <select name="status" form="form_pencarian" class="form-control">
                                                                            <option value="semua">Semua</option>
                                                                            <option value="menunggu">Menunggu</option>
                                                                            <option value="proses">Proses</option>
                                                                            <option value="selesai" selected>Selesai</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="col-md-1">
                                                    <label><br></label>
                                                    <button type="submit" class="btn btn-primary btn-fill">
                                                        <i class="fa fa-search"></i> Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                    } else {
                                        ?>
                                        <form id="form_pencarian" action="?" method="get">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label> Judul Pengajuan</label>
                                                        <input type="text" name="judul" class="form-control">
                                                    </div>
                                                </div>
                                                <?php
                                                $query_MIN = "SELECT MIN(tanggal_pengajuan) from pengajuan";
                                                $result_MIN = mysqli_query($con, $query_MIN);
                                                $data_MIN = mysqli_fetch_assoc($result_MIN);
                                                $MIN = date_create($data_MIN['MIN(tanggal_pengajuan)']);
                                                $awal = date_format($MIN, "d-m-Y");
                                                ?>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> Tanggal Pengajuan Awal </label>
                                                        <input type="text" name="tanggal_awal" id="datepicker1"
                                                            class="form-control" value="<?php echo $awal; ?>">
                                                    </div>
                                                </div>
                                                <?php
                                                $query_MAX = "SELECT MAX(tanggal_pengajuan) from pengajuan";
                                                $result_MAX = mysqli_query($con, $query_MAX);
                                                $data_MAX = mysqli_fetch_assoc($result_MAX);
                                                $MAX = date_create($data_MAX['MAX(tanggal_pengajuan)']);
                                                $akhir = date_format($MAX, "d-m-Y");
                                                ?>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> Tanggal Pengajuan Akhir </label>
                                                        <input type="text" name="tanggal_akhir" id="datepicker2"
                                                            class="form-control" value="<?php echo $akhir; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label> Status</label>
                                                        <select name="status" form="form_pencarian" class="form-control">
                                                            <option value="semua">Semua</option>
                                                            <option value="menunggu">Menunggu</option>
                                                            <option value="proses">Proses</option>
                                                            <option value="selesai">Selesai</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label><br></label>
                                                    <button type="submit" class="btn btn-primary btn-fill">
                                                        <i class="fa fa-search"></i> Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    <?php
                                    if (isset($_GET['judul'])) {
                                        $pengajuan = ($_GET["judul"]);
                                        $first = date_create(($_GET["tanggal_awal"]));
                                        $lass = date_create(($_GET["tanggal_akhir"]));
                                        $awal = date_format($first, "Y-m-d");
                                        $akhir = date_format($lass, "Y-m-d");
                                        $sts = ($_GET["status"]);

                                        if ($sts == "semua") {
                                            $status = "";
                                        } else {
                                            $status = $sts;
                                        }

                                        if ($pengajuan == "") {
                                            $query = "SELECT a.id_pengajuan, a.event, a.id_user, b.username, a.id_jenis_pengajuan, 
                                                    a.jenis_pengajuan, a.tanggal_pengajuan, a.jadwal_pelaksanaan, a.biaya, a.status, 
                                                    a.estimasi_waktu 
                                                    FROM pengajuan AS a 
                                                    INNER JOIN user AS b 
                                                    INNER JOIN jenis_pengajuan AS c 
                                                    WHERE a.id_user = b.id_user 
                                                    AND a.id_jenis_pengajuan = a.id_jenis_pengajuan
                                                    AND (a.tanggal_pengajuan BETWEEN '$awal' AND '$akhir') 
                                                    AND a.status like '%$status%' 
                                                    ORDER BY a.id_pengajuan DESC";
                                        } else {
                                            $query = "SELECT a.id_pengajuan, a.event, a.id_user, b.username, a.id_jenis_pengajuan, 
                                                    a.jenis_pengajuan, a.tanggal_pengajuan, a.jadwal_pelaksanaan, a.biaya, a.status, 
                                                    a.estimasi_waktu 
                                                    FROM pengajuan AS a 
                                                    INNER JOIN user AS b 
                                                    INNER JOIN jenis_pengajuan AS c 
                                                    WHERE a.id_user = b.id_user 
                                                    AND a.id_jenis_pengajuan = a.id_jenis_pengajuan
                                                    AND a.event like '%$pengajuan%' 
                                                    AND (a.tanggal_pengajuan BETWEEN '$awal' AND '$akhir') 
                                                    AND a.status like '%$status%' 
                                                    ORDER BY a.id_pengajuan DESC";
                                        }
                                    } else {
                                        $query = "SELECT a.id_pengajuan, a.event, a.id_user, b.username, a.id_jenis_pengajuan, 
                                                a.jenis_pengajuan, a.tanggal_pengajuan, a.jadwal_pelaksanaan, a.biaya, a.status, 
                                                a.estimasi_waktu 
                                                FROM pengajuan AS a 
                                                INNER JOIN user AS b 
                                                INNER JOIN jenis_pengajuan AS c 
                                                WHERE a.id_user = b.id_user 
                                                AND a.id_jenis_pengajuan = a.id_jenis_pengajuan
                                                ORDER BY a.id_pengajuan DESC";
                                    }
                                    $result = mysqli_query($con, $query);
                                    if (!$result) {
                                        die("Query gagal dijalankan: " . mysqli_errno($con) .
                                            " - " . mysqli_error($con));
                                    }
                                    if ($result->num_rows == 0) {
                                        echo '<div class="content table-responsive table-full-width">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <th>No</th>
                                                <th>Event</th>
                                                <th>Pengaju</th>
                                                <th>Jenis</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Jadwal Pelaksanaan</th>
                                                <th>Biaya</th>
                                                <th>Status</th>
                                                <th>Tindak Lanjut</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="9" align="center">
                                                        Anda tidak memiliki pengajuan
                                                        <br>
                                                        <a href="pengajuan">
                                                            <button type="button" class="btn btn-primary btn-fill btn-sm">
                                                                <i class="fa fa-refresh"></i> Refresh data
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>';
                                    } else {
                                        $no = 1;
                                        echo '<div class="content table-responsive table-full-width">
                                        <table class="table table-hover table-striped table-paginate">
                                            <thead>
                                                <tr>
                                                    <th align="center">No</th>
                                                    <th align="center">Event</th>
                                                    <th align="center">Pengaju</th>
                                                    <th align="center">Jenis Pengajuan</th>
                                                    <th align="center">Tanggal Pengajuan</th>
                                                    <th align="center">Jadwal Pelaksanaan</th>
                                                    <th align="center">Biaya</th>
                                                    <th align="center">Status</th>
                                                    <th align="center">Tindak Lanjut</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                        while ($data = mysqli_fetch_assoc($result)) {
                                            echo '<tr>
                                                <td align="center">' . $no . '</td>
                                                <td align="center">' . $data['event'] . '</td>
                                                <td align="center">' . $data['username'] . '</td>
                                                <td align="center">' . $data['jenis_pengajuan'] . '</td>
                                                <td align="center">' . tanggal_indo($data['tanggal_pengajuan']) . '</td>
                                                <td align="center">' . ($data['jadwal_pelaksanaan'] != '0000-00-00' ? tanggal_indo($data['jadwal_pelaksanaan']) : '-') . '</td>
                                                <td align="center">Rp. ' . number_format($data['biaya'], 0, ',', '.') . '</td>
                                                <td align="center">';
                                            if ($data['status'] == "menunggu") {
                                                echo '<span class="badge menunggu upper">' . $data['status'] . '</span>';
                                            } else if ($data['status'] == "proses") {
                                                echo '<span>estimasi waktu : ' . $data['estimasi_waktu'] . ' hari </span><br>';
                                                echo '<span class="badge proses upper">' . $data['status'] . '</span>';
                                            } else {
                                                echo '<span class="badge selesai upper">' . $data['status'] . '</span>';
                                            }
                                            echo '</td>
                                                <td align="center">';
                                            if ($data['status'] == "menunggu") {
                                                echo '<button onclick="pengajuanditerima(' . $data['id_pengajuan'] . ')" type="button" class="btn btn-primary btn-fill btn-sm">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <button onclick="pengajuanditolak(' . $data['id_pengajuan'] . ')" type="button" class="btn btn-danger btn-fill btn-sm">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                    <a href="detail_pengajuan?id=' . $data['id_pengajuan'] . '">
                                                        <button type="button" class="btn btn-info btn-fill btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>';
                                            } else if ($data['status'] == "proses") {
                                                echo '<a href="pengajuan_diubah?id=' . $data['id_pengajuan'] . '">
                                                        <button onclick="pengajuandiubah(' . $data['id_pengajuan'] . ')" type="button" class="btn btn-primary btn-fill btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="detail_pengajuan?id=' . $data['id_pengajuan'] . '">
                                                        <button type="button" class="btn btn-info btn-fill btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>
                                                    <button onclick="pengajuandiselesaikan(' . $data['id_pengajuan'] . ')" type="button" name="input" class="btn btn-primary btn-fill btn-sm">
                                                        <i class="fa fa-check"></i>
                                                    </button>';
                                            } else if ($data['status'] == "selesai") {
                                                echo '<a href="detail_pengajuan?id=' . $data['id_pengajuan'] . '">
                                                        <button type="button" class="btn btn-info btn-fill btn-sm">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </a>';
                                            }
                                            echo '</td>
                                                </tr>';
                                            $no++;
                                        }
                                        echo '</tbody>
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
<script type="text/javascript" language="javascript"
    src="http:////cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript"
    src="http://cdn.datatables.net/plug-ins/9dcbecd42ad/integration/bootstrap/3/dataTables.bootstrap.js"></script>
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
    $(document).ready(function () {
        $('.table-paginate').dataTable({
            "searching": false,
            "paging": false,
            "info": false,
            "lengthChange": false
        });

        // Set current date and time
        var currentDate = new Date('2025-02-17 13:05:45');
        $('#current-time').text(currentDate.toLocaleString());
        $('#current-user').text('digicraftindonesia');
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
            function () {
                document.location = "../logout";
            })
    }

    function pengajuanditerima(id) {
        swal({
            title: "Konfirmasi ?",
            text: "Apakah anda ingin menerima pengajuan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00ff00",
            confirmButtonText: "Terima",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        },
            function () {
                document.location = "pengajuan_diterima?id=" + id;
            })
    }

    function pengajuanditolak(id) {
        swal({
            title: "Konfirmasi ?",
            text: "Apakah anda ingin menolak pengajuan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF4A55",
            confirmButtonText: "Tolak",
            cancelButtonText: "Batal",
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        },
            function () {
                document.location = "pengajuan_ditolak?id=" + id;
            })
    }

    function pengajuandiselesaikan(id) {
        swal({
            title: "Konfirmasi ?",
            text: "Apakah anda ingin menyelesaikan pengajuan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00ff00",
            confirmButtonText: "Selesaikan",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        },
            function () {
                document.location = "system/proses_pengajuan_diselesaikan?id=" + id;
            })
    }

    $(function () {
        $("#datepicker1").datepicker({
            dateFormat: "dd-mm-yy",
            monthNames: ["Januari", "Febuari", "Maret",
                "April", "Mei", "Juni",
                "Juli", "Agustus", "September",
                "Oktober", "November", "December"],
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
        });

        $("#datepicker2").datepicker({
            dateFormat: "dd-mm-yy",
            monthNames: ["Januari", "Febuari", "Maret",
                "April", "Mei", "Juni",
                "Juli", "Agustus", "September",
                "Oktober", "November", "December"],
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"]
        });

        // Set default date range if not already set
        if (!$("#datepicker1").val()) {
            $("#datepicker1").datepicker("setDate", new Date());
        }
        if (!$("#datepicker2").val()) {
            $("#datepicker2").datepicker("setDate", new Date());
        }
    });
</script>

</html>
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
    <title>Dashboard</title>
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
                    <li class="active">
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
                        <a href="laporan">
                            <i class="pe pe-7s-notebook"></i> <!-- Changed to notebook icon -->
                            <p>Laporan</p>
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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title" align="center">
                                        Pengajuan Berstatus <br>
                                        <span class="badge menunggu indextitle upper">Menunggu</span>
                                    </h4>
                                </div>
                                <?php
                                $query_menunggu = "SELECT * FROM pengajuan WHERE status LIKE 'menunggu'";
                                $result_menunggu = mysqli_query($con, $query_menunggu);
                                $banyakdata_menunggu = $result_menunggu->num_rows;
                                ?>
                                <div align="center">
                                    <h1><?php echo $banyakdata_menunggu ?></h1>
                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <a href="pengajuan">
                                                <i class="fa fa-eye"></i> Lihat Semua Pengajuan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title" align="center">
                                        Pengajuan Berstatus <br>
                                        <span class="badge proses indextitle upper">Proses</span>
                                    </h4>
                                </div>
                                <?php
                                $query_proses = "SELECT * FROM pengajuan WHERE status LIKE 'proses'";
                                $result_proses = mysqli_query($con, $query_proses);
                                $banyakdata_proses = $result_proses->num_rows;
                                ?>
                                <div align="center">
                                    <h1><?php echo $banyakdata_proses ?></h1>
                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <a href="pengajuan">
                                                <i class="fa fa-eye"></i> Lihat Semua Pengajuan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title" align="center">
                                        Pengajuan Berstatus <br>
                                        <span class="badge proses indextitle upper">Selesai</span>
                                    </h4>
                                </div>
                                <?php
                                $query_selesai = "SELECT * FROM pengajuan WHERE status LIKE 'selesai'";
                                $result_selesai = mysqli_query($con, $query_selesai);
                                $banyakdata_selesai = $result_selesai->num_rows;
                                ?>
                                <div align="center">
                                    <h1><?php echo $banyakdata_selesai ?></h1>
                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <a href="pengajuan">
                                                <i class="fa fa-eye"></i> Lihat Semua Pengajuan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card ">
                                <div class="header">
                                    <h4 class="title">List Pengajuan</h4>
                                    <p class="category">Status Pengajuan :
                                        <span class="badge proses upper">proses</span>
                                    </p>
                                </div>
                                <div class="content">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <tbody>

                                                <?php
                                                $query_pengajuan = "SELECT a.id_pengajuan, a.event, a.id_user,  b.username, a.status
                                FROM pengajuan AS a INNER JOIN user AS b WHERE a.id_user = b.id_user
                                AND a.status = 'proses' LIMIT 7 ";
                                                $result_pengajuan = mysqli_query($con, $query_pengajuan);
                                                if (!$result_pengajuan) {
                                                    die("Query Error: " . mysqli_errno($con) .
                                                        " - " . mysqli_error($con));
                                                }
                                                if ($result_pengajuan->num_rows == 0) {
                                                    echo "<tr>
                    <td colspan='3'>Data Pengajuan Tidak Di temukan</td>
                </tr>";
                                                } else {
                                                    while ($data_pengajuan = mysqli_fetch_assoc($result_pengajuan)) {
                                                        echo '<tr>
                                                <td> ' . $data_pengajuan['event'] . ' - <b>' . $data_pengajuan['username'] . '</b></td>
                                                <td class="td-actions text-right">
                                                    <a href="detail_pengajuan?id=' . $data_pengajuan['id_pengajuan'] . '">
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
                                            <a href="pengajuan">
                                                <i class="fa fa-link"></i>
                                                Lihat Semua Pengajuan Proses
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Riwayat</h4>
                                </div>
                                <div class="content">
                                    <?php
                                    $query2 = "SELECT a.id_riwayat, a.kegiatan, a.id_pengajuan, b.event, 
                a.jenis_riwayat, a.kegiatan3, a.tanggal_kegiatan, b.id_user, a.notifikasi FROM riwayat 
                AS a INNER JOIN pengajuan AS b WHERE a.id_pengajuan = b.id_pengajuan
                ORDER BY id_riwayat DESC LIMIT 3";
                                    $result2 = mysqli_query($con, $query2);
                                    if (!$result2) {
                                        die("Query Error: " . mysqli_errno($con) .
                                            " - " . mysqli_error($con));
                                    }
                                    if ($result2->num_rows == 0) {
                                        echo "<p>Tidak ada riwayat kegiatan !</p>";
                                    } else {
                                        while ($data2 = mysqli_fetch_assoc($result2)) {
                                            echo '<a href="detail_pengajuan?id=' . $data2['id_pengajuan'] . '" style="color:black">
                                <div class="card">
                                    <div class="content">
                                        <input type="hidden" name="id_pengajuan" value="' . $data2['id_pengajuan'] . '">
                                        <h5><b>' . $data2['jenis_riwayat'] . ' </b> - <small>' . $data2['event'] . '</small></h5>
                                        <h5>Tanggal kegiatan : ' . tanggal_indo($data2['tanggal_kegiatan']) . '</h5>
                                    </div>
                                </div>
                            </a>';
                                        }
                                    }
                                    ?>

                                    <div class="footer">
                                        <hr>
                                        <div class="stats">
                                            <a href="riwayat"><i class="fa fa-link"></i> Lihat Semua Riwayat </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $query_catatan = "SELECT * FROM catatan";
                    $result_catatan = mysqli_query($con, $query_catatan);
                    if (!$result_catatan) {
                        die("Query Error: " . mysqli_errno($con) .
                            " - " . mysqli_error($con));
                    }
                    $data_catatan = mysqli_fetch_assoc($result_catatan);
                    ?>
                    <div class="col-md-12">
                        <div class="card">
                            <form id="form_catatan" method="post" action="system/proses_catatan">
                                <div class="header">
                                    <h4 class="title">Pemberitahuan</h4>
                                    <p class="category">Update Terakhir :
                                        <b><?php echo tanggal_indo($data_catatan['update_catatan']) ?></b></p>
                                </div>
                                <div class="content">
                                    <input type="hidden" name="id_catatan" id="form_catatan"
                                        value="<?php echo $data_catatan['id_catatan'] ?>">
                                    <div class="form-group">
                                        <textarea rows="5" class="form-control" placeholder="Tidak Ada Catatan !"
                                            name="catatan"
                                            id="form_catatan"><?php echo $data_catatan['catatan'] ?></textarea>
                                    </div>
                                    <div align="right">
                                        <button type="submit" name="input" rel="tooltip" title="Konfirmasi"
                                            class="btn btn-primary btn-fill">
                                            <i class="fa fa-check"></i> Ubah Catatan
                                        </button>
                                    </div>
                            </form>
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
if (isset($_GET['update'])) {
    $update = ($_GET["update"]);
    if ($update == "true") {
        echo '<script type="text/javascript">
            swal({
                title: "Terubah!",
                text: "Catatan telah diubah.",
                type: "success",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            })
    </script>';
    }
}
?>

<script type="text/javascript">
    $(document).ready(function () {
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
            function () {
                document.location = "../logout";
            })
    }
</script>

</html>
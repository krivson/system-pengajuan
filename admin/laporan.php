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
    if ($data_cek['role'] != "manajemen") {
        echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    }
}

function tanggal_indo($tanggal)
{
    $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Laporan Pengajuan</title>
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
                    <li class="active">
                        <a href="laporan">
                            <i class="pe pe-7s-notebook"></i>
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Filter Laporan Pengajuan</h4>
                                </div>
                                <div class="content">
                                    <form method="post" action="generate_pdf.php" target="_blank">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Pengajuan</label>
                                                    <select class="form-control" name="status" required>
                                                        <option value="all">Semua Status</option>
                                                        <option value="menunggu">Menunggu</option>
                                                        <option value="proses">Proses</option>
                                                        <option value="selesai">Selesai</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-info btn-fill pull-right">
                                            <i class="fa fa-print"></i> Cetak Laporan
                                        </button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Preview Data Pengajuan</h4>
                                </div>
                                <div class="content table-responsive table-full-width">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Event</th>
                                                <th>Pengaju</th>
                                                <th>Jenis</th>
                                                <th>Tanggal</th>
                                                <th>Jadwal</th>
                                                <th>Biaya</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $status_filter = isset($_POST['status']) ? $_POST['status'] : 'all';
                                            $jenis_filter = isset($_POST['jenis_pengajuan']) ? $_POST['jenis_pengajuan'] : 'all';

                                            $query = "SELECT a.*, b.username 
                                                        FROM pengajuan a 
                                                        INNER JOIN user b ON a.id_user = b.id_user 
                                                        WHERE 1=1";

                                            if ($status_filter != 'all') {
                                                $query .= " AND a.status = '$status_filter'";
                                            }

                                            $query .= " ORDER BY a.tanggal_pengajuan DESC LIMIT 10";

                                            $result = mysqli_query($con, $query);
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>
                                                        <td>" . $no++ . "</td>
                                                        <td>" . $row['event'] . "</td>
                                                        <td>" . $row['username'] . "</td>
                                                        <td>" . $row['jenis_pengajuan'] . "</td>
                                                        <td>" . tanggal_indo($row['tanggal_pengajuan']) . "</td>
                                                        <td>" . ($row['jadwal_pelaksanaan'] != '0000-00-00' ? tanggal_indo($row['jadwal_pelaksanaan']) : '-') . "</td>
                                                        <td>Rp. " . number_format($row['biaya'], 0, ',', '.') . "</td>
                                                        <td><span class='badge " . $row['status'] . "'>" . $row['status'] . "</span></td>
                                                    </tr>";
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

<!-- Scripts -->
<script src="../assets/js/jquery-1.10.2.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../assets/dist/sweetalert-dev.js"></script>
<script>
    $(function () {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            changeMonth: true,
            changeYear: true
        });
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
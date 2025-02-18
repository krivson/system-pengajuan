<?php
/**
 * System Pengajuan - Form Page
 * 
 * This file handles the submission form for event proposals
 */

// Include database connection and start session
include "system/koneksi.php";
session_start();

// Authentication Check
$logged_in = false;
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='login?proses=error ';</script>";
} else {
    $logged_in = true;

    // Check user role
    $query_cek = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
    $result_cek = mysqli_query($con, $query_cek);
    $data_cek = mysqli_fetch_assoc($result_cek);

    if ($data_cek['role'] != "tim") {
        echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    }
}

/**
 * Formats date to Indonesian format
 */
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

// Get user data for display
$query_login = "SELECT * FROM user WHERE email ='$_SESSION[email]'";
$result_login = mysqli_query($con, $query_login);
if (!$result_login) {
    die("Query Error: " . mysqli_errno($con) . " - " . mysqli_error($con));
}
$data_login = mysqli_fetch_assoc($result_login);
$id_login = $data_login["id_user"];
$username_login = $data_login["username"];

// Get notification count
$query_notifikasi = "SELECT a.id_riwayat FROM riwayat 
    AS a INNER JOIN pengajuan AS b WHERE a.id_pengajuan = b.id_pengajuan
    AND b.id_user = '$id_login' AND a.notifikasi= '1'";
$result_notifikasi = mysqli_query($con, $query_notifikasi);
$banyakdata_notifikasi = $result_notifikasi->num_rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Pengajuan</title>

    <!-- Stylesheets -->
    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />
    <link href="assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/dist/sweetalert.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar1.jpg">
            <div class="sidebar-wrapper">
                <!-- Logo -->
                <div class="logo">
                    <a href="index" class="simple-text">
                        System Pengajuan<br>
                        <small>( TIM ) - <?php echo $username_login ?></small>
                    </a>
                </div>

                <!-- Navigation Menu -->
                <ul class="nav">
                    <li><a href="index"><i class="pe pe-7s-home"></i>
                            <p>Home</p>
                        </a></li>
                    <li class="active"><a href="pengajuan"><i class="pe pe-7s-note2"></i>
                            <p>Pengajuan</p>
                        </a></li>
                    <li><a href="riwayat"><i class="pe pe-7s-timer"></i>
                            <p>Riwayat</p>
                        </a></li>
                    <li>
                        <a href="notifikasi">
                            <i class="pe pe-7s-bell"></i>
                            <p>Notifikasi
                                <?php if ($banyakdata_notifikasi > 0): ?>
                                    <span class='new badge'>
                                        <?php echo $banyakdata_notifikasi <= 10 ? $banyakdata_notifikasi : "10 +" ?>
                                    </span>
                                <?php endif; ?>
                            </p>
                        </a>
                    </li>
                    <li><a href="profil"><i class="pe pe-7s-user"></i>
                            <p>Profile</p>
                        </a></li>
                    <li><a href="#" onclick="logout()"><i class="pe pe-7s-back"></i>
                            <p>Log out</p>
                        </a></li>
                </ul>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Submission Form Card -->
                            <div class="card">
                                <!-- Card Header -->
                                <div class="header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="title">Pengajuan</h4>
                                        </div>
                                        <div class="col-md-6" align="right">
                                            <small><?php echo tanggal_indo(date("Y-m-d")); ?></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Content -->
                                <div class="content">
                                    <form id="form_user" method="post" action="system/proses_tambah_pengajuan"
                                        enctype="multipart/form-data">
                                        <!-- Event Details -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Event</label>
                                                    <input type="text" name="event" class="form-control"
                                                        placeholder="Event" required
                                                        oninvalid="this.setCustomValidity('Mohon isi form berikut !')"
                                                        oninput="setCustomValidity('')">
                                                    <input type="hidden" name="id_pengaju"
                                                        value="<?php echo $id_login ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Event Date -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Tanggal Pelaksanaan Event</label>
                                                    <input type="date" name="jadwal_pelaksanaan" class="form-control"
                                                        required
                                                        oninvalid="this.setCustomValidity('Mohon isi tanggal pelaksanaan!')"
                                                        oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submission Type and Cost -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Jenis Pengajuan</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="jenis_pengajuan" class="form-control"
                                                            placeholder="Jenis pengajuan" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Biaya</label>
                                                    <div class="row">
                                                        <div class="col-md-1">Rp.</div>
                                                        <div class="col-md-10">
                                                            <input type="number" name="biaya" class="form-control"
                                                                placeholder="Biaya" required>
                                                        </div>
                                                        <div class="col-md-1">,00,-</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Additional Information -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <textarea rows="5" name="keterangan" class="form-control"
                                                        placeholder="Silakan Tulis Keterangan Anda Disini"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Alasan</label>
                                                    <textarea rows="5" name="alasan" class="form-control"
                                                        placeholder="Silakan Tulis Alasan Anda Disini"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Time Estimate -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Estimasi Waktu</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="estimasi_waktu" class="form-control"
                                                            placeholder="Estimasi waktu" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="row">
                                            <div class="col-md-12" align="right">
                                                <a href="pengajuan">
                                                    <button type="button" class="btn btn-info btn-fill">
                                                        <i class="fa fa-arrow-left"></i> Batal
                                                    </button>
                                                </a>
                                                <button type="submit" name="input" class="btn btn-primary btn-fill">
                                                    <i class="fa fa-check"></i> Ajukan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/dist/sweetalert-dev.js"></script>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
    <script src="assets/js/chartist.min.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
    <script src="assets/js/light-bootstrap-dashboard.js"></script>
    <script src="assets/js/demo.js"></script>

    <!-- Process Messages -->
    <?php if (isset($_GET['proses'])): ?>
        <script type="text/javascript">
            <?php
            $messages = [
                'error' => 'Terjadi kesalahan !',
                'size' => 'Ukuran gambar terlalu besar !',
                'format' => 'Format gambar tidak sesuai !'
            ];

            if (isset($messages[$_GET['proses']])) {
                echo "swal({
                title: 'Mohon Maaf!',
                text: '{$messages[$_GET['proses']]}',
                type: 'error',
                showConfirmButton: true,
                confirmButtonColor: '#00ff00'
            });";
            }
            ?>
        </script>
    <?php endif; ?>

    <!-- Custom Scripts -->
    <script type="text/javascript">
        $(document).ready(function () {
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

        function logout() {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin keluar",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00",
                confirmButtonText: "Logout",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            }, function () {
                document.location = "logout";
            });
        }
    </script>
</body>

</html>
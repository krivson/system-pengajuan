<?php
include 'system/koneksi.php';
session_start();

// Security check
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>document.location='login?proses=error';</script>";
    exit();
}

// User role validation
$stmt = mysqli_prepare($con, "SELECT * FROM user WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$data_cek = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($data_cek['role'] !== "tim") {
    echo "<script type='text/javascript'>window.location=history.go(-1);</script>";
    exit();
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

$id_login = $data_cek["id_user"];
$username_login = $data_cek["username"];

// Helper function to format date for database query
function formatDateForDB($date)
{
    if (empty($date))
        return null;
    $formatted = DateTime::createFromFormat('d-m-Y', $date);
    return $formatted ? $formatted->format('Y-m-d') : null;
}

// Build query with proper parameter binding
$query = "SELECT a.*, b.username 
          FROM pengajuan a 
          INNER JOIN user b ON a.id_user = b.id_user 
          WHERE b.id_user = ?";
$params = [$id_login];
$types = "i";

// Add filters
if (!empty($_GET['judul'])) {
    $query .= " AND a.event LIKE ?";
    $params[] = "%" . $_GET['judul'] . "%";
    $types .= "s";
}

if (!empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
    $start_date = formatDateForDB($_GET['tanggal_awal']);
    $end_date = formatDateForDB($_GET['tanggal_akhir']);
    if ($start_date && $end_date) {
        $query .= " AND (a.tanggal_pengajuan BETWEEN ? AND ?)";
        $params[] = $start_date;
        $params[] = $end_date;
        $types .= "ss";
    }
}

if (!empty($_GET['status']) && $_GET['status'] !== 'semua') {
    $query .= " AND a.status = ?";
    $params[] = $_GET['status'];
    $types .= "s";
}

$query .= " ORDER BY a.id_pengajuan DESC";

// Prepare and execute the query
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    die("Query preparation failed: " . mysqli_error($con));
}

// Get date ranges for filter
$date_query = "SELECT MIN(tanggal_pengajuan) as min_date, MAX(tanggal_pengajuan) as max_date 
               FROM pengajuan WHERE id_user = ?";
$date_stmt = mysqli_prepare($con, $date_query);
mysqli_stmt_bind_param($date_stmt, "i", $id_login);
mysqli_stmt_execute($date_stmt);
$date_range = mysqli_fetch_assoc(mysqli_stmt_get_result($date_stmt));
$min_date = date('d-m-Y', strtotime($date_range['min_date'] ?: date('Y-m-d')));
$max_date = date('d-m-Y', strtotime($date_range['max_date'] ?: date('Y-m-d')));

// Helper function to generate action buttons
function generateActionButtons($id, $status)
{
    $buttons = [];

    // View button - always shown
    $buttons[] = sprintf(
        '<a href="detail_pengajuan?id=%d"><button type="button" class="btn btn-info btn-fill btn-sm"><i class="fa fa-eye"></i></button></a>',
        $id
    );

    if ($status === 'menunggu') {
        // Edit button
        $buttons[] = sprintf(
            '<a href="edit_pengajuan?id=%d"><button type="button" class="btn btn-primary btn-fill btn-sm"><i class="fa fa-edit"></i></button></a>',
            $id
        );
        // Cancel button
        $buttons[] = sprintf(
            '<button onclick="batal(%d)" type="button" class="btn btn-danger btn-fill btn-sm"><i class="fa fa-close"></i></button>',
            $id
        );
    } elseif ($status === 'selesai') {
        // Delete button
        $buttons[] = sprintf(
            '<button onclick="hapus(%d)" type="button" class="btn btn-danger btn-fill btn-sm"><i class="fa fa-trash"></i></button>',
            $id
        );
    }

    return implode(' ', $buttons);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Pengajuan</title>

    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/animate.min.css" rel="stylesheet">
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet">
    <link href="assets/css/demo.css" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dist/sweetalert.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/datepicker.css">

    <style>
        .badge {
            padding: 5px 10px;
            border-radius: 3px;
        }

        .badge.menunggu {
            background: #f0ad4e;
            color: white;
        }

        .badge.proses {
            background: #5bc0de;
            color: white;
        }

        .badge.selesai {
            background: #5cb85c;
            color: white;
        }

        .upper {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="assets/img/sidebar1.jpg">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="index" class="simple-text">
                        System Pengajuan<br>
                        <small>(TIM) - <?php echo htmlspecialchars($username_login); ?></small>
                    </a>
                </div>
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
                            <?php
                            $query_notifikasi = "SELECT COUNT(*) as count FROM riwayat a 
                                               INNER JOIN pengajuan b ON a.id_pengajuan = b.id_pengajuan 
                                               WHERE b.id_user = '$id_login' AND a.notifikasi = '1'";
                            $result_notifikasi = mysqli_query($con, $query_notifikasi);
                            $notif_count = mysqli_fetch_assoc($result_notifikasi)['count'];
                            ?>
                            <p>
                                Notifikasi
                                <?php if ($notif_count > 0): ?>
                                    <span class="new badge">
                                        <?php echo $notif_count > 10 ? '10+' : $notif_count; ?>
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

        <div class="main-panel">
            <div class="content">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <!-- Header -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="title">Data Pengajuan</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="tambah_pengajuan">
                                        <button type="button" class="btn btn-primary btn-fill">
                                            <i class="fa fa-plus"></i> Tambah Pengajuan
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <!-- Filter Form -->
                            <form id="form_pencarian" action="?" method="get" class="mt-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Judul Pengajuan</label>
                                            <input type="text" name="judul" class="form-control"
                                                value="<?= isset($_GET['judul']) ? htmlspecialchars($_GET['judul']) : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tanggal Pengajuan Awal</label>
                                            <input type="text" name="tanggal_awal" id="datepicker1" class="form-control"
                                                value="<?= isset($_GET['tanggal_awal']) ? htmlspecialchars($_GET['tanggal_awal']) : $min_date ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tanggal Pengajuan Akhir</label>
                                            <input type="text" name="tanggal_akhir" id="datepicker2"
                                                class="form-control"
                                                value="<?= isset($_GET['tanggal_akhir']) ? htmlspecialchars($_GET['tanggal_akhir']) : $max_date ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <?php
                                                $statuses = [
                                                    'semua' => 'Semua',
                                                    'menunggu' => 'Menunggu',
                                                    'proses' => 'Proses',
                                                    'selesai' => 'Selesai'
                                                ];
                                                foreach ($statuses as $value => $label):
                                                    $selected = (isset($_GET['status']) && $_GET['status'] === $value) ? 'selected' : '';
                                                    ?>
                                                    <option value="<?= $value ?>" <?= $selected ?>><?= $label ?></option>
                                                <?php endforeach; ?>
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

                            <!-- Table -->
                            <div class="content table-responsive table-full-width">
                                <table
                                    class="table table-hover table-striped <?= mysqli_num_rows($result) > 0 ? 'table-paginate' : '' ?>">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Event</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jadwal Pelaksanaan</th> <!-- New column -->
                                            <th>Biaya</th>
                                            <th>Status</th>
                                            <th>Tindak Lanjut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($result) === 0): ?>
                                            <tr>
                                                <td colspan="8" class="text-center"> <!-- Update colspan to 8 -->
                                                    Tidak ada pengajuan<br>
                                                    <a href="pengajuan">
                                                        <button type="button" class="btn btn-primary btn-fill btn-sm">
                                                            <i class="fa fa-refresh"></i> Refresh data
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php
                                            $no = 1;
                                            while ($data = mysqli_fetch_assoc($result)):
                                                ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($data['event']) ?></td>
                                                    <td><?= htmlspecialchars($data['jenis_pengajuan']) ?></td>
                                                    <td><?= tanggal_indo($data['tanggal_pengajuan']) ?></td>
                                                    <td>
                                                        <?php
                                                        if (!empty($data['jadwal_pelaksanaan']) && $data['jadwal_pelaksanaan'] != '0000-00-00') {
                                                            echo tanggal_indo($data['jadwal_pelaksanaan']);
                                                        } else {
                                                            echo '<span class="text-muted">-</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>Rp <?= number_format($data['biaya'], 0, ',', '.') ?></td>
                                                    <td>
                                                        <?php if ($data['status'] === 'proses'): ?>
                                                            <span>Estimasi waktu: <?= $data['estimasi_waktu'] ?> hari</span><br>
                                                        <?php endif; ?>
                                                        <span
                                                            class="badge <?= $data['status'] ?> upper"><?= $data['status'] ?></span>
                                                    </td>
                                                    <td><?= generateActionButtons($data['id_pengajuan'], $data['status']) ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
    <script src="assets/js/bootstrap-notify.js"></script>
    <script src="assets/js/light-bootstrap-dashboard.js"></script>
    <script src="assets/dist/sweetalert-dev.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('.table-paginate').dataTable({
                "searching": false,
                "paging": false,
                "info": false,
                "lengthChange": false
            });

            // Initialize Datepicker
            $("#datepicker1, #datepicker2").datepicker({
                dateFormat: "dd-mm-yy",
                monthNames: ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                dayNamesMin: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"]
            });
        });

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

        function batal(id) {
            swal({
                title: "Konfirmasi ?",
                text: "Apakah anda ingin membatalkan pengajuan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#00cc00",
                confirmButtonText: "Iya",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            }, function () {
                document.location = "system/hapus_pengajuan?id=" + id;
            });
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
            }, function () {
                document.location = "system/hapus_pengajuan?id=" + id;
            });
        }
    </script>
    <?php if (isset($_GET['proses'])): ?>
        <script>
            swal({
                title: "<?php echo $_GET['proses'] == 'delete' ? 'Terhapus!' : 'Tertambah!'; ?>",
                text: "Pengajuan telah <?php echo $_GET['proses'] == 'delete' ? 'dihapus' : 'ditambah'; ?>.",
                type: "success",
                showConfirmButton: true,
                confirmButtonColor: "#00ff00"
            });
        </script>
    <?php endif; ?>
</body>

</html>
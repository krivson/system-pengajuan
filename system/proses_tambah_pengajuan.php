<?php
/**
 * Process Form Submission
 * Handles the submission of new proposals/pengajuan
 */

session_start();
include 'koneksi.php';

// Initialize response
$response = [
  'success' => false,
  'message' => '',
  'redirect' => ''
];

try {
  // Get current date
  $tgl = date('Y-m-d');

  // Sanitize and validate input
  $formData = [
    'event' => filter_input(INPUT_POST, 'event', FILTER_SANITIZE_STRING),
    'id_pengaju' => filter_input(INPUT_POST, 'id_pengaju', FILTER_VALIDATE_INT),
    'estimasi_waktu' => filter_input(INPUT_POST, 'estimasi_waktu', FILTER_SANITIZE_STRING),
    'jenis_pengajuan' => filter_input(INPUT_POST, 'jenis_pengajuan', FILTER_SANITIZE_STRING),
    'biaya' => filter_input(INPUT_POST, 'biaya', FILTER_VALIDATE_INT),
    'alasan' => filter_input(INPUT_POST, 'alasan', FILTER_SANITIZE_STRING),
    'keterangan' => filter_input(INPUT_POST, 'keterangan', FILTER_SANITIZE_STRING) ?: '-',
    'jadwal_pelaksanaan' => filter_input(INPUT_POST, 'jadwal_pelaksanaan', FILTER_SANITIZE_STRING)
  ];

  // Validate required fields
  if (!$formData['event'] || !$formData['id_pengaju']) {
    throw new Exception("Required fields are missing");
  }

  // Prepare query
  $query = "INSERT INTO pengajuan SET 
        event = ?,
        id_user = ?,
        id_jenis_pengajuan = FLOOR(10000000000 + RAND() * 90000000000),
        jenis_pengajuan = ?,
        tanggal_pengajuan = ?,
        jadwal_pelaksanaan = ?,
        biaya = ?,
        alasan = ?,
        keterangan = ?,
        status = 'menunggu',
        update_pengajuan = ?,
        estimasi_waktu = ?";

  // Prepare and execute statement
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param(
    $stmt,
    'sisssissss',
    $formData['event'],
    $formData['id_pengaju'],
    $formData['jenis_pengajuan'],
    $tgl,
    $formData['jadwal_pelaksanaan'],
    $formData['biaya'],
    $formData['alasan'],
    $formData['keterangan'],
    $tgl,
    $formData['estimasi_waktu']
  );

  $result = mysqli_stmt_execute($stmt);

  if ($result) {
    $response['success'] = true;
    $response['redirect'] = '../pengajuan?proses=tambah';
  } else {
    throw new Exception("Failed to insert data: " . mysqli_error($con));
  }

} catch (Exception $e) {
  $response['message'] = $e->getMessage();
  $response['redirect'] = '../tambah_pengajuan?proses=error';
}

// Close database connection
mysqli_close($con);

// Redirect based on result
header("Location: " . $response['redirect']);
exit();
?>
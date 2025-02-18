<?php
require('fpdf/fpdf.php');

// Koneksi ke database
$con = mysqli_connect("localhost", "root", "", "nama_database");
if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari database
$query = "SELECT a.id_pengajuan, a.event, a.id_user, b.username, a.id_jenis_pengajuan, 
                 a.jenis_pengajuan, a.tanggal_pengajuan, a.biaya, a.status, a.estimasi_waktu 
          FROM pengajuan AS a
          INNER JOIN user AS b ON a.id_user = b.id_user
          INNER JOIN jenis_pengajuan AS c ON a.id_jenis_pengajuan = c.id_jenis_pengajuan
          ORDER BY a.id_pengajuan DESC";
$result = mysqli_query($con, $query);

// Buat objek PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Laporan Pengajuan', 0, 1, 'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(40, 10, 'Event', 1, 0, 'C');
$pdf->Cell(40, 10, 'User', 1, 0, 'C');
$pdf->Cell(30, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell(25, 10, 'Biaya', 1, 0, 'C');
$pdf->Cell(25, 10, 'Status', 1, 1, 'C');

// Isi tabel
$pdf->SetFont('Arial', '', 10);
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(40, 10, $row['event'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['username'], 1, 0, 'C');
    $pdf->Cell(30, 10, $row['tanggal_pengajuan'], 1, 0, 'C');
    $pdf->Cell(25, 10, number_format($row['biaya']), 1, 0, 'C');
    $pdf->Cell(25, 10, ucfirst($row['status']), 1, 1, 'C');
}

// Output PDF
$pdf->Output('D', 'Laporan_Pengajuan.pdf');
?>

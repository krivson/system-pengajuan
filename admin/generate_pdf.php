<?php
session_start();
include '../system/koneksi.php';
require('../fpdf/fpdf.php');

if (empty($_SESSION['email'])) {
    header("Location: ../login");
    exit();
}

class PDF extends FPDF
{
    private $isFirstPage = true;

    function Header()
    {
        // Set margins
        $this->SetMargins(15, 15, 15);

        // Logo
        $this->Image('../assets/img/icon.png', 15, 10, 25);

        // Header text
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(25); // Space after logo
        $this->Cell(237, 10, 'LAPORAN PENGAJUAN', 0, 0, 'C');

        // Company details
        $this->Ln(8);
        $this->SetFont('Arial', '', 12);
        $this->Cell(25); // Space after logo
        $this->Cell(237, 7, 'SISTEM PENGAJUAN', 0, 0, 'C');

        $this->Ln(7);
        $this->SetFont('Arial', '', 10);

        // Separator line
        $this->Ln(10);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(15, 42, 282, 42);
        $this->Ln(15);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(133.5, 10, 'Laporan Pengajuan', 0, 0, 'L');
        $this->Cell(133.5, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
}

// Initialize PDF
$pdf = new PDF('L');
$pdf->SetAutoPageBreak(true, 15);
$pdf->AliasNbPages();
$pdf->AddPage('L');

// Get filter parameters
$status = $_POST['status'];

// Display filter information
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(267, 10, 'DATA PENGAJUAN', 0, 1, 'L');

// Status information
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 8, 'Status', 0);
$pdf->Cell(5, 8, ':', 0);
$pdf->Cell(100, 8, ($status == 'all' ? 'Semua Status' : ucfirst($status)), 0, 1);

$pdf->Ln(5);

// Table Header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200);

// Define column widths (total = 267)
$w = array(10, 57, 35, 35, 35, 35, 35, 25);

// Header
$header = array('No', 'Event', 'Pengaju', 'Jenis', 'Tgl Pengajuan', 'Jadwal', 'Biaya', 'Status');
foreach ($header as $i => $h) {
    $pdf->Cell($w[$i], 7, $h, 1, 0, 'C', true);
}
$pdf->Ln();

// Data
$query = "SELECT p.*, u.username 
          FROM pengajuan p 
          INNER JOIN user u ON p.id_user = u.id_user";

if ($status != 'all') {
    $query .= " WHERE p.status = '$status'";
}

$query .= " ORDER BY p.tanggal_pengajuan DESC";
$result = mysqli_query($con, $query);

$pdf->SetFont('Arial', '', 9);
$no = 1;
$total_biaya = 0;

while ($row = mysqli_fetch_assoc($result)) {
    // Check if we need a new page
    if ($pdf->GetY() > 180) {
        $pdf->AddPage('L');
        // Reprint headers
        $pdf->SetFont('Arial', 'B', 10);
        foreach ($header as $i => $h) {
            $pdf->Cell($w[$i], 7, $h, 1, 0, 'C', true);
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
    }

    $pdf->Cell($w[0], 7, $no++, 1, 0, 'C');
    $pdf->Cell($w[1], 7, $row['event'], 1);
    $pdf->Cell($w[2], 7, $row['username'], 1);
    $pdf->Cell($w[3], 7, $row['jenis_pengajuan'], 1);
    $pdf->Cell($w[4], 7, tanggal_indo($row['tanggal_pengajuan']), 1);
    $pdf->Cell($w[5], 7, ($row['jadwal_pelaksanaan'] != '0000-00-00' ? tanggal_indo($row['jadwal_pelaksanaan']) : '-'), 1);
    $pdf->Cell($w[6], 7, 'Rp. ' . number_format($row['biaya'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell($w[7], 7, ucfirst($row['status']), 1);
    $pdf->Ln();

    $total_biaya += $row['biaya'];
}

// Print total
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(array_sum($w) - 35, 7, 'Total Biaya', 1, 0, 'R');
$pdf->Cell(35, 7, 'Rp. ' . number_format($total_biaya, 0, ',', '.'), 1, 1, 'R');

// Format date for filename
$filename = 'Laporan_Pengajuan_' . ($status == 'all' ? 'Semua' : ucfirst($status)) . '_' . date('Y-m-d') . '.pdf';
$pdf->Output('I', $filename);

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
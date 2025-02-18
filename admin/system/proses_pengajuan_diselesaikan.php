<!DOCTYPE html>
<html>
<head>
    <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php 
include '../../system/koneksi.php';
$id_pengajuan = $_GET['id']; 
 
$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

$query = "UPDATE pengajuan SET status='selesai', update_pengajuan='$tgl' WHERE id_pengajuan='$id_pengajuan'";
  $result = mysqli_query($con, $query);
  // periska query apakah ada error
  if(!$result){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));
  }
 
$query2 = "INSERT INTO riwayat SET kegiatan='Telah Melakukan Menyelesaian Pengajuan', kegiatan2='Pengajuan Diselesaikan',
          kegiatan3='Pengajuan Anda Telah Diselesaikan Oleh Pihak Manajemen', jenis_riwayat='Penyelesaian', 
          id_pengajuan='$id_pengajuan', tanggal_kegiatan='$tgl', notifikasi='1' ";
  $result2 = mysqli_query($con, $query2);

  if(!$result2){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));
  }

header("location:../detail_pengajuan?id=$id_pengajuan&proses=selesai"); 
?> 
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php 
include '../../system/koneksi.php';
$id_pengajuan = $_POST['id_pengajuan']; 
$jadwal_pelaksanaan = $_POST['jadwal_pelaksanaan'];
$ctt = $_POST['catatan']; 
$tanggal_pelaksanaan = date('Y-m-d', strtotime($jadwal_pelaksanaan));
  
$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

if($ctt == ""){
  $catatan = "-";
}else{
  $catatan = $ctt;
}

$query = "UPDATE pengajuan SET jadwal_pelaksanaan='$tanggal_pelaksanaan', catatan='$catatan', status='proses', update_pengajuan='$tgl' WHERE id_pengajuan='$id_pengajuan'";
  $result = mysqli_query($con, $query);
  if(!$result){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));
  } 

$query2 = "INSERT INTO riwayat SET kegiatan='Telah Melakukan Perubahan Pengajuan', kegiatan2='Pengajuan Diubah',
          kegiatan3 = 'Pengajuan Anda Telah Diubah Oleh Pihak Manajemen', catatan = '$catatan', jenis_riwayat='Pengubahan',
          id_pengajuan='$id_pengajuan', tanggal_kegiatan='$tgl',  notifikasi='1' ";
  $result2 = mysqli_query($con, $query2);

  if(!$result2){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));
  }

header("location:../detail_pengajuan?id=$id_pengajuan&proses=edit"); 
?>

</body>
</html>
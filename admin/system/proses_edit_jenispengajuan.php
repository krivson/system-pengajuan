<!DOCTYPE html>
<html>
<head>
    <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">
 
<div id="loader"></div>

<?php 
include '../../system/koneksi.php';
$id = $_POST['id'];
$jenis_pengajuan = $_POST['jenis_pengajuan'];
$deskripsi = $_POST['deskripsi'];

$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

$query = "UPDATE jenis_pengajuan SET jenis_pengajuan='$jenis_pengajuan', deskripsi='$deskripsi' WHERE id_jenis_pengajuan ='$id'";
  $result = mysqli_query($con, $query);
  // periska query apakah ada error
  if(!$result){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));

  }
header("location:../jenis_pengajuan?proses=ubah"); 
?>
</body>
</html>
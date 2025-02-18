<!DOCTYPE html>
<html>
<head>
    <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php 
include '../../system/koneksi.php';

$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);
date_default_timezone_set('Asia/Jakarta');
$jam=date("H:i:s");

    $id = ($_GET["id"]);

$query = "UPDATE user SET role='manajemen', update_akun='$tgl $jam' WHERE id_user='$id'";
  $result = mysqli_query($con, $query);
  if(!$result){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));
  }
        header('location:../detail_user?id='.$id.'&proses=edit');  
?>
 
</body>
</html>
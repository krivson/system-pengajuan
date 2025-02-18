<!DOCTYPE html>
<html>
<head>
    <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php 
  include("../../system/koneksi.php");

$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

  if (isset($_GET["id"])) {

    $id = $_GET["id"];

    //jalankan query DELETE untuk menghapus data
    $query = "DELETE FROM user WHERE id_user='$id'";
    $hasil_query = mysqli_query($con, $query);


    $query2 = "DELETE FROM pengajuan WHERE id_user='$id'";
    $hasil2 = mysqli_query($con, $query2);

    //periksa query, apakah ada kesalahan
    if(!$hasil_query) {
      die ("Gagal menghapus data: ".mysqli_errno($con).
           " - ".mysqli_error($con));
    }

  }
header("location:../user?proses=delete"); 
?>
</body>
</html>
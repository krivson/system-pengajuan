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
    $query = "DELETE FROM jenis_pengajuan WHERE id_jenis_pengajuan='$id'";
    $hasil_query = mysqli_query($con, $query);

    $query2 = "DELETE FROM pengajuan WHERE id_jenis_pengajuan='$id'";
    $hasil_query2 = mysqli_query($con, $query2);
    
      if(!$hasil_query) {
        die ("Gagal menghapus data: ".mysqli_errno($con).
            " - ".mysqli_error($con));
      } 
  }

 
  header("location:../jenis_pengajuan?proses=hapus");
?>

</body>
</html>
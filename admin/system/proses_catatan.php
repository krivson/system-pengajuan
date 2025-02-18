<!DOCTYPE html>
<html> 
<head>
    <link href="../../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">
 
<div id="loader"></div>

<?php 
include '../../system/koneksi.php';
$id= $_POST['id_catatan'];
$catatan = $_POST['catatan'];
 
$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

$query = "UPDATE catatan SET catatan='$catatan', update_catatan='$tgl' WHERE id_catatan ='$id'";
echo $query;
  $result = mysqli_query($con, $query);
  // periska query apakah ada error
  if(!$result){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));
  }
  
header("location:../index?update=true"); 
?>

</body>
</html>
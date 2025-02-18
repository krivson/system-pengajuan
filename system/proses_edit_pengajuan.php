<!DOCTYPE html>
<html>
<head>
    <link href="../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php 
include 'koneksi.php';

$id = $_GET['id'];
$event = $_POST['event'];
$jenis_pengajuan = $_POST['jenis_pengajuan'];
$biaya = $_POST['biaya'];
$als = $_POST['alasan'];

	if($als == ""){
      $alasan = "-";
    }else {
      $alasan = $als;
    }

$ket = $_POST['keterangan'];
    if($ket == ""){
      $keterangan = "-";
    }else {
      $keterangan = $ket;
    }

$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);


			$query = "UPDATE pengajuan SET event='$event'
				, jenis_pengajuan='$jenis_pengajuan', tanggal_pengajuan='$tgl'
				,  biaya='$biaya',alasan='$alasan'
				, keterangan ='$keterangan' WHERE id_pengajuan='".$id."'";

 
		$sql = mysqli_query($con, $query); 
		if($sql){ 
				header("location: ../detail_pengajuan?id=$id&proses=edit"); 
		}else{
				header("location:../edit_pengajuan?proses=error"); 
		}
?>

</body>
</html>
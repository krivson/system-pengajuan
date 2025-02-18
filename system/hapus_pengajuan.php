<!DOCTYPE html>
<html>
<head>
    <link href="../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php

include "koneksi.php"; 

$id = $_GET['id'];

$query = "SELECT * FROM pengajuan WHERE id_pengajuan='".$id."'";
$sql = mysqli_query($con, $query); 
$data = mysqli_fetch_array($sql); 

if(is_file("../image/".$data['gambar'])) 
			unlink("../image/".$data['gambar']); 

$query2 = "DELETE FROM pengajuan WHERE id_pengajuan='".$id."'";
$sql2 = mysqli_query($con, $query2);

$query3 = "DELETE FROM riwayat WHERE id_pengajuan='".$id."'";
$sql3 = mysqli_query($con, $query3);

if($sql2){ 
	if($sql3){
		header("location:../pengajuan?proses=delete"); 
	}else{
		header("location:../pengajuan?proses=error"); 
	}
}else{
	header("location:../pengajuan?proses=error"); 
}
?>
  
</body>
</html>
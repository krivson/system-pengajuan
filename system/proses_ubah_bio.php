<!DOCTYPE html>
<html>
<head>
    <link href="../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php 
include 'koneksi.php';
$id = $_POST['id'];
$username = $_POST['username'];
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$alamat = $_POST['alamat'];
$nohp = $_POST['nohp'];
$password = $_POST['password'];
$hash=md5($password);
 
$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

		$query_cek = "SELECT password FROM user WHERE id_user='".$id."'";
		$sql_cek = mysqli_query($con, $query_cek); 
		$data_cek = mysqli_fetch_array($sql_cek); 

    if( $hash == $data_cek['password']){
      $query = "UPDATE user SET username='$username', 
                nama_depan='$nama_depan', nama_belakang='$nama_belakang', 
                no_hp='$nohp', alamat='$alamat', update_akun='$tgl' 
                WHERE id_user='$id'";
               
      $result = mysqli_query($con, $query);
      header("location:../profil?proses=edit"); 
    }

    else {
      header("location:../ubah_bio?error=true"); 
    }
?>
</body>
</html>
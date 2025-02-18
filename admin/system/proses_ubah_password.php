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
$password_baru = $_POST['password_baru'];
$konfirmasi_password = $_POST['konfirmasi_password'];
$hash_baru=md5($password_baru);
$password_lama = $_POST['password_lama'];
$hash=md5($password_lama);
  
$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal); 

if($password_baru == $konfirmasi_password){
  
		$query_cek = "SELECT password FROM user WHERE id_user='".$id."'";
		$sql_cek = mysqli_query($con, $query_cek); 
		$data_cek = mysqli_fetch_array($sql_cek);  

    if( $hash == $data_cek['password']){
      $query = "UPDATE user SET password='$hash_baru',
               update_akun='$tgl' WHERE id_user='$id'";
               
      $result = mysqli_query($con, $query);
        header('location:../profil?proses=edit'); 
    }

    else {
        header('location:../ubah_password?error=true2'); 
    }

}else{
        header('location:../ubah_password?error=true1'); 
}
?>

 
</body>
</html>
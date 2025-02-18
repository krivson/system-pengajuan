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

if (isset($_POST['input'])) {
  $username           = $_POST['username'];
  $email           = $_POST['email'];
  $password           = $_POST['password'];
  $nama_depan        = $_POST['nama_depan'];
  $nama_belakang        = $_POST['nama_belakang'];
  $jk     = $_POST['jeniskelamin'];
  $nohp        = $_POST['nohp'];
  $alamat        = $_POST['alamat'];
  $role        = $_POST['role'];
 
$cekdulu= "SELECT * FROM user WHERE username='$username' OR email='$email'";
$prosescek= mysqli_query($con, $cekdulu);
if (mysqli_num_rows($prosescek)>0) { 
  header("location:../tambah_user?error=true");  
}
else { 

  $query = "INSERT INTO user SET username='$username',email='$email'
        ,password=md5('$password'),nama_depan='$nama_depan',nama_belakang='$nama_belakang',jk='$jk'
        ,no_hp='$nohp',alamat='$alamat',role='$role', pembuatan_akun='$tgl', update_akun='$tgl'";
  $result = mysqli_query($con, $query);

  if(!$result){
      die ("Query gagal dijalankan: ".mysqli_errno($con).
           " - ".mysqli_error($con));
  }
header("location:../user?proses=tambah"); 
}
}
 
?>

</body>
</html>
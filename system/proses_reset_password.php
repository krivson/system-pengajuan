<!DOCTYPE html>
<html>
<head>
    <link href="../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php 
include 'koneksi.php';
$email = $_POST['email'];
$password = $_POST['password'];
$konfirmasi_password = $_POST['konfirmasi_password'];
$hash_baru=md5($password);
$hash=md5($konfirmasi_password);
 
$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);

$cekdulu= "SELECT * FROM user WHERE email='$email'";
            $prosescek= mysqli_query($con, $cekdulu);

            if (mysqli_num_rows($prosescek)>0) { 
                if($hash_baru == $hash ){
                    $query = "UPDATE user SET password='$hash_baru',
                            update_akun='$tgl' WHERE email='$email'";
                            
                    $result = mysqli_query($con, $query);
                    header("location:../login?proses=edit"); 
                }
                else{
                    header("location:../lupa_password?proses=error2"); 
                }
            }
            else { 
                header("location:../lupa_password?proses=error1"); 
            }
?>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <link href="../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php

include '../system/koneksi.php';

if (isset($_POST['input'])) {
    $username                   = $_POST['username'];
    $email                      = $_POST['email'];
    $password                   = $_POST['password'];
    $hash_password              = md5($password);
    $konfimasi_password         = $_POST['konfirmasi_password'];
    $hash_konfirmasi_password   = md5($konfimasi_password);
    $nama_depan                 = $_POST['nama_depan'];
    $nama_belakang              = $_POST['nama_belakang'];
    $jk                         = $_POST['jeniskelamin'];
    $nohp                       = $_POST['nohp'];
    $alamat                     = $_POST['alamat'];
    $tanggal                    = mktime(date("m"),date("d"),date("Y"));
    $tgl                        = date("Y-m-d", $tanggal);

            $cekdulu= "SELECT * FROM user WHERE email='$email'";
            $prosescek= mysqli_query($con, $cekdulu);

            if (mysqli_num_rows($prosescek)>0) { 
                header("location:../daftar?error=true1");  
            }
            else { 
                if($hash_password == $hash_konfirmasi_password ){
                    $query = "INSERT INTO user SET username='$username',email='$email'
                        ,password=md5('$password'),nama_depan='$nama_depan',nama_belakang='$nama_belakang',jk='$jk'
                        ,no_hp='$nohp',alamat='$alamat',role='tim', pembuatan_akun='$tgl', update_akun='$tgl'";
                    $result = mysqli_query($con, $query);
                        
                    if(!$result){
                        die ("Query gagal dijalankan: ".mysqli_errno($con).
                            " - ".mysqli_error($con));
                    }

                    header("location:../login?proses=new"); 
                }
                else{
                    header("location:../daftar?error=true2");   
                }
            }
}

?>

</body>
</html>
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
$email = $_POST['email'];
$password = $_POST['password'];
$hash=md5($password);

$tanggal= mktime(date("m"),date("d"),date("Y"));
$tgl = date("Y-m-d", $tanggal);
		$query_cek = "SELECT password FROM user WHERE id_user='".$id."'";
		$sql_cek = mysqli_query($con, $query_cek); 
		$data_cek = mysqli_fetch_array($sql_cek); 

    if( $hash == $data_cek['password']){ 
        $cekdulu= "SELECT * FROM user WHERE email='$email'";
            $prosescek= mysqli_query($con, $cekdulu);

            if (mysqli_num_rows($prosescek)>0) { 
                header("location:../ubah_email?error=true1"); 
            }
            else { 
                $query = "UPDATE user SET email='$email',
                        update_akun='$tgl' WHERE id_user='$id'";
                $result = mysqli_query($con, $query);

                if(!$result){
                    die ("Query gagal dijalankan: ".mysqli_errno($con).
                        " - ".mysqli_error($con));
                }
                header("location:../../logout_edit"); 
            }
    }
    else {
      header("location:../ubah_email?error=true2"); 
    }
?>
 
</body>
</html>
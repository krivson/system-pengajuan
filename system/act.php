<!DOCTYPE html>
<html>
<head>
    <link href="../assets/css/loader.css" rel="stylesheet" />
</head>
<body onload="myFunction()" style="margin:0;">

<div id="loader"></div>

<?php
session_start();
include "koneksi.php";
$email=$_POST['email'];
$password=$_POST['password'];
$hash=md5($password);
$op=$_GET['op'];
if($op=="in"){
	$sql=mysqli_query( $con, "SELECT * FROM user WHERE email='$email' AND password = '$hash'");
	if(mysqli_num_rows($sql)==1){
		$qry = mysqli_fetch_array($sql);
		$_SESSION['email'] = $qry['email'];
		$_SESSION['role'] = $qry['role'];
		if($qry['role']=="manajemen"){
			header("location:../admin/index");
		}
		else if($qry['role']=="tim"){
			header("location:../index");
		}
	}else{
	}

} 
    echo "<script type='text/javascript'>document.location='../login?proses=false ';</script>";
?>

</body>
</html>
<?php
session_start();
include "system/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="assets/img/icon.png">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
    <link href="assets/css/login.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/supersized.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/dist/sweetalert.css">
</head>

<body>
    <div class="page-container">
        <h1>Sistem Pengajuan Kebutuhan Event</h1>
        <img src="assets/img/logo-lp3.png" alt="Logo LP3" style="display: block; margin: 10px auto; max-width: 100px;">
        <form action="system/act?op=in" method="POST">
            <input type="text" name="email" placeholder="Email" required
                oninvalid="this.setCustomValidity('Mohon isi Email Anda !')" oninput="setCustomValidity('')">
            <input type="password" name="password" placeholder="Password" required
                oninvalid="this.setCustomValidity('Mohon isi Password Anda !')" oninput="setCustomValidity('')">
            <button type="submit" value="Login" name="submit">Login</button>
            <div class="error"><span>+</span></div>
        </form>
    </div>
    <?php
    if (isset($_GET['proses'])) {
        $login = ($_GET["proses"]);
        if ($login == "false") {
            echo '<a href="lupa_password" class="link"> Lupa Password!</a>';
        }
    }
    ?>
    <!--<div id="footer">
            <a href="daftar" class="footer">Daftar Disini!</a>
            &copy;<?php echo date("Y") ?> System Pengajuan
        </div>-->
</body>

</html>
<script src="assets/dist/sweetalert-dev.js"></script>
<?php
if (isset($_GET['proses'])) {
    echo '<script type="text/javascript">';
    $login = ($_GET["proses"]);
    if ($login == "false") {
        echo 'swal({
            title: "Mohon Maaf!",
            text: "Periksa ulang Email atau Password anda !",
            type: "error",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    } else if ($login == "error") {
        echo 'swal({
            title: "Mohon Maaf!",
            text: "Anda harus login terlebih dahulu !",
            type: "error",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    } else if ($login == "edit") {
        echo 'swal({
            title: "Terubah!",
            text: "Profil telah diubah! Silakan Login Kembali",
            type: "success",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    } else if ($login == "new") {
        echo 'swal({
            title: "Terdaftar!",
            text: "Akun anda sudah terdaftar, Silakan Login!",
            type: "success",
            showConfirmButton: true,
            confirmButtonColor: "#00ff00"
        })';
    }
    echo '</script>';
}
?>
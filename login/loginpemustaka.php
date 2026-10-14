<?php
require_once('../function.php');
require_once('../base.php');
require_once('../database.php');
session_start();

// Otorisasi
if(isset($_SESSION['id'])){
       if($_SESSION['aktor'] == "pemustaka"){
        header("Location: ../index.php");
        exit();
    }else{
        header("Location: ../admin/index.php");
        exit();
    }
}


$nim = $password = "";
$error_nim = $error_password = "";

if(isset($_POST['submit'])) {
    $nim = htmlspecialchars($_POST['nim']);
    $password = htmlspecialchars($_POST['password']);
    $dataPemustaka = isPemustakaNIM($nim);

    if(!tidak_boleh_kosong($nim)){
        $error_nim = "Masukkan Wajib Diisi";
    } elseif(!numerik($nim)) {
        $error_nim = "Masukkan Harus Numerik";
    } elseif(!isPemustakaNIM($nim)) {
        $error_nim = "NIM tidak terdaftar";
    } else {
        $error_nim = "";
    }

    if (!tidak_boleh_kosong($password)) {
        $error_password = "Masukkan wajib diisi";
    } elseif (!alfaNumerik($password)) {
        $error_password = "Password harus alfanumerik";
    } elseif (isPemustakaNIM($nim)) {
        if ($dataPemustaka['passwordPemustaka'] != hash('sha256', $password)) {
        $error_password = "Password Salah";
    } 
    } 
    // elseif (!panjang($password,8)) {
    //     $error_password = "Password minimal 8 karakter";
    // }
     else {
        $error_password = "";
    }

    if($error_nim == "" && $error_password == "") {
        $_SESSION['aktor'] = "pemustaka";
        $_SESSION['id'] = $dataPemustaka['idPemustaka'];
        header("location:../index.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIPUSTAKA</title>
    <link rel="stylesheet" href="login.css">

</head>
<body>
<div class="main-content">
<fieldset class="box">
    <h2 class="title">Selamat Datang di UNIPUSTAKA</h2>
    <p class="subtitle">Silahkan Login Terlebih Dahulu</p>
    <form method="POST" action="loginpemustaka.php">
    <table>
    <tr><td class="label">NIP/NIM</td></tr>
    <tr><td><input type="text" name="nim" value="<?= $nim; ?>"></td></tr>
    <tr><td class="error"><?= $error_nim; ?></td></tr>

    <tr><td class="label">Password</td></tr>
    <tr><td><input class="password" type="text" name="password" value="<?= $password; ?>" autocomplete="off"></td></tr>
    <tr><td class="error"><?= $error_password; ?></td></tr>
      
    <tr><td><button type="submit" name="submit">Login</button></td></tr>

    <tr><td><hr></td></tr>

    <tr><td class="center-text">Belum Punya Akun?</td></tr>
    <tr><td><a href="regist.php" class="baru" ><div class="button">Buat Akun Baru</div></a></td></tr>

    <tr><td><hr></td></tr>

    <tr><td>Atau Login Sebagai <a href="loginadmin.php" class="admin">Admin</a></td></tr>
    </table>
    </form>
</fieldset>
</div>
</body>
</html>
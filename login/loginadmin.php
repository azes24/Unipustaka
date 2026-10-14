<?php
require_once('../function.php');
require_once('../base.php');
require_once(BASE_PATH . '/database.php');
session_start();

// Otorisasi
if(isset($_SESSION['id'])){
    if($_SESSION['aktor'] == "admin"){
        header("Location: ../admin/index.php");
        exit();
    }else{
        header("Location: ../index.php");
        exit();
    }
}

$nip = $password = "";
$error_nip = $error_password = "";

if(isset($_POST['submit'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $password = htmlspecialchars($_POST['password']);
    $dataAdmin = isAdminNIP($nip);

    if(!tidak_boleh_kosong($nip)){
        $error_nip = "Masukkan Wajib Diisi";
    } elseif(!numerik($nip)) {
        $error_nip = "Masukkan Harus Numerik";
    } elseif(!isAdminNIP($nip)) {
        $error_nip = "Nomer Induk Tidak terdaftar";
    } else {
        $error_nip = "";
    }

    if (!tidak_boleh_kosong($password)) {
        $error_password = "Masukkan wajib diisi";
    } elseif (!alfaNumerik($password)) {
        $error_password = "Password harus alfanumerik";
    } elseif(isAdminNIP($nip)) {
        if($dataAdmin['passwordAdmin'] != hash('sha256', $password)){
        $error_password = "Password Salah"; 
        }
    }
    else {
        $error_password = "";
    }

    if($error_nip == "" && $error_password == "") {
        $_SESSION['aktor'] = "admin";
        $_SESSION['id'] = $dataAdmin['idAdmin'];
        header("location:../admin/index.php");
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
    <form method="POST" action="loginadmin.php">
    <table>
    <tr><td class="label">NIP</td></tr>
    <tr><td><input type="text" name="nip" value="<?= $nip; ?>"></td></tr>
    <tr><td class="error"><?= $error_nip; ?></td></tr>

    <tr><td class="label">Password</td></tr>
    <tr><td><input class="password" type="text" name="password" value="<?= $password; ?>" autocomplete="off"></td></tr>
    <tr><td class="error"><?= $error_password; ?></td></tr>
      
    <tr>
        <td><a class="kembali" href="loginpemustaka.php">Kembali</a>
        <button type="submit" name="submit">Login</button></td>
    </tr>

    </table>
    </form>
</fieldset>
</div>
</body>
</html>
<?php
require_once('../function.php');
require_once('../database.php');

$namadepan = $namabelakang = $nip = $password = $email = $nomor = $alamat = "";
$error_namadepan = $error_namabelakang = $error_nip = $error_password = $error_email = $error_nomor = $error_alamat = "";

if(isset($_POST['submit'])){
    $namadepan = htmlspecialchars($_POST['namadepan']);
    $namabelakang = htmlspecialchars($_POST['namabelakang']);
    $nip = htmlspecialchars($_POST['nip']);
    $password = htmlspecialchars($_POST['password']);
    $email = htmlspecialchars($_POST['email']);
    $nomor = htmlspecialchars($_POST['nomor']);
    $alamat = htmlspecialchars($_POST['alamat']);

    if(!tidak_boleh_kosong($namadepan)){
        $error_namadepan = "Masukkan Wajib Diisi";
    } elseif(!alfabet($namadepan)) {
        $error_namadepan = "Masukkan Harus Alfabet";
    } else{
        $error_namadepan = "";
    }

    if(!tidak_boleh_kosong($namabelakang)){
        $error_namabelakang = "Masukkan Wajib Diisi";
    } elseif(!alfabet($namabelakang)) {
        $error_namabelakang = "Masukkan Harus Alfabet";
    } else{
        $error_namabelakang = "";
    }

    if(!tidak_boleh_kosong($nip)){
        $error_nip = "Masukkan Wajib Diisi";
    } elseif(!numerik($nip)) {
        $error_nip = "Masukkan Harus Numerik";
    } elseif(!rentangPanjang($nip, 12, 18)){
        $error_nip = "Panjang NIP/NIM harus antara 12 sampai 18 digit";
    } elseif(isPemustakaNIM($nip)){
        $error_nip = "NIP/NIM Sudah Terdaftar";
    }
    else{
        $error_nip = "";
    }

    if(!tidak_boleh_kosong($password)){
        $error_password = "Masukkan Wajib Diisi";
    } elseif(!alfabetDanNumerik($password)) {
        $error_password = "Password Harus Mengandung Huruf Dan Angka";
    } elseif(!panjang($password, 8)){
        $error_password = "Password Minimal 8 Karakter";
    }else{
        $error_password = "";
    }

    if(!tidak_boleh_kosong($email)){
        $error_email = "Masukkan Wajib Diisi";
    } elseif(!validasiEmail($email)) {
        $error_email = "Masukkan Wajib Format Email";
    } else{
        $error_email = "";
    }

    if(!tidak_boleh_kosong($nomor)){
        $error_nomor = "Masukkan Wajib Diisi";
    } elseif(!numerik($nomor)) {
        $error_nomor = "Masukkan Wajib Numerik";
    } elseif(!rentangPanjang($nomor, 10, 13)){
        $error_nomor ="Panjang nomor telepon harus antara 10 sampai 13 digit";
    } else{
        $error_nomor = "";
    }

    if(!tidak_boleh_kosong($alamat)){
        $error_alamat = "Masukkan Wajib Diisi";
    } elseif(!alfanumerik($alamat)) {
        $error_alamat = "Masukkan Harus Huruf atau Angka";
    } else{
        $error_alamat = "";
    }

    if($error_namadepan == "" && $error_namabelakang == "" && $error_nip == ""  && 
       $error_password == "" && $error_email == "" && $error_nomor == "" && 
       $error_alamat == ""){
        
        tambahPemustaka($namadepan, $nip, $namabelakang, $alamat, $nomor, $email, $password);
        header("location: loginpemustaka.php");
        exit();
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
<div class="main-content-regist">
 <fieldset class="box">
    <h2 class="title">UNIPUSTAKA</h2>
    <p class="subtitle">Silahkan Mengisi Form Untuk Membuat Akun</p>
    <form method="post" action="regist.php">
    <table>
        <tr><td class="label">Nama Depan</td></tr>
        <tr><td><input type="text" name="namadepan" placeholder="Masukkan Nama Depan" value="<?= $namadepan; ?>"></td></tr>
        <tr><td class="error"><?= $error_namadepan; ?></td></tr>

        <tr><td class="label">Nama Belakang</td></tr>
        <tr><td><input type="text" name="namabelakang" placeholder="Masukkan Nama Belakang" value="<?= $namabelakang; ?>"></td></tr>
        <tr><td class="error"><?= $error_namabelakang; ?></td></tr>

        <tr><td class="label">NIP/NIM</td></tr>
        <tr><td><input type="text" name="nip" placeholder="Masukkan NIP/NIM" value="<?= $nip; ?>"></td></tr>
        <tr><td class="error"><?= $error_nip; ?></td></tr>

        <tr><td class="label">Email</td></tr>
        <tr><td><input type="text" name="email" placeholder="Masukkan Email" value="<?= $email; ?>"></td></tr>
        <tr><td class="error"><?= $error_email; ?></td></tr>

        <tr><td class="label">Nomor Telepon</td></tr>
        <tr><td><input type="text" name="nomor" placeholder="Masukkan Nomor" value="<?= $nomor; ?>"></td></tr>
        <tr><td class="error"><?= $error_nomor; ?></td></tr>

        <tr><td class="label">Alamat</td></tr>
        <tr><td><input type="text" name="alamat" placeholder="Masukkan Alamat Lengkap" value="<?= $alamat; ?>"></td></tr>
        <tr><td class="error"><?= $error_alamat; ?></td></tr>

        <tr><td class="label">Password</td></tr>
        <tr><td><input type="text" name="password" placeholder="Masukkan Password" autocomplete="off"></td></tr>
        <tr><td class="error"><?= $error_password; ?></td></tr>

        <tr><td><hr></td></tr>

        <tr>
            <td class="jarak"><a class="kembali" href="loginpemustaka.php">Kembali</a>
            <button type="submit" name="submit">Daftar</button></td>
        </tr>
    </table>
    </form>
 </fieldset>
 </div>
</body>
</html>
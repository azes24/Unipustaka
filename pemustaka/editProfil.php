<?php 
session_start();
require_once('../base.php');
require_once('../function.php');
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

// CEK AKSES PEMUSTAKA
if($_SESSION['aktor'] == "admin"){
    header("Location:../admin/index.php");
    exit();
}

// CEK PROFIL PEMUSTAKA SEBELUM EDIT
if(!isset($_POST['namaDepan'])){
    $idPemustaka = $_SESSION['id'];
    $dataPemustaka = ambilpemustaka($idPemustaka);
}

// INISIALISASI VARIABEL SEBELUM DI SUBMIT
$namaDepan = $namaBelakang = $emailPemustaka = $noTlpnPemustaka = $alamatPemustaka = "";
$error_namadepan = $error_namabelakang = $error_email = $error_noTlpn = $error_alamat = "";

// MEMPERBARUI DATA
if(isset($_POST['namaDepan'])){
    $idPemustaka = $_SESSION['id'];
    $namaDepan = htmlspecialchars($_POST['namaDepan']);
    $namaBelakang = htmlspecialchars($_POST['namaBelakang']);
    $emailPemustaka = htmlspecialchars($_POST['email']);
    $noTlpnPemustaka = htmlspecialchars($_POST['noTlpn']);
    $alamatPemustaka = htmlspecialchars($_POST['alamatPemustaka']);

    // VALIDASI
    if(!tidak_boleh_kosong($namaDepan)){
        $error_namadepan = "Masukkan Wajib Diisi";
    } elseif(!alfabet($namaDepan)) {
        $error_namadepan = "Masukkan Harus Alfabet";
    } else{
        $error_namadepan = "";
    }

    if(!tidak_boleh_kosong($namaBelakang)){
        $error_namabelakang = "Masukkan Wajib Diisi";
    } elseif(!alfabet($namaBelakang)) {
        $error_namabelakang = "Masukkan Harus Alfabet";
    } else{
        $error_namabelakang = "";
    }

    if(!tidak_boleh_kosong($emailPemustaka)){
        $error_email = "Masukkan Wajib Diisi";
    } elseif(!validasiEmail($emailPemustaka)) {
        $error_email = "Masukkan Wajib Format Email";
    } else{
        $error_email = "";
    }

    if(!tidak_boleh_kosong($noTlpnPemustaka)){
        $error_noTlpn = "Masukkan Wajib Diisi";
    } elseif(!numerik($noTlpnPemustaka)) {
        $error_noTlpn = "Masukkan Wajib Numerik";
    } elseif(!rentangPanjang($noTlpnPemustaka, 10, 13)){
        $error_noTlpn ="Panjang nomor telepon harus antara 10 sampai 13 digit";
    } else{
        $error_noTlpn = "";
    }

    if(!tidak_boleh_kosong($alamatPemustaka)){
        $error_alamat = "Masukkan Wajib Diisi";
    } else{
        $error_alamat = "";
    }

    if($error_namadepan == "" && $error_namabelakang == "" && 
       $error_email == "" && $error_noTlpn == "" && 
       $error_alamat == ""){
        
        editPemustaka($idPemustaka, $namaDepan, $namaBelakang, $emailPemustaka, $noTlpnPemustaka, $alamatPemustaka);
        header("Location:../index.php");
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
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/form.css">
</head>
<body>
    <!-- ISI KONTEN EDIT PROFIL -->
    <div class="tombolkembali">
        <a href="../index.php"><div class="back">kembali</div></a>
    </div>
    <div class="editprofil">
    <h1>Edit Profil</h1>
    <form class="edit-form" method="POST" action="editProfil.php">
        <input type="hidden" name="idPemustaka" value="<?= $idPemustaka ?>">
        <label for="namaDepan">Nama Depan:</label>
        <input type="text" id="namaDepan" name="namaDepan" value="<?php if(!isset($_POST['namaDepan'])){echo $dataPemustaka['namaDepan'];} else {echo $namaDepan;} ?>">
        <p><?= $error_namadepan; ?></p>

        <label for="namaBelakang">Nama Belakang:</label>
        <input type="text" id="namaBelakang" name="namaBelakang" value="<?php if(!isset($_POST['namaDepan'])){echo $dataPemustaka['namaBelakang'];} else {echo $namaBelakang;} ?>">
        <p><?= $error_namabelakang; ?></p>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php if(!isset($_POST['namaDepan'])){echo $dataPemustaka['emailPemustaka'];} else {echo $emailPemustaka;} ?>">
        <p><?= $error_email; ?></p>

        <label for="email">Nomor Telepon:</label>
        <input type="text" id="noTlpn" name="noTlpn" value="<?php if(!isset($_POST['namaDepan'])){echo $dataPemustaka['noTlpnPemustaka'];} else {echo $noTlpnPemustaka;} ?>">
        <p><?= $error_noTlpn; ?></p>
        
        <label for="alamatPemustaka">Alamat:</label>
        <input type="text" id="alamatPemustaka" name="alamatPemustaka" value="<?php if(!isset($_POST['namaDepan'])){echo $dataPemustaka['alamatPemustaka'];} else {echo $alamatPemustaka;} ?>">
        <p><?= $error_alamat; ?></p>

        <button type="submit" class="simpanUbah">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
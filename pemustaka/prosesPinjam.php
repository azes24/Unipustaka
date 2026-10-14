<?php
session_start();
require_once('../base.php');
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

// CEK AKSES PEMUSTAKA
if($_SESSION['aktor'] == "admin"){
    header("Location:../admin/index.php");
    exit();
}

$idPemustaka = $_SESSION['id'];
$idBuku = $_GET['idBuku'];
$buku = detailbuku($idBuku);
$totalPinjaman = totalPinjamanPemustaka($idPemustaka);

// CEK TOTAL PINJAMAN BUKU
if ($totalPinjaman < 2 ) {
    pinjam($idPemustaka,$idBuku);
    ubahStatusBuku($idBuku,"Sedang Dipinjam");
    header('location:../index.php?page=pinjam');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/style.css">
    <title>UNIPUSTAKA</title>
</head>
<body class="body-peringatan">
    <!-- PERINGATAN JIKA MELEBIHI BATAS PEMINJAMAN -->
    <div class="peringatan">
        <h2>Anda melebihi Batas!</h2><br>
        <p>Maksimal peminjaman buku pemustaka adalah 2 buku dalam satu masa peminjaman.</p>
        <a href="../index.php?page=pinjam"><div class="oke-peringatan">Oke</div></a>
    </div>
</body>
</html>
<?php
session_start();
require_once('../base.php');
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

// CEK AKSES ADMIN
if($_SESSION['aktor'] == "pemustaka"){
    header("Location:../index.php");
    exit();
}

// AMBIL DATA PEMINJAM
$peminjam = getAllPeminjam();

$idPeminjam = $_POST['idPeminjam'];
$statusPinjam = $_POST['statusPinjam'];
$idBuku = $_POST['idBuku'];

// UPDATE STATUS PEMINJAM DAN BUKU
ubahStatusPeminjam($idPeminjam,$statusPinjam);

// UPDATE STATUS BUKU BERDASARKAN STATUS PEMINJAMAN
if($statusPinjam == "Dipinjam"){
    ubahStatusBuku($idBuku,"Sedang Dipinjam");
}
if($statusPinjam == "Dikembalikan" || $statusPinjam == "Ditolak"){
    ubahStatusBuku($idBuku,"Tersedia");
}
header("location:updateStatus.php");
?>
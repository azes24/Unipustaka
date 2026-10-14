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

// AMBIL DATA
$idPeminjam = $_GET['idPeminjam'];
$idBuku = $_GET['idBuku'];

// PROSES BATAL PINJAM BUKU
ubahStatusBuku($idBuku,"Tersedia");
ubahStatusPeminjam($idPeminjam,"Dibatalkan");
header('location:../index.php?page=pinjam');

?>
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

// PENGHAPUSAN
if(isset($_POST['confirm'])){
    if($_POST['confirm'] === 'yes'){
        $idBuku = $_POST['idBuku'];
        $detail = detailbuku($idBuku);
        unlink(("../assets/coverBuku/" . $detail['urlCover']));
        hapusbuku($idBuku);
    }
    header('Location: manage.php');
    exit();
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
    <!-- KONFIRMASI PENGHAPUSAN -->
    <div class="peringatan">
        <h2>Apakah Anda yakin ingin menghapus buku ini?</h2><br>
        <p>Jika iya Buku akan terhapus secara permanen.</p>
        <form action="deleteBuku.php" method="post">
        <input type="hidden" name="idBuku" value="<?= $_GET['idBuku'] ?>">
        <button type="submit" name="confirm" value="yes" class="iya-peringatan">Ya, Hapus</button>
        <button type="submit" name="confirm" value="no" class="tidak-peringatan">Tidak, Kembali</button>
    </form>
    </div>
</body>
</html>
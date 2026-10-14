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

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UNIPUSTAKA</title>
        <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
        <!-- MEMANGGIL HEADER -->
        <?php include BASE_PATH . '/components/header.php'; ?>

        <!-- ISI KONTEN MENU ADMIN -->
        <div class="main-content">
                <h1>Perpustakaan Kampus UNIPUSTAKA</h1>
                <div class="menu-container">
                        <a href="manage.php" class="menu-card">Manajemen Buku</a>
                        <a href="daftar_pemustaka.php" class="menu-card">Daftar Pemustaka</a>
                        <a href="updateStatus.php" class="menu-card">Update Status</a>
                </div>
        </div>

        <!-- MEMANGGIL FOOTER -->
        <?php include BASE_PATH . '/components/footer.php'; ?>
        </body>
</html>

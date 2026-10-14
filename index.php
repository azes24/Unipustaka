<?php
session_start();
require_once('base.php');
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

// CEK AKSES PEMUSTAKA
if($_SESSION['aktor'] == "admin"){
    header("Location:./admin/index.php");
    exit();
}

// HALAMAN AWAL ADALAH BERANDA
$page = isset($_GET['page']) ? $_GET['page'] : 'beranda';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unipustaka - Perpustakaan Kampus</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <div class="body-main">
    <!-- MEMANGGIL HEADER -->
    <?php include BASE_PATH . '/components/header.php'; ?>
    <div class="main">
        <?php include BASE_PATH . '/components/sidebar.php'; ?>

        <div class="main-content">
            <?php
            // Routing berdasarkan parameter page
            switch($page) {
                case 'koleksi':
                    include './pemustaka/koleksi.php';
                    break;
                case 'pinjam':
                    include './pemustaka/pinjam.php';
                    break;
                default:
                    include './pemustaka/beranda.php';
            }
            ?>
        </div>
    </div>
    <!-- MEMANGGIL FOOTER -->
    <?php include BASE_PATH . '/components/footer.php'; ?>
    </div>
</body>
</html>


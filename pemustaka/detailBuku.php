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


$id = $_GET['idBuku'];
$bukudetail = detailbuku($id); 

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
    <!-- ISI KONTEN DETAIL BUKU -->
    <div class="halamandetail">
    <a href="../index.php?page=pinjam"><div class="kembali-button">Kembali</div></a>

    <div class="detail">
        <!-- KANAN (COVER BUKU) -->
        <div class="kiri">
            <div class="cover">
                <div class="book-cover-detail">
                    <img src="<?= BASE_URL . "/assets/coverBuku/" . $bukudetail['urlCover']?>" alt="cover">
                </div>
            </div>

            <?php if ($bukudetail['statusBuku'] == 'Tersedia'): ?>
            <a href="prosesPinjam.php?idBuku=<?= $id ?>">
                <div class="pinjam-button">Pinjam Buku</div>
            </a>
            <?php endif; ?>
        </div>

        <!-- KANAN (DETAIL BUKU) -->
        <div class="detailbuku">
            <h1><?= $bukudetail['judulBuku']?></h1>
            <p><strong>Penulis:</strong> <?= $bukudetail['penulis']?></p>
            <p><strong>Penerbit:</strong> <?= $bukudetail['penerbit']?></p>
            <p><strong>Tahun Terbit:</strong> <?= $bukudetail['tahunTerbit']?></p>
            <p><strong>Halaman:</strong> <?= $bukudetail['halaman']?></p>
            <p><strong>Bahasa:</strong> <?= $bukudetail['bahasa']?></p>
            <p><strong>Kategori Buku:</strong> <?= $bukudetail['kategoriBuku']?></p>
            <p><strong>Deskripsi:</strong> <?= $bukudetail['deskripsi']?></p>
        </div>
    </div>
    </div>
</body>

</html>

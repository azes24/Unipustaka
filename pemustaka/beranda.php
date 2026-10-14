<?php
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

// MENGAMBIL DATA BUKU TERBARU SESUAI DENGAN DATABASE
$bukuTerbaru = getBukuTerbaru(3);

// MENGAMBIL DATA PEMUSTAKA SESUAI DENGAN SESSION ID YANG SEDANG LOGIN
$pemustaka = ambilpemustaka($_SESSION['id']); 

// MENGHITUNG TOTAL BUKU YANG ADA DI DATABASE
$totalbuku = totalbuku();

?>
<!-- ISI KONTEN BERANDA  -->
<div class="hero">
    <h2>Selamat Datang, <?= $pemustaka['namaDepan']?></h2> 
    <p>Di UNIPUSTAKA Perpustakaan Universitas Negeri</p>
    <!-- BUTTON BERBENTUK HYPERLINK MENUJU HALAMAN koleksi.php -->
    <a href="?page=koleksi" class="btn-primary">Lihat Koleksi Lainnya</a>
</div>

<div class="content-section">
    <div>
        <h3 class="section-title"><b>Koleksi Terbaru</b></h3>
        <!-- MENAMPILKAN BUKU TERBARU DI DATABASE -->
        <div class="book-position">
            <?php foreach ($bukuTerbaru as $buku): ?>
            <div class="book-card">
                <div class="book-cover"><img src="<?= BASE_URL . "/assets/coverBuku/" . $buku['urlCover']?>" alt="cover"></div>
                <div class="book-title"><?= $buku['judulBuku']?></div>
                <div class="book-author"><?= $buku['penulis']?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- MENAMPILKAN TOTAL BUKU YANG DIMILIKI UNIPUSTAKA -->
    <div class="about">
        <h3 class="section-title"><b>Total Buku Kami</b></h3>
        <h1><?php echo $totalbuku ?></h1>
        <h3>buku</h3>
    </div>
</div>
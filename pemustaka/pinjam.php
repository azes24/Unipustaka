<?php

require_once(BASE_PATH . '/base.php');
require_once(BASE_PATH . '/database.php');

// AMBIL DATA BUKU
$bukuList = getAllBuku();

// CARI BUKU
$bukucari = caribuku();

// RIWAYAT PEMINJAMAN
$riwayat = riwayatpinjam($_SESSION['id']);

$value = "";

// CEK SEARCH BAR TERISI
if (isset($_GET['search'])) {
    $value = $_GET["search-input"];
}
?>
<!-- ISI KONTEN PINJAM -->
<div class="page-content">
    <form method="GET" class="search-bar">
        <input type="hidden" name="page" value="pinjam">
        <input type="text" name="search-input" class="search-input" value="<?=$value?>" placeholder="Cari judul buku ...">
        <button class="cari" name="search">Cari</button>
    </form>
    <div class="pinjam-box">
    <div class="pinjam-books">
        <?php 
        if(isset($_GET['search'])) {
            foreach ($bukucari as $pinjamcari):?>
            <a href="./pemustaka/detailBuku.php?idBuku=<?= $pinjamcari['idBuku']?>">
                <div class="pinjam-card">
                    <div class="book-cover"><img src="<?= BASE_URL . "/assets/coverBuku/" . $pinjamcari['urlCover']?>" alt="cover"></div>
                    <div class="book-title"><?= $pinjamcari['judulBuku']?></div>
                    <div class="book-author"><?= $pinjamcari['penulis']?></div>
                    <div class="book-status"><?= $pinjamcari['statusBuku']?></div>
                </div>
            </a>
                <?php endforeach;
            } else {
                foreach ($bukuList as $pinjambuku):?>
            <a href="./pemustaka/detailBuku.php?idBuku=<?= $pinjambuku['idBuku']?>">
                <div class="pinjam-card">
                    <div class="book-cover"><img src="<?= BASE_URL . "/assets/coverBuku/" . $pinjambuku['urlCover']?>" alt="cover"></div>
                    <div class="book-title"><?= $pinjambuku['judulBuku']?></div>
                    <div class="book-author"><?= $pinjambuku['penulis']?></div>
                    <div class="book-status"><?= $pinjambuku['statusBuku']?></div>
                </div>
            </a>
            <?php endforeach;
       
            }
        ?>
    </div>
    <div class="history">
        <h3>RIWAYAT</h3>
            <?php foreach(array_reverse($riwayat) as $riwayatbuku):?>
                <?php $detailBuku = detailbuku($riwayatbuku['foreignBuku']);?>
                <div class="history-box"><b><?php if($riwayatbuku['foreignBuku'] != null) {echo $detailBuku['judulBuku'];}else{echo "! Buku Telah Dihapus !";}?></b>
                <div class="history-status">
                    <?= $riwayatbuku['tanggalPinjam']?>
                    <hr>
                    Status : <?= $riwayatbuku['statusPinjam']?>
            </div>
                <?php if($riwayatbuku['statusPinjam'] == "Permohonan"):?>
                <a href="<?= BASE_URL ?>/pemustaka/batalPinjam.php?idBuku=<?= $riwayatbuku['foreignBuku']?>&idPeminjam=<?= $riwayatbuku['idPeminjam']?>"><div class="history-batal">Batalkan</div></a>
                <?php endif;?>
            </div>
            <?php endforeach;?>
    </div>
    </div>
</div>
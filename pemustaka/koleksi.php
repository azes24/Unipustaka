<?php 
require_once(BASE_PATH . '/base.php');
require_once(BASE_PATH . '/database.php');

// MENGAMBIL DATA SEMUA BUKU YANG ADA DI DATABASE
$bukuList = getAllBuku();

// MENGAMBIL DATA BUKU BERDASARKAN PENCARIAN JUDUL BUKU
$bukucari = caribuku();

$value = "";
$kategori = "";

// CEK FILTER TERISI
if (isset($_GET['search'])) {
    $value = $_GET["search-input"];
    $kategori = $_GET["kategori"];
}
?>

<!-- ISI KONTEN KOLEKSI -->
<div class="page-content">
    <!-- FORM PENCARIAN BUKU BERDASARKAN JUDUL DAN KATEGORI BUKU -->
    <form method="GET" class="search-bar">
        <input type="hidden" name="page" value="koleksi">
        <input type="text" name="search-input" class="search-input" value="<?= $value?>" placeholder="Cari judul buku ...">
        <select name="kategori" class="filter-select" >
            <option value="" <?php if($kategori == ""){echo "selected";}?>>Semua Kategori</option>
            <option value="Hukum" <?php if($kategori == "Hukum"){echo "selected";} ?>>Hukum</option>
            <option value="Ilmu Komputer" <?php if($kategori == "Ilmu Komputer"){echo "selected";} ?>>Ilmu Komputer</option>
            <option value="Agama" <?php if($kategori == "Agama"){echo "selected";}?>>Agama</option>
            <option value="Ilmu Sosial" <?php if($kategori == "Ilmu Sosial"){echo "selected";} ?>>Ilmu Sosial</option>
            <option value="Sejarah" <?php if($kategori == "Sejarah"){echo "selected";} ?>>Sejarah</option>
            <option value="Seni" <?php if($kategori == "Seni"){echo "selected";} ?>>Seni</option>
        </select>
        <button class="cari" name="search">Cari</button>
    </form>

    <!-- MENAMPILKAN BUKU SESUAI DI PENCARIAN JUDUL DAN KATEGORI -->
    <div class="books-koleksi">
        <?php
        if(isset($_GET['search'])) {
            // MENAMPILKAN HASIL PENCARIAN BUKU BERDASARKAN JUDUL DAN KATEGORI
            foreach ($bukucari as $caribuku):?>
            <?php if($caribuku['kategoriBuku'] == $kategori || $kategori == ""):?>
                <div class="book-card">
                    <div class="book-cover"><img src="<?= BASE_URL . "/assets/coverBuku/" . $caribuku['urlCover']?>" alt="cover"></div>
                    <div class="book-title"><?= $caribuku['judulBuku']?></div>
                    <div class="book-author"><?= $caribuku['penulis']?></div>
                </div>
            <?php endif; ?>
                <?php endforeach;
            } else {
                // MENAMPILKAN SEMUA KOLEKSI BUKU JIKA TIDAK ADA PENCARIAN
                foreach ($bukuList as $koleksibuku):?>
                    <div class="book-card">
                        <div class="book-cover"><img src="<?= BASE_URL . "/assets/coverBuku/" . $koleksibuku['urlCover']?>" alt="cover"></div>
                        <div class="book-title"><?= $koleksibuku['judulBuku']?></div>
                        <div class="book-author"><?= $koleksibuku['penulis']?></div>
                    </div>
                    <?php endforeach;
            }
        ?>
    </div>
</div>
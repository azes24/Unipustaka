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

// AMBIL DATA BUKU
$bukuList = getAllBuku();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIPUSTAKA</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/table.css">
</head>
<body>
    <!-- MEMANGGIL HEADER -->
    <?php include BASE_PATH . '/components/header.php'; ?>

    <!-- ISI KONTEN MANAGEMENT BUKU-->
    <div class="tabelBukuContainer">
        <div class="judulTabel">
            <h1>Daftar Buku UNIPUSTAKA</h1>
            <a href="index.php" class="back-button">Kembali</a>
            <a href="tambahBuku.php" class="button-tambah">+ Tambah Buku</a>
        </div>
        <table class="tabelbuku">
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>  
                <th>Penerbit</th>
                <th>Halaman</th>
                <th>Bahasa</th>
                <th>Kategori Buku</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($bukuList as $buku): ?>
            <tr>
                <td><?= $buku['idBuku']?></td>
                <td><?= $buku['judulBuku']?></td>
                <td><?= $buku['penulis']?></td>
                <td><?= $buku['tahunTerbit']?></td>
                <td><?= $buku['penerbit']?></td>
                <td><?= $buku['halaman']?></td>
                <td><?= $buku['bahasa']?></td>
                <td><?= $buku['kategoriBuku']?></td>
                <td>
                    <a href="editBuku.php?idBuku=<?= $buku['idBuku']?>"><div class="tombolEdit">Edit</div></a>
                    <a href="deleteBuku.php?idBuku=<?= $buku['idBuku']?>"><div class="tombolHapus">Delete</div></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- MEMANGGIL FOOTER -->
    <?php include BASE_PATH . '/components/footer.php'; ?>
</body>
</html>

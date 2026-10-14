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

    <!-- ISI KONTEN UPDATE STATUS PEMINJAMAN -->
    <div class="tabelStatusContainer">
        <div class="judulTabel">
            <h1>Daftar Peminjaman</h1>
            <a href="index.php" class="back-button">Kembali</a>
        </div>

        <table class="tabelstatus">
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($peminjam as $listPeminjam): ?>
                <?php if($listPeminjam['statusPinjam'] == "Permohonan" || $listPeminjam['statusPinjam'] == "Dipinjam" ):?>
                <?php $detailBuku = detailbuku($listPeminjam['foreignBuku']);?>
                <?php $detailPemustaka = ambilpemustaka($listPeminjam['foreignPemustaka']);?>
            <tr>
                <td><?= $listPeminjam['idPeminjam']?></td>
                <td><?= $detailPemustaka['namaDepan'] . " " . $detailPemustaka['namaBelakang'] ?></td>
                <td><?= $detailBuku['judulBuku'] ?></td>
                <td><?= $listPeminjam['tanggalPinjam']?></td>
                <td>
                    <form action="prosesUpdateStatus.php" method="POST">
                    <select class="status-select" name="statusPinjam">
                        <option value="Permohonan" <?php if($listPeminjam['statusPinjam'] == "Permohonan"){echo "selected";}?> >Permohonan</option>
                        <option value="Dipinjam" <?php if($listPeminjam['statusPinjam'] == "Dipinjam"){echo "selected";}?> >Dipinjam</option>
                        <option value="Dikembalikan" <?php if($listPeminjam['statusPinjam'] == "Dikembalikan"){echo "selected";}?> >Dikembalikan</option>
                        <option value="Ditolak" <?php if($listPeminjam['statusPinjam'] == "Ditolak"){echo "selected";}?> >Ditolak</option>
                    </select>

                </td>
                <td>
                    <input type="hidden" value="<?= $listPeminjam['foreignBuku'] ?> " name ="idBuku">
                    <input type="hidden" value="<?= $listPeminjam['idPeminjam'] ?> " name ="idPeminjam">
                    <button type="submit" class="add-button">Perbarui</button>
                    </form>
                </td>
            </tr>
            <?php endif;?>
            <?php endforeach;?>
        </table>
        


    <!-- ISI KONTEN RIWAYAT PEMINJAMAN -->
    <div class="daftar-riwayat">
        <div class="judulTabel">
            <h1>Riwayat Semua Peminjaman</h1>
        </div>
        <table class="tabelstatus">
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tanggal Peminjaman</th>
                <th>Status</th>
            </tr>
            <?php foreach (array_reverse($peminjam) as $listPeminjam): ?>
                <?php if($listPeminjam['statusPinjam'] != "Permohonan" || $listPeminjam['statusPinjam'] != "Dipinjam" ):?>
                <?php $detailBuku = detailbuku($listPeminjam['foreignBuku']);?>
                <?php $detailPemustaka = ambilpemustaka($listPeminjam['foreignPemustaka']);?>
            <tr>
                <td><?= $listPeminjam['idPeminjam']?></td>
                <td><?= $detailPemustaka['namaDepan'] . " " . $detailPemustaka['namaBelakang'] ?></td>
                <td><?= $detailBuku['judulBuku'] ?></td>
                <td><?= $listPeminjam['tanggalPinjam']?></td>
                <td><?= $listPeminjam['statusPinjam'] ?></td>
            </tr>
            <?php endif;?>
            <?php endforeach;?>
        </table>
        </div>
    </div>
    <!-- MEMANGGIL FOOTER -->
    <?php include BASE_PATH . '/components/footer.php'; ?>
</body>
</html>
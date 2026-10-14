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

// AMBIL DATA PEMUSTAKA
$daftarpemustaka = getAllPemustaka();
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
    <?php include BASE_PATH . '/components/header.php';?>

    <!-- ISI KONTEN DAFTAR PEMUSTAKA -->
    <div class="tabelPemustakaContainer">
        <div class="judulTabel">
            <h1>Daftar Pemustaka</h1>
            <a href="index.php" class="back-button">Kembali</a>
        </div>

        <table class="tabelpemustaka">
            <tr>
                <th>Nama Depan Pemustaka</th>
                <th>Nama Belakang Pemustaka</th>
                <th>No Induk Pemustaka</th>
                <th>Alamat Pemustaka</th>
                <th>No Tlp Pemustaka</th>
                <th>Email Pemustaka</th>
            </tr>
            <?php foreach ($daftarpemustaka as $pemustaka): ?>
            <tr>
                <td><?= $pemustaka['namaDepan']?></td>
                <td><?= $pemustaka['namaBelakang']?></td>
                <td><?= $pemustaka['noIndukPemustaka']?></td>
                <td><?= $pemustaka['alamatPemustaka']?></td>
                <td><?= $pemustaka['noTlpnPemustaka']?></td>
                <td><?= $pemustaka['emailPemustaka']?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- MEMANGGIL FOOTER -->
    <?php include BASE_PATH . '/components/footer.php'; ?>
</body>
</html>
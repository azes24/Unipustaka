<?php
session_start();
require_once('../base.php');
require_once('../function.php');
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

// INISIALISASI VARIABEL SEBELUM DI SUBMIT
$judul = $penulis = $tahun = $penerbit = $halaman = $bahasa = $kategoriBuku = $deskripsi = $coverBuku = "";
$errjudul = $errpenulis = $errtahun = $errpenerbit = $errhalaman = $errbahasa = $errkategori = $errdeskripsi = $errcover = "";

// CEK AKSES ADMIN
if($_SESSION['aktor'] == "pemustaka"){
    header("Location:../index.php");
    exit();
}

// TAMBAH BUKU BARU
if(isset($_POST['judul'])){
    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $tahun = htmlspecialchars($_POST['tahun']);
    $penerbit = htmlspecialchars($_POST['penerbit']);
    $halaman = htmlspecialchars($_POST['halaman']);
    $bahasa = htmlspecialchars($_POST['bahasa']);
    $kategoriBuku = htmlspecialchars($_POST['kategoribuku']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    
    $coverBuku = $_FILES['coverBuku']['name'];
    $coverBuku = str_replace(' ', '', $coverBuku);
    $namaCover = $tahun . $coverBuku;
    $tmp = $_FILES['coverBuku']['tmp_name'];

    // VALIDASI FORM
    if(!tidak_boleh_kosong($coverBuku)){
        $errcover = "Masukkan Wajib Diisi";
    } else {
        $errcover = "";
    }


    if(!tidak_boleh_kosong($judul)){
        $errjudul = "Masukkan Wajib Diisi";
    } elseif(!alfaNumerik($judul)){
        $errjudul = "Masukkan Wajib Alfabet atau Numerik atau Keduanya";
    } else {
        $errjudul = "";
    }

    if(!tidak_boleh_kosong($penulis)){
        $errpenulis = "Masukkan Wajib Diisi";
    } elseif(!alfabet($penulis)){
        $errpenulis = "Masukkan Wajib Alfabet";
    } else {
        $errpenulis = "";
    }

    if(!tidak_boleh_kosong($tahun)){
        $errtahun = "Masukkan Wajib Diisi";
    } elseif(!validasitahun($tahun)){
        $errtahun = "Masukkan Wajib 4 Angka Numerik";
    } else {
        $errtahun = "";
    }

    if(!tidak_boleh_kosong($penerbit)){
        $errpenerbit = "Masukkan Wajib Diisi";
    } elseif(!alfabet($penerbit)){
        $errpenerbit = "Masukkan Wajib Alfabet";
    } else {
        $errpenerbit = "";
    }

    if(!tidak_boleh_kosong($halaman)){
        $errhalaman = "Masukkan Wajib Diisi";
    } elseif(!numerik($halaman)){
        $errhalaman = "Masukkan Wajib Numerik";
    } else {
        $errhalaman = "";
    }

    if(!tidak_boleh_kosong($bahasa)){
        $errbahasa = "Masukkan Wajib Diisi";
    } elseif(!alfabet($bahasa)){
        $errbahasa = "Masukkan Wajib Alfabet";
    } else {
        $errbahasa = "";
    }

    if($kategoriBuku == ""){
        $errkategori = "Wajib Pilih Kategori Buku";
    } else {
        $errkategori = "";
    }

    if(!tidak_boleh_kosong($deskripsi)){
        $errdeskripsi = "Masukkan Wajib Diisi";
    } else {
        $errdeskripsi = "";
    }

    // JIKA TIDAK ADA ERROR, TAMBAH BUKU KE DATABASE
    if($errjudul == "" && $errpenulis == "" && $errtahun == "" && $errpenerbit == "" && $errhalaman == "" && $errbahasa == "" && $errkategori == "" && $errdeskripsi == "" && $errcover == "") {
        tambahBuku($judul, $penulis, $tahun, $penerbit, $halaman, $bahasa, $kategoriBuku, $deskripsi);
        uploadcoverbuku($judul, $namaCover);
        move_uploaded_file($tmp, "../assets/coverBuku/" . $namaCover);
        header('Location: manage.php');
        exit();
    }   
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIPUSTAKA</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/form.css">
</head>
<body>
    <!-- MEMANGGIL HEADER -->
    <?php include BASE_PATH . '/components/header.php'; ?>
    <div class="tombolkembali">
        <a href="manage.php">kembali</a>
    </div>
    <!-- ISI KONTEN FORM TAMBAH BUKU -->
    <div class="tambahbuku">
        <h1>Tambah Buku Baru</h1>
        <form action="tambahBuku.php" method="post" enctype="multipart/form-data" class="formTambah">
            <label for="coverBuku">Cover Buku:</label>
            <input type="file" id="coverBuku" name="coverBuku">
            <p><?= $errcover; ?></p>

            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul" name="judul" value="<?= $judul?>">
            <p><?= $errjudul; ?></p>

            <label for="penulis">Penulis:</label>
            <input type="text" id="penulis" name="penulis" value="<?= $penulis?>">
            <p><?= $errpenulis; ?></p>

            <label for="tahun">Tahun Terbit:</label>
            <input type="text" id="tahun" name="tahun" value="<?= $tahun?>">
            <p><?= $errtahun; ?></p>

            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" value="<?= $penerbit?>">
            <p><?= $errpenerbit; ?></p>

            <label for="halaman">Halaman:</label>
            <input type="text" id="halaman" name="halaman" value="<?= $halaman?>">
            <p><?= $errhalaman; ?></p>

            <label for="bahasa">Bahasa:</label>
            <input type="text" id="bahasa" name="bahasa" value="<?= $bahasa?>">
            <p><?= $errbahasa; ?></p>

            <label for="kategoribuku">Kategori Buku:</label>
            <select name="kategoribuku" id="kategoribuku">
                <option value="" <?php if($kategoriBuku == ""){echo "selected";}?>>Pilih Kategori</option>
                <option value="Hukum" <?php if($kategoriBuku == "Hukum"){echo "selected";} ?>>Hukum</option>
                <option value="Ilmu Komputer" <?php if($kategoriBuku == "Ilmu Komputer"){echo "selected";} ?>>Ilmu Komputer</option>
                <option value="Agama" <?php if($kategoriBuku == "Agama"){echo "selected";}?>>Agama</option>
                <option value="Ilmu Sosial" <?php if($kategoriBuku == "Ilmu Sosial"){echo "selected";} ?>>Ilmu Sosial</option>
                <option value="Sejarah" <?php if($kategoriBuku == "Sejarah"){echo "selected";} ?>>Sejarah</option>
                <option value="Seni" <?php if($kategoriBuku == "Seni"){echo "selected";} ?>>Seni</option>
            </select>
            <p><?= $errkategori; ?></p>

            <label for="deskripsi">Deskripsi:</label>
            <input type="text" id="deskripsi" name="deskripsi" value="<?= $deskripsi?>">
            <p><?= $errdeskripsi; ?></p>

            <button type="submit" class="tombolTambah">+ Tambah</button>

        </form>
    </div>
    <!-- MEMANGGIL FOOTER -->
    <?php include BASE_PATH . '/components/footer.php'; ?>
</body>
</html>

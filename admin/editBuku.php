<?php
session_start();
require_once('../base.php');
require_once('../function.php');
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

// CEK AKSES ADMIN
if($_SESSION['aktor'] == "pemustaka"){
    header("Location:../index.php");
    exit();
}

// CEK BUKU SEBELUM EDIT
if(!isset($_POST['judul'])){
    $id = $_GET['idBuku'];
    $detail = detailbuku($id);
}

// INISIALISASI VARIABEL SEBELUM DI SUBMIT
$judul = $penulis = $tahun = $penerbit = $halaman = $bahasa = $kategoriBuku = $deskripsi = "";
$errjudul = $errpenulis = $errtahun = $errpenerbit = $errhalaman = $errbahasa = $errkategori = $errdeskripsi = "";

// MEMPERBARUI DATA
if(isset($_POST['judul'])){
    $idBuku = $_POST['idBuku'];
    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $tahun = htmlspecialchars($_POST['tahun']);
    $penerbit = htmlspecialchars($_POST['penerbit']);
    $halaman = htmlspecialchars($_POST['halaman']);
    $bahasa = htmlspecialchars($_POST['bahasa']);
    $kategoriBuku = htmlspecialchars($_POST['kategoribuku']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    // CEK COVER TERISI
    if($_FILES['coverBuku']['name'] != "" ) {
        $coverBuku = $_FILES['coverBuku']['name'];
        $coverBuku = str_replace(' ', '', $coverBuku);
        $namaCover = $tahun . $coverBuku;
        $tmp = $_FILES['coverBuku']['tmp_name'];
    }

    // VALIDASI
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

    // JIKA TIDAK ADA ERROR, EDIT BUKU KE DATABASE
    if($errjudul == "" && $errpenulis == "" && $errtahun == "" && $errpenerbit == "" && $errhalaman == "" && $errbahasa == "" && $errkategori == "" && $errdeskripsi == ""){
        editBuku($idBuku, $judul, $penulis, $tahun, $penerbit, $halaman, $bahasa, $kategoriBuku, $deskripsi);
        if($_FILES['coverBuku']['name'] != ''){
            $detail = detailbuku($idBuku);
            unlink(("../assets/coverBuku/" . $detail['urlCover']));
            uploadcoverbuku($judul, $namaCover);
            move_uploaded_file($tmp, "../assets/coverBuku/" . $namaCover);
        }
        header('Location: manage.php');
        exit();
    }   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIPUSTAKA</title>
    <link rel="stylesheet" href="../assets/form.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <!-- MEMANGGIL HEADER -->
    <?php include BASE_PATH . '../components/header.php'; ?>

    <div class="tombolkembali">
        <a href="manage.php">kembali</a>
    </div>

    <!-- ISI KONTEN FORM EDIT BUKU -->
    <div class="editbuku">
        <h1>Edit Buku</h1>
        <form action="editBuku.php" method="post" class="formedit" enctype="multipart/form-data">
            <label for="coverBuku">Cover Buku:</label>
            <i>Isi Jika Ingin Merubah Cover*</i>
            <input type="file" name="coverBuku">

            <label for="judul">Judul Buku:</label>
            <input type="text" id="judul" name="judul" value="<?php if(isset($_GET['idBuku'])){echo $detail['judulBuku'];}else{ echo $judul;}?>">
            <p><?= $errjudul; ?></p>

            <label for="penulis">Penulis:</label>
            <input type="text" id="penulis" name="penulis" value="<?php if(isset($_GET['idBuku'])){echo $detail['penulis'];}else{ echo $penulis;}?>">
            <p><?= $errpenulis; ?></p>

            <label for="tahun">Tahun Terbit:</label>
            <input type="text" id="tahun" name="tahun" value="<?php if(isset($_GET['idBuku'])){echo $detail['tahunTerbit'];}else{ echo $tahun;}?>">
            <p><?= $errtahun;?></p>

            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" value="<?php if(isset($_GET['idBuku'])){echo $detail['penerbit'];}else{ echo $penerbit;}?>">
            <p><?= $errpenerbit; ?></p>

            <label for="halaman">Halaman:</label>
            <input type="text" id="halaman" name="halaman" value="<?php if(isset($_GET['idBuku'])){echo $detail['halaman'];}else{ echo $halaman;}?>">
            <p><?= $errhalaman; ?></p>

            <label for="bahasa">Bahasa:</label>
            <input type="text" id="bahasa" name="bahasa" value="<?php if(isset($_GET['idBuku'])){echo $detail['bahasa'];}else{ echo $bahasa;}?>">
            <p><?= $errbahasa; ?></p>

            <label for="kategori">Kategori Buku:</label>
            <select name="kategoribuku">
                <option value="">Pilih Kategori</option>
                <option value="Hukum" <?php if(isset($_GET['idBuku'])){if($detail['kategoriBuku'] == "Hukum"){echo "selected";}}else{if($kategoriBuku == "Hukum"){echo "selected";}} ?>>Hukum</option>
                <option value="Ilmu Komputer" <?php if(isset($_GET['idBuku'])){if($detail['kategoriBuku'] == "Ilmu Komputer"){echo "selected";}}else{if($kategoriBuku == "Ilmu Komputer"){echo "selected";}} ?>>Ilmu Komputer</option>
                <option value="Agama" <?php if(isset($_GET['idBuku'])){if($detail['kategoriBuku'] == "Agama"){echo "selected";}}else{if($kategoriBuku == "Agama"){echo "selected";}} ?>>Agama</option>
                <option value="Ilmu Sosial" <?php if(isset($_GET['idBuku'])){if($detail['kategoriBuku'] == "Ilmu Sosial"){echo "selected";}}else{if($kategoriBuku == "Ilmu Sosial"){echo "selected";}} ?>>Ilmu Sosial</option>
                <option value="Sejarah" <?php if(isset($_GET['idBuku'])){if($detail['kategoriBuku'] == "Sejarah"){echo "selected";}}else{if($kategoriBuku == "Sejarah"){echo "selected";}} ?>>Sejarah</option>
                <option value="Seni" <?php if(isset($_GET['idBuku'])){if($detail['kategoriBuku'] == "Seni"){echo "selected";}}else{if($kategoriBuku == "Seni"){echo "selected";}} ?>>Seni</option>
            </select>
            <p><?= $errkategori; ?></p>

            <label for="deskripsi">Deskripsi:</label>
            <input type="text" id="deskripsi" name="deskripsi" value="<?php if(isset($_GET['idBuku'])){echo $detail['deskripsi'];}else{ echo $deskripsi;}?>">
            <p><?= $errdeskripsi; ?></p>
            
            <input type="hidden" value="<?= $id?>" name="idBuku">
            <button type="submit" class="tombolSimpan">Simpan</button>
        </form>
    </div>

    <!-- MEMANGGIL FOOTER -->
    <?php include BASE_PATH . '/components/footer.php'; ?>
</body>
</html>

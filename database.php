<?php 
 require_once("base.php");
 require_once(BASE_PATH . '/conn.php');

// FUNCTION MENGAMBIL DATA PEMUSTAKA DARI DATABASE
function getAllpemustaka(){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM pemustaka");
    $stmt->execute();
    return $stmt->fetchAll();
}

// FUNCTION MENGAMBIL DATA BUKU DARI DATABASE
function getAllBuku(){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM buku");
    $stmt->execute();
    return $stmt->fetchAll();
}

// FUNCTION MENGAMBIL DATA PEMINJAM BUKU DARI DATABASE
function getAllPeminjam(){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM peminjam");
    $stmt->execute();
    return $stmt->fetchAll();
}

// FUNCTION MENGAMBIL DATA BUKU TERBARU DARI DATABASE MENGGUNAKAN ID BUKU DESCENDING
function getBukuTerbaru($limit = 3){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM buku ORDER BY idBuku DESC LIMIT :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// FUNCTION MENCARI BUKU BERDASARKAN JUDUL BUKU
function caribuku(){
    global $DBH;
    if (isset($_GET['search'])) {
        $searchInput = '%' . $_GET['search-input'] . '%';
        $stmt = $DBH->prepare("SELECT * FROM buku WHERE judulBuku LIKE :searchInput");
        $stmt->bindParam(':searchInput', $searchInput, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

// FUNCTION MENGAMBIL DATA PEMUSTAKA BERDASARKAN ID PEMUSTAKA
function ambilpemustaka($idPemustaka){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM pemustaka WHERE idPemustaka = :idPemustaka");
    $stmt->bindParam(':idPemustaka', $idPemustaka, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

// FUNCTION MENGHITUNG TOTAL BUKU YANG DIMILIKI TABEL BUKU DI DATABASE
function totalbuku(){
    global $DBH;
    $stmt = $DBH->prepare("SELECT COUNT(*) as total From buku;");
    $stmt->execute();
    $result = $stmt->fetch();
    return $result["total"];
}

// FUNCTION MENGAMBIL DETAIL BUKU BERDASARKAN ID BUKU DI DATABASE
function detailbuku($idBuku){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM buku WHERE idBuku = :idBuku");
    $stmt->bindParam(':idBuku', $idBuku);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

// FUNCTION MENAMBAH DATA BUKU BARU KE DATABASE
function tambahBuku($judul, $penulis, $tahun, $penerbit, $halaman, $bahasa, $kategoriBuku, $deskripsi){
    global $DBH;
    $stmt = $DBH->prepare("INSERT INTO buku (judulBuku, penulis, tahunTerbit, penerbit, halaman, bahasa, kategoriBuku, deskripsi) VALUES (:judul, :penulis, :tahun, :penerbit, :halaman, :bahasa, :kategoriBuku, :deskripsi)");
    $stmt->bindParam(':judul', $judul);
    $stmt->bindParam(':penulis', $penulis);
    $stmt->bindParam(':tahun', $tahun);
    $stmt->bindParam(':penerbit', $penerbit);
    $stmt->bindParam(':halaman', $halaman);
    $stmt->bindParam(':bahasa', $bahasa);
    $stmt->bindParam(':kategoriBuku', $kategoriBuku);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->execute();
}

// FUNCTION MENGEDIT DATA BUKU DI DATABASE
function editbuku($idBuku, $judul, $penulis, $tahun, $penerbit, $halaman, $bahasa, $kategoriBuku, $deskripsi){
    global $DBH;
    $stmt = $DBH->prepare("UPDATE buku SET judulBuku = :judul, penulis = :penulis, tahunTerbit = :tahun, penerbit = :penerbit, halaman = :halaman, bahasa = :bahasa, kategoriBuku = :kategoriBuku, deskripsi = :deskripsi WHERE idBuku = :idBuku");
    $stmt->bindParam(':idBuku', $idBuku);
    $stmt->bindParam(':judul', $judul);
    $stmt->bindParam(':penulis', $penulis);
    $stmt->bindParam(':tahun', $tahun);
    $stmt->bindParam(':penerbit', $penerbit);
    $stmt->bindParam(':halaman', $halaman);
    $stmt->bindParam(':bahasa', $bahasa);
    $stmt->bindParam(':kategoriBuku', $kategoriBuku);
    $stmt->bindParam(':deskripsi', $deskripsi);
    $stmt->execute();
}

// FUNCTION MENGHAPUS DATA BUKU DARI DATABASE
function hapusbuku($idBuku){
    global $DBH;
    $stmt = $DBH->prepare("DELETE FROM buku WHERE idBuku = :idBuku");
    $stmt->bindParam(':idBuku', $idBuku);
    $stmt->execute();
}

// FUNCTION MEMBUAT PERMOHONAN PEMINJAMAN BUKU YANG DI LAKUKAN PEMUSTAKA
function pinjam($idPemustaka, $idBuku){
    global $DBH;
    $stmt = $DBH->prepare("INSERT INTO peminjam (foreignPemustaka, foreignBuku, statusPinjam) VALUES (:idPemustaka, :idBuku, 'permohonan')");
    $stmt->bindParam(':idPemustaka', $idPemustaka);
    $stmt->bindParam(':idBuku', $idBuku);
    $stmt->execute();
}

// FUNCTION MENGAMBIL RIWAYAT PEMINJAMAN BUKU BERDASARKAN ID PEMUSTAKA DI DATABASE
function riwayatpinjam($idPemustaka){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM peminjam WHERE foreignPemustaka = :idPemustaka");
    $stmt->bindParam(':idPemustaka', $idPemustaka);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

// FUNCTION MENGUBAH STATUS BUKU DI DATABASE
function ubahStatusBuku($idBuku,$statusBuku){
    global $DBH;
    $stmt = $DBH->prepare("UPDATE buku SET statusBuku = :statusBuku WHERE idBuku = :idBuku");
    $stmt->bindParam(':idBuku', $idBuku);
    $stmt->bindParam(':statusBuku', $statusBuku);
    $stmt->execute();
}

// FUNCTION MENGUBAH STATUS PEMINJAM DI DATABASE
function ubahStatusPeminjam($idPeminjam,$statusPinjam){
    global $DBH;
    $stmt = $DBH->prepare("UPDATE peminjam SET statusPinjam = :statusPinjam WHERE idPeminjam = :idPeminjam");
    $stmt->bindParam(':idPeminjam', $idPeminjam);
    $stmt->bindParam(':statusPinjam', $statusPinjam);
    $stmt->execute();
}

// FUNCTION MENGHITUNG TOTAL PINJAMAN YANG DILAKUKAN PEMUSTAKA BERDASARKAN ID PEMUSTAKA
function totalPinjamanPemustaka($idPemustaka){
    global $DBH;
    $stmt = $DBH->prepare("SELECT COUNT(*) as total From peminjam where foreignPemustaka = :idPemustaka AND statusPinjam IN ('Dipinjam', 'Permohonan')");
    $stmt->bindParam(':idPemustaka', $idPemustaka);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result["total"];
}

// LOGIN ADMIN
function isAdminNIP($NIP){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * FROM admin Where noIndukAdmin = :NIP;");
    $stmt->bindParam(':NIP', $NIP);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

// LOGIN PEMUSTAKA
function isPemustakaNIM($NIM){
    global $DBH;
    $stmt = $DBH->prepare("SELECT * From pemustaka where noIndukPemustaka = :NIM;");
    $stmt->bindParam(':NIM', $NIM);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}

// FUNCTION MENAMBAH DATA PEMUSTAKA BARU KE DATABASE
function tambahPemustaka($namaDepan, $noIndukPemustaka, $namaBelakang, $alamatPemustaka, $noTlpnPemustaka, $emailPemustaka, $passwordPemustaka){
    global $DBH;
    $stmt = $DBH->prepare("INSERT INTO pemustaka (namaDepan, noIndukPemustaka, namaBelakang, alamatPemustaka, noTlpnPemustaka, emailPemustaka, passwordPemustaka) VALUES (:namaDepan, :noIndukPemustaka, :namaBelakang, :alamatPemustaka, :noTlpnPemustaka, :emailPemustaka, :passwordPemustaka)");
    $stmt->bindParam(':namaDepan', $namaDepan);
    $stmt->bindParam(':noIndukPemustaka', $noIndukPemustaka);
    $stmt->bindParam(':namaBelakang', $namaBelakang);
    $stmt->bindParam(':alamatPemustaka', $alamatPemustaka);
    $stmt->bindParam(':noTlpnPemustaka', $noTlpnPemustaka);
    $stmt->bindParam(':emailPemustaka', $emailPemustaka);
    $pass = hash('sha256', $passwordPemustaka);
    $stmt->bindParam(':passwordPemustaka', $pass);
    $stmt->execute();
}

// FUNCTION MENGEDIT DATA PEMUSTAKA DI DATABASE
function editPemustaka($idPemustaka, $namaDepan, $namaBelakang, $emailPemustaka, $noTlpnPemustaka, $alamatPemustaka){
    global $DBH;
    $stmt = $DBH->prepare("UPDATE pemustaka SET namaDepan = :namaDepan, namaBelakang = :namaBelakang, emailPemustaka = :emailPemustaka, noTlpnPemustaka = :noTlpnPemustaka, alamatPemustaka = :alamatPemustaka WHERE idPemustaka = :idPemustaka");
    $stmt->bindParam(':namaDepan', $namaDepan);
    $stmt->bindParam(':namaBelakang', $namaBelakang);
    $stmt->bindParam(':idPemustaka', $idPemustaka);
    $stmt->bindParam(':emailPemustaka', $emailPemustaka);
    $stmt->bindParam(':noTlpnPemustaka', $noTlpnPemustaka);
    $stmt->bindParam(':alamatPemustaka', $alamatPemustaka);
    $stmt->execute();
}

// FUNCTION MENGUPLOAD COVER BUKU DI DATABASE
function uploadcoverbuku($judulBuku, $urlCover){
    global $DBH;
    $stmt = $DBH->prepare("UPDATE buku SET urlCover = :urlCover WHERE judulBuku = :judulBuku");
    $stmt->bindParam(':judulBuku', $judulBuku);
    $stmt->bindParam(':urlCover', $urlCover);
    $stmt->execute();
}
?>
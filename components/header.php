<!-- BAGIAN HEADER YANG AKAN DI PANNGIL DI SETAIP HALAMAN WEB -->
<?php 
require_once(BASE_PATH . '/database.php');
require_once(BASE_PATH . '/session.php');

$pemustaka = ambilpemustaka($_SESSION['id']); 
?>

<div class="header">
    <div class="logo-section">
        <div class="logo"><img src="<?= BASE_URL ?>/assets/LOGO1.png" alt="logo"></div>
        <div class="logo-text">
            <h1>UNIPUSTAKA</h1>
            <p>Perpustakaan Universitas</p>
        </div>
    </div>

    <div class="kosong"></div>

    <?php if ($_SESSION['aktor'] == 'pemustaka'):?>
        <a href=<?= BASE_URL . '/pemustaka/editProfil.php' ?>>
            <div class="profile-btn">
                <div class="profile-icon">👤</div>
                <span><?= $pemustaka['namaDepan']?></span>
            </div>
        </a>
        <?php endif; ?>
        <a href=<?= BASE_URL . '/logout.php' ?>>
        <div class="logout-btn">
            <span>LogOut</span>
        </div>
        </a>
</div>

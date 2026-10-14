<!-- BAGIAN SIDEBAR YANG AKAN DI PANGGIL DI SETAIP HALAMAN WEB UNTUK HALAMAN PEMUSTAKA -->
<div class="sidebar">
    <a href="?page=beranda" class="menu-item <?php echo $page == 'beranda' ? 'active' : ''; ?>">
        <div>Beranda</div>
    </a>
    <a href="?page=koleksi" class="menu-item <?php echo $page == 'koleksi' ? 'active' : ''; ?>">
        <div>Koleksi</div>
    </a>
    <a href="?page=pinjam" class="menu-item <?php echo $page == 'pinjam' ? 'active' : ''; ?>">
        <div>Pinjam</div>
    </a>
</div>
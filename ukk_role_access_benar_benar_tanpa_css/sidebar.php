<?php 
$role = strtolower($_SESSION['role'] ?? ''); 
?>
<div class="col-md-3 col-lg-2 bg-black text-white p-3 d-flex flex-column justify-content-between" style="min-height: 100vh;">
    <div>
        <h4 class="text-white mb-4 fw-bold pb-2 border-bottom border-secondary">My Website</h4>
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link text-white active bg-info">Dashboard</a>
            </li>

            <!-- MENU KHUSUS ADMIN -->
            <?php if ($role === 'admin'): ?>
                <li class="text-muted small mt-3 mb-1 px-2 fw-bold text-uppercase">MASTER DATA ADMIN</li>
                <li class="nav-item"><a href="kelola_siswa.php" class="nav-link text-white">Kelola Siswa</a></li>
                <li class="nav-item"><a href="kelola_guru.php" class="nav-link text-white">Kelola Guru</a></li>
                <li class="nav-item"><a href="kelola_kelas.php" class="nav-link text-white">Kelola Kelas</a></li>
                <li class="nav-item"><a href="kelola_tahun_ajaran.php" class="nav-link text-white">Kelola Tahun Ajaran</a></li>
                <li class="nav-item"><a href="penempatan_siswa.php" class="nav-link text-white">Penempatan Siswa</a></li>
                <li class="nav-item"><a href="kelola_wali_kelas.php" class="nav-link text-white">Kelola Wali Kelas</a></li>
                <li class="nav-item"><a href="kategori_pelanggaran.php" class="nav-link text-white">Kategori Pelanggaran</a></li>
                <li class="nav-item"><a href="jenis_pelanggaran.php" class="nav-link text-white">Jenis Pelanggaran</a></li>
                <li class="nav-item"><a href="cetak_export.php" class="nav-link text-white">Cetak / Export</a></li>
            <?php endif; ?>

            <!-- MENU PELANGGARAN (Bisa diakses Admin & Guru) -->
            <li class="text-muted small mt-3 mb-1 px-2 fw-bold text-uppercase">PELANGGARAN</li>
            <li class="nav-item"><a href="catat_pelanggaran.php" class="nav-link text-white">Catat Pelanggaran</a></li>
            <li class="nav-item"><a href="tindakan.php" class="nav-link text-white">Tindakan</a></li>
            <li class="nav-item"><a href="laporan.php" class="nav-link text-white">Laporan</a></li>
            <li class="nav-item"><a href="riwayat.php" class="nav-link text-white">Riwayat</a></li>
            <li class="nav-item"><a href="rekap_poin.php" class="nav-link text-white">Rekap Poin</a></li>
        </ul>
    </div>
    <div>
        <hr class="text-secondary">
        <a href="logout.php" class="btn text-white w-100 text-start fw-bold" style="background-color: #a91d3a;">Logout</a>
    </div>
</div>
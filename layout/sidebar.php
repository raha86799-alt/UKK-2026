<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
$role = strtolower(trim($_SESSION['role'] ?? 'guru'));
?>

<!-- SIDEBAR TERPUSAT -->
<div class="col-md-3 col-lg-2 bg-dark p-3 d-flex flex-column justify-content-between" style="min-height: 100vh; position: sticky; top: 0; height: 100vh; overflow-y: auto;">
    <div>
        <h4 class="text-white mb-4 fw-bold pb-2 border-bottom border-secondary">
            Pelanggaran Siswa
        </h4>

        <ul class="nav nav-pills flex-column">

            <!-- MENU UTAMA (SELALU MUNCUL UNTUK SEMUA ROLE) -->
            <li class="nav-item mb-2">
                <a href="dashboard.php" class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : 'text-white' ?>">
                    Dashboard
                </a>
            </li>

            <!-- MENU KHUSUS ADMIN -->
            <?php if ($role === 'admin'): ?>
                <li class="nav-item mb-2">
                    <a href="kelola_siswa.php" class="nav-link <?= (in_array($current_page, ['kelola_siswa.php', 'tambah_siswa.php', 'edit_siswa.php'])) ? 'active' : 'text-white' ?>">
                        Data Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_guru.php" class="nav-link <?= (in_array($current_page, ['kelola_guru.php', 'tambah_guru.php', 'edit_guru.php'])) ? 'active' : 'text-white' ?>">
                        Data Guru
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_kelas.php" class="nav-link <?= (in_array($current_page, ['kelola_kelas.php', 'tambah_kelas.php', 'edit_kelas.php'])) ? 'active' : 'text-white' ?>">
                        Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="penempatan_siswa.php" class="nav-link <?= (in_array($current_page, ['penempatan_siswa.php', 'tambah_penempatan_siswa.php', 'edit_penempatan_siswa.php'])) ? 'active' : 'text-white' ?>">
                        Penempatan Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kategori_pelanggaran.php" class="nav-link <?= (in_array($current_page, ['kategori_pelanggaran.php', 'tambah_kategori_pelanggaran.php', 'edit_kategori_pelanggaran.php'])) ? 'active' : 'text-white' ?>">
                        Kategori Pelanggaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="about.php" class="nav-link <?= ($current_page == 'about.php') ? 'active' : 'text-white' ?>">
                        About
                    </a>
                </li>
            <?php endif; ?>

            <!-- MENU KHUSUS GURU -->
            <?php if ($role === 'guru' || $role === 'wali_kelas'): ?>
                <li class="nav-item mb-2">
                    <a href="catat_pelanggaran.php" class="nav-link <?= ($current_page == 'catat_pelanggaran.php') ? 'active' : 'text-white' ?>">
                        Catat Pelanggaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="riwayat.php" class="nav-link <?= ($current_page == 'riwayat.php') ? 'active' : 'text-white' ?>">
                        Riwayat
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="rekap_poin.php" class="nav-link <?= ($current_page == 'rekap_poin.php') ? 'active' : 'text-white' ?>">
                        Rekap Poin Siswa
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>

    <div>
        <hr class="text-secondary">
        <a href="logout.php" class="btn text-white w-100 text-start fw-bold" style="background-color: #a91d3a;">
            Logout
        </a>
    </div>
</div>
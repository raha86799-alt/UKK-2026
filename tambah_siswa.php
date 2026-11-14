<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config.php';

if (function_exists('requireRole')) {
    requireRole(['admin', 'guru']);
}

$title = 'Tambah Siswa';
$section = 'admin';
$pesan = '';
$jenisPesan = 'danger';

// Ambil kelas dan tahun ajaran aktif dari struktur database UKK-2026.
try {
    $stmtKelas = $pdo->query("SELECT id, nama FROM t_kelas WHERE status_aktif = 1 ORDER BY nama");
    $daftarKelas = $stmtKelas->fetchAll();

    $stmtTahun = $pdo->query("SELECT id, nama, tanggal_mulai, tanggal_selesai FROM t_tahun_ajaran WHERE status_aktif = 1 ORDER BY tanggal_mulai DESC LIMIT 1");
    $tahunAktif = $stmtTahun->fetch();
} catch (PDOException $e) {
    $daftarKelas = [];
    $tahunAktif = null;
    $pesan = 'Gagal mengambil data kelas/tahun ajaran: ' . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = trim($_POST['nis'] ?? '');
    $nisn = trim($_POST['nisn'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $kelasId = filter_var($_POST['kelas_id'] ?? null, FILTER_VALIDATE_INT);
    $jenisKelamin = $_POST['jenis_kelamin'] ?? '';
    $tanggalLahir = $_POST['tanggal_lahir'] ?? '';
    $statusAktif = filter_var($_POST['status_aktif'] ?? '1', FILTER_VALIDATE_INT);
    $alamat = trim($_POST['alamat'] ?? '');

    if (!preg_match('/^\d{1,10}$/', $nis) ||
        !preg_match('/^\d{1,15}$/', $nisn) ||
        $nama === '' ||
        !$kelasId ||
        !in_array($jenisKelamin, ['L', 'P'], true) ||
        !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalLahir) ||
        !checkdate((int)substr($tanggalLahir, 5, 2), (int)substr($tanggalLahir, 8, 2), (int)substr($tanggalLahir, 0, 4)) ||
        !in_array($statusAktif, [0, 1], true) ||
        $alamat === '') {
        $pesan = 'Data belum lengkap atau format NIS/NISN/tanggal lahir tidak valid.';
    } elseif (!$tahunAktif) {
        $pesan = 'Tidak ada tahun ajaran aktif. Aktifkan tahun ajaran terlebih dahulu sebelum menambahkan siswa.';
    } else {
        try {
            // Pastikan kelas yang dipilih memang tersedia dan aktif.
            $cekKelas = $pdo->prepare("SELECT id FROM t_kelas WHERE id = ? AND status_aktif = 1");
            $cekKelas->execute([$kelasId]);
            if (!$cekKelas->fetch()) {
                throw new RuntimeException('Kelas yang dipilih tidak ditemukan atau tidak aktif.');
            }

            // Cek NIS/NISN agar tidak menambahkan data ganda.
            $cek = $pdo->prepare("SELECT id FROM t_siswa WHERE nis = ? OR nisn = ? LIMIT 1");
            $cek->execute([$nis, $nisn]);
            if ($cek->fetch()) {
                throw new RuntimeException('NIS atau NISN sudah digunakan siswa lain.');
            }

            $pdo->beginTransaction();

            // t_siswa pada database ini tidak menyimpan kelas_id.
            $insertSiswa = $pdo->prepare(
                "INSERT INTO t_siswa (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif, created_at, updated_at)
                 VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())"
            );
            $insertSiswa->execute([$nis, $nisn, $nama, $jenisKelamin, $tanggalLahir, $alamat, $statusAktif]);
            $siswaId = (int)$pdo->lastInsertId();

            // Relasi kelas dan tahun ajaran disimpan di t_kelas_siswa.
            $insertPenempatan = $pdo->prepare(
                "INSERT INTO t_kelas_siswa
                 (siswa_id, tahun_ajaran_id, kelas_id, tanggal_mulai, tanggal_selesai, status_aktif, created_at, updated_at)
                 VALUES (?, ?, ?, ?, ?, 1, NOW(), NOW())"
            );
            $insertPenempatan->execute([
                $siswaId,
                (int)$tahunAktif['id'],
                $kelasId,
                $tahunAktif['tanggal_mulai'],
                $tahunAktif['tanggal_selesai']
            ]);

            $pdo->commit();
            $_SESSION['flash_success'] = 'Data siswa berhasil ditambahkan dan ditempatkan pada kelas ' . $daftarKelas[array_search($kelasId, array_column($daftarKelas, 'id'))]['nama'] . '.';
            header('Location: kelola_siswa.php');
            exit;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $pesan = $e instanceof RuntimeException ? $e->getMessage() : 'Gagal menyimpan data siswa: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body { background-color: #f4f4f4; overflow-x: hidden; margin: 0; }
        .content-card { background-color: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 25px; box-shadow: 0 2px 5px rgba(0,0,0,.05); margin-bottom: 30px; }
    </style>
</head>
<body>
<div class="container-fluid d-flex p-0" style="min-height: 100vh;">
    <div class="row flex-grow-1 g-0 w-100">
        <?php include __DIR__ . "/layout/sidebar.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h3 class="mb-4 fw-bold">Kelola Siswa</h3>
            <div class="content-card shadow-sm">
                <h5 class="fw-bold mb-3">Tambah Data Siswa</h5>
                <?php if ($pesan !== ''): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
                <?php if (!$tahunAktif): ?>
                    <div class="alert alert-warning">Tahun ajaran aktif belum tersedia. Aktifkan tahun ajaran terlebih dahulu.</div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control angka-saja" id="nis" name="nis" maxlength="10" inputmode="numeric"  pattern="[0-9]{1,10}" value="<?= htmlspecialchars($_POST['nis'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control angka-saja" id="nisn" name="nisn" maxlength="15" inputmode="numeric" pattern="[0-9]{1,15}" value="<?= htmlspecialchars($_POST['nisn'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama" name="nama" maxlength="150" value="<?= htmlspecialchars($_POST['nama'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($daftarKelas as $kelas): ?>
                                    <option value="<?= (int)$kelas['id'] ?>" <?= (($_POST['kelas_id'] ?? '') == $kelas['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($kelas['nama'], ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (!$daftarKelas): ?><div class="form-text text-danger">Belum ada kelas aktif. Tambahkan/aktifkan kelas terlebih dahulu.</div><?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" <?= (($_POST['jenis_kelamin'] ?? '') === 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= (($_POST['jenis_kelamin'] ?? '') === 'P') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= htmlspecialchars($_POST['tanggal_lahir'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status_aktif" class="form-label">Status Aktif</label>
                            <select class="form-select" id="status_aktif" name="status_aktif" required>
                                <option value="1" <?= (($_POST['status_aktif'] ?? '1') === '1') ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= (($_POST['status_aktif'] ?? '') === '0') ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required><?= htmlspecialchars($_POST['alamat'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning fw-semibold px-4 text-dark" <?= (!$daftarKelas || !$tahunAktif) ? 'disabled' : '' ?>>Simpan</button>
                        <a href="kelola_siswa.php" class="btn btn-secondary fw-semibold px-4 ms-2">Kembali</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>document.querySelectorAll(".angka-saja").forEach(el=>el.addEventListener("input",()=>el.value=el.value.replace(/[^0-9]/g,"")));</script>
</body>
</html>

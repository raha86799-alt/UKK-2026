<?php
session_start();
require_once __DIR__ . '/includes/cek_session.php';
require_once __DIR__ . '/config/koneksi.php';

$embed = (($_POST['embed'] ?? '') === '1');
function backCatatan($embed) {
    header('Location: catatan_pelanggaran.php' . ($embed ? '?embed=1' : ''));
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') backCatatan($embed);

$sid = (int)($_POST['siswa_id'] ?? 0);
$pilihan = trim((string)($_POST['pelanggaran_id'] ?? ''));
$tanggal = trim($_POST['tanggal'] ?? '');
$ket = trim($_POST['keterangan'] ?? '');
if (!$sid || $pilihan === '' || !$tanggal || $ket === '') {
    $_SESSION['pesan'] = 'Siswa, pelanggaran, tanggal, dan keterangan wajib diisi.';
    backCatatan($embed);
}

// Pilihan dapat berupa jenis:<id> atau kategori:<id>.
$bagian = explode(':', $pilihan, 2);
$tipePilihan = $bagian[0] ?? '';
$idPilihan = isset($bagian[1]) ? (int)$bagian[1] : 0;
if (!in_array($tipePilihan, ['jenis', 'kategori'], true) || $idPilihan <= 0) {
    $_SESSION['pesan'] = 'Pilihan pelanggaran tidak valid. Silakan pilih ulang.';
    backCatatan($embed);
}

$st = mysqli_prepare($koneksi, "SELECT s.id,s.nama,ks.tahun_ajaran_id,ks.kelas_id,k.nama nama_kelas FROM t_siswa s LEFT JOIN t_kelas_siswa ks ON ks.siswa_id=s.id AND ks.status_aktif=1 LEFT JOIN t_kelas k ON k.id=ks.kelas_id WHERE s.id=? AND s.status_aktif=1 ORDER BY ks.id DESC LIMIT 1");
mysqli_stmt_bind_param($st, 'i', $sid);
mysqli_stmt_execute($st);
$s = mysqli_fetch_assoc(mysqli_stmt_get_result($st));
mysqli_stmt_close($st);

// Validasi akses wali kelas tetap diberlakukan.
if ($s && hak_role_efektif() === HAK_WALI_KELAS) {
    $uid = (int)($_SESSION['id'] ?? 0);
    $tahunSiswa = (int)($s['tahun_ajaran_id'] ?? 0);
    $kelasSiswa = (int)($s['kelas_id'] ?? 0);
    $cekWali = mysqli_prepare($koneksi, "SELECT 1 FROM t_wali_kelas wk INNER JOIN t_guru g ON g.id=wk.guru_id WHERE g.user_id=? AND wk.status_aktif=1 AND wk.kelas_id=? AND (wk.tahun_ajaran_id=? OR wk.tahun_ajaran_id IS NULL) LIMIT 1");
    mysqli_stmt_bind_param($cekWali, 'iii', $uid, $kelasSiswa, $tahunSiswa);
    mysqli_stmt_execute($cekWali);
    $bolehCatat = mysqli_num_rows(mysqli_stmt_get_result($cekWali)) > 0;
    mysqli_stmt_close($cekWali);
    if (!$bolehCatat) {
        $_SESSION['pesan'] = 'Anda hanya dapat mencatat pelanggaran siswa di kelas perwalian Anda.';
        backCatatan($embed);
    }
}

$pid = null;
$kategori = 0;
$poin = 0;
if ($tipePilihan === 'jenis') {
    $st = mysqli_prepare($koneksi, "SELECT id,nama,poin,pelanggaran_kategori_id FROM t_pelanggaran WHERE id=? AND status_aktif=1 LIMIT 1");
    mysqli_stmt_bind_param($st, 'i', $idPilihan);
    mysqli_stmt_execute($st);
    $p = mysqli_fetch_assoc(mysqli_stmt_get_result($st));
    mysqli_stmt_close($st);
    if (!$p) {
        $_SESSION['pesan'] = 'Jenis pelanggaran tidak ditemukan atau tidak aktif.';
        backCatatan($embed);
    }
    $pid = (int)$p['id'];
    $namaPelanggaran = $p['nama'];
    $kategori = (int)($p['pelanggaran_kategori_id'] ?? 0);
    $poin = (int)$p['poin'];
} else {
    // Kategori dapat dicatat langsung; poin diambil dari bobot poin kategori.
    $st = mysqli_prepare($koneksi, "SELECT id,nama,poin FROM t_pelanggaran_kategori WHERE id=? AND status_aktif=1 LIMIT 1");
    mysqli_stmt_bind_param($st, 'i', $idPilihan);
    mysqli_stmt_execute($st);
    $k = mysqli_fetch_assoc(mysqli_stmt_get_result($st));
    mysqli_stmt_close($st);
    if (!$k) {
        $_SESSION['pesan'] = 'Kategori pelanggaran tidak ditemukan atau tidak aktif.';
        backCatatan($embed);
    }
    $namaPelanggaran = 'Kategori: ' . $k['nama'];
    $kategori = (int)$k['id'];
    $poin = (int)$k['poin'];
}
if (!$s) {
    $_SESSION['pesan'] = 'Data siswa tidak ditemukan atau tidak aktif.';
    backCatatan($embed);
}

$uid = (int)($_SESSION['id'] ?? 0);
$guruId = null;
$namaGuru = trim($_SESSION['name'] ?? 'Guru');
$st = mysqli_prepare($koneksi, "SELECT id,nama FROM t_guru WHERE user_id=? AND status_aktif=1 LIMIT 1");
mysqli_stmt_bind_param($st, 'i', $uid);
mysqli_stmt_execute($st);
$g = mysqli_fetch_assoc(mysqli_stmt_get_result($st));
mysqli_stmt_close($st);
if ($g) {
    $guruId = (int)$g['id'];
    if (!empty($g['nama'])) $namaGuru = $g['nama'];
} elseif (strtolower($_SESSION['role'] ?? '') === 'guru') {
    $_SESSION['pesan'] = 'Akun guru belum terhubung dengan data guru. Hubungi administrator.';
    backCatatan($embed);
}

$tahun = isset($s['tahun_ajaran_id']) ? (int)$s['tahun_ajaran_id'] : null;
$kelas = isset($s['kelas_id']) ? (int)$s['kelas_id'] : null;
$namaKelas = $s['nama_kelas'] ?: 'Belum ditempatkan';
$namaSiswa = $s['nama'];
$tindakan = '';
$status = 'Belum ditindaklanjuti';
$sql = "INSERT INTO t_pelanggaran_siswa (tahun_ajaran_id,siswa_id,nama_siswa,kelas_id,nama_kelas,pelanggaran_id,nama_pelanggaran,pelanggaran_kategori_id,guru_id,nama_guru,tanggal,keterangan,poin,tindakan,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$st = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($st, 'iisisisiisssiss', $tahun, $sid, $namaSiswa, $kelas, $namaKelas, $pid, $namaPelanggaran, $kategori, $guruId, $namaGuru, $tanggal, $ket, $poin, $tindakan, $status);
if (mysqli_stmt_execute($st)) {
    $_SESSION['pesan'] = $tipePilihan === 'kategori'
        ? 'Kategori pelanggaran berhasil dicatat dengan poin kategori.'
        : 'Pelanggaran siswa berhasil dicatat.';
} else {
    $_SESSION['pesan'] = 'Gagal menyimpan pelanggaran: ' . mysqli_stmt_error($st);
}
mysqli_stmt_close($st);
backCatatan($embed);

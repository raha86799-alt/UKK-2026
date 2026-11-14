<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/config/koneksi.php';
if (function_exists('requireRole')) requireRole(['admin', 'guru']);
function eS($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function hasColS(mysqli $db, string $table, string $col): bool {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
    $col = $db->real_escape_string($col);
    $q = $db->query("SHOW COLUMNS FROM `$table` LIKE '$col'");
    return $q && $q->num_rows > 0;
}
$id = filter_var($_GET['id'] ?? 0, FILTER_VALIDATE_INT);
if (!$id || $id < 1) { $_SESSION['pesan']='ID siswa tidak valid.'; header('Location: kelola_siswa.php'); exit; }
$hasKelasId = hasColS($koneksi, 't_siswa', 'kelas_id');
$relQ = $koneksi->query("SHOW TABLES LIKE 't_kelas_siswa'");
$hasRelasi = $relQ && $relQ->num_rows > 0;
$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis=trim($_POST['nis']??''); $nisn=trim($_POST['nisn']??''); $nama=trim($_POST['nama']??'');
    $kelasId=filter_var($_POST['kelas_id']??0,FILTER_VALIDATE_INT); $jk=$_POST['jenis_kelamin']??'';
    $tanggal=$_POST['tanggal_lahir']??''; $alamat=trim($_POST['alamat']??'');
    $status=filter_var($_POST['status_aktif']??1,FILTER_VALIDATE_INT);
    if (!preg_match('/^[0-9]{1,10}$/',$nis) || !preg_match('/^[0-9]{1,15}$/',$nisn)) {
        $pesan='NIS hanya boleh angka (minimal 10 dan maksimal 30 digit) dan NISN hanya boleh angka (maksimal 20 digit).';
    } elseif ($nama==='' || !$kelasId || !in_array($jk,['L','P'],true) || !preg_match('/^\d{4}-\d{2}-\d{2}$/',$tanggal) || !checkdate((int)substr($tanggal,5,2),(int)substr($tanggal,8,2),(int)substr($tanggal,0,4)) || $alamat==='' || !in_array($status,[0,1],true)) {
        $pesan='Periksa kembali semua data yang wajib diisi.';
    } else {
        $cek=$koneksi->prepare('SELECT id FROM t_siswa WHERE (nis=? OR nisn=?) AND id<>? LIMIT 1');
        $cek->bind_param('ssi',$nis,$nisn,$id); $cek->execute(); $duplikat=$cek->get_result()->num_rows>0; $cek->close();
        $kc=$koneksi->prepare('SELECT id FROM t_kelas WHERE id=? LIMIT 1'); $kc->bind_param('i',$kelasId); $kc->execute(); $kelasValid=$kc->get_result()->num_rows>0; $kc->close();
        if ($duplikat) $pesan='NIS atau NISN sudah digunakan siswa lain.';
        elseif (!$kelasValid) $pesan='Kelas yang dipilih tidak ditemukan.';
        else {
            try {
                $koneksi->begin_transaction();
                if ($hasKelasId) {
                    $up=$koneksi->prepare('UPDATE t_siswa SET nis=?,nisn=?,nama=?,kelas_id=?,jenis_kelamin=?,tanggal_lahir=?,alamat=?,status_aktif=?,updated_at=NOW() WHERE id=?');
                    $up->bind_param('sssisssii',$nis,$nisn,$nama,$kelasId,$jk,$tanggal,$alamat,$status,$id);
                } else {
                    $up=$koneksi->prepare('UPDATE t_siswa SET nis=?,nisn=?,nama=?,jenis_kelamin=?,tanggal_lahir=?,alamat=?,status_aktif=?,updated_at=NOW() WHERE id=?');
                    $up->bind_param('ssssssii',$nis,$nisn,$nama,$jk,$tanggal,$alamat,$status,$id);
                }
                if (!$up->execute()) throw new RuntimeException($up->error); $up->close();
                if (!$hasKelasId && $hasRelasi) {
                    $taQ=$koneksi->query('SELECT id,tanggal_mulai,tanggal_selesai FROM t_tahun_ajaran WHERE status_aktif=1 ORDER BY tanggal_mulai DESC LIMIT 1');
                    $ta=$taQ?$taQ->fetch_assoc():null;
                    if (!$ta) throw new RuntimeException('Belum ada tahun ajaran aktif.');
                    $rel=$koneksi->prepare('SELECT id FROM t_kelas_siswa WHERE siswa_id=? AND status_aktif=1 ORDER BY id DESC LIMIT 1');
                    $rel->bind_param('i',$id); $rel->execute(); $rr=$rel->get_result()->fetch_assoc(); $rel->close();
                    $taId=(int)$ta['id']; $mulai=$ta['tanggal_mulai']; $selesai=$ta['tanggal_selesai'];
                    if ($rr) {
                        $rid=(int)$rr['id']; $pr=$koneksi->prepare('UPDATE t_kelas_siswa SET tahun_ajaran_id=?,kelas_id=?,tanggal_mulai=?,tanggal_selesai=?,updated_at=NOW() WHERE id=?');
                        $pr->bind_param('iissi',$taId,$kelasId,$mulai,$selesai,$rid);
                    } else {
                        $pr=$koneksi->prepare('INSERT INTO t_kelas_siswa (siswa_id,tahun_ajaran_id,kelas_id,tanggal_mulai,tanggal_selesai,status_aktif,created_at,updated_at) VALUES (?,?,?,?,?,1,NOW(),NOW())');
                        $pr->bind_param('iisss',$id,$taId,$kelasId,$mulai,$selesai);
                    }
                    if (!$pr->execute()) throw new RuntimeException($pr->error); $pr->close();
                }
                $koneksi->commit(); $_SESSION['pesan']='Data siswa berhasil diperbarui.'; header('Location: kelola_siswa.php'); exit;
            } catch (Throwable $ex) { $koneksi->rollback(); $pesan='Gagal memperbarui siswa: '.$ex->getMessage(); }
        }
    }
}
$st=$koneksi->prepare('SELECT * FROM t_siswa WHERE id=? LIMIT 1'); $st->bind_param('i',$id); $st->execute(); $siswa=$st->get_result()->fetch_assoc(); $st->close();
if (!$siswa) { $_SESSION['pesan']='Data siswa tidak ditemukan.'; header('Location: kelola_siswa.php'); exit; }
$kelasTerpilih=(int)($siswa['kelas_id']??0);
if (!$kelasTerpilih && $hasRelasi) { $r=$koneksi->prepare('SELECT kelas_id FROM t_kelas_siswa WHERE siswa_id=? AND status_aktif=1 ORDER BY id DESC LIMIT 1'); $r->bind_param('i',$id); $r->execute(); $x=$r->get_result()->fetch_assoc(); $kelasTerpilih=(int)($x['kelas_id']??0); $r->close(); }
$qr=$koneksi->query('SELECT id,nama FROM t_kelas ORDER BY nama'); $kelasList=$qr?$qr->fetch_all(MYSQLI_ASSOC):[];
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Edit Siswa</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"><style>body{background:#f4f4f4}.content-card{background:#fff;border:1px solid #e0e0e0;border-radius:8px;padding:30px;box-shadow:0 2px 5px #0000000d}</style></head><body><div class="container-fluid p-0"><div class="row g-0 min-vh-100"><?php include __DIR__.'/layout/sidebar.php'; ?><main class="col-md-9 col-lg-10 p-4"><div class="content-card"><h2>Edit Siswa</h2><p class="text-muted">Perbarui data siswa terdaftar.</p><hr><?php if($pesan!==''): ?><div class="alert alert-danger"><?=eS($pesan)?></div><?php endif; ?>
<form method="post"><div class="row"><div class="col-md-6 mb-3"><label class="form-label" for="nis">NIS</label><input class="form-control angka-saja" id="nis" name="nis" maxlength="10"  pattern="[0-9]{1,10}" inputmode="numeric" value="<?=eS($_POST['nis']??$siswa['nis'])?>" required></div><div class="col-md-6 mb-3"><label class="form-label" for="nisn">NISN</label><input class="form-control angka-saja" id="nisn" name="nisn" maxlength="15" pattern="[0-9]{1,15}" inputmode="numeric" value="<?=eS($_POST['nisn']??$siswa['nisn'])?>" required></div></div>
<div class="mb-3"><label class="form-label" for="nama">Nama Siswa</label><input class="form-control" id="nama" name="nama" maxlength="150" value="<?=eS($_POST['nama']??$siswa['nama'])?>" required></div><div class="mb-3"><label class="form-label" for="kelas_id">Kelas</label><select class="form-select" id="kelas_id" name="kelas_id" required><option value="">-- Pilih Kelas --</option><?php foreach($kelasList as $k): ?><option value="<?=$k['id']?>" <?=((int)($_POST['kelas_id']??$kelasTerpilih)==(int)$k['id'])?'selected':''?>><?=eS($k['nama'])?></option><?php endforeach; ?></select></div>
<div class="row"><div class="col-md-6 mb-3"><label class="form-label" for="jenis_kelamin">Jenis Kelamin</label><select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required><option value="">-- Pilih --</option><option value="L" <?=($_POST['jenis_kelamin']??$siswa['jenis_kelamin'])==='L'?'selected':''?>>Laki-laki</option><option value="P" <?=($_POST['jenis_kelamin']??$siswa['jenis_kelamin'])==='P'?'selected':''?>>Perempuan</option></select></div><div class="col-md-6 mb-3"><label class="form-label" for="tanggal_lahir">Tanggal Lahir</label><input class="form-control" type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?=eS($_POST['tanggal_lahir']??$siswa['tanggal_lahir'])?>" required></div></div>
<div class="mb-3"><label class="form-label" for="status_aktif">Status</label><select class="form-select" id="status_aktif" name="status_aktif"><option value="1" <?=((string)($_POST['status_aktif']??$siswa['status_aktif'])==='1')?'selected':''?>>Aktif</option><option value="0" <?=((string)($_POST['status_aktif']??$siswa['status_aktif'])==='0')?'selected':''?>>Tidak Aktif</option></select></div><div class="mb-3"><label class="form-label" for="alamat">Alamat</label><textarea class="form-control" id="alamat" name="alamat" rows="3" required><?=eS($_POST['alamat']??$siswa['alamat'])?></textarea></div><button class="btn btn-warning" type="submit">Simpan Perubahan</button> <a class="btn btn-secondary" href="kelola_siswa.php">Kembali</a></form></div></main></div></div><script>document.querySelectorAll('.angka-saja').forEach(el=>el.addEventListener('input',()=>el.value=el.value.replace(/[^0-9]/g,'')));</script></body></html>

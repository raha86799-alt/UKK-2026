<?php
include 'includes/cek_session.php'; include 'config/koneksi.php';
$embed=(($_GET['embed']??'')==='1'); function eCat($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
$role = hak_role_efektif();
$uid = (int)($_SESSION['id'] ?? 0);
// Wali kelas hanya melihat dan mencatat pelanggaran siswa di kelas perwaliannya.
$filterSiswa = $role === HAK_WALI_KELAS
    ? " AND EXISTS (SELECT 1 FROM t_wali_kelas wk INNER JOIN t_guru g ON g.id=wk.guru_id WHERE g.user_id={$uid} AND wk.status_aktif=1 AND wk.kelas_id=ks.kelas_id AND (wk.tahun_ajaran_id=ks.tahun_ajaran_id OR wk.tahun_ajaran_id IS NULL))"
    : '';
$filterRiwayat = $role === HAK_WALI_KELAS
    ? " AND EXISTS (SELECT 1 FROM t_wali_kelas wk INNER JOIN t_guru g ON g.id=wk.guru_id WHERE g.user_id={$uid} AND wk.status_aktif=1 AND wk.kelas_id=t_pelanggaran_siswa.kelas_id AND (wk.tahun_ajaran_id=t_pelanggaran_siswa.tahun_ajaran_id OR wk.tahun_ajaran_id IS NULL))"
    : '';
$qSiswa=mysqli_query($koneksi,"SELECT s.id,s.nis,s.nama,COALESCE(k.nama,'Belum ditempatkan') nama_kelas FROM t_siswa s LEFT JOIN t_kelas_siswa ks ON ks.siswa_id=s.id AND ks.status_aktif=1 LEFT JOIN t_kelas k ON k.id=ks.kelas_id WHERE s.status_aktif=1 {$filterSiswa} ORDER BY s.nama");
$qPelanggaran=mysqli_query($koneksi,"SELECT id,kode,nama,poin FROM t_pelanggaran WHERE status_aktif=1 ORDER BY nama");
$qKategori=mysqli_query($koneksi,"SELECT id,nama,poin FROM t_pelanggaran_kategori WHERE status_aktif=1 ORDER BY nama");
$qRiwayat=mysqli_query($koneksi,"SELECT id,tanggal,nama_siswa,(SELECT nis FROM t_siswa WHERE t_siswa.id=t_pelanggaran_siswa.siswa_id) AS nis,nama_kelas,nama_pelanggaran,poin,keterangan,nama_guru FROM t_pelanggaran_siswa WHERE status <> 'Selesai' {$filterRiwayat} ORDER BY tanggal DESC,id DESC LIMIT 100");
if(!$qSiswa||!$qPelanggaran||!$qKategori||!$qRiwayat)die('Gagal memuat data: '.eCat(mysqli_error($koneksi)));
$namaGuru=trim($_SESSION['name']??'Guru');
$st=mysqli_prepare($koneksi,"SELECT nama FROM t_guru WHERE user_id=? AND status_aktif=1 LIMIT 1");mysqli_stmt_bind_param($st,'i',$uid);mysqli_stmt_execute($st);$g=mysqli_fetch_assoc(mysqli_stmt_get_result($st));mysqli_stmt_close($st);if($g&&!empty($g['nama']))$namaGuru=$g['nama'];
?>
<?php if(!$embed):?><!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Catat Pelanggaran</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"></head><body><?php endif;?>
<main class="container-fluid p-3 p-md-4 bg-white"><div class="mb-3"><h2 class="fw-bold">Catat Pelanggaran Siswa</h2><p class="text-secondary">Tambahkan catatan pelanggaran siswa dan kronologi kejadian.</p></div>
<?php if(!empty($_SESSION['pesan'])):?><div class="alert alert-info alert-dismissible fade show"><?=eCat($_SESSION['pesan'])?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php unset($_SESSION['pesan']);endif;?>
<div class="card border-0 shadow-sm mb-4"><div class="card-header bg-primary text-white fw-semibold">Form Tambah Pelanggaran</div><div class="card-body"><form method="post" action="simpan_catatan_pelanggaran.php"><input type="hidden" name="embed" value="<?=$embed?'1':'0'?>"><div class="row g-3">
<div class="col-md-6"><label class="form-label">Nama Siswa</label><div class="input-group mb-2"><input type="search" id="cariSiswaCatatan" class="form-control" placeholder="Cari NIS, nama, atau kelas siswa..."><button class="btn btn-outline-primary" type="button" id="tombolCariSiswa"><i class="bi bi-search"></i> Cari</button><button class="btn btn-outline-secondary" type="button" id="resetCariSiswa">Reset</button></div><select name="siswa_id" id="pilihSiswaCatatan" class="form-select" required><option value="">-- Pilih Siswa --</option><?php while($s=mysqli_fetch_assoc($qSiswa)):?><option value="<?=(int)$s['id']?>"><?=eCat($s['nis'])?> - <?=eCat($s['nama'])?> (<?=eCat($s['nama_kelas'])?>)</option><?php endwhile;?></select><small class="text-muted">Ketik kata kunci lalu tekan tombol Cari.</small></div>
<div class="col-md-6"><label class="form-label">Jenis Pelanggaran</label><input type="search" id="cariJenisPelanggaran" class="form-control mb-2" placeholder="Cari jenis pelanggaran berdasarkan kode atau nama..."><select name="pelanggaran_id" id="jenisPelanggaran" class="form-select" required><option value="">-- Pilih Pelanggaran --</option><?php if(mysqli_num_rows($qPelanggaran)>0):?><optgroup label="Jenis Pelanggaran"><?php while($p=mysqli_fetch_assoc($qPelanggaran)):?><option value="jenis:<?=(int)$p['id']?>"><?=eCat($p['kode']?:'Tanpa kode')?> - <?=eCat($p['nama'])?> (<?= (int)$p['poin']?> poin)</option><?php endwhile;?></optgroup><?php endif;?><?php if(mysqli_num_rows($qKategori)>0):?><optgroup label="Kategori Pelanggaran (pilihan langsung)"><?php while($k=mysqli_fetch_assoc($qKategori)):?><option value="kategori:<?=(int)$k['id']?>">Kategori - <?=eCat($k['nama'])?> (<?= (int)$k['poin']?> poin)</option><?php endwhile;?></optgroup><?php endif;?></select></div>
<div class="col-md-6"><label class="form-label">Tanggal Kejadian</label><input type="date" name="tanggal" class="form-control" value="<?=date('Y-m-d')?>" required></div>
<div class="col-12"><label class="form-label">Keterangan / Kronologi</label><textarea name="keterangan" class="form-control" rows="3" required placeholder="Jelaskan kejadian secara singkat dan jelas..."></textarea></div></div><button class="btn btn-primary mt-3" type="submit">Simpan Pelanggaran</button> <button class="btn btn-outline-secondary mt-3" type="reset">Reset</button></form></div></div>
<div class="card border-0 shadow-sm"><div class="card-header bg-light fw-semibold">Catatan Pelanggaran Aktif</div><div class="card-body"><div class="mb-3"><input type="search" id="cariCatatan" class="form-control" placeholder="Cari siswa berdasarkan NIS/nama, kelas, atau pelanggaran..."></div><div class="table-responsive"><table id="tabelCatatan" class="table table-bordered table-hover align-middle"><thead class="table-light"><tr><th>No</th><th>Tanggal</th><th>Siswa</th><th>Kelas</th><th>Pelanggaran</th><th>Poin</th><th>Keterangan</th><th>Guru</th></tr></thead><tbody><?php $no=1;while($r=mysqli_fetch_assoc($qRiwayat)):?><tr><td><?=$no++?></td><td><?=eCat($r['tanggal'])?></td><td><?=eCat($r['nama_siswa'])?><br><small class="text-muted">NIS: <?=eCat($r['nis']??'')?></small></td><td><?=eCat($r['nama_kelas'])?></td><td><?=eCat($r['nama_pelanggaran'])?></td><td><span class="badge text-bg-danger"><?=(int)$r['poin']?></span></td><td><?=eCat($r['keterangan'])?></td><td><?=eCat($r['nama_guru'])?></td></tr><?php endwhile;?><?php if(mysqli_num_rows($qRiwayat)===0):?><tr><td colspan="8" class="text-center text-muted">Belum ada catatan pelanggaran.</td></tr><?php endif;?></tbody></table></div></div></div></main>
<script>
document.getElementById('cariCatatan')?.addEventListener('input',function(){const k=this.value.toLocaleLowerCase('id');document.querySelectorAll('#tabelCatatan tbody tr').forEach(tr=>tr.hidden=!tr.textContent.toLocaleLowerCase('id').includes(k));});
(function(){
 const input=document.getElementById('cariSiswaCatatan');
 const pilih=document.getElementById('pilihSiswaCatatan');
 const cari=document.getElementById('tombolCariSiswa');
 const reset=document.getElementById('resetCariSiswa');
 if(!input||!pilih)return;
 const opsi=Array.from(pilih.options).slice(1);
 function filterSiswa(){
   const kata=input.value.trim().toLocaleLowerCase('id');
   opsi.forEach(opt=>{opt.hidden=!!kata&&!opt.textContent.toLocaleLowerCase('id').includes(kata);});
   if(pilih.selectedOptions[0]?.hidden)pilih.value='';
 }
 cari?.addEventListener('click',filterSiswa);
 input.addEventListener('keydown',e=>{if(e.key==='Enter'){e.preventDefault();filterSiswa();}});
 reset?.addEventListener('click',()=>{input.value='';filterSiswa();input.focus();});
})();
</script>
<script>
const cariJenis=document.getElementById('cariJenisPelanggaran');
const selectJenis=document.getElementById('jenisPelanggaran');
const opsiJenis=selectJenis?Array.from(selectJenis.options).slice(1):[];
cariJenis?.addEventListener('input',function(){
    const kata=this.value.trim().toLocaleLowerCase('id');
    const pilihanLama=selectJenis.value;
    opsiJenis.forEach(function(opt){
        opt.hidden=!opt.textContent.toLocaleLowerCase('id').includes(kata);
    });
    if(pilihanLama && selectJenis.selectedOptions[0]?.hidden) selectJenis.value='';
});
</script><script src="assets/siswa-search.js"></script><?php if(!$embed):?></body></html><?php endif;?>

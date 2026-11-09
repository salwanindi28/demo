<?php
$title = 'Pengajuan Izin'; $breadcrumb = 'Pengajuan Izin';
include ROOT . '/resources/views/layouts/header.php';
// Variabel dari controller izin: $rows, $success
$kosong = empty($rows);
?>
<section class="permit-page">
    <div class="permit-heading-row">
        <div>
            <a href="<?= e(url('mahasiswa')) ?>" class="back-link"><span>←</span> Kembali ke home</a>
            <h1>Riwayat Pengajuan Izin</h1>
            <p class="permit-subtitle">Lihat riwayat izin perkuliahan dan pantau status pengajuanmu.</p>
        </div>
        <a href="<?= e(url('mahasiswa/izin/buat')) ?>" class="primary-button create-top"><span>＋</span> Buat Izin Baru</a>
    </div>

    <?php if ($kosong): ?>
        <div class="permit-info"><span class="notice-info">i</span><div><strong>Ajukan izin perkuliahan melalui portal mahasiswa.</strong><span>Pilih mata kuliah, jelaskan alasan ketidakhadiran, dan sertakan bukti PDF agar dosen dapat memverifikasi pengajuanmu.</span></div></div>
    <?php endif; ?>

    <section class="attendance-card permit-table-card">
        <div class="table-card-heading">
            <div class="permit-title-group"><h2>Semua pengajuan</h2><?php if (!$kosong): ?><span class="count-pill"><?= count($rows) ?> pengajuan</span><?php endif; ?></div>
            <?php if ($kosong): ?><span class="status-pill">Belum ada data</span><?php else: ?><span class="updated-at">Semester Ganjil 2026/2027</span><?php endif; ?>
        </div>
        <div class="table-scroll">
            <table class="permit-table">
                <thead><tr><th>ID Pengajuan</th><th>Tanggal</th><th>Jenis</th><th>Keterangan</th><th>Berkas</th><th>Status</th></tr></thead>
                <tbody>
                <?php if ($kosong): ?>
                    <tr><td colspan="6" class="permit-empty-cell"></td></tr>
                <?php else: foreach ($rows as $r):
                    $status = strtoupper((string)$r['STATUS_PENGAJUAN']);
                    $detail = $status === 'MENUNGGU' ? 'Verifikasi dosen' : ($status === 'DITOLAK' ? (string)($r['ALASAN_PENOLAKAN'] ?? '') : '');
                ?>
                    <tr>
                        <td class="permit-id"><?= e($r['ID_PENGAJUAN']) ?></td>
                        <td class="muted-cell"><?= e(fmt_tgl($r['TANGGAL_PENGAJUAN'])) ?></td>
                        <td><?= e(status_label($r['JENIS_IZIN'])) ?></td>
                        <td class="permit-description"><?= e($r['KETERANGAN']) ?><small><?= e($r['NAMA_MATKUL']) ?> · Pertemuan <?= e((string)$r['PERTEMUAN_KE']) ?> · <?= e(fmt_tgl($r['TANGGAL'])) ?></small></td>
                        <td>
                            <?php if (!empty($r['FILE_BUKTI'])): ?>
                            <a class="file-link" target="_blank" rel="noopener" href="<?= e(url('uploads/' . rawurlencode($r['FILE_BUKTI']))) ?>"><svg viewBox="0 0 20 20"><path d="M6 2.5h5l4 4v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1Z"/><path d="M11 2.5v4h4M7.5 10h5M7.5 13h5"/></svg>Bukti.pdf</a><small class="file-size">PDF · <?= e(ukuran_bukti($r['FILE_BUKTI'])) ?></small>
                            <?php else: ?>
                            <span class="muted-cell">—</span>
                            <?php endif; ?>
                        </td>
                        <td><span class="permit-status <?= e(strtolower($status)) ?>"><?= e(status_label($status)) ?></span><?php if ($detail !== ''): ?><small class="status-detail"><?= e($detail) ?></small><?php endif; ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($kosong): ?>
        <div class="empty-state permit-empty-state">
            <div class="empty-illustration permit-empty-icon">
                <svg viewBox="0 0 120 120" role="img" aria-label="Ilustrasi belum ada pengajuan"><circle cx="60" cy="60" r="59" fill="#edf3ff"/><rect x="24" y="12" width="72" height="94" rx="10" fill="#fff" stroke="#b9ceff" stroke-width="2"/><path d="M39 36h24M39 53h38M39 70h38M39 87h38" stroke="#dce7fb" stroke-width="3" stroke-linecap="round"/><path d="M39 36h23" stroke="#9db9fb" stroke-width="5" stroke-linecap="round"/><path d="M38 53h4M38 70h4M38 87h4" stroke="#b9ceff" stroke-width="4" stroke-linecap="round"/><circle cx="100" cy="95" r="16" fill="#285bd8" stroke="#fff" stroke-width="3"/><path d="M100 87v16M92 95h16" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            <h2>Belum ada pengajuan izin</h2><p>data riwayat kosong. anda belum pernah membuat izin sebelumnya</p>
            <a href="<?= e(url('mahasiswa/izin/buat')) ?>" class="primary-button"><span>＋</span> Buat Izin Baru</a>
        </div>
        <?php endif; ?>
    </section>

    <?php if (!$kosong): ?>
    <div class="permit-info bottom-info"><span class="notice-info">i</span><div><strong>Pengajuanmu akan ditinjau oleh dosen pengampu.</strong><span>Status Menunggu berarti pengajuan belum diverifikasi. Pengajuan yang disetujui akan menjadi dasar pencatatan izin atau sakit pada rekap kehadiran.</span></div></div>
    <?php endif; ?>
</section>

<?php if ($success): ?>
<!-- Popup berhasil terkirim (muncul setelah redirect dari simpanPengajuan) -->
<div class="permit-modal-overlay is-visible" id="permit-success" aria-hidden="false">
    <section class="permit-modal" role="dialog" aria-modal="true" aria-labelledby="permit-success-title">
        <button type="button" class="permit-modal-close" id="permit-success-close" aria-label="Tutup popup">×</button>
        <h2 id="permit-success-title">Berhasil terkirim!</h2>
        <p class="permit-modal-description">Pengajuan anda masuk ke dalam daftar antrean. Pantau terus.</p>
        <div class="permit-modal-actions">
            <button type="button" class="primary-button" id="permit-success-ok">OK</button>
        </div>
    </section>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('permit-success');
    document.body.classList.add('modal-open');
    function closeModal() { modal.classList.remove('is-visible'); modal.setAttribute('aria-hidden', 'true'); document.body.classList.remove('modal-open'); }
    document.getElementById('permit-success-ok').addEventListener('click', closeModal);
    document.getElementById('permit-success-close').addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });
});
</script>
<?php endif; ?>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

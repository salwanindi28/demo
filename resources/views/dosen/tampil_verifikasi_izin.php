<?php
$title = 'Antrean Pengajuan Izin'; $breadcrumb = 'Pengajuan Izin';
include ROOT . '/resources/views/layouts/header.php';
// Variabel dari controller verifikasi_izin: $rows, $success, $error
$kosong = empty($rows);
?>
<section class="attendance-page lecturer-queue-page">
    <a href="<?= e(url('dosen')) ?>" class="back-link"><span>←</span> Kembali ke home</a>
    <div class="page-heading lecturer-page-heading">
        <h1>Antrean Pengajuan Izin</h1>
        <p>Tinjau dan verifikasi pengajuan izin mahasiswa pada mata kuliah yang Anda ampu.</p>
    </div>

    <?php if ($error): ?><div class="lecturer-flash error"><?= e($error) ?></div><?php endif; ?>

    <section class="attendance-card lecturer-queue-card <?= $kosong ? 'is-empty' : 'has-rows' ?>">
        <div class="table-card-heading">
            <div class="permit-title-group"><h2>Menunggu verifikasi</h2><?php if (!$kosong): ?><span class="count-pill"><?= count($rows) ?> pengajuan</span><?php endif; ?></div>
            <?php if (!$kosong): ?><span class="updated-at">Diperbarui <?= e(date('d M Y, H.i')) ?> WIB</span><?php endif; ?>
        </div>
        <div class="table-scroll">
            <table class="lecturer-table">
                <thead><tr><th>ID Pengajuan</th><th>NIM</th><th>Nama</th><th>Mata Kuliah</th><th>Jenis</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php if ($kosong): ?>
                    <tr><td colspan="7" class="lecturer-empty-cell"></td></tr>
                <?php else: foreach ($rows as $r): ?>
                    <tr>
                        <td class="permit-id"><?= e($r['ID_PENGAJUAN']) ?></td>
                        <td class="muted-cell"><?= e($r['NIM']) ?></td>
                        <td class="lecturer-student-name"><?= e($r['NAMA_MAHASISWA']) ?></td>
                        <td class="lecturer-course"><?= e($r['NAMA_MATKUL']) ?><small>Kelas <?= e($r['KELAS']) ?> · Pertemuan <?= e((string)$r['PERTEMUAN_KE']) ?></small></td>
                        <td><?= e(status_label($r['JENIS_IZIN'])) ?></td>
                        <td class="muted-cell"><?= e(fmt_tgl($r['TANGGAL_PENGAJUAN'])) ?></td>
                        <td><a class="lecturer-detail-link" href="<?= e(url('dosen/izin/' . rawurlencode($r['ID_PENGAJUAN']))) ?>">Detail <span>›</span></a></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php if ($kosong): ?>
        <div class="empty-state lecturer-empty-state">
            <div class="empty-illustration lecturer-empty-icon">
                <svg viewBox="0 0 120 120" role="img" aria-label="Semua pengajuan telah ditinjau">
                    <circle cx="60" cy="60" r="59" fill="#edf3ff"/>
                    <rect x="24" y="12" width="72" height="94" rx="10" fill="#fff" stroke="#b9ceff" stroke-width="2"/>
                    <path d="M39 36h24M39 53h38M39 70h38M39 87h38" stroke="#dce7fb" stroke-width="3" stroke-linecap="round"/>
                    <path d="M39 36h23" stroke="#9db9fb" stroke-width="5" stroke-linecap="round"/>
                    <path d="M38 53h4M38 70h4M38 87h4" stroke="#b9ceff" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="100" cy="95" r="16" fill="#285bd8" stroke="#fff" stroke-width="3"/>
                    <path d="m93 95 5 5 9-11" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2>Semua pengajuan sudah ditinjau</h2>
            <p>Tidak Ada Antrean Pengajuan. Semua pengajuan izin telah selesai diverifikasi.</p>
            <div class="lecturer-empty-note"><span>✓</span> Tidak ada pengajuan yang perlu ditindaklanjuti</div>
        </div>
        <?php endif; ?>
    </section>
</section>

<?php if ($success): ?>
<!-- Popup berhasil (muncul setelah redirect dari prosesSetujui / prosesTolak) -->
<div class="permit-modal-overlay is-visible" id="lecturerSuccessModal" aria-hidden="false">
    <div class="permit-modal" role="dialog" aria-modal="true" aria-labelledby="lecturerSuccessTitle">
        <button type="button" class="permit-modal-close" id="lecturerSuccessClose" aria-label="Tutup">×</button>
        <h2 id="lecturerSuccessTitle"><?= e($success) ?></h2>
        <div class="permit-modal-actions">
            <button type="button" class="primary-button" id="lecturerSuccessOk">OK</button>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('lecturerSuccessModal');
    document.body.classList.add('modal-open');
    function closeModal() { modal.classList.remove('is-visible'); modal.setAttribute('aria-hidden', 'true'); document.body.classList.remove('modal-open'); }
    document.getElementById('lecturerSuccessOk').addEventListener('click', closeModal);
    document.getElementById('lecturerSuccessClose').addEventListener('click', closeModal);
    modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });
});
</script>
<?php endif; ?>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

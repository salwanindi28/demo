<?php
$title = 'Detail Pengajuan Izin'; $breadcrumb = 'Pengajuan Izin';
include ROOT . '/resources/views/layouts/header.php';
// Variabel dari controller verifikasi_izin: $row, $error
$idEnc    = rawurlencode($row['ID_PENGAJUAN']);
$status   = strtoupper((string)$row['STATUS_PENGAJUAN']);
$urlSetuju = url('dosen/izin/' . $idEnc . '/setujui');
$urlTolak  = url('dosen/izin/' . $idEnc . '/tolak');
?>
<section class="attendance-page lecturer-queue-page lecturer-detail-page">
    <a href="<?= e(url('dosen/izin')) ?>" class="back-link"><span>←</span> Kembali ke antrean</a>
    <div class="page-heading lecturer-page-heading">
        <h1>Detail Pengajuan Izin</h1>
        <p>Periksa informasi dan bukti pendukung sebelum memberikan keputusan.</p>
    </div>
    <?php if ($error): ?><div class="lecturer-flash error"><?= e($error) ?></div><?php endif; ?>

    <div class="lecturer-detail-layout">
        <section class="attendance-card lecturer-detail-card">
            <div class="table-card-heading"><h2>Informasi pengajuan</h2></div>
            <div class="lecturer-detail-content">
                <div class="lecturer-detail-meta">
                    <div><small>ID Pengajuan</small><strong><?= e($row['ID_PENGAJUAN']) ?></strong></div>
                    <div><small>Tanggal Pengajuan</small><strong><?= e(fmt_tgl($row['TANGGAL_PENGAJUAN'], true)) ?></strong></div>
                </div>
                <div class="lecturer-detail-grid">
                    <div><small>Nama</small><strong><?= e($row['NAMA_MAHASISWA']) ?></strong></div>
                    <div><small>NIM</small><strong><?= e($row['NIM']) ?></strong></div>
                    <div><small>Mata Kuliah</small><strong><?= e($row['NAMA_MATKUL']) ?><small class="detail-subline">Kelas <?= e($row['KELAS']) ?> · Pertemuan <?= e((string)$row['PERTEMUAN_KE']) ?> · <?= e(fmt_tgl($row['TANGGAL'])) ?></small></strong></div>
                    <div><small>Jenis</small><strong><?= e(status_label($row['JENIS_IZIN'])) ?></strong></div>
                    <div class="lecturer-detail-wide"><small>Keterangan</small><strong><?= e($row['KETERANGAN']) ?></strong></div>
                    <?php if ($status === 'DITOLAK' && !empty($row['ALASAN_PENOLAKAN'])): ?>
                    <div class="lecturer-detail-wide"><small>Alasan penolakan</small><strong><?= e($row['ALASAN_PENOLAKAN']) ?></strong></div>
                    <?php endif; ?>
                </div>
                <div class="lecturer-proof-section">
                    <small>Bukti</small>
                    <div class="lecturer-proof-file">
                        <span class="lecturer-proof-icon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path d="M14 3v6h5M9 13h6M9 17h6"/></svg></span>
                        <span class="lecturer-proof-name"><strong><?= !empty($row['FILE_BUKTI']) ? 'Bukti pengajuan.pdf' : 'Bukti belum dilampirkan' ?></strong><small>PDF · <?= e(ukuran_bukti($row['FILE_BUKTI'] ?? null)) ?></small></span>
                        <?php if (!empty($row['FILE_BUKTI'])): ?>
                            <a class="lecturer-open-file" href="<?= e(url('uploads/' . rawurlencode($row['FILE_BUKTI']))) ?>" target="_blank" rel="noopener"><span>↗</span> Buka PDF</a>
                        <?php else: ?>
                            <span class="lecturer-open-file is-disabled">Tidak ada berkas</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($status === 'MENUNGGU'): ?>
            <!-- Satu form, action diisi JS: /setujui atau /tolak (sesuai route di public/index.php) -->
            <form class="lecturer-review-actions" id="lecturerReviewForm" method="POST" action="<?= e($urlTolak) ?>" data-url-setujui="<?= e($urlSetuju) ?>" data-url-tolak="<?= e($urlTolak) ?>">
                <?= csrf_field() ?>
                <button class="lecturer-reject" id="lecturerRejectButton" type="button">Tolak</button>
                <input type="text" name="alasan" id="lecturerRejectReason" aria-label="Alasan penolakan" placeholder="Alasan:" maxlength="250">
                <button class="primary-button lecturer-approve" id="lecturerApproveButton" type="button">Setujui</button>
            </form>
            <?php else: ?>
            <div class="lecturer-reviewed-note">Pengajuan ini sudah <?= e(strtolower(status_label($status))) ?>.</div>
            <?php endif; ?>
        </section>

        <aside class="lecturer-review-guide">
            <h3><span>ⓘ</span> Periksa sebelum memutuskan</h3>
            <ul>
                <li>Identitas dan mata kuliah sesuai.</li>
                <li>Alasan ketidakhadiran disampaikan dengan jelas.</li>
                <li>Bukti PDF terbaca dan mendukung keterangan.</li>
            </ul>
        </aside>
    </div>
</section>

<?php if ($status === 'MENUNGGU'): ?>
<!-- Popup konfirmasi setuju & validasi alasan -->
<div class="permit-modal-overlay" id="lecturerApproveModal" aria-hidden="true">
    <div class="permit-modal" role="dialog" aria-modal="true" aria-labelledby="lecturerApproveTitle">
        <button type="button" class="permit-modal-close" data-close-modal="lecturerApproveModal" aria-label="Tutup">×</button>
        <h2 id="lecturerApproveTitle">Ingin melanjutkan tindakan?</h2>
        <p class="permit-modal-description">Pastikan Anda telah yakin untuk menyetujui pengajuan izin ini.</p>
        <div class="permit-modal-actions lecturer-modal-actions">
            <button type="button" class="lecturer-modal-cancel" data-close-modal="lecturerApproveModal">Batal</button>
            <button type="button" class="primary-button" id="lecturerConfirmApprove">Ya, Setujui</button>
        </div>
    </div>
</div>

<div class="permit-modal-overlay" id="lecturerReasonModal" aria-hidden="true">
    <div class="permit-modal" role="dialog" aria-modal="true" aria-labelledby="lecturerReasonTitle">
        <button type="button" class="permit-modal-close" data-close-modal="lecturerReasonModal" aria-label="Tutup">×</button>
        <h2 id="lecturerReasonTitle">Alasan wajib diisi</h2>
        <p class="permit-modal-description">Anda harus mengisi alasan ketika menolak pengajuan.</p>
        <div class="permit-modal-actions">
            <button type="button" class="primary-button" id="lecturerCompleteReason">← &nbsp; Lengkapi Formulir</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('lecturerReviewForm');
    const reason = document.getElementById('lecturerRejectReason');
    const approveModal = document.getElementById('lecturerApproveModal');
    const reasonModal = document.getElementById('lecturerReasonModal');

    function openModal(modal) {
        modal.classList.add('is-visible');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
    }
    function closeModal(modal) {
        modal.classList.remove('is-visible');
        modal.setAttribute('aria-hidden', 'true');
        if (!document.querySelector('.permit-modal-overlay.is-visible')) document.body.classList.remove('modal-open');
    }

    // Setujui -> konfirmasi dulu -> POST ke /setujui
    document.getElementById('lecturerApproveButton').addEventListener('click', () => openModal(approveModal));
    document.getElementById('lecturerConfirmApprove').addEventListener('click', function () {
        form.action = form.dataset.urlSetujui;
        form.submit();
    });

    // Tolak -> alasan wajib -> POST ke /tolak
    function tolak() {
        if (!reason.value.trim()) { openModal(reasonModal); return; }
        form.action = form.dataset.urlTolak;
        form.submit();
    }
    document.getElementById('lecturerRejectButton').addEventListener('click', tolak);
    reason.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); tolak(); } });

    document.getElementById('lecturerCompleteReason').addEventListener('click', function () {
        closeModal(reasonModal);
        reason.focus();
    });
    document.querySelectorAll('[data-close-modal]').forEach(button => {
        button.addEventListener('click', () => closeModal(document.getElementById(button.dataset.closeModal)));
    });
    [approveModal, reasonModal].forEach(modal => {
        modal.addEventListener('click', event => { if (event.target === modal) closeModal(modal); });
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.permit-modal-overlay.is-visible').forEach(closeModal);
    });
});
</script>
<?php endif; ?>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

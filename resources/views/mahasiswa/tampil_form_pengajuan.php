<?php
$title = 'Buat Pengajuan Izin'; $breadcrumb = 'Pengajuan Izin';
include ROOT . '/resources/views/layouts/header.php';
// Variabel dari controller izin: $presensi (pertemuan alpha yang belum diajukan), $errors, $old
$u = current_user();
$errors = $errors ?? [];
$old = $old ?? [];

// Tentukan mode popup awal kalau server menolak formulir
$popupAwal = '';
if ($errors) {
    $popupAwal = (isset($errors['file_bukti']) && stripos($errors['file_bukti'], '2 MB') !== false) ? 'file' : 'incomplete';
}
?>
<section class="permit-form-page">
    <a href="<?= e(url('mahasiswa/izin')) ?>" class="back-link"><span>←</span> Kembali ke riwayat</a>
    <div class="page-heading permit-form-heading"><h1>Buat Pengajuan Izin</h1><p>Sampaikan izin ketidakhadiranmu kepada dosen pengampu mata kuliah.</p></div>
    <div class="permit-form-layout">
        <form id="permit-form" class="form-card" action="<?= e(url('mahasiswa/izin/simpan')) ?>" method="POST" enctype="multipart/form-data" novalidate>
            <?= csrf_field() ?>
            <div class="form-card-title"><div>Informasi pengajuan</div><small class="form-intro">Lengkapi data berikut. Semua field bertanda * wajib diisi.</small></div>
            <div class="form-fields">
                <div class="form-grid">
                    <label class="form-field">Nama
                        <input type="text" value="<?= e($u['name']) ?>" readonly>
                    </label>
                    <label class="form-field">NIM
                        <input type="text" value="<?= e($u['nim']) ?>" readonly>
                    </label>
                    <label class="form-field">Mata Kuliah &amp; Pertemuan *
                        <select name="id_presensi" required class="<?= isset($errors['id_presensi']) ? 'is-invalid' : '' ?>">
                            <option value="">Pilih mata kuliah dan pertemuan</option>
                            <?php foreach ($presensi as $p): ?>
                            <option value="<?= e($p['ID_PRESENSI']) ?>" <?= ($old['id_presensi'] ?? '') === $p['ID_PRESENSI'] ? 'selected' : '' ?>><?= e($p['NAMA_MATKUL']) ?> · <?= e($p['KELAS']) ?> · Pertemuan <?= e((string)$p['PERTEMUAN_KE']) ?> (<?= e(fmt_tgl($p['TANGGAL'])) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['id_presensi'])): ?><small class="field-error"><?= e($errors['id_presensi']) ?></small><?php endif; ?>
                        <?php if (!$presensi): ?><small class="upload-hint">Tidak ada pertemuan berstatus alpha yang bisa diajukan.</small><?php endif; ?>
                    </label>
                    <label class="form-field">Jenis *
                        <select name="jenis_izin" required class="<?= isset($errors['jenis_izin']) ? 'is-invalid' : '' ?>">
                            <option value="">Pilih Izin / Sakit</option>
                            <option value="IZIN" <?= ($old['jenis_izin'] ?? '') === 'IZIN' ? 'selected' : '' ?>>Izin</option>
                            <option value="SAKIT" <?= ($old['jenis_izin'] ?? '') === 'SAKIT' ? 'selected' : '' ?>>Sakit</option>
                        </select>
                        <?php if (isset($errors['jenis_izin'])): ?><small class="field-error"><?= e($errors['jenis_izin']) ?></small><?php endif; ?>
                    </label>
                </div>
                <label class="form-field full-field">Keterangan *
                    <textarea name="keterangan" rows="4" placeholder="Jelaskan alasan ketidakhadiranmu secara singkat dan jelas" required class="<?= isset($errors['keterangan']) ? 'is-invalid' : '' ?>"><?= e($old['keterangan'] ?? '') ?></textarea>
                    <?php if (isset($errors['keterangan'])): ?><small class="field-error"><?= e($errors['keterangan']) ?></small><?php endif; ?>
                </label>
                <div class="form-field full-field">
                    <label for="bukti" class="upload-label">Bukti *</label>
                    <label class="upload-zone <?= isset($errors['file_bukti']) ? 'upload-invalid' : '' ?>" for="bukti" id="upload-zone">
                        <input id="bukti" type="file" name="file_bukti" accept="application/pdf,.pdf" required>
                        <svg viewBox="0 0 24 24"><path d="M12 16V4m0 0L7 9m5-5 5 5M4 16v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3"/></svg>
                        <strong id="upload-title">Klik untuk memilih berkas</strong><span id="upload-description">atau tarik berkas ke sini · PDF, maksimal 2 MB</span>
                    </label>
                    <?php if (isset($errors['file_bukti'])): ?><small class="field-error"><?= e($errors['file_bukti']) ?></small><?php endif; ?>
                    <small class="upload-hint">Lampirkan surat dokter atau dokumen pendukung izin.</small>
                </div>
            </div>
            <div class="form-actions"><a href="<?= e(url('mahasiswa/izin')) ?>" class="secondary-button">Batal</a><button type="submit" class="primary-button submit-button"><span>➤</span> Kirim Pengajuan</button></div>
        </form>
        <div class="permit-side-notes">
            <aside class="form-help permit-help-card"><div class="help-title"><span class="help-info-icon">i</span><strong>Sebelum mengajukan</strong></div>
                <strong class="help-subtitle">Pilih mata kuliah yang sesuai</strong><p>Ajukan satu pengajuan untuk setiap pertemuan yang tidak dapat kamu ikuti.</p>
                <strong class="help-subtitle">Jelaskan alasan dengan lengkap</strong><p>Sebutkan alasan ketidakhadiran pada keterangan (minimal 5 karakter).</p>
                <strong class="help-subtitle">Siapkan bukti pendukung</strong><p>Gunakan PDF yang jelas dan terbaca, dengan ukuran maksimal 2 MB.</p>
            </aside>
            <aside class="form-help"><strong>Apa yang terjadi setelah dikirim?</strong><p>Dosen pengampu akan memeriksa pengajuanmu. Pantau status verifikasi melalui halaman Riwayat Pengajuan Izin.</p></aside>
        </div>
    </div>
</section>

<div class="permit-modal-overlay" id="permit-modal" aria-hidden="true">
    <section class="permit-modal" role="dialog" aria-modal="true" aria-labelledby="permit-modal-title" aria-describedby="permit-modal-description">
        <button type="button" class="permit-modal-close" id="permit-modal-close" aria-label="Tutup popup">×</button>
        <h2 id="permit-modal-title">Formulir belum lengkap</h2>
        <p class="permit-modal-description" id="permit-modal-description">Beberapa informasi berikut masih kosong.</p>
        <p class="permit-modal-note" id="permit-modal-note">Pengajuan belum dikirim. Data yang sudah diisi tetap tersimpan di formulir.</p>
        <div class="permit-modal-actions">
            <button type="button" class="primary-button" id="permit-modal-action">Lengkapi Formulir</button>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const MAX_BYTES = 2 * 1024 * 1024;
    const form = document.getElementById('permit-form');
    const input = document.getElementById('bukti');
    const title = document.getElementById('upload-title');
    const desc = document.getElementById('upload-description');
    const zone = document.getElementById('upload-zone');
    const modal = document.getElementById('permit-modal');
    const modalTitle = document.getElementById('permit-modal-title');
    const modalDescription = document.getElementById('permit-modal-description');
    const modalNote = document.getElementById('permit-modal-note');
    const modalAction = document.getElementById('permit-modal-action');
    const modalClose = document.getElementById('permit-modal-close');
    let modalMode = 'incomplete';

    function showModal(mode) {
        modalMode = mode;
        modal.classList.add('is-visible');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        if (mode === 'file') {
            modalTitle.textContent = 'Ukuran berkas terlalu besar';
            modalDescription.textContent = 'Bukti harus berupa PDF dengan ukuran maksimal 2 MB.';
            modalNote.textContent = 'Pengajuan belum dikirim. Data yang sudah diisi tetap tersimpan di formulir.';
            modalAction.innerHTML = '<span class="modal-upload-icon">⇧</span> Ganti Berkas';
        } else {
            modalTitle.textContent = 'Formulir belum lengkap';
            modalDescription.textContent = 'Beberapa informasi berikut masih kosong.';
            modalNote.textContent = 'Pengajuan belum dikirim. Data yang sudah diisi tetap tersimpan di formulir.';
            modalAction.innerHTML = '<span class="modal-back-icon">←</span> Lengkapi Formulir';
        }
        modalAction.focus();
    }
    function closeModal() {
        modal.classList.remove('is-visible');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }
    function clearDynamicErrors() {
        form.querySelectorAll('.field-error.client-error').forEach(el => el.remove());
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    }
    function markInvalid(field, message) {
        field.classList.add('is-invalid');
        const error = document.createElement('small');
        error.className = 'field-error client-error';
        error.textContent = message;
        const parent = field.closest('.form-field');
        if (parent) parent.appendChild(error);
    }

    input.addEventListener('change', function () {
        if (this.files && this.files.length) {
            const file = this.files[0];
            title.textContent = file.name;
            desc.textContent = (file.size / 1024).toFixed(0) + ' KB · Klik untuk mengganti berkas';
            clearDynamicErrors();
            if (file.size > MAX_BYTES) { zone.classList.add('upload-invalid'); showModal('file'); }
            else { zone.classList.remove('upload-invalid'); }
        }
    });

    ['dragenter', 'dragover'].forEach(n => zone.addEventListener(n, e => { e.preventDefault(); zone.classList.add('dragging'); }));
    ['dragleave', 'drop'].forEach(n => zone.addEventListener(n, e => { e.preventDefault(); zone.classList.remove('dragging'); }));
    zone.addEventListener('drop', e => {
        if (e.dataTransfer.files.length) {
            input.files = e.dataTransfer.files;
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });

    form.addEventListener('submit', function (event) {
        clearDynamicErrors();
        const requiredFields = [
            ['id_presensi', 'Mata kuliah & pertemuan wajib dipilih.'],
            ['jenis_izin', 'Jenis izin wajib dipilih.'],
            ['keterangan', 'Keterangan wajib diisi.']
        ];
        let firstInvalid = null;
        requiredFields.forEach(([name, message]) => {
            const field = form.elements[name];
            if (!field.value.trim()) { markInvalid(field, message); firstInvalid = firstInvalid || field; }
        });
        if (!input.files || !input.files.length) {
            zone.classList.add('upload-invalid');
            const error = document.createElement('small');
            error.className = 'field-error client-error';
            error.textContent = 'Bukti PDF wajib dilampirkan.';
            zone.parentElement.appendChild(error);
            firstInvalid = firstInvalid || input;
        } else if (input.files[0].size > MAX_BYTES) {
            event.preventDefault();
            showModal('file');
            return;
        }
        if (firstInvalid) { event.preventDefault(); showModal('incomplete'); }
    });

    modalAction.addEventListener('click', function () {
        if (modalMode === 'file') { closeModal(); input.click(); }
        else {
            closeModal();
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid && firstInvalid !== input) firstInvalid.focus(); else input.click();
        }
    });
    modalClose.addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && modal.classList.contains('is-visible')) closeModal(); });

    <?php if ($popupAwal !== ''): ?>
    showModal(<?= json_encode($popupAwal) ?>);
    <?php endif; ?>
});
</script>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

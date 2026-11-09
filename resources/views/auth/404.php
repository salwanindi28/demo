<?php $title = 'Data tidak ditemukan'; $breadcrumb = 'Tidak ditemukan'; include ROOT . '/resources/views/layouts/header.php'; ?>
<section class="simple-page attendance-card">
    <div class="empty-state">
        <h2>Data tidak ditemukan</h2>
        <p>Pengajuan tidak tersedia atau Anda bukan dosen pengampu mata kuliah tersebut.</p>
        <a href="<?= e(url('dosen/izin')) ?>" class="primary-button"><span>←</span> Kembali ke antrean</a>
    </div>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

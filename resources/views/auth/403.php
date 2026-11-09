<?php $title = 'Akses ditolak'; $breadcrumb = 'Akses ditolak'; include ROOT . '/resources/views/layouts/header.php'; ?>
<section class="simple-page attendance-card">
    <div class="empty-state">
        <h2>Akses ditolak</h2>
        <p>Akun Anda tidak memiliki izin untuk membuka halaman ini.</p>
        <a href="<?= e(url('')) ?>" class="primary-button"><span>←</span> Kembali</a>
    </div>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

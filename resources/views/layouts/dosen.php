<?php
$u = current_user() ?? [];
$dosenName = (string)($u['name'] ?? 'Dr. Bima Pratama, M.Kom.');
$dosenSub = (string)($u['nip'] ?? 'Dosen · Sistem Informasi');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title><?= e($title ?? 'Portal Dosen') ?> - Universitas Cakrawala Nusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('css/portal.css')) ?>">
</head>
<body>
<header class="topbar">
    <div class="topbar-left">
        <a href="<?= e(url('dosen')) ?>" class="crumb-muted">Portal Dosen</a>
        <svg class="chevron" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
        <span class="crumb-current"><?= e($breadcrumb ?? 'Beranda') ?></span>
    </div>
    <div class="topbar-right">
        <span class="semester-pill">Semester Ganjil 2026/2027</span>
        <button class="icon-button notification" type="button" aria-label="Notifikasi">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg><i></i>
        </button>
        <button class="profile-menu" type="button" aria-label="Profil dosen">
            <span class="avatar"><?= e(initials($dosenName)) ?></span>
            <span class="profile-copy"><strong><?= e($dosenName) ?></strong><small><?= e($dosenSub) ?></small></span>
            <svg class="chevron-down" viewBox="0 0 24 24"><path d="m7 10 5 5 5-5"/></svg>
        </button>
    </div>
</header>
<main class="page-shell"><?= $content ?? '' ?></main>
<footer class="site-footer">
    <span>© 2026 Universitas Cakrawala Nusantara</span>
    <span>Sistem Informasi Akademik · Universitas Cakrawala Nusantara</span>
    <nav><a href="#">Panduan mahasiswa</a><a href="#">Hubungi akademik</a></nav>
</footer>
<script src="<?= e(url('js/portal.js')) ?>"></script>
</body>
</html>

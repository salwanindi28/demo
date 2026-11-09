<?php
// Layout atas (topbar) - tampilan sama dengan layouts/app.blade.php & layouts/dosen.blade.php
$u          = current_user();
$isDosen    = ($u['role'] ?? '') === 'DOSEN';
$title      = $title ?? 'Portal Akademik';
$breadcrumb = $breadcrumb ?? $title;
$homeUrl    = $isDosen ? url('dosen') : url('mahasiswa');
$portal     = $isDosen ? 'Portal Dosen' : 'Portal Mahasiswa';
$subInfo    = $isDosen ? 'Dosen · ' . ($u['nip'] ?? '') : ($u['nim'] ?? ($u['email'] ?? ''));

if (!function_exists('fmt_tgl')) {
    // Format tanggal demo -> "20 Oct 2026" atau "20 Oct 2026 · 07.15 WIB"
    function fmt_tgl($v, bool $jam = false): string {
        $t = strtotime((string)$v);
        if (!$t) return (string)$v;
        return $jam ? date('d M Y · H.i', $t) . ' WIB' : date('d M Y', $t);
    }
}
if (!function_exists('ukuran_bukti')) {
    // Ukuran file bukti di public/uploads, contoh "428 KB"
    function ukuran_bukti(?string $file): string {
        if (!$file) return '—';
        $p = ROOT . '/public/uploads/' . basename($file);
        return is_file($p) ? number_format(filesize($p) / 1024, 0) . ' KB' : '—';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title><?= e($title) ?> - Universitas Cakrawala Nusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(url('css/portal.css')) ?>">
    <link rel="stylesheet" href="<?= e(url('css/tambahan.css')) ?>">
</head>
<body>
    <header class="topbar">
        <div class="topbar-left">
            <a href="<?= e($homeUrl) ?>" class="crumb-muted"><?= e($portal) ?></a>
            <svg class="chevron" viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
            <span class="crumb-current"><?= e($breadcrumb) ?></span>
        </div>

        <div class="topbar-right">
            <span class="semester-pill">Semester Ganjil 2026/2027</span>
            <button class="icon-button notification" type="button" aria-label="Notifikasi">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>
                <i></i>
            </button>
            <?php if ($u): ?>
            <div class="profile-wrap">
                <button class="profile-menu" type="button" id="profileToggle" aria-label="Menu profil" aria-expanded="false">
                    <span class="avatar"><?= e(initials($u['name'])) ?></span>
                    <span class="profile-copy"><strong><?= e($u['name']) ?></strong><small><?= e($subInfo) ?></small></span>
                    <svg class="chevron-down" viewBox="0 0 24 24" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg>
                </button>
                <div class="profile-dropdown" id="profileDropdown">
                    <form method="post" action="<?= e(url('logout')) ?>">
                        <?= csrf_field() ?>
                        <button type="submit">Keluar</button>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <main class="page-shell">

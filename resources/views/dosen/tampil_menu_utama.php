<?php
$title = 'Beranda Dosen'; $breadcrumb = 'Beranda';
include ROOT . '/resources/views/layouts/header.php';

$nama = current_user()['name'];
$nip  = current_user()['nip'] ?? '';
// Opsional: kalau controller mengirim $jumlahMenunggu, angkanya tampil. Kalau tidak, tampil "–".
$menunggu = isset($jumlahMenunggu) ? (string)$jumlahMenunggu : '0';
?>
<section class="home-content lecturer-home">
    <h1 class="welcome-title">Selamat Datang, <?= e($nama) ?>!</h1>

    <section class="hero-card lecturer-hero">
        <div class="hero-copy">
            <span class="eyebrow">PERAN AKADEMIKMU</span>
            <h2>Bimbing, kelola, dan dukung perjalanan mahasiswa.</h2>
            <div class="student-meta">
                <span><?= e($nama) ?></span><span><?= e($nip) ?></span><span>Dosen Pengampu &amp; DPA</span>
            </div>
        </div>
        <div class="lecturer-avatar-art" aria-label="Ilustrasi profil dosen">
            <svg viewBox="0 0 220 220" role="img" aria-hidden="true">
                <circle cx="110" cy="70" r="40" fill="#629be9"/>
                <path d="M35 190c7-47 35-70 75-70s68 23 75 70c1 6-4 10-10 10H45c-6 0-11-4-10-10Z" fill="#629be9"/>
            </svg>
        </div>
    </section>

    <section class="stats-card lecturer-stats">
        <!-- Dua kartu pertama masih statis (belum ada query-nya) -->
        <div class="stat-item"><span class="stat-label">Mahasiswa Bimbingan</span><div class="stat-value">38</div><span class="stat-note">DPA Semester Ganjil 2026/2027</span></div>
        <div class="stat-item"><span class="stat-label">Kelas Pengampu</span><div class="stat-value">4 <small>Mata Kuliah</small></div><span class="stat-note">Aktif semester ini</span></div>
        <div class="stat-item"><span class="stat-label">Pengajuan Menunggu</span><div class="stat-value"><?= e($menunggu) ?> <small>Pengajuan</small></div><span class="stat-note">Perlu verifikasi &amp; persetujuan</span></div>
    </section>

    <section class="quick-section lecturer-quick">
        <h2>Akses cepat</h2>
        <div class="quick-grid">
            <a class="quick-card" href="#">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="M12 8H9a4 4 0 0 0-4 4v5M36 8h3a4 4 0 0 1 4 4v5M5 31v5a4 4 0 0 0 4 4h3M43 31v5a4 4 0 0 1-4 4h-3M15 24h18"/></svg></span>
                <span class="quick-copy"><strong>Presensi</strong><small>Buka &amp; catat presensi kelas</small></span><span class="quick-arrow">↗</span>
            </a>
            <a class="quick-card" href="#">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="M12 7h22a4 4 0 0 1 4 4v29H12a5 5 0 0 1-5-5V12a5 5 0 0 1 5-5ZM7 15h10M7 23h8M7 31h8M17 7v33M27 22l11-14a4 4 0 0 1 6 5L33 27l-8 3 2-8Z"/></svg></span>
                <span class="quick-copy"><strong>KRS</strong><small>Setujui rencana studi</small></span><span class="quick-arrow">↗</span>
            </a>
            <a class="quick-card" href="<?= e(url('dosen/izin')) ?>">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="M28 7H12a4 4 0 0 0-4 4v27a4 4 0 0 0 4 4h20a4 4 0 0 0 4-4V27M28 7l8 8M28 7v8h8M18 35l2-8 13-14a4 4 0 0 1 6 6L26 34l-8 1Z"/></svg></span>
                <span class="quick-copy"><strong>Pengajuan Izin</strong><small>Verifikasi izin mahasiswa</small></span><span class="quick-arrow">↗</span>
            </a>
            <a class="quick-card" href="#">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="m5 30 12-14 8 8L43 5M10 40V31M20 40V27M30 40V22M40 40V13"/></svg></span>
                <span class="quick-copy"><strong>KHS</strong><small>Kelola nilai mahasiswa</small></span><span class="quick-arrow">↗</span>
            </a>
        </div>
    </section>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

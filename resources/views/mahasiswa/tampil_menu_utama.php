<?php
$title = 'Beranda'; $breadcrumb = 'Beranda';
include ROOT . '/resources/views/layouts/header.php';

// Data dari database ($profile dikirim controller BerandaMahasiswa)
$nama = $profile['NAMA_MAHASISWA'] ?? current_user()['name'];
$nim  = $profile['NIM'] ?? current_user()['nim'];
$prodi = $profile['PROGRAM_STUDI'] ?? 'Sistem Informasi';

// Belum ada di database -> tetap statis seperti sebelumnya
$semester = 3; $status = 'Mahasiswa aktif';
$ipk = '3,78'; $sksSemester = 24; $sksLulus = 48; $sksMaks = 144;
?>
<section class="home-content">
    <h1 class="welcome-title">Selamat Datang, <?= e($nama) ?>!</h1>

    <section class="hero-card">
        <div class="hero-copy">
            <span class="eyebrow">PERJALANAN AKADEMIKMU</span>
            <h2>Satu semester, banyak kemungkinan.</h2>
            <div class="student-meta">
                <span><?= e($nama) ?></span>
                <span><?= e($nim) ?></span>
                <span><?= e($prodi) ?></span>
            </div>
            <div class="student-meta second">
                <span>Semester <?= e((string)$semester) ?></span>
                <span><?= e($status) ?></span>
            </div>
        </div>
        <div class="hero-photo">
            <img src="<?= e(url('images/foto-mahasiswa.jpg')) ?>" alt="Foto <?= e($nama) ?>">
        </div>
    </section>

    <section class="stats-card" aria-label="Ringkasan akademik">
        <div class="stat-item">
            <span class="stat-label">Indeks Prestasi Kumulatif</span>
            <div class="stat-value"><?= e($ipk) ?> <small>/ 4,00</small></div>
            <span class="stat-note">Prestasi yang membanggakan</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">Beban studi semester ini</span>
            <div class="stat-value"><?= e((string)$sksSemester) ?> <small>SKS</small></div>
            <span class="stat-note">7 mata kuliah · KRS disetujui</span>
        </div>
        <div class="stat-item">
            <span class="stat-label">Total SKS lulus</span>
            <div class="stat-value"><?= e((string)$sksLulus) ?> <small>SKS</small></div>
            <span class="stat-note">dari <?= e((string)$sksMaks) ?> SKS kelulusan</span>
        </div>
    </section>

    <section class="quick-section">
        <h2>Akses cepat</h2>
        <div class="quick-grid">
            <a class="quick-card" href="<?= e(url('mahasiswa/presensi')) ?>">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="M12 8H9a4 4 0 0 0-4 4v5M36 8h3a4 4 0 0 1 4 4v5M5 31v5a4 4 0 0 0 4 4h3M43 31v5a4 4 0 0 1-4 4h-3M15 24h18"/></svg></span>
                <span class="quick-copy"><strong>Presensi</strong><small>Catat &amp; cek kehadiran</small></span>
                <span class="quick-arrow">↗</span>
            </a>
            <a class="quick-card" href="#">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="M12 7h22a4 4 0 0 1 4 4v29H12a5 5 0 0 1-5-5V12a5 5 0 0 1 5-5ZM7 15h10M7 23h8M7 31h8M17 7v33M27 22l11-14a4 4 0 0 1 6 5L33 27l-8 3 2-8Z"/></svg></span>
                <span class="quick-copy"><strong>KRS</strong><small>Rencana studi semester</small></span>
                <span class="quick-arrow">↗</span>
            </a>
            <a class="quick-card" href="<?= e(url('mahasiswa/izin')) ?>">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="M28 7H12a4 4 0 0 0-4 4v27a4 4 0 0 0 4 4h20a4 4 0 0 0 4-4V27M28 7l8 8M28 7v8h8M18 35l2-8 13-14a4 4 0 0 1 6 6L26 34l-8 1Z"/></svg></span>
                <span class="quick-copy"><strong>Pengajuan Izin</strong><small>Ajukan izin perkuliahan</small></span>
                <span class="quick-arrow">↗</span>
            </a>
            <a class="quick-card" href="#">
                <span class="quick-icon"><svg viewBox="0 0 48 48"><path d="m5 30 12-14 8 8L43 5M10 40V31M20 40V27M30 40V22M40 40V13"/></svg></span>
                <span class="quick-copy"><strong>KHS</strong><small>Lihat hasil studimu</small></span>
                <span class="quick-arrow">↗</span>
            </a>
        </div>
    </section>

    <section class="attendance-notice">
        <span class="notice-info">i</span>
        <div class="notice-copy">
            <strong>Jangan lupa cek kehadiranmu secara berkala.</strong>
            <span>Ada data yang kurang sesuai? Hubungi dosen pengampu mata kuliah terkait.</span>
        </div>
        <a href="<?= e(url('mahasiswa/presensi')) ?>" class="notice-button"><span>→</span> Rekap kehadiran</a>
    </section>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

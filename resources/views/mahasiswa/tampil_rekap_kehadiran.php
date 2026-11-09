<?php
$title = 'Presensi'; $breadcrumb = 'Presensi';
include ROOT . '/resources/views/layouts/header.php';
// Variabel dari controller presensi: $rekap, $log, $kosong
?>
<section class="attendance-page">
    <a href="<?= e(url('mahasiswa')) ?>" class="back-link"><span>←</span> Kembali ke home</a>
    <div class="page-heading">
        <h1>Rekap Kehadiran</h1>
        <p>Pantau kehadiranmu di setiap mata kuliah selama satu semester.<?php if (!$kosong): ?> Jaga kehadiranmu untuk memenuhi syarat UAS (&gt;=80%)<?php endif; ?></p>
    </div>

    <section class="attendance-card">
        <div class="table-card-heading">
            <h2>Kehadiran per mata kuliah</h2>
            <?php if ($kosong): ?>
                <span class="status-pill">Belum ada data</span>
            <?php else: ?>
                <span class="updated-at">Diperbarui <?= e(date('d M Y, H.i')) ?> WIB</span>
            <?php endif; ?>
        </div>

        <div class="table-scroll">
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Kode MK</th><th>Nama MK</th><th>Kelas</th><th>Alpha</th><th>Izin</th><th>Sakit</th><th>Hadir</th><th>Total</th><th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($kosong): ?>
                    <tr class="empty-table-row"><td colspan="9"></td></tr>
                <?php else: foreach ($rekap as $r):
                    $persen  = (float)$r['PERSENTASE'];
                    $warning = $persen <= 80;
                    $alpha   = (int)$r['ALPHA'];
                ?>
                    <tr class="<?= $warning ? 'row-warning' : '' ?>">
                        <td class="muted-cell"><?= e($r['ID_MATKUL']) ?></td>
                        <td class="course-name"><?= e($r['NAMA_MATKUL']) ?><small>Semester <?= e((string)$r['SEMESTER']) ?> · <?= e((string)$r['TAHUN_AKADEMIK']) ?></small></td>
                        <td class="muted-cell center"><?= e($r['KELAS']) ?></td>
                        <td class="center <?= $alpha > 0 ? 'alpha-value' : 'muted-cell' ?>"><?= e((string)$r['ALPHA']) ?></td>
                        <td class="center muted-cell"><?= e((string)$r['IZIN']) ?></td>
                        <td class="center muted-cell"><?= e((string)$r['SAKIT']) ?></td>
                        <td class="center strong-cell"><?= e((string)$r['HADIR']) ?></td>
                        <td class="center muted-cell"><?= e((string)$r['TOTAL_PERTEMUAN']) ?></td>
                        <td>
                            <div class="percentage-cell">
                                <span class="progress-track"><span class="progress-fill <?= $warning ? 'warning' : '' ?>" style="width: <?= min(100, $persen) ?>%"></span></span>
                                <span class="percentage-label <?= $warning ? 'warning-text' : '' ?>"><?= e(number_format($persen, 1, ',', '.')) ?>%</span>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($kosong): ?>
        <div class="empty-state">
            <div class="empty-illustration">
                <svg viewBox="0 0 120 120" role="img" aria-label="Ilustrasi daftar kosong">
                    <circle cx="60" cy="60" r="59" fill="#edf3ff"/>
                    <rect x="24" y="12" width="72" height="94" rx="10" fill="#fff" stroke="#b9ceff" stroke-width="2"/>
                    <path d="M39 36h24M39 53h38M39 70h38M39 87h38" stroke="#dce7fb" stroke-width="3" stroke-linecap="round"/>
                    <path d="M39 36h23" stroke="#9db9fb" stroke-width="5" stroke-linecap="round"/>
                    <path d="M38 53h4M38 70h4M38 87h4" stroke="#b9ceff" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="100" cy="95" r="16" fill="#285bd8" stroke="#fff" stroke-width="3"/>
                    <circle cx="100" cy="95" r="8" fill="none" stroke="#fff" stroke-width="2"/>
                    <path d="M100 90v5l4 2" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <h2>Belum ada rekap kehadiran</h2>
            <p>Rekap untuk semester ini akan muncul setelah perkuliahan dimulai<br class="desktop-break"> dan dosen mencatat presensimu.</p>
            <a href="<?= e(url('mahasiswa')) ?>" class="primary-button"><span>←</span> Kembali ke Beranda</a>
        </div>
        <?php endif; ?>
    </section>

    <?php if (!$kosong && $log): ?>
    <section class="attendance-card">
        <div class="table-card-heading">
            <h2>Riwayat pertemuan terbaru</h2>
            <span class="updated-at">20 pertemuan terakhir</span>
        </div>
        <div class="table-scroll">
            <table class="attendance-table">
                <thead><tr><th>Mata kuliah</th><th>Kelas</th><th>Pertemuan</th><th>Tanggal</th><th>Status</th></tr></thead>
                <tbody>
                <?php foreach (array_slice($log, 0, 20) as $r): ?>
                    <tr>
                        <td class="course-name"><?= e($r['NAMA_MATKUL']) ?></td>
                        <td class="muted-cell center"><?= e($r['KELAS']) ?></td>
                        <td class="muted-cell center"><?= e((string)$r['PERTEMUAN_KE']) ?></td>
                        <td class="muted-cell"><?= e(fmt_tgl($r['TANGGAL'])) ?></td>
                        <td><span class="permit-status <?= e(strtolower($r['STATUS_PRESENSI'])) ?>"><?= e(status_label($r['STATUS_PRESENSI'])) ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php endif; ?>
</section>
<?php include ROOT . '/resources/views/layouts/footer.php'; ?>

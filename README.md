# Portal Akademik — Demo PHP Native MVC

Project demo terpisah dari project lama. Menggunakan PHP Native dengan pola MVC dan **tidak menggunakan database maupun koneksi Db2**. Data contoh disimpan dalam session PHP sehingga perubahan status berjalan selama session browser aktif.

## Menjalankan
1. Ekstrak folder `demo`.
2. Letakkan folder di document root web server (misalnya `htdocs/demo`).
3. Jalankan Apache dari XAMPP.
4. Buka `http://localhost/demo/public/`.

## Akun demo
| Peran | Username / NIM / NIP | Kata sandi |
|---|---|---|
| Mahasiswa | `2024001` | `mahasiswa123` |
| Dosen | `198705012015041001` | `dosen123` |

Email demo juga dapat digunakan: `alya@ucn.ac.id` atau `bima@ucn.ac.id`.

## Logika rekap kehadiran
- Rekap dihitung terpisah per mata kuliah.
- Hadir, izin yang disetujui, dan sakit yang disetujui dihitung sebagai kehadiran.
- Pengajuan berstatus Menunggu tidak mengubah status presensi dan tetap dihitung Alpha sampai diverifikasi.
- Pengajuan yang disetujui mengubah status pertemuan menjadi Izin atau Sakit.
- Pengajuan yang ditolak tetap berstatus Alpha.
- Persentase = (Total pertemuan − Alpha) / Total pertemuan × 100%.

## Alur demo
- Mahasiswa dapat melihat rekap dan riwayat pengajuan, serta mengajukan izin/sakit untuk pertemuan Alpha yang belum pernah diajukan.
- Dosen dapat melihat antrean pengajuan, membuka detail, menyetujui, atau menolak dengan alasan.
- Seed awal memuat pengajuan Menunggu, Disetujui, dan Ditolak.
- Data tersimpan pada session, bukan database. Data demo akan kembali ke seed awal ketika session browser berakhir/dihapus.

## Struktur MVC
- `app/controllers/` — pengendali alur aplikasi.
- `app/models/` — model data demo dan perhitungan.
- `resources/views/` — tampilan.
- `public/index.php` — front controller dan routing.

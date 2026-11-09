<?php
declare(strict_types=1);

/** Model UC-11: sumber data Kartu Hasil Studi mahasiswa. */
class KHS_modal {
    /**
     * Operasi sesuai class diagram: lihatDataKhs(semester: int): list<KHS>.
     * Untuk sementara data demo dipakai agar halaman dapat diuji tanpa Db2.
     * NIM diambil dari sesi pengguna yang sedang login.
     */
    public function lihatDataKhs(int $semester): array {
        $user = current_user() ?? [];
        $nim = (string)($user['nim'] ?? '');

        // Data sementara hanya untuk mode demo, belum membaca database.
        if (!empty($user['demo'])) {
            if ($semester !== 3 || $nim !== '231011024') return [];
            $data = [
                ['kodeMK'=>'IF4101','mataKuliah'=>'Administrasi Basis Data','sks'=>3,'nilai'=>null,'keterangan'=>'Data nilai belum tersedia','detail'=>[]],
                ['kodeMK'=>'IF4102','mataKuliah'=>'Dasar Manajemen Proyek','sks'=>2,'nilai'=>null,'keterangan'=>'Data nilai belum tersedia','detail'=>[]],
                ['kodeMK'=>'IF4103','mataKuliah'=>'Etika Profesional','sks'=>2,'nilai'=>null,'keterangan'=>'Data nilai belum tersedia','detail'=>[]],
                ['kodeMK'=>'IF4104','mataKuliah'=>'Komunikasi Profesional','sks'=>2,'nilai'=>null,'keterangan'=>'Data nilai belum tersedia','detail'=>[]],
                ['kodeMK'=>'IF4105','mataKuliah'=>'Manajemen Produk','sks'=>3,'nilai'=>null,'keterangan'=>'Data nilai belum tersedia','detail'=>[]],
                ['kodeMK'=>'IF4106','mataKuliah'=>'Probabilitas & Statistik','sks'=>2,'nilai'=>null,'keterangan'=>'Data nilai belum tersedia','detail'=>[]],
                ['kodeMK'=>'IF4107','mataKuliah'=>'Rekayasa Sistem Informasi','sks'=>5,'nilai'=>null,'keterangan'=>'Data nilai belum tersedia','detail'=>[]],
            ];
            // Simulasi kondisi nilai sudah terbit: buka URL dengan ?semester=3&contoh=nilai.
            if (($_GET['contoh'] ?? '') === 'nilai') {
                foreach ($data as &$row) {
                    $row['nilai'] = 'A';
                    $row['keterangan'] = '-';
                    $row['detail'] = [
                        ['komponen'=>'Tugas','nilai'=>'A'],
                        ['komponen'=>'UTS','nilai'=>'A'],
                        ['komponen'=>'UAS','nilai'=>'A'],
                    ];
                }
                unset($row);
            }
            return $data;
        }

        // Belum ada tabel NILAI pada database project saat ini.
        // Query KRS + mata kuliah dapat ditambahkan setelah struktur tabel nilai disepakati.
        // Mengembalikan array kosong mencegah aplikasi menjalankan query ke tabel yang belum ada.
        return [];
    }
}

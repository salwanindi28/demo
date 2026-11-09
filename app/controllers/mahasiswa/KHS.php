<?php
declare(strict_types=1);

/**
 * Controller UC-11: Melihat KHS oleh Mahasiswa.
 */
class KHS
{
    /**
     * Mengatur proses mahasiswa melihat KHS.
     */
    public function lihatKhs(int $semester = 3): void
    {
        // Memastikan pengguna memiliki role Mahasiswa.
        AuthMiddleware::role('MAHASISWA');

        // Membatasi semester dari 1 sampai 14.
        $semester = max(1, min(14, $semester));

        // Memanggil Model KHS.
        $model = new KHS_modal();

        // Mengambil data KHS berdasarkan semester.
        $dataKhs = $model->lihatDataKhs($semester);

        // Jika tidak ada data, tampilkan pesan.
        if (count($dataKhs) === 0) {
            $this->tampilkanPesan($semester);
            return;
        }

        // Jika ada data, tampilkan tabel KHS.
        $this->tampilkan($dataKhs, $semester);
    }

    /**
     * Menampilkan tabel KHS mahasiswa.
     */
    public function tampilkan(array $dataKhs, int $semester): void
    {
        view('mahasiswa/tampil_KHS', [
            'dataKhs' => $dataKhs,
            'semesterTerpilih' => $semester,
            'kosong' => false,
        ]);
    }

    /**
     * Menampilkan pesan jika tidak ada data KHS.
     */
    public function tampilkanPesan(int $semester): void
    {
        view('mahasiswa/tampil_pesan', [
            'semesterTerpilih' => $semester
        ]);
    }
}

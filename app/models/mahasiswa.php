<?php
declare(strict_types=1);
class Mahasiswa {
 public function getByNim(string $nim): ?array { return ['NIM'=>$nim,'NAMA_MAHASISWA'=>'Alya Putri Ramadhani','PROGRAM_STUDI'=>'Sistem Informasi','ANGKATAN'=>'2024']; }
}

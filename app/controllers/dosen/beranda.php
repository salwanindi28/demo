<?php
declare(strict_types=1);
class BerandaDosen { public function tampil(): void {AuthMiddleware::role('DOSEN');$n=(new verifikasi_izin_m())->getDaftarPending((string)current_user()['nip']);view('dosen/tampil_menu_utama',['jumlahMenunggu'=>count($n)]);} }

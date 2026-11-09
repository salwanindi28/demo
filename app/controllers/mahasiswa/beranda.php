<?php
declare(strict_types=1);
class BerandaMahasiswa { public function tampil(): void {AuthMiddleware::role('MAHASISWA');$m=(new Mahasiswa())->getByNim((string)current_user()['nim']);view('mahasiswa/tampil_menu_utama',['profile'=>$m]);} }

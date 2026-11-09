<?php
declare(strict_types=1);
class verifikasi_izin {
 public function getDaftarPengajuanPending(): void {AuthMiddleware::role('DOSEN');$rows=(new verifikasi_izin_m())->getDaftarPending((string)current_user()['nip']);view('dosen/tampil_verifikasi_izin',['rows'=>$rows,'success'=>flash('success'),'error'=>flash('error')]);}
 public function getDetailPengajuan(string $id): void {AuthMiddleware::role('DOSEN');$row=(new verifikasi_izin_m())->getDetailData($id,(string)current_user()['nip']);if(!$row){http_response_code(404);view('auth/404');return;}view('dosen/tampil_detail_izin',['row'=>$row,'error'=>flash('error')]);}
 public function getPopupKonfirmasi(): bool { return true; }
 public function showDetailPengajuan(string $id): void { $this->getDetailPengajuan($id); }
 public function showPesanAlasanHarusDiisi(): void { flash('error','Alasan penolakan wajib diisi.'); }
 public function showPesanBerhasil(string $pesan='Pengajuan berhasil diproses.'): void { flash('success',$pesan); }
 public function showPesanTidakAda(): void { http_response_code(404); view('auth/404'); }
 public function showPopupKonfirmasi(): bool { return $this->getPopupKonfirmasi(); }
 public function showTabelAntrean(array $rows): void { view('dosen/tampil_verifikasi_izin',['rows'=>$rows,'success'=>flash('success'),'error'=>flash('error')]); }
 public function prosesSetujui(string $id): void {AuthMiddleware::role('DOSEN');require_post_csrf();$ok=(new verifikasi_izin_m())->updateStatusApproved($id,(string)current_user()['nip']);flash($ok?'success':'error',$ok?'Pengajuan berhasil disetujui.':'Pengajuan tidak ditemukan atau bukan wewenang Anda.');redirect('dosen/izin');}
 public function prosesTolak(string $id): void {AuthMiddleware::role('DOSEN');require_post_csrf();$alasan=trim((string)($_POST['alasan']??''));if($alasan===''){flash('error','Alasan penolakan wajib diisi.');redirect('dosen/izin/'.$id);} $ok=(new verifikasi_izin_m())->updateStatusRejected($id,(string)current_user()['nip'],$alasan);flash($ok?'success':'error',$ok?'Pengajuan berhasil ditolak.':'Pengajuan tidak ditemukan atau bukan wewenang Anda.');redirect('dosen/izin');}
}

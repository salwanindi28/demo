<?php
declare(strict_types=1);
class izin {
 public function getRiwayatPengajuan(): void {AuthMiddleware::role('MAHASISWA');$rows=(new izin_m())->getDataRiwayat((string)current_user()['nim']);view('mahasiswa/tampil_riwayat_pengajuan',['rows'=>$rows,'success'=>flash('success')]);}
 public function getFormPengajuan(): void {AuthMiddleware::role('MAHASISWA');$presensi=(new izin_m())->getFormPengajuan((string)current_user()['nim']);view('mahasiswa/tampil_form_pengajuan',['presensi'=>$presensi,'errors'=>flash('errors')??[],'old'=>flash('old')??[]]);}
 public function showHalamanKosong(): void { view('mahasiswa/tampil_riwayat_pengajuan',['rows'=>[],'success'=>null]); }
 public function showTabelRiwayat(array $rows): void { view('mahasiswa/tampil_riwayat_pengajuan',['rows'=>$rows,'success'=>flash('success')]); }
 public function showPesanBelumLengkap(): void { flash('errors',['form'=>'Periksa kembali formulir.']); redirect('mahasiswa/izin/buat'); }
 public function showPesanBerhasil(): void { flash('success','Pengajuan izin berhasil dikirim.'); redirect('mahasiswa/izin'); }
 public function showPesanFileMax2MB(): void { flash('errors',['file_bukti'=>'Ukuran file maksimal 2 MB.']); redirect('mahasiswa/izin/buat'); }
 public function simpanPengajuan(): void {AuthMiddleware::role('MAHASISWA');require_post_csrf();$nim=(string)current_user()['nim'];$id=(string)($_POST['id_presensi']??'');$jenis=(string)($_POST['jenis_izin']??'');$ket=trim((string)($_POST['keterangan']??''));$errors=[];if($id==='' || !(new izin_m())->canSubmit($id,$nim))$errors['id_presensi']='Pilih pertemuan valid yang berstatus alpha dan belum pernah diajukan.';if(!in_array($jenis,['SAKIT','IZIN'],true))$errors['jenis_izin']='Pilih jenis izin.';if(mb_strlen($ket)<5)$errors['keterangan']='Keterangan minimal 5 karakter.';$file=$_FILES['file_bukti']??null;
 if(!$file||$file['error']===UPLOAD_ERR_NO_FILE)$errors['file_bukti']='Bukti PDF wajib diunggah.';elseif($file['error']!==UPLOAD_ERR_OK)$errors['file_bukti']='Unggahan gagal.';elseif($file['size']>2097152)$errors['file_bukti']='Ukuran file maksimal 2 MB.';elseif((new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name'])!=='application/pdf')$errors['file_bukti']='Berkas harus berformat PDF.';
 if($errors){flash('errors',$errors);flash('old',['id_presensi'=>$id,'jenis_izin'=>$jenis,'keterangan'=>$ket]);redirect('mahasiswa/izin/buat');}
 $target=ROOT.'/public/uploads';if(!is_dir($target))mkdir($target,0775,true);$stored=bin2hex(random_bytes(12)).'.pdf';if(!move_uploaded_file($file['tmp_name'],$target.'/'.$stored)){flash('errors',['file_bukti'=>'File gagal disimpan.']);redirect('mahasiswa/izin/buat');}
 try{(new izin_m())->insertDataPengajuan($id,$nim,$jenis,$ket,$stored);flash('success','Pengajuan izin berhasil dikirim.');redirect('mahasiswa/izin');}catch(Throwable $e){@unlink($target.'/'.$stored);throw $e;}
 }
}

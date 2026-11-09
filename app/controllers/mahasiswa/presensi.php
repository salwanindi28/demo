<?php
declare(strict_types=1);
class presensi { public function getLogPresensi(): void { AuthMiddleware::role('MAHASISWA');$nim=(string)current_user()['nim'];$model=new presensi_m();$rekap=$model->getDataRekap($nim);$log=$model->getLogPresensi($nim);if(!$rekap){$this->showPesanKosong();return;}$this->showRekapLengkap($rekap,$log); }
 public function showPesanKosong(): void { view('mahasiswa/tampil_rekap_kehadiran',['rekap'=>[],'log'=>[],'kosong'=>true]); }
 public function showRekapLengkap(array $dataRekap,array $log=[]): void { view('mahasiswa/tampil_rekap_kehadiran',['rekap'=>$dataRekap,'log'=>$log,'kosong'=>false]); } }

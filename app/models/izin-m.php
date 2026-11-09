<?php
declare(strict_types=1);
class izin_m {
 public function getDataRiwayat(string $nim): array {
  $d=&DemoStore::data(); $out=[];
  foreach($d['requests'] as $r){$m=$this->meeting($r['meeting_id']);$out[]=['ID_PENGAJUAN'=>$r['id'],'JENIS_IZIN'=>$r['type'],'KETERANGAN'=>$r['note'],'FILE_BUKTI'=>$r['file'],'STATUS_PENGAJUAN'=>$r['status'],'ALASAN_PENOLAKAN'=>$r['reason'],'TANGGAL_PENGAJUAN'=>$r['date'],'NAMA_MATKUL'=>$m['course'],'PERTEMUAN_KE'=>$m['meeting'],'TANGGAL'=>$m['date']];}
  usort($out,fn($a,$b)=>strcmp($b['TANGGAL_PENGAJUAN'],$a['TANGGAL_PENGAJUAN'])); return $out;
 }
 public function getFormPengajuan(string $nim): array {
  $d=&DemoStore::data();$used=array_column($d['requests'],'meeting_id');$out=[];
  foreach($d['meetings'] as $m) if($m['status']==='ALPHA'&&!in_array($m['id'],$used,true))$out[]=['ID_PRESENSI'=>$m['id'],'NAMA_MATKUL'=>$m['course'],'KELAS'=>$m['class'],'PERTEMUAN_KE'=>$m['meeting'],'TANGGAL'=>$m['date'],'STATUS_PRESENSI'=>'ALPHA'];
  return $out;
 }
 public function canSubmit(string $id,string $nim): bool { foreach($this->getFormPengajuan($nim) as $m) if($m['ID_PRESENSI']===$id)return true; return false; }
 public function insertDataPengajuan(string $id,string $nim,string $jenis,string $ket,string $file): string {
  if(!$this->canSubmit($id,$nim))throw new RuntimeException('Pertemuan tidak valid untuk diajukan.');
  $d=&DemoStore::data();$new='IZ'.str_pad((string)(count($d['requests'])+1),3,'0',STR_PAD_LEFT);
  $d['requests'][]=['id'=>$new,'meeting_id'=>$id,'type'=>$jenis,'note'=>$ket,'file'=>$file,'status'=>'MENUNGGU','date'=>date('Y-m-d'),'reason'=>''];return $new;
 }
 private function meeting(string $id): array { $d=&DemoStore::data();foreach($d['meetings'] as $m)if($m['id']===$id)return $m;return ['course'=>'-','meeting'=>0,'date'=>'']; }
}

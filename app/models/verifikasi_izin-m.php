<?php
declare(strict_types=1);
class verifikasi_izin_m {
 public function getDaftarPending(string $nip): array {
  $d=&DemoStore::data();$out=[];
  foreach($d['requests'] as $r)if($r['status']==='MENUNGGU'){$m=$this->meeting($r['meeting_id']);$out[]=$this->format($r,$m);}
  return $out;
 }
 public function getDetailData(string $id,string $nip): ?array {
  $d=&DemoStore::data();foreach($d['requests'] as $r)if($r['id']===$id){$m=$this->meeting($r['meeting_id']);return $this->format($r,$m);}return null;
 }
 public function updateStatusApproved(string $id,string $nip): bool {return $this->update($id,'DISETUJUI','');}
 public function updateStatusRejected(string $id,string $nip,string $reason): bool {return $this->update($id,'DITOLAK',$reason);}
 private function update(string $id,string $status,string $reason): bool {
  $d=&DemoStore::data();
  foreach($d['requests'] as &$r)if($r['id']===$id&&$r['status']==='MENUNGGU'){
   $r['status']=$status;$r['reason']=$reason;
   if($status==='DISETUJUI')foreach($d['meetings'] as &$m)if($m['id']===$r['meeting_id'])$m['status']=$r['type'];
   unset($m,$r);return true;
  } unset($r);return false;
 }
 private function meeting(string $id): array { $d=&DemoStore::data();foreach($d['meetings'] as $m)if($m['id']===$id)return $m;return []; }
 private function format(array $r,array $m): array {
  return ['ID_PENGAJUAN'=>$r['id'],'ID_PRESENSI'=>$r['meeting_id'],'JENIS_IZIN'=>$r['type'],'KETERANGAN'=>$r['note'],'FILE_BUKTI'=>$r['file'],'STATUS_PENGAJUAN'=>$r['status'],'ALASAN_PENOLAKAN'=>$r['reason'],'TANGGAL_PENGAJUAN'=>$r['date'],'NIM'=>'2024001','NAMA_MAHASISWA'=>'Alya Putri Ramadhani','NAMA_MATKUL'=>$m['course']??'-','KELAS'=>$m['class']??'-','PERTEMUAN_KE'=>$m['meeting']??0,'TANGGAL'=>$m['date']??''];
 }
}

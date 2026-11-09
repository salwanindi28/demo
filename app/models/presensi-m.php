<?php
declare(strict_types=1);
class presensi_m {
 public function getDataRekap(string $nim): array {
  $d=&DemoStore::data(); $out=[];
  foreach($d['courses'] as $c){
   $ms=array_values(array_filter($d['meetings'],fn($m)=>$m['course_id']===$c['id']));
   $total=count($ms); $alpha=count(array_filter($ms,fn($m)=>$m['status']==='ALPHA'));
   $izin=count(array_filter($ms,fn($m)=>$m['status']==='IZIN')); $sakit=count(array_filter($ms,fn($m)=>$m['status']==='SAKIT'));
   $hadir=$total-$alpha;
   $out[]=['ID_PENGAMBILAN'=>$c['id'],'ID_MATKUL'=>$c['id'],'NAMA_MATKUL'=>$c['name'],'KELAS'=>$c['class'],'SEMESTER'=>3,'TAHUN_AKADEMIK'=>'2026/2027','TOTAL_PERTEMUAN'=>$total,'HADIR'=>$hadir,'IZIN'=>$izin,'SAKIT'=>$sakit,'ALPHA'=>$alpha,'PERSENTASE'=>$total?round(($total-$alpha)/$total*100,2):0];
  } return $out;
 }
 public function getLogPresensi(string $nim): array {
  $d=&DemoStore::data(); $rows=[];
  foreach($d['meetings'] as $m) $rows[]=['NAMA_MATKUL'=>$m['course'],'KELAS'=>$m['class'],'PERTEMUAN_KE'=>$m['meeting'],'TANGGAL'=>$m['date'],'STATUS_PRESENSI'=>$m['status'],'WAKTU_PRESENSI'=>'08:00:00'];
  usort($rows,fn($a,$b)=>strcmp($b['TANGGAL'],$a['TANGGAL'])); return $rows;
 }
}

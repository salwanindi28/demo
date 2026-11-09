<?php
declare(strict_types=1);

/** Penyimpanan demo berbasis session: tidak membutuhkan database. */
final class DemoStore {
    private static function seed(): array {
        $courses = [
            ['id'=>'SI101','name'=>'Algoritma dan Pemrograman','class'=>'A'],
            ['id'=>'SI102','name'=>'Pengantar Sistem Informasi','class'=>'A'],
            ['id'=>'SI103','name'=>'Basis Data','class'=>'B'],
        ];
        $meetings = [];
        $dates = ['2026-09-07','2026-09-14','2026-09-21','2026-09-28','2026-10-05','2026-10-12','2026-10-19','2026-10-26','2026-11-02','2026-11-09'];
        $statuses = [
            'SI101'=>['HADIR','HADIR','HADIR','ALPHA','HADIR','HADIR','HADIR','HADIR','HADIR','HADIR'],
            'SI102'=>['HADIR','IZIN','HADIR','HADIR','ALPHA','HADIR','SAKIT','HADIR','HADIR','HADIR'],
            'SI103'=>['HADIR','HADIR','ALPHA','HADIR','HADIR','HADIR','HADIR','ALPHA','HADIR','HADIR'],
        ];
        $i=1;
        foreach ($courses as $c) foreach ($dates as $j=>$date) {
            $meetings[]=['id'=>'PRS'.str_pad((string)$i++,3,'0',STR_PAD_LEFT),'course_id'=>$c['id'],'course'=>$c['name'],'class'=>$c['class'],'meeting'=>$j+1,'date'=>$date,'status'=>$statuses[$c['id']][$j]];
        }
        $requests = [
            ['id'=>'IZ001','meeting_id'=>'PRS004','type'=>'IZIN','note'=>'Ada keperluan keluarga yang tidak dapat ditinggalkan.','file'=>'demo_IZ001.pdf','status'=>'MENUNGGU','date'=>'2026-11-03','reason'=>''],
            ['id'=>'IZ002','meeting_id'=>'PRS012','type'=>'SAKIT','note'=>'Mengalami demam dan perlu beristirahat.','file'=>'demo_IZ002.pdf','status'=>'DISETUJUI','date'=>'2026-10-06','reason'=>''],
            ['id'=>'IZ003','meeting_id'=>'PRS023','type'=>'IZIN','note'=>'Mengikuti kegiatan di luar kampus.','file'=>'demo_IZ003.pdf','status'=>'DITOLAK','date'=>'2026-10-20','reason'=>'Bukti pendukung belum sesuai.'],
            ['id'=>'IZ004','meeting_id'=>'PRS028','type'=>'SAKIT','note'=>'Kondisi kesehatan kurang baik.','file'=>'demo_IZ004.pdf','status'=>'MENUNGGU','date'=>'2026-11-04','reason'=>''],
        ];
        // Status presensi hanya berubah setelah persetujuan; ditolak tetap Alpha.
        $meetById=[]; foreach($meetings as $m) $meetById[$m['id']]=$m;
        foreach($requests as $r) if($r['status']==='DISETUJUI') {
            foreach($meetings as &$m) if($m['id']===$r['meeting_id']) $m['status']=$r['type'];
            unset($m);
        }
        return ['courses'=>$courses,'meetings'=>$meetings,'requests'=>$requests];
    }
    public static function &data(): array {
        if (!isset($_SESSION['demo_data'])) $_SESSION['demo_data']=self::seed();
        return $_SESSION['demo_data'];
    }
    public static function reset(): void { $_SESSION['demo_data']=self::seed(); }
}

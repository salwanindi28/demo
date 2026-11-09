<?php
declare(strict_types=1);
class Dosen { public function jumlahMenunggu(string $nip): int { $d=&DemoStore::data(); return count(array_filter($d['requests'],fn($r)=>$r['status']==='MENUNGGU')); } }

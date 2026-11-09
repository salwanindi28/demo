<?php
declare(strict_types=1);
class AkunPengguna {
    public function ValidasiKredensial(string $login,string $password): ?array {
        $users=[
          ['login'=>'2024001','password'=>'mahasiswa123','role'=>'MAHASISWA','name'=>'Alya Putri Ramadhani','nim'=>'2024001','nip'=>null,'email'=>'alya@ucn.ac.id'],
          ['login'=>'198705012015041001','password'=>'dosen123','role'=>'DOSEN','name'=>'Dr. Bima Pratama, M.Kom.','nim'=>null,'nip'=>'198705012015041001','email'=>'bima@ucn.ac.id'],
        ];
        foreach($users as $u) if(strcasecmp($login,$u['login'])===0 || strcasecmp($login,$u['email'])===0)
            return hash_equals($u['password'],$password) ? $u : null;
        return null;
    }
}

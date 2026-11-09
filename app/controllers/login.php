<?php
declare(strict_types=1);
class Login {
 public function Tampilkan(): void {if(current_user())redirect(current_user()['role']==='DOSEN'?'dosen':'mahasiswa');view('auth/tampil_login',['error'=>flash('error')]);}
 public function ProsesLogin(): void {require_post_csrf();$u=(new AkunPengguna())->ValidasiKredensial(trim((string)($_POST['email']??'')),(string)($_POST['kata_sandi']??''));if(!$u){flash('error','Akun atau kata sandi tidak sesuai. Gunakan akun demo yang tersedia.');redirect('');}session_regenerate_id(true);$_SESSION['user']=$u;redirect($u['role']==='DOSEN'?'dosen':'mahasiswa');}
 public function Logout(): void {require_post_csrf();$_SESSION=[];session_regenerate_id(true);$_SESSION['_csrf']=bin2hex(random_bytes(32));redirect('');}
}

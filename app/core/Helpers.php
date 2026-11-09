<?php
declare(strict_types=1);
function base_path_url(): string { return rtrim((string)($_ENV['APP_BASE_PATH'] ?? '/demo/public'), '/'); }
function url(string $path=''): string { return base_path_url().($path===''?'/':'/'.ltrim($path,'/')); }
function redirect(string $path): never { header('Location: '.url($path)); exit; }
function e(?string $v): string { return htmlspecialchars((string)$v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8'); }
function csrf_field(): string { return '<input type="hidden" name="_token" value="'.e($_SESSION['_csrf']??'').'">'; }
function flash(string $key,mixed $value=null): mixed { if(func_num_args()>1){$_SESSION['_flash'][$key]=$value;return null;} $v=$_SESSION['_flash'][$key]??null;unset($_SESSION['_flash'][$key]);return $v; }
function view(string $file,array $data=[]): void { extract($data,EXTR_SKIP);$f=ROOT.'/resources/views/'.$file.'.php';if(!is_file($f))throw new RuntimeException("View tidak ditemukan: {$file}");require $f; }
function current_user(): ?array { return $_SESSION['user']??null; }
function initials(string $name): string { $p=preg_split('/\s+/',trim($name));return strtoupper(substr($p[0]??'U',0,1).(isset($p[1])?substr($p[1],0,1):'')); }
function status_label(string $s): string { return match(strtoupper($s)){'MENUNGGU'=>'Menunggu','DISETUJUI'=>'Disetujui','DITOLAK'=>'Ditolak','HADIR'=>'Hadir','IZIN'=>'Izin','SAKIT'=>'Sakit','ALPHA'=>'Alpha',default=>ucfirst(strtolower($s))}; }
function fmt_tgl($v,bool $jam=false): string { $t=strtotime((string)$v);return $t?($jam?date('d M Y · H.i',$t).' WIB':date('d M Y',$t)):(string)$v; }
function ukuran_bukti(?string $file): string { if(!$file)return '—';$p=ROOT.'/public/uploads/'.basename($file);return is_file($p)?number_format(filesize($p)/1024,0).' KB':'—'; }
function require_post_csrf(): void { if(!hash_equals((string)($_SESSION['_csrf']??''),(string)($_POST['_token']??''))){http_response_code(419);exit('Sesi formulir kedaluwarsa. Muat ulang halaman.');} }

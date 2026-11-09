<?php
declare(strict_types=1);
class AuthMiddleware {
    public static function auth(): void { if (!current_user()) { flash('error', 'Silakan login terlebih dahulu.'); redirect(''); } }
    public static function role(string $role): void {
        self::auth();
        if ((current_user()['role'] ?? '') !== $role) { http_response_code(403); view('auth/403'); exit; }
    }
}

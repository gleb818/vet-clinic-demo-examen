<?php
class Auth {
    public static function login(array $user): void {
        $_SESSION['user_id']  = (int)$user['id'];
        $_SESSION['is_admin'] = (int)$user['is_admin'];
    }
    public static function logout(): void {
        unset($_SESSION['user_id'], $_SESSION['is_admin']);
    }
    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }
    public static function id(): ?int {
        return $_SESSION['user_id'] ?? null;
    }
    public static function isAdmin(): bool {
        return !empty($_SESSION['is_admin']);
    }
    public static function requireUser(): void {
        if (!self::check()) redirect('/frontend/login.php');
    }
    public static function requireAdmin(): void {
        if (!self::isAdmin()) redirect('/frontend/login.php');
    }
}
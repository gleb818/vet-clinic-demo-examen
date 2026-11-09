<?php
session_start();

$config = require __DIR__ . '/config.php';
define('BASE', $config['base'] ?? '');

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Validator.php';
require_once __DIR__ . '/classes/Auth.php';
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/Application.php';
require_once __DIR__ . '/classes/Review.php';

function redirect(string $path): void {
    header('Location: ' . BASE . $path);
    exit;
}

function flash(string $key, ?string $value = null): ?string {
    if ($value === null) {
        $v = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $v;
    }
    $_SESSION['flash'][$key] = $value;
    return null;
}

function errors(): array {
    $e = $_SESSION['errors'] ?? [];
    unset($_SESSION['errors']);
    return $e;
}

function e($s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
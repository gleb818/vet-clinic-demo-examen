<?php
require_once __DIR__ . '/../bootstrap.php';

$login    = trim($_POST['login'] ?? '');
$password = $_POST['password'] ?? '';

$user = User::findByLogin($login);
if (!$user || !password_verify($password, $user['password_hash'])) {
    $_SESSION['errors'] = ['login' => 'Неверный логин или пароль'];
    $_SESSION['old'] = ['login' => $login];
    redirect('/frontend/login.php');
}

Auth::login($user);
flash('success', 'Добро пожаловать');
redirect('/frontend/applications.php');
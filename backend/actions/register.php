<?php
require_once __DIR__ . '/../bootstrap.php';

$data = [
    'login'     => trim($_POST['login'] ?? ''),
    'password'  => $_POST['password'] ?? '',
    'full_name' => trim($_POST['full_name'] ?? ''),
    'phone'     => trim($_POST['phone'] ?? ''),
    'email'     => trim($_POST['email'] ?? ''),
];

$map = ['login' => 'login', 'password' => 'password', 'full_name' => 'fullName', 'phone' => 'phone', 'email' => 'email'];
$errors = [];
foreach ($map as $field => $method) {
    $e = Validator::$method($data[$field]);
    if ($e) $errors[$field] = $e;
}
if (!isset($errors['login']) && User::exists($data['login'])) {
    $errors['login'] = 'Логин уже занят';
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $data;
    redirect('/frontend/register.php');
}

User::create($data);
flash('success', 'Пользователь создан. Войдите.');
redirect('/frontend/login.php');
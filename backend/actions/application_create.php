<?php
require_once __DIR__ . '/../bootstrap.php';
Auth::requireUser();

$data = [
    'pet_name'             => trim($_POST['pet_name'] ?? ''),
    'species'              => trim($_POST['species'] ?? ''),
    'service'              => trim($_POST['service'] ?? ''),
    'appointment_datetime' => trim($_POST['appointment_datetime'] ?? ''),
    'payment_method_id'    => (int)($_POST['payment_method_id'] ?? 0),
];

$errors = [];
$required = [
    'pet_name'             => 'Введите кличку',
    'species'              => 'Введите вид',
    'service'              => 'Введите услугу',
    'appointment_datetime' => 'Введите дату и время',
];
foreach ($required as $f => $msg) {
    if ($data[$f] === '') $errors[$f] = $msg;
}
if ($data['payment_method_id'] <= 0) $errors['payment_method_id'] = 'Выберите способ оплаты';

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $data;
    redirect('/frontend/application_create.php');
}

Application::create(Auth::id(), $data);
flash('success', 'Заявка создана');
redirect('/frontend/applications.php');
<?php
require_once __DIR__ . '/../bootstrap.php';
Auth::requireUser();

$data = [
    'pet_name'           => trim($_POST['pet_name'] ?? ''),
    'species'            => trim($_POST['species'] ?? ''),
    'service'            => trim($_POST['service'] ?? ''),
    'appointment_date'   => trim($_POST['appointment_date'] ?? ''),
    'appointment_time'   => trim($_POST['appointment_time'] ?? ''),
    'payment_method_id'  => (int)($_POST['payment_method_id'] ?? 0),
];

$errors = [];
if ($data['pet_name'] === '') $errors['pet_name'] = 'Введите кличку';
if ($data['species'] === '') $errors['species'] = 'Выберите вид';
if ($data['service'] === '') $errors['service'] = 'Выберите услугу';
if ($data['payment_method_id'] <= 0) $errors['payment_method_id'] = 'Выберите способ оплаты';

$date = DateTime::createFromFormat('d.m.Y', $data['appointment_date']);
if (!$date || $date->format('d.m.Y') !== $data['appointment_date']) {
    $errors['appointment_date'] = 'Формат даты: ДД.ММ.ГГГГ';
}

if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $data['appointment_time'])) {
    $errors['appointment_time'] = 'Формат времени: ЧЧ:ММ';
} else {
    $hour = (int)explode(':', $data['appointment_time'])[0];

    if ($hour < 9 || $hour >= 20) {
        $errors['appointment_time'] = 'Клиника работает с 09:00 до 20:00';
    }
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $data;
    redirect('/frontend/application_create.php');
}

$data['appointment_datetime'] = $data['appointment_date'] . ' ' . $data['appointment_time'];

Application::create(Auth::id(), $data);
flash('success', 'Заявка создана');
redirect('/frontend/applications.php');
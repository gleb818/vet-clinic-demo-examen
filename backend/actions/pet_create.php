<?php
require_once __DIR__ . '/../bootstrap.php';
Auth::requireUser();

$name = trim($_POST['name'] ?? '');
$species = trim($_POST['species'] ?? '');

if ($name !== '' && $species !== '') {
    Pet::add(Auth::id(), $name, $species);
    flash('success', 'Питомец добавлен в профиль');
} else {
    flash('error', 'Заполните все поля');
}
redirect('/frontend/pets.php');
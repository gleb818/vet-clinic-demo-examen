<?php
require_once __DIR__ . '/../bootstrap.php';
Auth::requireUser();

$appId = (int)($_POST['application_id'] ?? 0);
$text  = trim($_POST['text'] ?? '');
$app   = Application::find($appId);

if (!$app || (int)$app['user_id'] !== Auth::id()) {
    flash('error', 'Заявка не найдена');
    redirect('/frontend/applications.php');
}
if (Application::statusName($appId) !== 'Приём завершён') {
    flash('error', 'Отзыв доступен после завершения приёма');
    redirect('/frontend/applications.php');
}
if ($text === '') {
    flash('error', 'Введите текст отзыва');
    redirect('/frontend/applications.php');
}

Review::create($appId, Auth::id(), $text);
flash('success', 'Спасибо за отзыв');
redirect('/frontend/applications.php');
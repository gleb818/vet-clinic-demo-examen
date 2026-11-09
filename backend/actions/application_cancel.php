<?php
require_once __DIR__ . '/../bootstrap.php';
Auth::requireUser();

$id = (int)($_POST['id'] ?? 0);
$app = Application::find($id);

if (!$app || (int)$app['user_id'] !== Auth::id()) {
    flash('error', 'Заявка не найдена');
    redirect('/frontend/applications.php');
}

if (Application::statusName($id) === 'Новая') {
    $st = Database::pdo()->prepare("SELECT id FROM statuses WHERE name = 'Отменена'");
    $st->execute();
    $statusId = $st->fetchColumn();
    
    if ($statusId) {
        Application::updateStatus($id, (int)$statusId);
        flash('success', 'Заявка отменена');
    }
} else {
    flash('error', 'Отменить можно только новую заявку');
}
redirect('/frontend/applications.php');
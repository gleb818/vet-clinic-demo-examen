<?php
require_once __DIR__ . '/../bootstrap.php';
Auth::requireAdmin();

$id       = (int)($_POST['id'] ?? 0);
$statusId = (int)($_POST['status_id'] ?? 0);
if ($id > 0 && $statusId > 0) {
    Application::updateStatus($id, $statusId);
    flash('success', 'Статус обновлён');
}
redirect('/frontend/admin.php');
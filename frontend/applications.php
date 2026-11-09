<?php
require_once __DIR__ . '/../backend/bootstrap.php';
Auth::requireUser();

$apps = Application::forUser(Auth::id());
$reviewed = [];
foreach (Review::forUser(Auth::id()) as $r) {
    $reviewed[(int)$r['application_id']] = true;
}
require __DIR__ . '/partials/header.php';
?>
<h1>Мои записи</h1>
<p><a class="btn" href="<?= BASE ?>/frontend/application_create.php">Новая запись</a></p>

<?php if (!$apps): ?><p>Записей пока нет.</p><?php endif; ?>

<?php foreach ($apps as $a): ?>
  <div class="card">
    <div><b><?= e($a['pet_name']) ?></b> (<?= e($a['species']) ?>)</div>
    <div>Услуга: <?= e($a['service']) ?></div>
    <div>Когда: <?= e($a['appointment_datetime']) ?></div>
    <div>Оплата: <?= e($a['payment_name']) ?></div>
    <div>Статус: <span class="status"><?= e($a['status_name']) ?></span></div>

    <?php if ($a['status_name'] === 'Приём завершён' && empty($reviewed[(int)$a['id']])): ?>
      <form method="post" action="<?= BASE ?>/backend/actions/review_create.php" class="form-inline">
        <input type="hidden" name="application_id" value="<?= (int)$a['id'] ?>">
        <input type="text" name="text" placeholder="Отзыв о клинике">
        <button class="btn small">Оставить отзыв</button>
      </form>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
<?php require __DIR__ . '/partials/footer.php'; ?>
<?php
require_once __DIR__ . '/../backend/bootstrap.php';
Auth::requireAdmin();

$apps = Application::all();
$statuses = Database::pdo()->query('SELECT * FROM statuses')->fetchAll();
require __DIR__ . '/partials/header.php';
?>
<h1>Панель администратора</h1>
<?php if (!$apps): ?>
  <p>Заявок пока нет.</p>
<?php endif; ?>

<?php foreach ($apps as $a): ?>
  <div class="card">
    <div><b>#<?= (int)$a['id'] ?></b> <?= e($a['owner_name']) ?> — <?= e($a['pet_name']) ?> (<?= e($a['species']) ?>)</div>
    <div>Услуга: <?= e($a['service']) ?></div>
    <div>Когда: <?= e($a['appointment_datetime']) ?></div>
    <div>Оплата: <?= e($a['payment_name']) ?></div>
    <form method="post" action="<?= BASE ?>/backend/actions/admin_status.php" class="form-inline">
      <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
      <select name="status_id">
        <?php foreach ($statuses as $s): ?>
          <option value="<?= (int)$s['id'] ?>" <?= (int)$s['id'] === (int)$a['status_id'] ? 'selected' : '' ?>>
            <?= e($s['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <button class="btn small">Сохранить</button>
    </form>
  </div>
<?php endforeach; ?>
<?php require __DIR__ . '/partials/footer.php'; ?>
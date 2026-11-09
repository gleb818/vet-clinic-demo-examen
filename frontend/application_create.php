<?php
require_once __DIR__ . '/../backend/bootstrap.php';
Auth::requireUser();

$errors = errors();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
$payments = Database::pdo()->query('SELECT * FROM payment_methods')->fetchAll();
require __DIR__ . '/partials/header.php';
?>
<h1>Запись на приём</h1>
<form method="post" action="<?= BASE ?>/backend/actions/application_create.php" class="form">
  <label>Кличка питомца
    <input name="pet_name" value="<?= e($old['pet_name'] ?? '') ?>">
    <?php if (!empty($errors['pet_name'])): ?><span class="err"><?= e($errors['pet_name']) ?></span><?php endif; ?>
  </label>
  <label>Вид животного
    <input name="species" value="<?= e($old['species'] ?? '') ?>">
    <?php if (!empty($errors['species'])): ?><span class="err"><?= e($errors['species']) ?></span><?php endif; ?>
  </label>
  <label>Услуга
    <input name="service" value="<?= e($old['service'] ?? '') ?>">
    <?php if (!empty($errors['service'])): ?><span class="err"><?= e($errors['service']) ?></span><?php endif; ?>
  </label>
  <label>Дата и время приёма
    <input name="appointment_datetime" value="<?= e($old['appointment_datetime'] ?? '') ?>">
    <?php if (!empty($errors['appointment_datetime'])): ?><span class="err"><?= e($errors['appointment_datetime']) ?></span><?php endif; ?>
  </label>
  <label>Способ оплаты
    <select name="payment_method_id">
      <option value="">— выберите —</option>
      <?php foreach ($payments as $p): ?>
        <option value="<?= (int)$p['id'] ?>" <?= (int)($old['payment_method_id'] ?? 0) === (int)$p['id'] ? 'selected' : '' ?>>
          <?= e($p['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['payment_method_id'])): ?><span class="err"><?= e($errors['payment_method_id']) ?></span><?php endif; ?>
  </label>
  <button class="btn" type="submit">Записаться</button>
</form>
<?php require __DIR__ . '/partials/footer.php'; ?>
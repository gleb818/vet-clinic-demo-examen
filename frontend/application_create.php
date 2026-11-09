<?php
require_once __DIR__ . '/../backend/bootstrap.php';
Auth::requireUser();

$errors = errors();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
$payments = Database::pdo()->query('SELECT * FROM payment_methods')->fetchAll();
$pets = Pet::forUser(Auth::id());

require __DIR__ . '/partials/header.php';
?>
<h1>Запись на приём</h1>

<?php if (!$pets): ?>
    <div class="toast error">У вас нет добавленных питомцев. <a href="<?= BASE ?>/frontend/pets.php">Добавьте питомца</a> сначала.</div>
<?php else: ?>
<form method="post" action="<?= BASE ?>/backend/actions/application_create.php" class="form">
  
  <label>Выберите питомца
    <select name="pet_id">
      <option value="">— выберите —</option>
      <?php foreach ($pets as $p): ?>
        <option value="<?= (int)$p['id'] ?>" <?= (int)($old['pet_id'] ?? 0) === (int)$p['id'] ? 'selected' : '' ?>>
          <?= e($p['name']) ?> (<?= e($p['species']) ?>)
        </option>
      <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['pet_id'])): ?><span class="err"><?= e($errors['pet_id']) ?></span><?php endif; ?>
  </label>

  <label>Услуга
    <select name="service">
      <option value="">— выберите —</option>
      <?php 
      $servicesList = ['Первичный осмотр', 'Вакцинация', 'Стрижка когтей', 'УЗИ'];
      foreach ($servicesList as $s): ?>
        <option value="<?= $s ?>" <?= ($old['service'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['service'])): ?><span class="err"><?= e($errors['service']) ?></span><?php endif; ?>
  </label>

  <label>Дата (ДД.ММ.ГГГГ)
    <input name="appointment_date" placeholder="01.12.2026" value="<?= e($old['appointment_date'] ?? '') ?>">
    <?php if (!empty($errors['appointment_date'])): ?><span class="err"><?= e($errors['appointment_date']) ?></span><?php endif; ?>
  </label>

  <label>Время (ЧЧ:ММ)
    <input name="appointment_time" id="appointment_time" placeholder="14:30" value="<?= e($old['appointment_time'] ?? '') ?>">
    <?php if (!empty($errors['appointment_time'])): ?><span class="err"><?= e($errors['appointment_time']) ?></span><?php endif; ?>
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
<?php endif; ?>
<?php require __DIR__ . '/partials/footer.php'; ?>
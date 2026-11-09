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
    <select name="species">
      <option value="">— выберите —</option>
      <?php 
      $speciesList = ['Кошка', 'Собака', 'Грызун', 'Птица', 'Другое'];
      foreach ($speciesList as $s): ?>
        <option value="<?= $s ?>" <?= ($old['species'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
    <?php if (!empty($errors['species'])): ?><span class="err"><?= e($errors['species']) ?></span><?php endif; ?>
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

  <label>Время (ЧЧ:ММ, с 09:00 до 20:00)
    <input name="appointment_time" placeholder="14:30" value="<?= e($old['appointment_time'] ?? '') ?>">
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
<?php require __DIR__ . '/partials/footer.php'; ?>
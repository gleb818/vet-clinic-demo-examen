<?php
require_once __DIR__ . '/../backend/bootstrap.php';
$errors = errors();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
require __DIR__ . '/partials/header.php';

$fields = [
    'login'     => 'Логин (латиница и цифры, ≥6)',
    'password'  => 'Пароль (≥6)',
    'full_name' => 'ФИО',
    'phone'     => 'Телефон (+7(XXX)XXX-XX-XX)',
    'email'     => 'E-mail',
];
?>
<h1>Регистрация</h1>
<form method="post" action="<?= BASE ?>/backend/actions/register.php" class="form">
  <?php foreach ($fields as $name => $label): ?>
    <label><?= e($label) ?>
      <input type="<?= $name === 'password' ? 'password' : 'text' ?>"
             name="<?= $name ?>" value="<?= e($old[$name] ?? '') ?>">
      <?php if (!empty($errors[$name])): ?><span class="err"><?= e($errors[$name]) ?></span><?php endif; ?>
    </label>
  <?php endforeach; ?>
  <button class="btn" type="submit">Создать пользователя</button>
  <p><a href="<?= BASE ?>/frontend/login.php">Уже зарегистрированы? Войти</a></p>
</form>
<?php require __DIR__ . '/partials/footer.php'; ?>
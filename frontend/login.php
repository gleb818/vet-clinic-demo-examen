<?php
require_once __DIR__ . '/../backend/bootstrap.php';
$errors = errors();
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
require __DIR__ . '/partials/header.php';
?>
<h1>Вход</h1>
<form method="post" action="<?= BASE ?>/backend/actions/login.php" class="form">
  <label>Логин
    <input name="login" value="<?= e($old['login'] ?? '') ?>">
    <?php if (!empty($errors['login'])): ?><span class="err"><?= e($errors['login']) ?></span><?php endif; ?>
  </label>
  <label>Пароль
    <input type="password" name="password">
  </label>
  <button class="btn" type="submit">Войти</button>
  <p><a href="<?= BASE ?>/frontend/register.php">Еще не зарегистрированы? Регистрация</a></p>
</form>
<?php require __DIR__ . '/partials/footer.php'; ?>
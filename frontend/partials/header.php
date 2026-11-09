<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Хвост и Лапы</title>
<link rel="stylesheet" href="<?= BASE ?>/frontend/assets/css/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="<?= BASE ?>/index.php">🐾 Хвост и Лапы</a>
  <nav>
    <?php if (Auth::check()): ?>
      <?php if (Auth::isAdmin()): ?>
        <a href="<?= BASE ?>/frontend/admin.php">Админ-панель</a>
      <?php else: ?>
        <a href="<?= BASE ?>/frontend/applications.php">Мои записи</a>
        <a href="<?= BASE ?>/frontend/application_create.php">Записаться</a>
      <?php endif; ?>
      <a href="<?= BASE ?>/backend/actions/logout.php">Выйти</a>
    <?php else: ?>
      <a href="<?= BASE ?>/frontend/login.php">Вход</a>
      <a href="<?= BASE ?>/frontend/register.php">Регистрация</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
<?php if ($m = flash('success')): ?><div class="toast success"><?= e($m) ?></div><?php endif; ?>
<?php if ($m = flash('error')): ?><div class="toast error"><?= e($m) ?></div><?php endif; ?>
<?php
require_once __DIR__ . '/backend/bootstrap.php';

if (Auth::check()) {
    redirect(Auth::isAdmin() ? '/frontend/admin.php' : '/frontend/applications.php');
}
require __DIR__ . '/frontend/partials/header.php';
?>
<section class="hero">
  <h1>Забота о хвостатых и лапастых</h1>
  <p>Онлайн-запись в ветеринарную клинику «Хвост и Лапы».</p>
  <p>
    <a class="btn" href="<?= BASE ?>/frontend/register.php">Зарегистрироваться</a>
    <a class="btn ghost" href="<?= BASE ?>/frontend/login.php">Войти</a>
  </p>
</section>
<?php require __DIR__ . '/frontend/partials/footer.php'; ?>
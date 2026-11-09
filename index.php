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
  
  <div class="slider" id="slider">
    <div class="slides" id="slides">
      <img src="<?= BASE ?>/frontend/assets/img/slide1.jpg" alt="Врачи">
      <img src="<?= BASE ?>/frontend/assets/img/slide2.jpg" alt="Питомцы">
      <img src="<?= BASE ?>/frontend/assets/img/slide3.jpg" alt="Клиника">
      <img src="<?= BASE ?>/frontend/assets/img/slide4.jpg" alt="Вакцинация">
    </div>
    <button class="slider-btn prev" id="prevBtn">&#10094;</button>
    <button class="slider-btn next" id="nextBtn">&#10095;</button>
  </div>

  <p style="margin-top: 20px;">
    <a class="btn" href="<?= BASE ?>/frontend/register.php">Зарегистрироваться</a>
    <a class="btn ghost" href="<?= BASE ?>/frontend/login.php">Войти</a>
  </p>
</section>
<?php require __DIR__ . '/frontend/partials/footer.php'; ?>
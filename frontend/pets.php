<?php
require_once __DIR__ . '/../backend/bootstrap.php';
Auth::requireUser();

$pets = Pet::forUser(Auth::id());
require __DIR__ . '/partials/header.php';
?>
<h1>Мои питомцы</h1>
<p><a href="<?= BASE ?>/frontend/applications.php" class="btn ghost small">&larr; Назад к записям</a></p>

<div class="card">
    <h3>Добавить питомца</h3>
    <form method="post" action="<?= BASE ?>/backend/actions/pet_create.php" class="form-inline">
        <input type="text" name="name" placeholder="Кличка" required>
        <select name="species" required>
            <option value="">Вид</option>
            <option value="Кошка">Кошка</option>
            <option value="Собака">Собака</option>
            <option value="Грызун">Грызун</option>
            <option value="Птица">Птица</option>
            <option value="Другое">Другое</option>
        </select>
        <button class="btn small">Добавить</button>
    </form>
</div>

<?php if (!$pets): ?>
    <p>У вас пока нет добавленных питомцев.</p>
<?php endif; ?>

<?php foreach ($pets as $p): ?>
    <div class="card">
        <b><?= e($p['name']) ?></b> (<?= e($p['species']) ?>)
    </div>
<?php endforeach; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
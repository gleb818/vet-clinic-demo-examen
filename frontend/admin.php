<?php
require_once __DIR__ . '/../backend/bootstrap.php';
Auth::requireAdmin();

$filters = [
    'status_id' => $_GET['status_id'] ?? '',
    'service'   => $_GET['service'] ?? '',
    'search'    => trim($_GET['search'] ?? '')
];

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 5; 
$offset = ($page - 1) * $limit;

$apps = Application::all($filters, $limit, $offset);
$total = Application::countAll($filters);
$totalPages = ceil($total / $limit);

$statuses = Database::pdo()->query('SELECT * FROM statuses')->fetchAll();
$services = ['Первичный осмотр', 'Вакцинация', 'Стрижка когтей', 'УЗИ'];

require __DIR__ . '/partials/header.php';
?>
<h1>Панель администратора</h1>

<form method="get" action="<?= BASE ?>/frontend/admin.php" class="filters form-inline" style="margin-bottom: 20px; background: #fff; padding: 10px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.05);">
  <input type="text" name="search" placeholder="Кличка или ФИО" value="<?= e($filters['search']) ?>" style="flex: 1;">
  
  <select name="status_id">
    <option value="">Все статусы</option>
    <?php foreach ($statuses as $s): ?>
      <option value="<?= $s['id'] ?>" <?= (int)$filters['status_id'] === (int)$s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option>
    <?php endforeach; ?>
  </select>

  <select name="service">
    <option value="">Все услуги</option>
    <?php foreach ($services as $s): ?>
      <option value="<?= $s ?>" <?= $filters['service'] === $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select>

  <button class="btn small" type="submit">Найти</button>
  <a href="<?= BASE ?>/frontend/admin.php" class="btn small ghost">Сбросить</a>
</form>

<?php if (!$apps): ?>
  <p>Заявок не найдено.</p>
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

<?php if ($totalPages > 1): ?>
  <div class="pagination" style="margin-top: 20px; text-align: center;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
      <?php 
      $query = http_build_query(array_merge($filters, ['page' => $i])); 
      ?>
      <a href="?<?= $query ?>" class="btn small <?= $i === $page ? '' : 'ghost' ?>" style="margin: 0 2px;"><?= $i ?></a>
    <?php endfor; ?>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>
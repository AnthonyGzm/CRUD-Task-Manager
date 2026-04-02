<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

$conn   = getConnection();
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
$tasks  = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();

$total    = count($tasks);
$pending  = count(array_filter($tasks, fn($t) => $t['status'] === 'pending'));
$progress = count(array_filter($tasks, fn($t) => $t['status'] === 'in-progress'));
$done     = count(array_filter($tasks, fn($t) => $t['status'] === 'completed'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark px-4 py-3">
  <span class="navbar-brand fw-bold fs-5">
    <i class="bi bi-check2-square me-2"></i>Task Manager
  </span>
  <a href="create.php" class="btn btn-primary btn-sm">
    <i class="bi bi-plus-lg me-1"></i>Nueva Tarea
  </a>
</nav>

<div class="container py-4">

  <!-- ESTADÍSTICAS -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card total">
        <div class="number text-primary"><?= $total ?></div>
        <small class="text-muted">Total</small>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="number text-warning"><?= $pending ?></div>
        <small class="text-muted">Pendientes</small>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="number text-info"><?= $progress ?></div>
        <small class="text-muted">En progreso</small>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="number text-success"><?= $done ?></div>
        <small class="text-muted">Completadas</small>
      </div>
    </div>
  </div>

  <!-- TABLA -->
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3">
      <span class="fw-semibold">Lista de Tareas</span>
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <th>Creada</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($tasks)): ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-4">
                No hay tareas. <a href="create.php">¡Crea la primera!</a>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($tasks as $i => $task): ?>
              <tr>
                <td class="text-muted"><?= $i + 1 ?></td>
                <td class="fw-semibold"><?= sanitize($task['title']) ?></td>
                <td class="text-muted small"><?= sanitize($task['description'] ?: '—') ?></td>
                <td><?= statusBadge($task['status']) ?></td>
                <td><?= priorityBadge($task['priority']) ?></td>
                <td class="small text-muted">
                  <?= date('d/m/Y', strtotime($task['created_at'])) ?>
                </td>
                <td class="text-center">
                  <a href="edit.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                    <i class="bi bi-pencil"></i>
                  </a>
                  <a href="delete.php?id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-danger"
                     title="Eliminar"
                     onclick="return confirm('¿Estás seguro de que quieres eliminar la tarea: <?= addslashes(sanitize($task['title'])) ?>?')">
                    <i class="bi bi-trash3"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

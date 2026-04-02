<?php
require_once 'config/db.php';
require_once 'includes/functions.php';

$errors       = [];
$titleInvalid = false;
$data = ['title' => '', 'description' => '', 'status' => 'pending', 'priority' => 'medium'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['title']       = sanitize($_POST['title'] ?? '');
    $data['description'] = sanitize($_POST['description'] ?? '');
    $data['status']      = in_array($_POST['status'] ?? '', ['pending','in-progress','completed'])
                            ? $_POST['status'] : 'pending';
    $data['priority']    = in_array($_POST['priority'] ?? '', ['low','medium','high'])
                            ? $_POST['priority'] : 'medium';

    // Validación
    if (empty($data['title'])) {
        $errors[]     = 'El título es obligatorio.';
        $titleInvalid = true;
    }

    if (empty($errors)) {
        $conn = getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO tasks (title, description, status, priority)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param('ssss',
            $data['title'],
            $data['description'],
            $data['status'],
            $data['priority']
        );
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nueva Tarea — Task Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark px-4 py-3">
  <a href="index.php" class="navbar-brand fw-bold fs-5">
    <i class="bi bi-check2-square me-2"></i>Task Manager
  </a>
</nav>

<div class="container py-4" style="max-width: 600px">
  <div class="card shadow-sm">
    <div class="card-header py-3">
      <h5 class="mb-0 fw-semibold"><i class="bi bi-plus-circle me-2"></i>Nueva Tarea</h5>
    </div>
    <div class="card-body p-4">

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <?php foreach ($errors as $e): ?>
            <div><?= $e ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

       // aplicar clase is-invalid
      <form method="POST">
        <div class="mb-3">
          <label class="form-label fw-semibold">Título <span class="text-danger">*</span></label>
          <input type="text" name="title"
                 class="form-control <?= $titleInvalid ? 'is-invalid' : '' ?>"
                 value="<?= $data['title'] ?>" placeholder="Nombre de la tarea" maxlength="100">
          <div class="invalid-feedback">El título es obligatorio.</div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Descripción</label>
          <textarea name="description" class="form-control" rows="3"
                    placeholder="Descripción opcional..."><?= $data['description'] ?></textarea>
        </div>

        <div class="row g-3 mb-4">
          <div class="col">
            <label class="form-label fw-semibold">Estado</label>
            <select name="status" class="form-select">
              <option value="pending"     <?= $data['status'] === 'pending'     ? 'selected' : '' ?>>Pendiente</option>
              <option value="in-progress" <?= $data['status'] === 'in-progress' ? 'selected' : '' ?>>En progreso</option>
              <option value="completed"   <?= $data['status'] === 'completed'   ? 'selected' : '' ?>>Completada</option>
            </select>
          </div>
          <div class="col">
            <label class="form-label fw-semibold">Prioridad</label>
            <select name="priority" class="form-select">
              <option value="low"    <?= $data['priority'] === 'low'    ? 'selected' : '' ?>>Baja</option>
              <option value="medium" <?= $data['priority'] === 'medium' ? 'selected' : '' ?>>Media</option>
              <option value="high"   <?= $data['priority'] === 'high'   ? 'selected' : '' ?>>Alta</option>
            </select>
          </div>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i>Guardar tarea
          </button>
          <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once 'config/db.php';

$id = intval($_GET['id'] ?? 0);

if ($id > 0) {
    $conn = getConnection();

    // Verificar que la tarea existe antes de eliminar(Working)
    $check = $conn->prepare("SELECT id FROM tasks WHERE id = ?");
    $check->bind_param('i', $id);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;
    $check->close();

    if ($exists) {
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();
}

header('Location: index.php');
exit;
?>

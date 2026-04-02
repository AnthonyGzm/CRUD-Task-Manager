<?php
// ─────────────────────────────────────────────
//  Funciones auxiliares
// ─────────────────────────────────────────────

function sanitize($value) {
    return htmlspecialchars(strip_tags(trim($value)));
}

function statusBadge($status) {
    $map = [
        'pending'     => ['class' => 'bg-warning text-dark', 'label' => 'Pendiente'],
        'in-progress' => ['class' => 'bg-primary',           'label' => 'En progreso'],
        'completed'   => ['class' => 'bg-success',           'label' => 'Completada'],
    ];
    $s = $map[$status] ?? ['class' => 'bg-secondary', 'label' => $status];
    return "<span class=\"badge {$s['class']}\">{$s['label']}</span>";
}

function priorityBadge($priority) {
    $map = [
        'high'   => ['class' => 'bg-danger',    'label' => 'Alta'],
        'medium' => ['class' => 'bg-warning text-dark', 'label' => 'Media'],
        'low'    => ['class' => 'bg-secondary', 'label' => 'Baja'],
    ];
    $p = $map[$priority] ?? ['class' => 'bg-secondary', 'label' => $priority];
    return "<span class=\"badge {$p['class']}\">{$p['label']}</span>";
}
?>

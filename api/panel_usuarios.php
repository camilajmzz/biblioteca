<?php
require 'config.php';
$pdo = getConnection();

$stmt = $pdo->query("SELECT id, nombre, email, tipo FROM usuarios ORDER BY id ASC");
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Panel Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .table-container { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; }
        .table th { font-weight: 600; color: #475569; background-color: #f1f5f9 !important; border-bottom: 2px solid #e2e8f0; }
        .table td { vertical-align: middle; color: #334155; padding: 14px 12px; }
        .badge-custom { padding: 6px 12px; font-weight: 500; border-radius: 6px; font-size: 0.85rem; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark m-0">Control de Usuarios</h1>
            <p class="text-muted m-0 small">Lectores registrados y personal del sistema</p>
        </div>
        <a href="panel_index.php" class="btn btn-outline-secondary px-4 py-2 fw-medium">Volver al menú</a>
    </div>

    <div class="table-container shadow-sm p-2">
        <table class="table table-hover m-0">
            <thead>
            <tr>
                <th style="width: 100px;">ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th style="width: 180px;">Rol de Usuario</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td class="text-muted fw-medium">#<?= htmlspecialchars($u['id']) ?></td>
                    <td class="fw-semibold text-dark"><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <?= $u['tipo'] === 'bibliotecario'
                            ? '<span class="badge-custom bg-primary-subtle text-primary">Bibliotecario</span>'
                            : '<span class="badge-custom bg-secondary-subtle text-dark">Lector</span>' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
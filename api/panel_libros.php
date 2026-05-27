<?php
require 'config.php';
$pdo = getConnection();

$stmt = $pdo->query("SELECT * FROM libros ORDER BY id ASC");
$libros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros - Panel Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .table-container { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; }
        .table th { font-weight: 600; color: #475569; background-color: #f1f5f9 !important; border-bottom: 2px solid #e2e8f0; }
        .table td { vertical-align: middle; color: #334155; padding: 14px 12px; }
        .badge-custom { padding: 6px 12px; font-weight: 500; border-radius: 6px; font-size: 0.85rem; }
        .qr-thumb { width: 50px; height: 50px; border-radius: 6px; border: 1px solid #e2e8f0; object-fit: cover; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark m-0">Catálogo de Libros</h1>
            <p class="text-muted m-0 small">Listado completo de obras registradas</p>
        </div>
        <a href="panel_index.php" class="btn btn-outline-secondary px-4 py-2 fw-medium">Volver al menú</a>
    </div>

    <div class="table-container shadow-sm p-2">
        <table class="table table-hover m-0">
            <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th style="width: 100px;">Año</th>
                <th style="width: 140px;">Disponibilidad</th>
                <th style="width: 100px;">Código QR</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($libros as $libro): ?>
                <tr>
                    <td class="text-muted fw-medium">#<?= htmlspecialchars($libro['id']) ?></td>
                    <td class="fw-semibold text-dark"><?= htmlspecialchars($libro['titulo']) ?></td>
                    <td><?= htmlspecialchars($libro['autor']) ?></td>
                    <td><?= htmlspecialchars($libro['anio']) ?></td>
                    <td>
                        <?= $libro['disponible'] 
                            ? '<span class="badge-custom bg-success-subtle text-success">Disponible</span>' 
                            : '<span class="badge-custom bg-danger-subtle text-danger">Prestado</span>' ?>
                    </td>
                    <td>
                        <?php if (!empty($libro['qr_code'])): ?>
                            <img src="<?= htmlspecialchars($libro['qr_code']) ?>" alt="QR" class="qr-thumb">
                        <?php else: ?>
                            <span class="text-muted small">No asignado</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
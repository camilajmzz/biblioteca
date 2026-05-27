<?php
require 'config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; }
        .main-card { 
            transition: transform 0.2s, box-shadow 0.2s; 
            border: 1px solid #e2e8f0;
        }
        .main-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); 
        }
        .icon-wrapper {
            width: 48px; height: 48px;
            background-color: #eff6ff;
            color: #2563eb;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px; font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container py-5" style="max-width: 900px;">
    <div class="border-bottom pb-3 mb-5">
        <h1 class="fw-bold text-dark m-0">Sistema de Gestión</h1>
        <p class="text-muted m-0 mt-1">Panel de administración global de la biblioteca</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 main-card shadow-sm">
                <div class="card-body d-flex flex-column p-4">
                    <div class="icon-wrapper mb-3">LIB</div>
                    <h5 class="card-title fw-semibold text-dark">Libros</h5>
                    <p class="card-text text-muted small flex-grow-1">Administrar catálogo, existencias, estados y códigos QR.</p>
                    <a href="panel_libros.php" class="btn btn-outline-primary btn-sm w-100 mt-3 py-2 fw-medium">Acceder al módulo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 main-card shadow-sm">
                <div class="card-body d-flex flex-column p-4">
                    <div class="icon-wrapper mb-3" style="background-color: #f0fdf4; color: #16a34a;">USR</div>
                    <h5 class="card-title fw-semibold text-dark">Usuarios</h5>
                    <p class="card-text text-muted small flex-grow-1">Control de cuentas de lectores, permisos y roles del personal.</p>
                    <a href="panel_usuarios.php" class="btn btn-outline-success btn-sm w-100 mt-3 py-2 fw-medium">Acceder al módulo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 main-card shadow-sm">
                <div class="card-body d-flex flex-column p-4">
                    <div class="icon-wrapper mb-3" style="background-color: #fff7ed; color: #ea580c;">PRM</div>
                    <h5 class="card-title fw-semibold text-dark">Préstamos</h5>
                    <p class="card-text text-muted small flex-grow-1">Historial, devoluciones activas, alertas de retraso y registros.</p>
                    <a href="panel_prestamos.php" class="btn btn-outline-warning btn-sm w-100 mt-3 py-2 fw-medium text-dark">Acceder al módulo</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
require_once __DIR__ . '/../src/config/config.php';
// KPIs principales
$clientes = $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn();
$ingresos = $pdo->query('SELECT SUM(total_venta) FROM ventas')->fetchColumn();
$beneficio = 60; // Simulado
$facturas = $pdo->query('SELECT COUNT(*) FROM ventas')->fetchColumn();
// Mensajes simulados
$mensajes = [
    ['tipo' => 'info', 'texto' => 'Bienvenido a la plataforma BI de Supermercado Orión.'],
    ['tipo' => 'success', 'texto' => 'El sistema está funcionando correctamente.'],
    ['tipo' => 'warning', 'texto' => 'Recuerda revisar el stock crítico de productos.'],
];
// Perfil simulado
$perfil = [
    'nombre' => 'Luis Salas',
    'correo' => 'luissalas@orion.com',
    'avatar' => 'https://randomuser.me/api/portraits/men/32.jpg',
    'rol' => 'Administrador',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio | Orion BI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .profile-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.08);
            padding: 2rem 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
            border: 3px solid #4361ee;
        }
        .profile-name {
            font-size: 1.4rem;
            font-weight: bold;
            color: #232946;
        }
        .profile-role {
            color: #4361ee;
            font-size: 1rem;
            font-weight: 500;
        }
        .kpi-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.08);
            padding: 1.5rem 1rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .kpi-value {
            font-size: 2rem;
            font-weight: bold;
            color: #232946;
        }
        .kpi-label {
            color: #6c757d;
            font-size: 1rem;
        }
        .alert {
            font-size: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="profile-card">
                <img src="<?= $perfil['avatar'] ?>" alt="avatar" class="profile-avatar">
                <div class="profile-name"><?= htmlspecialchars($perfil['nombre']) ?></div>
                <div class="profile-role"><i class='bx bx-user'></i> <?= htmlspecialchars($perfil['rol']) ?></div>
                <div class="text-muted mt-2"><i class='bx bx-envelope'></i> <?= htmlspecialchars($perfil['correo']) ?></div>
            </div>
            <div>
                <?php foreach ($mensajes as $msg): ?>
                    <div class="alert alert-<?= $msg['tipo'] ?> d-flex align-items-center" role="alert">
                        <i class='bx bx-info-circle me-2'></i> <?= htmlspecialchars($msg['texto']) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card">
                        <div class="kpi-value"><?= number_format($clientes) ?></div>
                        <div class="kpi-label">Clientes</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card">
                        <div class="kpi-value">$<?= number_format($ingresos, 2) ?></div>
                        <div class="kpi-label">Ingresos</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card">
                        <div class="kpi-value"><?= $beneficio ?>%</div>
                        <div class="kpi-label">Beneficio</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="kpi-card">
                        <div class="kpi-value"><?= number_format($facturas) ?></div>
                        <div class="kpi-label">Facturas</div>
                    </div>
                </div>
            </div>
            <div class="card p-4">
                <h5 class="mb-3"><i class='bx bx-message-dots'></i> Mensajes de Clientes Recientes</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">"Excelente atención y productos de calidad." <span class="badge bg-success ms-2">Nuevo</span></li>
                    <li class="list-group-item">"¿Cuándo reponen stock de arroz?" <span class="badge bg-warning ms-2">Pendiente</span></li>
                    <li class="list-group-item">"Gracias por la rápida entrega." <span class="badge bg-success ms-2">Nuevo</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

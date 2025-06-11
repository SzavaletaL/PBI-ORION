<?php
// dashboard.php: Layout principal tipo dashboard con sidebar vertical y área de contenido dinámico
$view = $_GET['view'] ?? 'index';

// Mapear vistas a archivos
$views = [
    'index' => __DIR__ . '/index_content.php',
    'productos' => __DIR__ . '/../src/dashboards/productos_stock.php',
    'tienda' => __DIR__ . '/../src/dashboards/categorias_productos.php',
    'clientes' => __DIR__ . '/../src/dashboards/clientes.php',
    'proveedores' => __DIR__ . '/../src/dashboards/proveedores.php',
    'facturas' => __DIR__ . '/../src/dashboards/ingresos_productos.php',
    'estadisticas' => __DIR__ . '/../src/dashboards/resumen_diario.php',
];
$contentFile = $views[$view] ?? $views['index'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orion BI Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: #f4f6fa;
        }
        .dashboard-sidebar {
            min-height: 100vh;
            background: #232946;
            color: #fff;
            width: 90px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 0 1rem 0;
        }
        .dashboard-sidebar .logo {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: #fff;
        }
        .dashboard-sidebar .sidebar-link {
            color: #b8c1ec;
            font-size: 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            border-radius: 12px;
            transition: background 0.2s, color 0.2s;
        }
        .dashboard-sidebar .sidebar-link.active, .dashboard-sidebar .sidebar-link:hover {
            background: #393e6e;
            color: #fff;
        }
        .dashboard-main {
            margin-left: 90px;
            padding: 2rem 2rem 1rem 2rem;
            min-height: 100vh;
        }
        @media (max-width: 991px) {
            .dashboard-sidebar {
                flex-direction: row;
                width: 100vw;
                height: 70px;
                min-height: unset;
                position: static;
                padding: 0.5rem 0;
            }
            .dashboard-main {
                margin-left: 0;
                margin-top: 70px;
                padding: 1rem;
            }
            .dashboard-sidebar .sidebar-link {
                margin: 0 1rem 0 0;
                font-size: 1.5rem;
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-sidebar">
        <div class="logo"><i class='bx bx-bar-chart-alt'></i></div>
        <a href="?view=index" class="sidebar-link<?= $view=='index' ? ' active' : '' ?>" title="Inicio"><i class='bx bx-home'></i></a>
        <a href="?view=productos" class="sidebar-link<?= $view=='productos' ? ' active' : '' ?>" title="Productos"><i class='bx bx-cube'></i></a>
        <a href="?view=tienda" class="sidebar-link<?= $view=='tienda' ? ' active' : '' ?>" title="Tienda"><i class='bx bx-store'></i></a>
        <a href="?view=clientes" class="sidebar-link<?= $view=='clientes' ? ' active' : '' ?>" title="Clientes"><i class='bx bx-user'></i></a>
        <a href="?view=proveedores" class="sidebar-link<?= $view=='proveedores' ? ' active' : '' ?>" title="Proveedores"><i class='bx bx-buildings'></i></a>
        <a href="?view=facturas" class="sidebar-link<?= $view=='facturas' ? ' active' : '' ?>" title="Facturas"><i class='bx bx-receipt'></i></a>
        <a href="?view=estadisticas" class="sidebar-link<?= $view=='estadisticas' ? ' active' : '' ?>" title="Estadísticas"><i class='bx bx-bar-chart'></i></a>
        <a href="logout.php" class="sidebar-link mt-auto" title="Salir"><i class='bx bx-log-out'></i></a>
    </div>
    <div class="dashboard-main">
        <?php include $contentFile; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
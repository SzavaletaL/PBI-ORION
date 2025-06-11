<?php
// src/dashboards/resumen_diario.php

require_once __DIR__ . '/../data/ventas.php';

$fecha = $_GET['fecha'] ?? date('Y-m-d');
$ventas = obtenerVentasPorDia($fecha);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos | Orion BI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <style>
        .table thead th {
            background: #232946;
            color: #fff;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.08);
            background: #fff;
        }
        .chart-container {
            height: 350px;
            width: 100%;
        }
    </style>
</head>
<body>
<?php include '../../public/navbar.php'; ?>
    <h1>Resumen de Ventas - <?= htmlspecialchars($fecha) ?></h1>
    <table border="1" cellpadding="5">
        <tr>
            <th>Producto</th>
            <th>Cantidad Vendida</th>
            <th>Ingresos</th>
        </tr>
        <?php foreach ($ventas as $venta): ?>
            <tr>
                <td><?= htmlspecialchars($venta['producto']) ?></td>
                <td><?= $venta['total_vendido'] ?></td>
                <td>S/. <?= number_format($venta['ingresos'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

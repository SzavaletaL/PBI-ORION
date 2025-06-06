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
    <title>Resumen Diario de Ventas</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
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

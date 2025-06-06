<?php
require_once __DIR__ . '/../src/data/ventas.php';

$fecha = '2025-06-01';
$ventas = obtenerVentasPorDia($fecha);

echo "Ventas para {$fecha}:\n";
foreach ($ventas as $venta) {
    echo "- {$venta['producto']}: {$venta['total_vendido']} unidades, S/. {$venta['ingresos']}\n";
}

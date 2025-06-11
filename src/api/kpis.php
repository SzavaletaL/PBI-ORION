<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';

$clientes = $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn();
$ingresos = $pdo->query('SELECT SUM(total_venta) FROM ventas')->fetchColumn();
$beneficio = 60; // Simulado
$facturas = $pdo->query('SELECT COUNT(*) FROM ventas')->fetchColumn();

$kpis = [
    'clientes' => (int)$clientes,
    'ingresos' => (float)$ingresos,
    'beneficio' => (float)$beneficio,
    'facturas' => (int)$facturas
];
echo json_encode($kpis); 
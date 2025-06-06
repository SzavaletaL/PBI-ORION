<?php
// src/api/ventas.php

header('Content-Type: application/json');
require_once __DIR__ . '/../data/ventas.php';

$fecha = $_GET['fecha'] ?? date('Y-m-d');
$datos = obtenerVentasPorDia($fecha);
echo json_encode($datos);

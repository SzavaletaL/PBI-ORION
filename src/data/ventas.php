<?php
// src/data/ventas.php

require_once __DIR__ . '/../config/config.php';

function obtenerVentasPorDia($fecha) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT p.nombre AS producto, SUM(dv.cantidad) AS total_vendido, SUM(dv.subtotal) AS ingresos
        FROM ventas v
        JOIN detalle_venta dv ON v.id = dv.id_venta
        JOIN productos p ON dv.id_producto = p.id
        WHERE v.fecha = :fecha
        GROUP BY p.nombre
        ORDER BY ingresos DESC
    ");
    $stmt->execute(['fecha' => $fecha]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

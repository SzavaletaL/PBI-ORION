<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->prepare('
    SELECT p.nombre AS producto, SUM(dv.cantidad) AS total_vendido, SUM(dv.subtotal) AS ingresos
    FROM ventas v
    JOIN detalle_venta dv ON v.id = dv.id_venta
    JOIN productos p ON dv.id_producto = p.id
    WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    GROUP BY p.nombre
    ORDER BY total_vendido DESC
    LIMIT 10
');
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); 
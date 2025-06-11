<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->prepare('
    SELECT v.fecha, SUM(dv.subtotal) AS ingresos, SUM(dv.cantidad) AS unidades
    FROM ventas v
    JOIN detalle_venta dv ON v.id = dv.id_venta
    WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 90 DAY)
    GROUP BY v.fecha
    ORDER BY v.fecha ASC
');
$stmt->execute();
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); 
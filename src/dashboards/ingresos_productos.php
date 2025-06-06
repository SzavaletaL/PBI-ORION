<?php
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->query("
    SELECT i.fecha, pr.nombre AS proveedor, p.nombre AS producto, i.cantidad, i.costo_unitario
    FROM ingresos i
    JOIN productos p ON i.id_producto = p.id
    JOIN proveedores pr ON i.id_proveedor = pr.id
    ORDER BY i.fecha DESC
");
$ingresos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ingresos de Productos</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
<div class="contenedor">
    <h1>📥 Ingresos de Productos</h1>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Proveedor</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Costo Unitario (S/)</th>
        </tr>
        <?php foreach ($ingresos as $ing): ?>
            <tr>
                <td><?= $ing['fecha'] ?></td>
                <td><?= htmlspecialchars($ing['proveedor']) ?></td>
                <td><?= htmlspecialchars($ing['producto']) ?></td>
                <td><?= $ing['cantidad'] ?></td>
                <td><?= number_format($ing['costo_unitario'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

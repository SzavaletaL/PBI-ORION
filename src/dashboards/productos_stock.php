<?php
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->query("
    SELECT p.nombre AS producto, c.nombre AS categoria, p.stock, p.precio
    FROM productos p
    LEFT JOIN categorias c ON p.id_categoria = c.id
    ORDER BY p.nombre
");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Stock de Productos</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
<div class="contenedor">
    <h1>📦 Stock de Productos</h1>
    <table>
        <tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Precio (S/)</th>
        </tr>
        <?php foreach ($productos as $prod): ?>
            <tr>
                <td><?= htmlspecialchars($prod['producto']) ?></td>
                <td><?= htmlspecialchars($prod['categoria']) ?></td>
                <td><?= $prod['stock'] ?></td>
                <td><?= number_format($prod['precio'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

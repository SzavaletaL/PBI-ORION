<?php
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->query("SELECT * FROM categorias ORDER BY nombre");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Categorías de Productos</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
<div class="contenedor">
    <h1>🗂️ Categorías de Productos</h1>
    <table>
        <tr><th>ID</th><th>Nombre</th></tr>
        <?php foreach ($categorias as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= htmlspecialchars($cat['nombre']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

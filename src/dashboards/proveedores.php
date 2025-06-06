<?php
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->query("SELECT * FROM proveedores ORDER BY nombre");
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Proveedores</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
<div class="contenedor">
    <h1>🏭 Lista de Proveedores</h1>
    <table>
        <tr><th>ID</th><th>Nombre</th><th>Contacto</th><th>Teléfono</th></tr>
        <?php foreach ($proveedores as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= htmlspecialchars($p['contacto']) ?></td>
                <td><?= htmlspecialchars($p['telefono']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

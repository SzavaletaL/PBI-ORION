<?php
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->query("SELECT * FROM clientes ORDER BY nombre");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="assets/css/style.css"> 
</head>
<body>
<div class="contenedor">
    <h1>👤 Lista de Clientes</h1>
    <table>
        <tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Teléfono</th></tr>
        <?php foreach ($clientes as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['nombre']) ?></td>
                <td><?= htmlspecialchars($c['correo']) ?></td>
                <td><?= htmlspecialchars($c['telefono']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

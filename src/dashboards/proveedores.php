<?php
require_once __DIR__ . '/../config/config.php';

$stmt = $pdo->query("SELECT * FROM proveedores ORDER BY nombre");
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Productos | Orion BI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <style>
        .table thead th {
            background: #232946;
            color: #fff;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.08);
            background: #fff;
        }
        .chart-container {
            height: 350px;
            width: 100%;
        }
    </style>
</head>
<body>
<?php include '../../public/navbar.php'; ?>
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

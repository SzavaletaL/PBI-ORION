<?php
// public/index.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard BI Supermercado</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Ruta corregida -->
</head>
<body>
    <div class="contenedor">
        <h1>Plataforma BI - Supermercado</h1>
        <h2>Dashboards y Reportes</h2>
        <ul>
            <li><a href="../src/dashboards/resumen_diario.php?fecha=2025-06-01">🧾 Resumen Diario de Ventas</a></li>
            <li><a href="../src/dashboards/productos_stock.php">📦 Productos y Stock Actual</a></li>
            <li><a href="../src/dashboards/categorias_productos.php">🗂️ Categorías de Productos</a></li>
            <li><a href="../src/dashboards/clientes.php">👤 Lista de Clientes</a></li>
            <li><a href="../src/dashboards/proveedores.php">🏭 Lista de Proveedores</a></li>
            <li><a href="../src/dashboards/ingresos_productos.php">📥 Ingresos de Productos</a></li>
        </ul>

        <h2>APIs disponibles</h2>
        <ul>
            <li><a href="../src/api/ventas.php?fecha=2025-06-01">🔗 API JSON: Ventas por día</a></li>
            <!-- Puedes agregar más endpoints aquí si los creas -->
        </ul>
    </div>
</body>
</html>

<?php
require_once __DIR__ . '/../config/config.php';

// Obtener categorías con estadísticas
$stmt = $pdo->query("
    SELECT 
        c.id,
        c.nombre,
        COUNT(p.id) as total_productos,
        SUM(p.stock) as stock_total,
        AVG(p.precio) as precio_promedio,
        SUM(p.stock * p.precio) as valor_inventario,
        (
            SELECT COUNT(DISTINCT dv.id_producto)
            FROM detalle_venta dv
            JOIN productos p2 ON dv.id_producto = p2.id
            WHERE p2.id_categoria = c.id
        ) as productos_vendidos
    FROM categorias c
    LEFT JOIN productos p ON c.id = p.id_categoria
    GROUP BY c.id, c.nombre
    ORDER BY c.nombre
");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener top 5 productos por categoría
$stmt = $pdo->query("
    SELECT 
        c.nombre as categoria,
        p.nombre as producto,
        SUM(dv.cantidad) as total_vendido,
        SUM(dv.cantidad * dv.subtotal) as total_ingresos
    FROM categorias c
    JOIN productos p ON c.id = p.id_categoria
    JOIN detalle_venta dv ON p.id = dv.id_producto
    GROUP BY c.id, c.nombre, p.id, p.nombre
    ORDER BY c.nombre, total_vendido DESC
");
$productos_por_categoria = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($productos_por_categoria[$row['categoria']])) {
        $productos_por_categoria[$row['categoria']] = [];
    }
    if (count($productos_por_categoria[$row['categoria']]) < 5) {
        $productos_por_categoria[$row['categoria']][] = $row;
    }
}

// Obtener tendencias de ventas por categoría
$stmt = $pdo->query("
    SELECT 
        c.nombre as categoria,
        DATE_FORMAT(v.fecha, '%Y-%m') as mes,
        SUM(dv.cantidad) as total_vendido,
        SUM(dv.subtotal) as total_ingresos
    FROM categorias c
    JOIN productos p ON c.id = p.id_categoria
    JOIN detalle_venta dv ON p.id = dv.id_producto
    JOIN ventas v ON dv.id_venta = v.id
    WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY c.id, c.nombre, DATE_FORMAT(v.fecha, '%Y-%m')
    ORDER BY c.nombre, mes
");
$tendencias = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (!isset($tendencias[$row['categoria']])) {
        $tendencias[$row['categoria']] = [];
    }
    $tendencias[$row['categoria']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías de Productos | Orion BI</title>
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
            margin-bottom: 1.5rem;
        }
        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }
        .stat-card i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #4361ee;
        }
        .stat-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .stat-card p {
            color: #666;
            margin: 0;
        }
        .chart-container {
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body>
<?php include '../../public/navbar.php'; ?>
<div class="container mt-4">
    <h2 class="mb-4"><i class='bx bx-category'></i> Análisis de Categorías</h2>

    <!-- Resumen General -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card">
                <i class='bx bx-package'></i>
                <h3><?= count($categorias) ?></h3>
                <p>Total Categorías</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <i class='bx bx-cube'></i>
                <h3><?= array_sum(array_column($categorias, 'total_productos')) ?></h3>
                <p>Total Productos</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <i class='bx bx-store'></i>
                <h3>S/ <?= number_format(array_sum(array_column($categorias, 'valor_inventario')), 2) ?></h3>
                <p>Valor Total Inventario</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <i class='bx bx-trending-up'></i>
                <h3><?= array_sum(array_column($categorias, 'productos_vendidos')) ?></h3>
                <p>Productos Vendidos</p>
            </div>
        </div>
    </div>

    <!-- Tabla de Categorías -->
    <div class="card p-3 mb-4">
        <h5 class="mb-3">Detalle por Categoría</h5>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Total Productos</th>
                        <th>Stock Total</th>
                        <th>Precio Promedio</th>
                        <th>Valor Inventario</th>
                        <th>Productos Vendidos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $cat): ?>
                        <tr>
                            <td><?= htmlspecialchars($cat['nombre']) ?></td>
                            <td><?= $cat['total_productos'] ?></td>
                            <td><?= $cat['stock_total'] ?></td>
                            <td>S/ <?= number_format($cat['precio_promedio'], 2) ?></td>
                            <td>S/ <?= number_format($cat['valor_inventario'], 2) ?></td>
                            <td><?= $cat['productos_vendidos'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Productos por Categoría -->
    <div class="row">
        <?php foreach ($productos_por_categoria as $categoria => $productos): ?>
            <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h5 class="mb-3">Top 5 Productos - <?= htmlspecialchars($categoria) ?></h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Unidades Vendidas</th>
                                    <th>Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p['producto']) ?></td>
                                        <td><?= $p['total_vendido'] ?></td>
                                        <td>S/ <?= number_format($p['total_ingresos'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Gráfico de Tendencias -->
    <div class="card p-3">
        <h5 class="mb-3">Tendencias de Ventas por Categoría (Últimos 6 meses)</h5>
        <div class="chart-container">
            <canvas id="tendenciasChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Gráfico de tendencias
const tendencias = <?= json_encode($tendencias) ?>;
const categorias = Object.keys(tendencias);
const meses = [...new Set(Object.values(tendencias).flat().map(t => t.mes))].sort();

const datasets = categorias.map(categoria => ({
    label: categoria,
    data: meses.map(mes => {
        const dato = tendencias[categoria].find(t => t.mes === mes);
        return dato ? dato.total_ingresos : 0;
    }),
    borderColor: `hsl(${Math.random() * 360}, 70%, 50%)`,
    tension: 0.3,
    fill: false
}));

new Chart(document.getElementById('tendenciasChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: meses.map(mes => {
            const [year, month] = mes.split('-');
            return new Date(year, month - 1).toLocaleDateString('es-PE', { month: 'short', year: 'numeric' });
        }),
        datasets: datasets
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Evolución de Ventas por Categoría'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => 'S/ ' + value.toLocaleString('es-PE')
                }
            }
        }
    }
});
</script>
</body>
</html>

<?php
require_once __DIR__ . '/../config/config.php';
// Obtener productos
$stmt = $pdo->query("
    SELECT p.nombre AS producto, c.nombre AS categoria, p.stock, p.precio
    FROM productos p
    LEFT JOIN categorias c ON p.id_categoria = c.id
    ORDER BY p.nombre
");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
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
<div class="container mt-4">
    <h2 class="mb-4"><i class='bx bx-cube'></i> Productos y Stock</h2>
    <div class="row mb-4">
        <div class="col-lg-7">
            <div class="card p-3 mb-4">
                <h5 class="mb-3">Lista de Productos</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoría</th>
                                <th>Stock</th>
                                <th>Precio (S/)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $prod): ?>
                                <tr>
                                    <td><?= htmlspecialchars($prod['producto']) ?></td>
                                    <td><?= htmlspecialchars($prod['categoria']) ?></td>
                                    <td><?= $prod['stock'] ?></td>
                                    <td><?= number_format($prod['precio'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-3 mb-4">
                <h5 class="mb-3">Top 10 Productos Más Vendidos</h5>
                <div class="chart-container">
                    <canvas id="topProductosChart"></canvas>
                </div>
            </div>
            <div class="card p-3">
                <h5 class="mb-3">Predicción de Demanda (14 días)</h5>
                <div class="chart-container">
                    <canvas id="prediccionProductosChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Top productos
fetch('../../src/api/productos_top.php')
    .then(res => res.json())
    .then(data => {
        const labels = data.map(p => p.producto);
        const values = data.map(p => p.total_vendido);
        new Chart(document.getElementById('topProductosChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Unidades Vendidas',
                    data: values,
                    backgroundColor: '#4361ee',
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true } }
            }
        });
    });
// Predicción de demanda
fetch('../../src/api/prediccion_ventas.php')
    .then(res => res.json())
    .then(data => {
        const labels = data.map(p => (new Date(p.date)).toLocaleDateString('es-PE', { day: '2-digit', month: '2-digit' }));
        const values = data.map(p => p.predicted_demand);
        new Chart(document.getElementById('prediccionProductosChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Demanda Estimada',
                    data: values,
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#27ae60',
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
</body>
</html>

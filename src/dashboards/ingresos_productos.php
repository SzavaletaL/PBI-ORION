<?php
require_once __DIR__ . '/../config/config.php';
// Obtener ingresos/facturas
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturas | Orion BI</title>
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
    <h2 class="mb-4"><i class='bx bx-receipt'></i> Facturas e Ingresos de Productos</h2>
    <div class="row mb-4">
        <div class="col-lg-7">
            <div class="card p-3 mb-4">
                <h5 class="mb-3">Lista de Facturas / Ingresos</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Costo Unitario (S/)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ingresos as $ing): ?>
                                <tr>
                                    <td><?= $ing['fecha'] ?></td>
                                    <td><?= htmlspecialchars($ing['proveedor']) ?></td>
                                    <td><?= htmlspecialchars($ing['producto']) ?></td>
                                    <td><?= $ing['cantidad'] ?></td>
                                    <td><?= number_format($ing['costo_unitario'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-3 mb-4">
                <h5 class="mb-3">Evolución de Facturación (90 días)</h5>
                <div class="chart-container">
                    <canvas id="evolucionFacturacionChart"></canvas>
                </div>
            </div>
            <div class="card p-3">
                <h5 class="mb-3">Predicción de Ingresos (14 días)</h5>
                <div class="chart-container">
                    <canvas id="prediccionFacturasChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Evolución de facturación
fetch('../../src/api/ventas_historicas.php')
    .then(res => res.json())
    .then(data => {
        const labels = data.map(f => f.fecha);
        const values = data.map(f => f.ingresos);
        new Chart(document.getElementById('evolucionFacturacionChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ingresos',
                    data: values,
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: '#4361ee',
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
// Predicción de ingresos
fetch('../../src/api/prediccion_ventas.php')
    .then(res => res.json())
    .then(data => {
        const labels = data.map(p => (new Date(p.date)).toLocaleDateString('es-PE', { day: '2-digit', month: '2-digit' }));
        const values = data.map(p => p.predicted_demand);
        new Chart(document.getElementById('prediccionFacturasChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ingresos Estimados',
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

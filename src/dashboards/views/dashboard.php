<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orion Supermercado - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.2.2/dist/echarts.min.js"></script>
    <style>
        :root {
            --primary-color: #2E86C1;
            --secondary-color: #27AE60;
            --warning-color: #F39C12;
            --danger-color: #E74C3C;
            --success-color: #2ECC71;
        }
        
        .dashboard-container {
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .widget {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .widget-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .widget-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .kpi-card {
            text-align: center;
            padding: 15px;
        }
        
        .kpi-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .kpi-label {
            font-size: 0.9rem;
            color: #666;
        }
        
        .chart-container {
            height: 400px;
            width: 100%;
        }
        
        .trend-indicator {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        
        .trend-up {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }
        
        .trend-down {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }
        
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #666;
            padding: 10px 20px;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            background: none;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="row mb-4">
            <div class="col-12">
                <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="executivo-tab" data-bs-toggle="tab" href="#executivo" role="tab">
                            Panel Ejecutivo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="operativo-tab" data-bs-toggle="tab" href="#operativo" role="tab">
                            Panel Operativo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="analitico-tab" data-bs-toggle="tab" href="#analitico" role="tab">
                            Panel Analítico
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="tab-content" id="dashboardTabsContent">
            <!-- Panel Ejecutivo -->
            <div class="tab-pane fade show active" id="executivo" role="tabpanel">
                <div class="row">
                    <!-- KPI Ventas -->
                    <div class="col-md-3">
                        <div class="widget kpi-card">
                            <div class="kpi-value" id="ventasTotal">$0</div>
                            <div class="kpi-label">Ventas Totales</div>
                            <div class="trend-indicator trend-up">
                                <i class='bx bx-up-arrow-alt'></i>
                                <span id="ventasCrecimiento">0%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- KPI Inventario -->
                    <div class="col-md-3">
                        <div class="widget kpi-card">
                            <div class="kpi-value" id="inventarioTotal">$0</div>
                            <div class="kpi-label">Valor Inventario</div>
                            <div class="trend-indicator trend-down">
                                <i class='bx bx-down-arrow-alt'></i>
                                <span id="inventarioRotacion">0%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Gráfico de Ventas -->
                    <div class="col-md-8">
                        <div class="widget">
                            <div class="widget-header">
                                <div class="widget-title">Evolución de Ventas</div>
                                <div class="widget-actions">
                                    <select class="form-select form-select-sm" id="ventasPeriodo">
                                        <option value="7">Últimos 7 días</option>
                                        <option value="30">Últimos 30 días</option>
                                        <option value="90">Últimos 90 días</option>
                                    </select>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="ventasChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top Productos -->
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="widget-header">
                                <div class="widget-title">Top 10 Productos</div>
                            </div>
                            <div class="chart-container">
                                <canvas id="topProductosChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel Operativo -->
            <div class="tab-pane fade" id="operativo" role="tabpanel">
                <div class="row">
                    <!-- Stock Crítico -->
                    <div class="col-md-6">
                        <div class="widget">
                            <div class="widget-header">
                                <div class="widget-title">Productos Stock Crítico</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="stockCriticoTable">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Stock Actual</th>
                                            <th>Stock Mínimo</th>
                                            <th>Días Restantes</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ventas por Hora -->
                    <div class="col-md-6">
                        <div class="widget">
                            <div class="widget-header">
                                <div class="widget-title">Ventas por Hora</div>
                            </div>
                            <div class="chart-container" id="ventasHoraChart"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Panel Analítico -->
            <div class="tab-pane fade" id="analitico" role="tabpanel">
                <div class="row">
                    <!-- Predicción de Ventas -->
                    <div class="col-md-8">
                        <div class="widget">
                            <div class="widget-header">
                                <div class="widget-title">Predicción de Ventas</div>
                            </div>
                            <div class="chart-container">
                                <canvas id="prediccionVentasChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Segmentación de Clientes -->
                    <div class="col-md-4">
                        <div class="widget">
                            <div class="widget-header">
                                <div class="widget-title">Segmentación de Clientes</div>
                            </div>
                            <div class="chart-container" id="segmentacionClientesChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script>
        // Inicialización de gráficos y carga de datos
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            loadDashboardData('executivo');
            
            // Event listeners para cambios de pestaña
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    const dashboardType = e.target.id.split('-')[0];
                    loadDashboardData(dashboardType);
                });
            });
        });
        
        function initializeCharts() {
            // Inicializar gráficos con Chart.js
            initializeVentasChart();
            initializeTopProductosChart();
            initializePrediccionVentasChart();
            
            // Inicializar gráficos con ECharts
            initializeVentasHoraChart();
            initializeSegmentacionClientesChart();
        }
        
        function loadDashboardData(dashboardType) {
            fetch(`/api/dashboard/${dashboardType}`)
                .then(response => response.json())
                .then(data => {
                    updateDashboard(data);
                })
                .catch(error => console.error('Error:', error));
        }
        
        function updateDashboard(data) {
            // Actualizar KPIs
            updateKPIs(data.kpis);
            
            // Actualizar gráficos
            updateCharts(data.charts);
            
            // Actualizar tablas
            updateTables(data.tables);
        }
        
        // Implementar funciones de inicialización y actualización de gráficos
        function initializeVentasChart() {
            const ctx = document.getElementById('ventasChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Ventas',
                        data: [],
                        borderColor: '#2E86C1',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
        
        // Implementar resto de funciones de inicialización y actualización
    </script>
</body>
</html> 
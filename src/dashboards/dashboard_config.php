<?php
return [
    'dashboards' => [
        'executivo' => [
            'title' => 'Panel Ejecutivo',
            'refresh_rate' => 300, // 5 minutos
            'widgets' => [
                'kpi_ventas' => [
                    'type' => 'kpi',
                    'title' => 'Ventas Totales',
                    'data_source' => 'ventas',
                    'metrics' => ['total', 'crecimiento', 'tendencia']
                ],
                'kpi_inventario' => [
                    'type' => 'kpi',
                    'title' => 'Estado de Inventario',
                    'data_source' => 'inventario',
                    'metrics' => ['valor_total', 'rotación', 'cobertura']
                ],
                'ventas_tiempo' => [
                    'type' => 'line_chart',
                    'title' => 'Evolución de Ventas',
                    'data_source' => 'ventas',
                    'dimensions' => ['fecha'],
                    'metrics' => ['ventas', 'unidades']
                ],
                'top_productos' => [
                    'type' => 'bar_chart',
                    'title' => 'Top 10 Productos',
                    'data_source' => 'productos',
                    'dimensions' => ['producto'],
                    'metrics' => ['ventas', 'margen']
                ]
            ]
        ],
        'operativo' => [
            'title' => 'Panel Operativo',
            'refresh_rate' => 60, // 1 minuto
            'widgets' => [
                'stock_critico' => [
                    'type' => 'table',
                    'title' => 'Productos Stock Crítico',
                    'data_source' => 'inventario',
                    'columns' => ['producto', 'stock_actual', 'stock_minimo', 'dias_restantes']
                ],
                'ventas_hora' => [
                    'type' => 'heatmap',
                    'title' => 'Ventas por Hora',
                    'data_source' => 'ventas',
                    'dimensions' => ['hora', 'dia'],
                    'metrics' => ['ventas']
                ],
                'categorias_rendimiento' => [
                    'type' => 'treemap',
                    'title' => 'Rendimiento por Categoría',
                    'data_source' => 'categorias',
                    'dimensions' => ['categoria'],
                    'metrics' => ['ventas', 'margen']
                ]
            ]
        ],
        'analitico' => [
            'title' => 'Panel Analítico',
            'refresh_rate' => 3600, // 1 hora
            'widgets' => [
                'prediccion_ventas' => [
                    'type' => 'forecast_chart',
                    'title' => 'Predicción de Ventas',
                    'data_source' => 'ventas',
                    'dimensions' => ['fecha'],
                    'metrics' => ['ventas_real', 'ventas_predicha']
                ],
                'segmentacion_clientes' => [
                    'type' => 'scatter_plot',
                    'title' => 'Segmentación de Clientes',
                    'data_source' => 'clientes',
                    'dimensions' => ['frecuencia', 'valor'],
                    'metrics' => ['recencia']
                ],
                'correlacion_productos' => [
                    'type' => 'correlation_matrix',
                    'title' => 'Correlación entre Productos',
                    'data_source' => 'ventas',
                    'dimensions' => ['producto'],
                    'metrics' => ['co_venta']
                ]
            ]
        ]
    ],
    'visualization_settings' => [
        'colors' => [
            'primary' => '#2E86C1',
            'secondary' => '#27AE60',
            'warning' => '#F39C12',
            'danger' => '#E74C3C',
            'success' => '#2ECC71'
        ],
        'charts' => [
            'default_height' => 400,
            'animation_duration' => 1000,
            'responsive' => true
        ],
        'tables' => [
            'pagination' => true,
            'items_per_page' => 10,
            'sortable' => true
        ]
    ]
]; 
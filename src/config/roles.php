<?php
return [
    'roles' => [
        'admin' => [
            'permissions' => ['*'],
            'description' => 'Acceso total al sistema'
        ],
        'gerente' => [
            'permissions' => [
                'view_dashboards',
                'manage_inventory',
                'view_reports',
                'manage_promotions'
            ],
            'description' => 'Gestión operativa'
        ],
        'analista' => [
            'permissions' => [
                'view_dashboards',
                'view_reports',
                'export_data'
            ],
            'description' => 'Análisis de datos'
        ],
        'inventario' => [
            'permissions' => [
                'view_inventory',
                'update_stock',
                'view_reports'
            ],
            'description' => 'Gestión de inventario'
        ]
    ],
    'dashboard_access' => [
        'resumen_diario' => ['admin', 'gerente', 'analista'],
        'productos_stock' => ['admin', 'gerente', 'inventario'],
        'proveedores' => ['admin', 'gerente'],
        'categorias_productos' => ['admin', 'gerente', 'inventario'],
        'clientes' => ['admin', 'gerente', 'analista'],
        'ingresos_productos' => ['admin', 'gerente', 'inventario']
    ]
]; 
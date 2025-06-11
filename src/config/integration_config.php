<?php
// Configuración de integración de datos
return [
    'data_sources' => [
        'ventas' => [
            'type' => 'mysql',
            'table' => 'ventas',
            'refresh_interval' => 300, // 5 minutos
        ],
        'inventario' => [
            'type' => 'mysql',
            'table' => 'productos',
            'refresh_interval' => 300,
        ],
        'logistica' => [
            'type' => 'mysql',
            'table' => 'ingresos',
            'refresh_interval' => 300,
        ],
        'finanzas' => [
            'type' => 'mysql',
            'table' => 'ventas',
            'refresh_interval' => 300,
        ]
    ],
    'cache_settings' => [
        'enabled' => true,
        'ttl' => 300, // 5 minutos
        'storage' => 'redis'
    ],
    'backup_settings' => [
        'enabled' => true,
        'schedule' => 'daily',
        'retention_days' => 30,
        'storage_path' => '/backups'
    ]
]; 
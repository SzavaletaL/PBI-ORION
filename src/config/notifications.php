<?php
return [
    'alert_types' => [
        'stock' => [
            'threshold' => 20, // Porcentaje mínimo de stock
            'channels' => ['email', 'dashboard', 'mobile'],
            'priority' => 'high'
        ],
        'ventas' => [
            'anomaly_threshold' => 15, // Porcentaje de variación
            'channels' => ['email', 'dashboard'],
            'priority' => 'medium'
        ],
        'tendencias' => [
            'min_confidence' => 0.85,
            'channels' => ['dashboard', 'report'],
            'priority' => 'low'
        ]
    ],
    'notification_channels' => [
        'email' => [
            'enabled' => true,
            'template_path' => '/templates/email/',
            'schedule' => 'daily'
        ],
        'dashboard' => [
            'enabled' => true,
            'refresh_rate' => 300, // 5 minutos
            'max_alerts' => 10
        ],
        'mobile' => [
            'enabled' => true,
            'push_notifications' => true,
            'max_notifications' => 5
        ]
    ],
    'reporting' => [
        'scheduled_reports' => [
            'daily_summary' => '08:00',
            'inventory_alert' => '12:00',
            'sales_analysis' => '18:00'
        ],
        'export_formats' => ['pdf', 'excel', 'csv'],
        'retention_period' => 90 // días
    ]
]; 
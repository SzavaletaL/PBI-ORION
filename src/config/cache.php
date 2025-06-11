<?php
return [
    'redis' => [
        'host' => 'localhost',
        'port' => 6379,
        'timeout' => 2.0,
        'prefix' => 'orion:'
    ],
    'dashboard_cache' => [
        'enabled' => true,
        'ttl' => 300, // 5 minutos
        'max_memory' => '512M',
        'compression' => true
    ],
    'query_cache' => [
        'enabled' => true,
        'ttl' => 60, // 1 minuto
        'max_items' => 1000
    ],
    'performance_metrics' => [
        'max_load_time' => 30, // segundos
        'alert_threshold' => 25 // segundos
    ]
]; 
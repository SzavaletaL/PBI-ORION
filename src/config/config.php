<?php
// src/config/config.php

define('DB_HOST', 'dataepis.uandina.pe:49206');
define('DB_NAME', 'supermercado');
define('DB_USER', 'luissalas');
define('DB_PASS', 'luissalas2025');

// Crear conexión PDO
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

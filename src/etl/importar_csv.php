<?php
// src/etl/importar_csv.php

require_once __DIR__ . '/../config/config.php';

function importarVentasDesdeCSV($archivo_csv) {
    global $pdo;
    if (!file_exists($archivo_csv)) {
        die("Archivo no encontrado.");
    }

    $fila = 0;
    if (($gestor = fopen($archivo_csv, "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
            if ($fila++ == 0) continue; // Saltar encabezado

            $fecha = $datos[0];
            $producto = $datos[1];
            $cantidad = (int)$datos[2];
            $total = (float)$datos[3];

            $stmt = $pdo->prepare("INSERT INTO ventas (fecha, producto, cantidad, total_venta) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fecha, $producto, $cantidad, $total]);
        }
        fclose($gestor);
        echo "Importación completada.";
    }
}

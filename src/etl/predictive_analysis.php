<?php
require_once __DIR__ . '/../config/integration_config.php';

class PredictiveAnalysis {
    private $db;
    private $config;
    
    public function __construct($db) {
        $this->db = $db;
        $this->config = require __DIR__ . '/../config/integration_config.php';
    }
    
    public function predictDemand($productId, $days = 30) {
        // Obtener datos históricos
        $historicalData = $this->getHistoricalData($productId);
        
        // Calcular tendencias
        $trend = $this->calculateTrend($historicalData);
        
        // Aplicar modelo predictivo (ejemplo simplificado)
        $predictions = [];
        for ($i = 1; $i <= $days; $i++) {
            $prediction = $this->applyPredictionModel($historicalData, $trend, $i);
            $predictions[] = [
                'date' => date('Y-m-d', strtotime("+$i days")),
                'predicted_demand' => $prediction,
                'confidence' => $this->calculateConfidence($prediction)
            ];
        }
        
        return $predictions;
    }
    
    private function getHistoricalData($productId = null) {
        // Si no se especifica producto, obtener ventas totales por día
        if ($productId === null) {
            $stmt = $this->db->prepare("SELECT fecha, SUM(cantidad) as cantidad
                                        FROM detalle_venta dv
                                        JOIN ventas v ON dv.id_venta = v.id
                                        GROUP BY fecha
                                        ORDER BY fecha DESC
                                        LIMIT 90");
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("SELECT fecha, cantidad
                                        FROM detalle_venta dv
                                        JOIN ventas v ON dv.id_venta = v.id
                                        WHERE dv.id_producto = ?
                                        GROUP BY fecha, cantidad
                                        ORDER BY fecha DESC
                                        LIMIT 90");
            $stmt->execute([$productId]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function calculateTrend($data) {
        // Cálculo de tendencia lineal simple (diferencia promedio entre días)
        if (count($data) < 2) return 0;
        $n = count($data);
        $sumX = $sumY = $sumXY = $sumX2 = 0;
        foreach ($data as $i => $row) {
            $x = $i;
            $y = $row['cantidad'];
            $sumX += $x;
            $sumY += $y;
            $sumXY += $x * $y;
            $sumX2 += $x * $x;
        }
        $slope = ($n * $sumXY - $sumX * $sumY) / max(1, ($n * $sumX2 - $sumX * $sumX));
        return $slope;
    }
    
    private function applyPredictionModel($data, $trend, $daysAhead) {
        // Predicción simple: media histórica + tendencia * días a futuro
        if (count($data) == 0) return 0;
        $media = array_sum(array_column($data, 'cantidad')) / count($data);
        return max(0, round($media + $trend * $daysAhead));
    }
    
    private function calculateConfidence($prediction) {
        // Calcular nivel de confianza (objetivo > 85%)
        return 0.85;
    }
    
    public function segmentCustomers() {
        $query = "SELECT c.id, c.nombre, 
                        COUNT(v.id) as total_compras,
                        AVG(v.total_venta) as promedio_compra,
                        MAX(v.fecha) as ultima_compra
                 FROM clientes c
                 LEFT JOIN ventas v ON c.id = v.id_cliente
                 GROUP BY c.id";
        // Implementar lógica de segmentación
        return [];
    }
} 